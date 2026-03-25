
import os
from collections import Counter, defaultdict

# Cấu hình thư mục
base_dir = 'D:/AI/data_train_v3'
subsets = ['train', 'valid']

def count_images(subset):
    image_dir = os.path.join(base_dir, subset, 'images')
    return len([f for f in os.listdir(image_dir) if f.endswith('.jpg')])

def count_labels_in_subset(subset):
    label_dir = os.path.join(base_dir, subset, 'labels')
    label_counter = Counter()
    total_labels = 0

    for fname in os.listdir(label_dir):
        if not fname.endswith('.txt'):
            continue
        with open(os.path.join(label_dir, fname), 'r') as f:
            for line in f:
                if line.strip() == '':
                    continue
                class_id = line.strip().split()[0]
                label_counter[class_id] += 1
                total_labels += 1

    return label_counter, total_labels

# Tổng hợp kết quả
grand_total = 0
grand_label_counter = Counter()

print("📊 Thông tin Dataset:")
for subset in subsets:
    img_count = count_images(subset)
    label_counter, label_total = count_labels_in_subset(subset)
    
    grand_total += label_total
    grand_label_counter.update(label_counter)

    print(f"\n📁 {subset.upper()}:")
    print(f"  - Số ảnh: {img_count}")
    print(f"  - Tổng nhãn: {label_total}")
    print(f"  - Số lượng theo class:")
    for class_id, count in sorted(label_counter.items(), key=lambda x: int(x[0])):
        print(f"    - Class {class_id}: {count} nhãn")

print("\n📦 Tổng quan toàn bộ dataset:")
print(f"  - Tổng nhãn: {grand_total}")
print(f"  - Số lượng theo class:")
for class_id, count in sorted(grand_label_counter.items(), key=lambda x: int(x[0])):
    print(f"    - Class {class_id}: {count} nhãn")
