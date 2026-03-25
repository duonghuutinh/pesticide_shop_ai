import os

# Đường dẫn đến thư mục label
dir_path = 'D:/AI/dataset/labels'

# Khởi tạo bộ đếm cho mỗi nhãn
# Nhãn: ['Algal Leaf Spot', 'Leaf Blight', 'Leaf Spot', 'No Disease']
label_counts = {0: 0, 1: 0, 2: 0, 3: 0}


# Duyệt qua tất cả các tập tin trong thư mục
for filename in os.listdir(dir_path):
    if filename.endswith('.txt'):
        with open(os.path.join(dir_path, filename), 'r') as f:
            for line in f:
                # Lấy nhãn từ dòng đầu tiên của mỗi dòng
                label = int(line.split()[0])
                # Nếu nhãn nằm trong danh sách nhãn cần đếm
                if label in label_counts:
                    label_counts[label] += 1

# Tính tổng số lượng của tất cả các nhãn
total_count = sum(label_counts.values())
print(f'Tổng số lượng của 4 nhãn là {total_count}')

# In ra số lượng của mỗi nhãn
for label, count in label_counts.items():
    print(f'Nhãn {label} có số lượng là {count}')

