<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $imagePath = $_FILES['image']['tmp_name'];
    $imageMimeType = mime_content_type($imagePath);
    
    if ($imageMimeType === 'image/jpeg' || $imageMimeType === 'image/png') {
        $image = curl_file_create($imagePath);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:5000/predict');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['image' => $image]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if ($response === false) {
            echo 'CURL Error: ' . curl_error($ch);
        } else {
            $data = json_decode($response, true);
            if (isset($data['image_url'])) {
                $image_url = 'http://localhost:5000/' . $data['image_url'];
                $predictions = $data['predictions'];
            } elseif (isset($data['message'])) {
                $message = $data['message'];
            } else {
                echo '<pre>';
                print_r($data);
                echo '</pre>';
            }
        }
        curl_close($ch);
    } else {
        echo 'Invalid file type. Only JPEG and PNG are allowed.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>YOLOv8 Prediction</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #333; }
        form { margin-top: 20px; }
        input[type="file"] { margin-bottom: 10px; }
        img { margin-top: 20px; width: 300px; height: 400px; }
    </style>
</head>
<body>
    <h1>Upload Image for YOLO Prediction</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image" required>
        <button type="submit">Upload</button>
    </form>
    <?php if (isset($image_url)): ?>
        <h2>Prediction Result:</h2>
        <?php foreach ($predictions as $prediction): ?>
            <h3>Label: <?php echo $prediction['label']; ?>, Confidence: <?php echo $prediction['confidence']; ?></h3>
        <?php endforeach; ?>
        <img  src="<?php echo $image_url; ?>" alt="Prediction Result">
    <?php elseif (isset($message)): ?>
        <h2><?php echo $message; ?></h2>
    <?php endif; ?>
</body>
</html>