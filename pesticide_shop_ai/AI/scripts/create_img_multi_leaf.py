import cv2
import numpy as np
import os
import random
import shutil

# Thư mục gốc
image_dir = 'data/train/images'
label_dir = 'data/train/labels'
bg_dir = 'data/background'
output_img_dir = 'data/aug_multi/images'
output_lbl_dir = 'data/aug_multi/labels'

os.makedirs(output_img_dir, exist_ok=True)
os.makedirs(output_lbl_dir, exist_ok=True)

def load_yolo_labels(label_path, img_width, img_height):
    boxes = []
    with open(label_path, 'r') as f:
        for line in f.readlines():
            cls, x, y, w, h = map(float, line.strip().split())
            # Chuyển từ tỉ lệ sang pixel
            x1 = int((x - w / 2) * img_width)
            y1 = int((y - h / 2) * img_height)
            x2 = int((x + w / 2) * img_width)
            y2 = int((y + h / 2) * img_height)
            boxes.append((cls, x1, y1, x2, y2))
    return boxes

def create_augmented_image(output_idx):
    bg_path = random.choice(os.listdir(bg_dir))
    bg = cv2.imread(os.path.join(bg_dir, bg_path))
    bg = cv2.resize(bg, (640, 640))

    bboxes_new = []

    for _ in range(random.randint(2, 3)):
        image_name = random.choice(os.listdir(image_dir))
        if not image_name.endswith('.jpg') and not image_name.endswith('.png'):
            continue

        img = cv2.imread(os.path.join(image_dir, image_name))
        h, w = img.shape[:2]
        label_path = os.path.join(label_dir, image_name.rsplit('.', 1)[0] + '.txt')

        boxes = load_yolo_labels(label_path, w, h)
        if not boxes:
            continue

        cls, x1, y1, x2, y2 = random.choice(boxes)
        leaf_crop = img[y1:y2, x1:x2]
        leaf_crop = cv2.resize(leaf_crop, (random.randint(100, 150), random.randint(100, 150)))

        # Random vị trí dán lên ảnh nền
        bh, bw = bg.shape[:2]
        px = random.randint(0, bw - leaf_crop.shape[1])
        py = random.randint(0, bh - leaf_crop.shape[0])

        # Dán
        bg[py:py+leaf_crop.shape[0], px:px+leaf_crop.shape[1]] = leaf_crop

        # Tính bbox mới tỉ lệ YOLO
        cx = (px + leaf_crop.shape[1] / 2) / bw
        cy = (py + leaf_crop.shape[0] / 2) / bh
        nw = leaf_crop.shape[1] / bw
        nh = leaf_crop.shape[0] / bh
        bboxes_new.append(f"{int(cls)} {cx:.6f} {cy:.6f} {nw:.6f} {nh:.6f}")

    # Lưu ảnh và nhãn
    out_img_name = f"multi_leaf_{output_idx}.jpg"
    out_lbl_name = f"multi_leaf_{output_idx}.txt"

    cv2.imwrite(os.path.join(output_img_dir, out_img_name), bg)
    with open(os.path.join(output_lbl_dir, out_lbl_name), 'w') as f:
        f.write('\n'.join(bboxes_new))

# 👉 Tạo 200 ảnh
for i in range(200):
    create_augmented_image(i)

print("✅ Đã tạo ảnh ghép có nhiều lá!")
