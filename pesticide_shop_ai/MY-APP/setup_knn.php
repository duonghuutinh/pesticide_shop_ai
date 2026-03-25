<?php
// Tự động phân tích và cập nhật DB, thêm dữ liệu giả
$mysqli = new mysqli("localhost", "root", "12345", "pesticide_shop");

if ($mysqli->connect_errno) {
    echo "Lỗi kết nối MySQL: " . $mysqli->connect_error;
    exit();
}

// 1. Kiểm tra và thêm cột cho products
$tables = ['disease_tag' => 'VARCHAR(255) NULL', 'views' => 'INT DEFAULT 0', 'rating' => 'FLOAT DEFAULT 0.0'];
foreach ($tables as $col => $type) {
    $result = $mysqli->query("SHOW COLUMNS FROM `product` LIKE '$col'");
    if($result->num_rows == 0) {
        $mysqli->query("ALTER TABLE `product` ADD `$col` $type");
        echo " [+] Đã thêm cột $col vào bảng product.\n";
    } else {
        echo " [*] Cột $col đã tồn tại trong bảng product.\n";
    }
}

// 2. Tạo bảng user_interactions nếu chưa có
$sql_ui = "CREATE TABLE IF NOT EXISTS `user_interactions` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `product_id` BIGINT NOT NULL,
  `action` VARCHAR(50) NOT NULL COMMENT 'view, buy, rate',
  `rating_value` INT NULL COMMENT 'Dành cho action rate',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`UserID`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `product`(`ProductID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if ($mysqli->query($sql_ui)) {
    echo " [+] Bảng user_interactions đã sẵn sàng.\n";
}

// 3. Tạo bảng item_similarity nếu chưa có
$sql_is = "CREATE TABLE IF NOT EXISTS `item_similarity` (
  `item_A` BIGINT NOT NULL,
  `item_B` BIGINT NOT NULL,
  `similarity` FLOAT NOT NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_A`, `item_B`),
  FOREIGN KEY (`item_A`) REFERENCES `product`(`ProductID`) ON DELETE CASCADE,
  FOREIGN KEY (`item_B`) REFERENCES `product`(`ProductID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if ($mysqli->query($sql_is)) {
    echo " [+] Bảng item_similarity đã sẵn sàng.\n";
}

// 4. Sinh dữ liệu giả (Dummy Data) cho user_interactions để chạy Cosine Similarity
$user_ids = [];
$res = $mysqli->query("SELECT UserID FROM users");
while($row = $res->fetch_assoc()) {
    $user_ids[] = $row['UserID'];
}

$product_ids = [];
$res = $mysqli->query("SELECT ProductID FROM product WHERE Status = 1");
while($row = $res->fetch_assoc()) {
    $product_ids[] = $row['ProductID'];
}

$res_count = $mysqli->query("SELECT COUNT(*) as cnt FROM user_interactions");
$row_count = $res_count->fetch_assoc();
if ($row_count['cnt'] < 100 && count($user_ids) > 0 && count($product_ids) > 0) {
    echo " [*] Đang sinh dữ liệu giả (interactions)...\n";
    $actions = ['view', 'buy', 'rate'];
    
    $insert_queries = [];
    for ($i = 0; $i < 300; $i++) {
        $u = $user_ids[array_rand($user_ids)];
        $p = $product_ids[array_rand($product_ids)];
        $a = $actions[array_rand($actions)];
        $r = ($a == 'rate') ? rand(1, 5) : 'NULL';
        $insert_queries[] = "($u, $p, '$a', $r)";
    }
    
    $values = implode(", ", $insert_queries);
    $mysqli->query("INSERT INTO user_interactions (user_id, product_id, action, rating_value) VALUES $values");
    echo " [+] Đã insert ".count($insert_queries)." bản ghi tương tác giả.\n";
} else {
    echo " [*] Bảng user_interactions đã có dữ liệu, bỏ qua sinh giả.\n";
}

// 5. Code tính Item-KNN (Cosine Similarity)
echo " [*] Đang tính Cosine Similarity giữa các item...\n";
$interactions = [];
$res = $mysqli->query("SELECT user_id, product_id, action, rating_value FROM user_interactions");
while($row = $res->fetch_assoc()) {
    $u = $row['user_id'];
    $p = $row['product_id'];
    $a = $row['action'];
    $r = $row['rating_value'];
    
    $score = 0;
    if ($a == 'view') $score = 1;
    if ($a == 'buy') $score = 3;
    if ($a == 'rate') $score = $r;
    
    if (!isset($interactions[$p])) {
        $interactions[$p] = [];
    }
    if (!isset($interactions[$p][$u])) {
        $interactions[$p][$u] = $score;
    } else {
        $interactions[$p][$u] = max($interactions[$p][$u], $score);
    }
}

$similarities = [];
$products = array_keys($interactions);
$total_prods = count($products);

for ($i = 0; $i < $total_prods; $i++) {
    for ($j = $i + 1; $j < $total_prods; $j++) {
        $p1 = $products[$i];
        $p2 = $products[$j];
        
        $dot_product = 0;
        $norm_a = 0;
        $norm_b = 0;
        
        $users_p1 = $interactions[$p1];
        $users_p2 = $interactions[$p2];
        
        foreach ($users_p1 as $u => $score1) {
            $norm_a += $score1 * $score1;
            if (isset($users_p2[$u])) {
                $dot_product += $score1 * $users_p2[$u];
            }
        }
        
        foreach ($users_p2 as $u => $score2) {
            $norm_b += $score2 * $score2;
        }
        
        if ($norm_a > 0 && $norm_b > 0) {
            $cos_sim = $dot_product / (sqrt($norm_a) * sqrt($norm_b));
            if ($cos_sim > 0) {
                // Format to 5 decimal places avoiding scientific notation
                $cos_sim = number_format($cos_sim, 5, '.', '');
                $similarities[] = "($p1, $p2, $cos_sim)";
                $similarities[] = "($p2, $p1, $cos_sim)"; 
            }
        }
    }
}

if (!empty($similarities)) {
    $mysqli->query("TRUNCATE TABLE item_similarity");
    $chunks = array_chunk($similarities, 200);
    foreach($chunks as $chunk) {
        $values = implode(", ", $chunk);
        $mysqli->query("INSERT INTO item_similarity (item_A, item_B, similarity) VALUES $values");
    }
    echo " [+] Đã cập nhật xong bảng item_similarity!\n";
} else {
    echo " [-] Không đủ dữ kiện trùng lặp user để tính Similarity.\n";
}

$mysqli->close();
echo " === HOÀN TẤT SETUP VÀ CALCULATE KNN ===\n";
