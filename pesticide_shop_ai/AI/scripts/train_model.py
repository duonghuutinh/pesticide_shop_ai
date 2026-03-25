from ultralytics import YOLO

def train_model():

    model = YOLO("D:/AI/yolo11n.pt")

    results = model.train(data='D:/AI/data_train_v4/data.yaml', epochs=100, imgsz=640)

if __name__ == "__main__":
    train_model()


# from ultralytics import YOLO
# import os

# def train_model():

#     model = YOLO("D:/AI/weights/best.pt")

#     # Train configuration
#     results = model.train(
#         data='D:/AI/data_train_v2/data.yaml',
#         epochs=500,                  
#         imgsz=640,                  
#         patience=20,   
#         batch=16,
#         name="yolov11_train_result",
#         project="D:/AI/train_result",
#         exist_ok=True
#     )


#     save_dir = os.path.join("D:/AI/train_result", "yolov11_train_result")
#     print("\n✅ Training hoàn tất!")
#     print(f"📂 Logs saved in: {save_dir}")
#     print(f"🥇 Best model saved at: {os.path.join(save_dir, 'weights/best.pt')}")
#     print(f"📉 CSV logs: {os.path.join(save_dir, 'results.csv')}")


# if __name__ == "__main__":
#     train_model()