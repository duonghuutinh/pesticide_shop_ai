<?php
// Tính Cosine Similarity bằng Content-Based Filtering (Dựa trên đặc trưng sản phẩm)
$mysqli = new mysqli("localhost", "root", "12345", "pesticide_shop");

if ($mysqli->connect_errno) {
    echo "Lỗi kết nối MySQL: " . $mysqli->connect_error;
    exit();
}

$mysqli->set_charset("utf8mb4");

// 1. Sinh ngẫu nhiên "disease_tag" cho các sản phẩm chưa có để thuật toán có dữ liệu so sánh
$tags_sample = ['Rầy nâu', 'Bệnh đạo ôn', 'Nhện đỏ', 'Ốc bươu vàng', 'Sâu đục thân', 'Khô vằn', 'Sương mai', 'Cháy lá', 'Thối rễ', 'Ghẻ sẹo'];
$res = $mysqli->query("SELECT ProductID, disease_tag FROM product WHERE Status = 1");
while($row = $res->fetch_assoc()) {
    if (empty($row['disease_tag'])) {
        // Random 1-3 tags
        $num_tags = rand(1, 3);
        shuffle($tags_sample);
        $selected_tags = array_slice($tags_sample, 0, $num_tags);
        $tag_str = implode(',', $selected_tags);
        $pid = $row['ProductID'];
        $mysqli->query("UPDATE product SET disease_tag = '$tag_str' WHERE ProductID = $pid");
    }
}

// 2. Lấy toàn bộ sản phẩm và xây dựng không gian đặc trưng (Feature Vector)
$products = [];
$all_brands = [];
$all_categories = [];
$all_tags = [];
$max_price = 0;

$res = $mysqli->query("SELECT ProductID, CategoryID, BrandID, disease_tag, Selling_price FROM product WHERE Status = 1");
while($row = $res->fetch_assoc()) {
    $products[$row['ProductID']] = $row;
    $all_brands[$row['BrandID']] = true;
    $all_categories[$row['CategoryID']] = true;
    
    if (!empty($row['disease_tag'])) {
        $tags = array_map('trim', explode(',', $row['disease_tag']));
        foreach($tags as $t) {
            if(!empty($t)) $all_tags[$t] = true;
        }
    }
    
    if ($row['Selling_price'] > $max_price) {
        $max_price = $row['Selling_price'];
    }
}

$all_brands = array_keys($all_brands);
$all_categories = array_keys($all_categories);
$all_tags = array_keys($all_tags);

// Trọng số cho từng loại đặc trưng (Tùy chỉnh độ quan trọng)
$WEIGHT_CATEGORY = 3.0;
$WEIGHT_TAG = 2.0;
$WEIGHT_BRAND = 1.0;
$WEIGHT_PRICE = 0.5;

// Xây dựng vector cho từng sản phẩm
$vectors = [];
foreach ($products as $pid => $p) {
    $vector = [];
    
    // Category Feature (One-hot encoding)
    foreach ($all_categories as $cat) {
        $vector["cat_$cat"] = ($p['CategoryID'] == $cat) ? $WEIGHT_CATEGORY : 0;
    }
    
    // Brand Feature
    foreach ($all_brands as $brand) {
        $vector["brand_$brand"] = ($p['BrandID'] == $brand) ? $WEIGHT_BRAND : 0;
    }
    
    // Disease Tag Feature (Multi-hot encoding)
    $p_tags = [];
    if (!empty($p['disease_tag'])) {
        $p_tags = array_map('trim', explode(',', $p['disease_tag']));
    }
    foreach ($all_tags as $tag) {
        $vector["tag_$tag"] = (in_array($tag, $p_tags)) ? $WEIGHT_TAG : 0;
    }
    
    // Price Feature (Normalized 0-1)
    $normalized_price = ($max_price > 0) ? ($p['Selling_price'] / $max_price) : 0;
    $vector["price"] = $normalized_price * $WEIGHT_PRICE;
    
    $vectors[$pid] = $vector;
}

// 3. Tính Cosine Similarity giữa các items
echo " [*] Đang tính Content-Based Cosine Similarity...\n";
$similarities = [];
$product_ids = array_keys($vectors);
$total_prods = count($product_ids);

for ($i = 0; $i < $total_prods; $i++) {
    for ($j = $i + 1; $j < $total_prods; $j++) {
        $p1 = $product_ids[$i];
        $p2 = $product_ids[$j];
        
        $v1 = $vectors[$p1];
        $v2 = $vectors[$p2];
        
        $dot_product = 0;
        $norm_a = 0;
        $norm_b = 0;
        
        foreach ($v1 as $feature_name => $val1) {
            $val2 = $v2[$feature_name];
            
            $dot_product += ($val1 * $val2);
            $norm_a += ($val1 * $val1);
            $norm_b += ($val2 * $val2);
        }
        
        if ($norm_a > 0 && $norm_b > 0) {
            $cos_sim = $dot_product / (sqrt($norm_a) * sqrt($norm_b));
            if ($cos_sim > 0) {
                $cos_sim = number_format($cos_sim, 5, '.', '');
                $similarities[] = "($p1, $p2, $cos_sim)";
                $similarities[] = "($p2, $p1, $cos_sim)"; 
            }
        }
    }
}

if (!empty($similarities)) {
    // Lưu vào bảng item_similarity (Sử dụng lại bảng trước đó để không phải sửa Model/Controller)
    $mysqli->query("TRUNCATE TABLE item_similarity");
    
    $chunks = array_chunk($similarities, 200);
    foreach($chunks as $chunk) {
        $values = implode(", ", $chunk);
        $mysqli->query("INSERT INTO item_similarity (item_A, item_B, similarity) VALUES $values");
    }
    echo " [+] Đã cập nhật xong bảng item_similarity bằng Content-Based Filtering!\n";
} else {
    echo " [-] Lỗi: Không tính được độ tương đồng nào.\n";
}

$mysqli->close();
echo " === HOÀN TẤT CONTENT-BASED KNN ===\n";
