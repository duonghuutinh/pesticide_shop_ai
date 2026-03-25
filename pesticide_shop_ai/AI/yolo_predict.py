import os
import cv2
import numpy as np
from flask import Flask, request, jsonify, send_file
from ultralytics import YOLO
from datetime import datetime

app = Flask(__name__)

# ==========================================================
# 1. CẤU HÌNH ĐƯỜNG DẪN TỰ ĐỘNG (SMART PATH)
# ==========================================================
BASE_DIR = os.path.dirname(os.path.abspath(__file__)) # Thư mục AI

# Danh sách các vị trí có thể chứa file model (Ưu tiên theo ảnh VS Code của bạn)
possible_paths = [
    os.path.join(BASE_DIR, "weights", "best.pt"),          # AI/weights/best.pt
    os.path.join(BASE_DIR, "..", "weights", "best.pt"),     # pesticide_shop_ai/weights/best.pt
    os.path.join(BASE_DIR, "best.pt"),                     # AI/best.pt
    r"e:\WEB_AI_THUOC_BVTV\pesticide_shop_ai\weights\best.pt" # Đường dẫn tuyệt đối cứng
]

model = None
for path in possible_paths:
    if os.path.exists(path):
        try:
            model = YOLO(path)
            print(f"✅ ĐÃ TÌM THẤY VÀ LOAD MODEL TẠI: {path}")
            break
        except Exception as e:
            print(f"⚠️ Thử load tại {path} nhưng lỗi: {e}")

if model is None:
    print("❌ LỖI NGHIÊM TRỌNG: Không tìm thấy file 'best.pt' ở bất kỳ đâu!")
    print(f"Thư mục hiện tại của file code: {BASE_DIR}")
    # Nếu vẫn lỗi, hãy copy đường dẫn thật từ VS Code dán vào đây:
    # model = YOLO(r"đường_dẫn_copy_vào_đây")

# ==========================================================
# 2. CÁC ROUTE XỬ LÝ API
# ==========================================================

@app.route('/predict', methods=['POST'])
def predict():
    try:
        if 'image' not in request.files:
            return jsonify({'error': 'No image provided'}), 400

        file = request.files['image']
        img_bytes = np.frombuffer(file.read(), np.uint8)
        img = cv2.imdecode(img_bytes, cv2.IMREAD_COLOR)
        
        if img is None:
            return jsonify({'error': 'Invalid image format'}), 400

        # Chạy dự đoán
        results = model(img)
        
        predictions = []
        for result in results:
            for box in result.boxes:
                confidence = float(box.conf[0].item())
                
                if confidence >= 0.1: # Ngưỡng tin cậy 10%
                    x1, y1, x2, y2 = map(int, box.xyxy[0].tolist())
                    class_id = int(box.cls[0].item())
                    
                    # Lấy tên class từ model, nếu không có thì để là 'Object'
                    class_name = model.names[class_id] if hasattr(model, 'names') else f"Class {class_id}"
                    
                    label = f"{class_name} {confidence:.2f}"
                    
                    # Vẽ Bounding Box và Label
                    cv2.rectangle(img, (x1, y1), (x2, y2), (0, 255, 0), 2)
                    
                    font = cv2.FONT_HERSHEY_SIMPLEX
                    (text_w, text_h), baseline = cv2.getTextSize(label, font, 0.5, 1)
                    text_y = y1 - 10 if y1 - 10 > text_h else y1 + text_h + 10
                    
                    cv2.rectangle(img, (x1, text_y - text_h - baseline), (x1 + text_w, text_y + baseline), (0, 255, 0), -1)
                    cv2.putText(img, label, (x1, text_y), font, 0.5, (0, 0, 0), 1)
                    
                    predictions.append({
                        'label': class_name,
                        'confidence': confidence,
                        'bbox': [x1, y1, x2, y2]
                    })
        
        if not predictions:
            return jsonify({'message': 'Không nhận diện được vật thể', 'predictions': []})
        
        # Lưu ảnh kết quả (Lưu vào thư mục AI/static/predictions)
        timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
        output_dir = os.path.join(BASE_DIR, "static", "predictions")
        os.makedirs(output_dir, exist_ok=True)
        
        filename = f"result_{timestamp}.jpg"
        save_path = os.path.join(output_dir, filename)
        cv2.imwrite(save_path, img)

        return jsonify({
            'status': 'success',
            'image_url': f"/static/predictions/{filename}",
            'predictions': predictions
        })
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/static/predictions/<filename>')
def get_prediction_image(filename):
    # Tìm ảnh trong thư mục AI/static/predictions
    image_path = os.path.join(BASE_DIR, "static", "predictions", filename)
    if os.path.exists(image_path):
        return send_file(image_path, mimetype='image/jpeg')
    return "Image not found", 404

if __name__ == '__main__':
    # Lấy cổng port do Render cấp phát, mặc định là 5000 nếu test ở local
    port = int(os.environ.get("PORT", 5000))
    # Chạy Flask Server với host 0.0.0.0 để chấp nhận mọi IP truy cập
    app.run(host='0.0.0.0', port=port, debug=False)