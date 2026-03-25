<?php
// Tính Cosine Similarity bằng TF-IDF (NLP Content-Based Filtering)
// So sánh "nội dung" thực tế (Name, Description, Product_uses, Category, Brand, Tags)

$mysqli = new mysqli("localhost", "root", "12345", "pesticide_shop");

if ($mysqli->connect_errno) {
    echo "Lỗi kết nối MySQL: " . $mysqli->connect_error;
    exit();
}
$mysqli->set_charset("utf8mb4");

// 1. Thu thập dữ liệu văn bản của sản phẩm
$documents = [];

// Join category và brand để cộng dồn thêm văn bản
$query = "SELECT p.ProductID, p.Name as PName, p.Description, p.Product_uses, p.disease_tag,
                 c.Name as CName, b.Name as BName 
          FROM product p
          LEFT JOIN category c ON p.CategoryID = c.CategoryID
          LEFT JOIN brand b ON p.BrandID = b.BrandID
          WHERE p.Status = 1";

$res = $mysqli->query($query);
while($row = $res->fetch_assoc()) {
    $pid = $row['ProductID'];
    
    // Gộp tất cả text lại thành 1 siêu văn bản (Document)
    // Tăng trọng số từ khóa bằng cách lặp lại tên và nhãn bệnh (nhân đôi tần suất)
    $text = $row['PName'] . " " . $row['PName'] . " " 
          . $row['CName'] . " " 
          . $row['BName'] . " " 
          . $row['disease_tag'] . " " . $row['disease_tag'] . " "
          . $row['Description'] . " " 
          . $row['Product_uses'];
    
    // Đưa về chữ thường
    $text = mb_strtolower($text, 'UTF-8');
    
    // Xóa dấu câu (Giữ lại chữ cái và số Tiếng Việt/Latin)
    $text = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $text);
    
    // Tách từ (Tokenization)
    $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
    
    $documents[$pid] = $words;
}

// 2. Tính TF (Term Frequency) & DF (Document Frequency)
$tf = [];
$df = [];
$total_docs = count($documents);

foreach ($documents as $pid => $words) {
    $word_counts = array_count_values($words);
    $total_words = count($words);
    $tf[$pid] = [];
    
    foreach ($word_counts as $word => $count) {
        // TF: Tần suất xuất hiện của từ trong tài liệu (chuẩn hóa trên tổng số từ)
        $tf[$pid][$word] = $count / $total_words;
        
        // Đếm DF (Số lượng document chứa từ này)
        if (!isset($df[$word])) {
            $df[$word] = 0;
        }
        $df[$word]++;
    }
}

// 3. Tính IDF & Chuyển hóa thành Vector TF-IDF
$tfidf = [];
foreach ($tf as $pid => $words_tf) {
    if (!isset($tfidf[$pid])) $tfidf[$pid] = [];
    
    foreach ($words_tf as $word => $tf_val) {
        // IDF = log( N / DF )
        $idf = log($total_docs / $df[$word]);
        $tfidf[$pid][$word] = $tf_val * $idf;
    }
}

// 4. Tính Cosine Similarity giữa các Vector TF-IDF
echo " [*] Đang phân tích NLP & Tính TF-IDF Content-Based Cosine Similarity...\n";
$similarities = [];
$product_ids = array_keys($tfidf);

for ($i = 0; $i < $total_docs; $i++) {
    for ($j = $i + 1; $j < $total_docs; $j++) {
        $p1 = $product_ids[$i];
        $p2 = $product_ids[$j];
        
        $v1 = $tfidf[$p1];
        $v2 = $tfidf[$p2];
        
        $dot_product = 0;
        $norm_a = 0;
        $norm_b = 0;
        
        // Tính độ lớn vector A (Norn A)
        foreach ($v1 as $val1) {
            $norm_a += ($val1 * $val1);
        }
        
        // Tính độ lớn vector B (Norm B)
        foreach ($v2 as $val2) {
            $norm_b += ($val2 * $val2);
        }
        
        // Tính Tích vô hướng (Dot Product) - chỉ duyệt các từ cùng xuất hiện
        foreach ($v1 as $word => $val1) {
            if (isset($v2[$word])) {
                $dot_product += ($val1 * $v2[$word]);
            }
        }
        
        if ($norm_a > 0 && $norm_b > 0) {
            $cos_sim = $dot_product / (sqrt($norm_a) * sqrt($norm_b));
            if ($cos_sim > 0) {
                // Formatting
                $cos_sim = number_format($cos_sim, 5, '.', '');
                $similarities[] = "($p1, $p2, $cos_sim)";
                $similarities[] = "($p2, $p1, $cos_sim)"; // Đối xứng
            }
        }
    }
}

if (!empty($similarities)) {
    // Xóa sạch similarity cũ
    $mysqli->query("TRUNCATE TABLE item_similarity");
    
    // Ghi đề data TF-IDF similarity mới
    $chunks = array_chunk($similarities, 200);
    foreach($chunks as $chunk) {
        $values = implode(", ", $chunk);
        $mysqli->query("INSERT INTO item_similarity (item_A, item_B, similarity) VALUES $values");
    }
    echo " [+] Đã Update thành công bảng item_similarity bằng chuẩn NLP TF-IDF!\n";
} else {
    echo " [-] Lỗi: Không có dữ kiện trùng lặp văn bản để tính Độ tương đồng.\n";
}

$mysqli->close();
echo " === HOÀN TẤT THUẬT TOÁN TF-IDF NLP ===\n";
