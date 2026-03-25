# import os
# import random
# import shutil

# # Cấu hình
# dataset_dir = 'D:/AI/dataset'
# output_dir = 'D:/AI/data_train'
# train_ratio = 0.8
# val_ratio = 0.2


# # Đọc danh sách ảnh
# images = [f for f in os.listdir(os.path.join(dataset_dir, 'images')) if f.endswith('.jpg')]
# random.shuffle(images)

# # Chia tập
# total = len(images)
# train_end = int(total * train_ratio)
# val_end = train_end + int(total * val_ratio)

# train_set = images[:train_end]
# val_set = images[train_end:val_end]


# def move_files(file_list, subset):
#     img_out = os.path.join(output_dir, subset, 'images')
#     lbl_out = os.path.join(output_dir, subset, 'labels')
#     os.makedirs(img_out, exist_ok=True)
#     os.makedirs(lbl_out, exist_ok=True)
#     for f in file_list:
#         shutil.copy(os.path.join(dataset_dir, 'images', f), os.path.join(img_out, f))
#         label_file = f.replace('.jpg', '.txt')
#         shutil.copy(os.path.join(dataset_dir, 'labels', label_file), os.path.join(lbl_out, label_file))

# def count_images(subset):
#     img_dir = os.path.join(output_dir, subset, 'images')
#     return len([f for f in os.listdir(img_dir) if f.endswith('.jpg')])


# move_files(train_set, 'train')
# move_files(val_set, 'val')


# # Đếm số ảnh đã chia
# train_count = count_images('train')
# val_count = count_images('val')


# print("Chia dữ liệu hoàn tất.")
# print(f"🟢 Train: {train_count} ảnh")
# print(f"🟡 Val:   {val_count} ảnh")





# import os
# import random
# import shutil

# # Cấu hình
# dataset_dir = 'D:/AI/dataset'
# output_dir = 'D:/AI/data_train_v4'
# train_ratio = 0.8

# # Đọc danh sách ảnh
# images = [f for f in os.listdir(os.path.join(dataset_dir, 'images')) if f.endswith('.jpg')]
# random.shuffle(images)

# # Chia tập
# total = len(images)
# train_end = int(total * train_ratio)

# train_set = images[:train_end]
# val_set = images[train_end:]

# def move_files(file_list, subset):
#     img_out = os.path.join(output_dir, subset, 'images')
#     lbl_out = os.path.join(output_dir, subset, 'labels')
#     os.makedirs(img_out, exist_ok=True)
#     os.makedirs(lbl_out, exist_ok=True)
#     for f in file_list:
#         shutil.copy(os.path.join(dataset_dir, 'images', f), os.path.join(img_out, f))
#         label_file = f.replace('.jpg', '.txt')
#         shutil.copy(os.path.join(dataset_dir, 'labels', label_file), os.path.join(lbl_out, label_file))

# def count_images(subset):
#     img_dir = os.path.join(output_dir, subset, 'images')
#     return len([f for f in os.listdir(img_dir) if f.endswith('.jpg')])

# move_files(train_set, 'train')
# move_files(val_set, 'val')

# # Đếm số ảnh đã chia
# train_count = count_images('train')
# val_count = count_images('val')

# print("Chia dữ liệu hoàn tất.")
# print(f"Train: {train_count} ảnh")
# print(f"Val:   {val_count} ảnh")


import os
import random
import shutil

# Cấu hình
background_dir = 'D:/AI/background/images'
output_dir = 'D:/AI/data_train_v4'
train_ratio = 0.8

# Đọc danh sách ảnh .jpg trong thư mục background
bg_images = [f for f in os.listdir(background_dir) if f.lower().endswith('.jpg')]
random.shuffle(bg_images)

# Chia tập
total = len(bg_images)
train_end = int(total * train_ratio)

bg_train = bg_images[:train_end]
bg_val = bg_images[train_end:]

# Hàm copy ảnh vào thư mục train/val
def move_background(files, subset):
    img_out = os.path.join(output_dir, subset, 'images')
    os.makedirs(img_out, exist_ok=True)
    for f in files:
        src = os.path.join(background_dir, f)
        dst = os.path.join(img_out, f)
        shutil.copy(src, dst)

# Thực hiện copy
move_background(bg_train, 'train')
move_background(bg_val, 'val')

# In kết quả
print("Chia ảnh background hoàn tất.")
print(f"🟢 Train background: {len(bg_train)} ảnh")
print(f"🟡 Val background:   {len(bg_val)} ảnh")







