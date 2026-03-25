use pesticide_shop;



CREATE TABLE `role` (
  `Role_ID` int NOT NULL AUTO_INCREMENT,
  `Role_name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  PRIMARY KEY (`Role_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Admin','Quản trị viên toàn hệ thống'),(2,'Customer','Khách hàng thông thường'),(3,'Collaborator','Cộng tác viên');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;





CREATE TABLE `users` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(500) NOT NULL,
  `Role_ID` int NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL DEFAULT 'Active',
  `Avatar` varchar(255) DEFAULT NULL,
  `Token_Code` varchar(11) DEFAULT NULL,
  `Date_created` datetime NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Email` (`Email`),
  KEY `Role_ID` (`Role_ID`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`Role_ID`) REFERENCES `role` (`Role_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'hohuuthuan789@gmail.com','$2y$10$B.94veR.J3CO/wtRnJtiiuQDpz8aVXqlOQAsFJV9W8mBGGReGBBLS',2,'Hồ Hữu Thuận','0345492751','102, ấp Tân Hoà, xã An Hiệp, Châu Thành, Đồng Tháp','1','1745313297-cabybara.jpg','JHP055823','2025-04-24 12:10:16'),(2,'admin123@gmail.com','$2y$10$JdKAXUcPCp8FkdkjseAt9.ZbLCLASMqlx06tInHkXrQ3/KCJK4uNi',1,'Hữu Thuận','0345492751','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','1','User-avatar.png','KPM870451','2025-04-22 11:03:32'),(3,'ttpt@gmail.com','$2y$10$sfJxXdk4wR/UE3IKrFL1SumcOGMT/mv8wZLjMBKQNfd1jwLhV9zTC',2,'Nguyễn Tấn Tài','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','1','User-avatar.png','RAE579607','2025-04-22 15:29:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;





CREATE TABLE `brand` (
  `BrandID` bigint NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Slug` varchar(255) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`BrandID`),
  UNIQUE KEY `Slug` (`Slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` VALUES (1,'Công Ty TNHH Bảo Vệ Thực Vật TDC','Công ty TNHH Bảo Vệ Thực Vật TDC là đơn vị tiên phong trong việc cung cấp phân bón và thuốc bảo vệ thực vật chất lượng cao tại Việt Nam.','1745360580-tdcpng.png','cong-ty-tnhh-bao-ve-thuc-vat-tdc',1),(2,'Công Ty Cổ Phần Phân Bón Cà Mau','Phân bón Cà Mau được biết đến với sản phẩm Urê Cà Mau, đáp ứng nhu cầu phân bón nitơ cho nông nghiệp Việt Nam. Công ty không ngừng cải tiến công nghệ và sản xuất để mang lại những sản phẩm hiệu quả, bền vững và an toàn cho môi trường.','1745360448-phan-bon-ca-maupng.png','cong-ty-co-phan-phan-bon-ca-mau',1),(3,'Công Ty Cổ Phần Phân Bón Việt Nhật (JVF)','Phân Bón Miền Nam đã có hơn 40 năm kinh nghiệm trong lĩnh vực sản xuất và phân phối phân bón. Các sản phẩm của công ty không chỉ cung cấp dinh dưỡng cho cây trồng mà còn giúp cải tạo đất, tăng cường độ phì nhiêu và năng suất nông sản.','1745360540-vietnhatpng.png','cong-ty-co-phan-phan-bon-viet-nhat-jvf',1),(4,'Công Ty Cổ Phần Phân Bón Bình Điền','Phân bón Bình Điền là một thương hiệu uy tín và lâu đời trong ngành nông nghiệp Việt Nam. Công ty này nổi tiếng với sản phẩm phân bón Đầu Trâu, được bà con nông dân ưa chuộng nhờ tính đa dạng và chất lượng cao.','1745360366-phân-bón-bình-điềnpng.png','cong-ty-co-phan-phan-bon-binh-dien',1),(5,'Công Ty TNHH Hóa Nông Lúa Vàng','Lúa Vàng là một trong những thương hiệu nổi tiếng trong ngành thuốc bảo vệ thực vật. Công ty chuyên cung cấp các sản phẩm bảo vệ cây trồng như thuốc trừ sâu, thuốc trừ bệnh, và thuốc diệt cỏ.','1745360686-luavangpng.png','cong-ty-tnhh-hoa-nong-lua-vang',1),(6,'Công Ty Cổ Phần Bảo Vệ Thực Vật Sài Gòn (SPC)','SPC đã có mặt trên thị trường từ năm 1985 và là một trong những đơn vị đi đầu trong lĩnh vực thuốc bảo vệ thực vật tại Việt Nam. Với hệ thống phân phối rộng khắp, SPC mang đến cho bà con nông dân các giải pháp bảo vệ cây trồng toàn diện và đáng tin cậy.','1745360230-SPCpng.png','cong-ty-co-phan-bao-ve-thuc-vat-sai-gon-spc',1),(7,'Công Ty Cổ Phần Nông Dược Hai','Nông Dược Hai là một trong những doanh nghiệp hàng đầu về cung cấp các loại thuốc bảo vệ thực vật. Với kinh nghiệm lâu năm và sự hợp tác với nhiều tập đoàn quốc tế, Nông Dược Hai mang đến những sản phẩm bảo vệ thực vật an toàn và hiệu quả, giúp cây trồng','1745360283-haipng.png','cong-ty-co-phan-nong-duoc-hai',1),(8,'Công Ty Cổ Phần Phân Bón Quốc Tế','Công ty Cổ phần Phân Bón Quốc Tế chuyên sản xuất các loại phân bón hữu cơ, phân vi sinh, và phân bón NPK chất lượng cao. Với cam kết mang lại sự bền vững cho nông nghiệp, các sản phẩm của công ty không chỉ đảm bảo năng suất mà còn giúp cải thiện môi trườn','1745360496-phan-bon-quoc-tepng.png','cong-ty-co-phan-phan-bon-quoc-te',1);
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;




CREATE TABLE `category` (
  `CategoryID` bigint NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Slug` varchar(255) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`CategoryID`),
  UNIQUE KEY `Slug` (`Slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Thuốc trừ bệnh trị nấm cây trồng','Danh mục dành cho những sản phẩm trừ bệnh và diệt nấm cây trồng','1745294644lá.png','thuoc-tru-benh-tri-nam-cay-trong',1),(2,'Thuốc diệt ốc','Danh mục cho những sản phẩm diệt ốc','1745294590lá.png','thuoc-diet-oc',1),(3,'Thuốc Sâu Rầy Nhện','Danh mục cho những sản phẩm đặc trị sâu, rầy và nhện','1745294600lá.png','thuoc-sau-ray-nhen',1),(4,'Thuốc diệt chuột','Danh mục dành cho những sản phẩm diệt chuột','1745465102lá.png','thuoc-diet-chuot',1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;



CREATE TABLE `discount` (
  `DiscountID` int NOT NULL AUTO_INCREMENT,
  `Coupon_code` varchar(50) NOT NULL,
  `Discount_type` enum('Percentage','Fixed') NOT NULL,
  `Discount_value` bigint NOT NULL,
  `Min_order_value` bigint NOT NULL DEFAULT '0',
  `Start_date` datetime NOT NULL,
  `End_date` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`DiscountID`),
  UNIQUE KEY `Coupon_code` (`Coupon_code`),
  CONSTRAINT `discount_chk_1` CHECK ((`Discount_value` >= 0)),
  CONSTRAINT `discount_chk_2` CHECK ((`Min_order_value` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `discount` WRITE;
/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
INSERT INTO `discount` VALUES (1,'SALE10','Percentage',10,500000,'2025-03-01 00:00:00','2025-12-31 00:00:00',0),(2,'VIP100','Fixed',100000,300000,'2025-04-17 00:00:00','2025-04-30 00:00:00',0),(3,'XMDLZ646555','Percentage',20,300000,'2025-04-22 00:00:00','2025-04-27 00:00:00',1),(4,'YVIDX893748','Fixed',100000,300000,'2025-04-22 00:00:00','2025-04-27 00:00:00',0),(5,'HAXQJ827764','Fixed',100000,300000,'2025-04-22 00:00:00','2025-04-27 00:00:00',1),(6,'HFMJU384240','Fixed',100000,300000,'2025-04-22 00:00:00','2025-04-27 00:00:00',0),(7,'CZRUK794789','Fixed',100000,300000,'2025-04-22 00:00:00','2025-04-27 00:00:00',0),(8,'QOEWJ663908','Fixed',100000,300000,'2025-04-22 00:00:00','2025-04-27 00:00:00',0),(9,'CBKPA50363','Fixed',100000,300000,'2025-04-22 00:00:00','2025-04-27 00:00:00',0),(13,'BCJXQ535141','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',0),(14,'IBXYT456183','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',1),(15,'RNOHV170343','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',1),(16,'WCDEY538489','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',1),(17,'SAJZR695375','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',1),(18,'TULNZ320921','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',1),(19,'QIMDT04446','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',1),(20,'MYWOX575925','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',1),(21,'OQRDA247932','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',1),(22,'DTZWA437722','Fixed',50000,300000,'2025-04-24 00:00:00','2025-05-23 00:00:00',1);
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;
UNLOCK TABLES;




DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `ProductID` bigint NOT NULL AUTO_INCREMENT,
  `Product_Code` varchar(50) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `Product_uses` varchar(255) DEFAULT NULL,
  `Unit` varchar(50) NOT NULL,
  `Selling_price` bigint NOT NULL,
  `Promotion` int DEFAULT '0',
  `Image` varchar(255) DEFAULT NULL,
  `Slug` varchar(255) NOT NULL,
  `CategoryID` bigint NOT NULL,
  `BrandID` bigint NOT NULL,
  `Date_created` datetime NOT NULL,
  `Status` int DEFAULT '0',
  `Deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ProductID`),
  UNIQUE KEY `Slug` (`Slug`),
  KEY `CategoryID` (`CategoryID`),
  KEY `BrandID` (`BrandID`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`),
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`BrandID`) REFERENCES `brand` (`BrandID`),
  CONSTRAINT `product_chk_1` CHECK ((`Selling_price` >= 0)),
  CONSTRAINT `product_chk_2` CHECK (((`Promotion` >= 0) and (`Promotion` <= 100)))
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Selecron500EC','Selecron 500EC','Selecron 500EC hiệu quả cao, diệt triệt để và nhanh chóng sâu non, thành trùng và trứng. Lý tưởng làm nền phối hợp với các loại thuốc trừ sâu khác, đặc biệt là nhóm Cúc tống hợp.','Mở rộng phổ phòng trị, hạ gục nhanh sâu hại, ngăn chặn dịch bộc phát, bảo vệ cây trồng tối đa. Diệt sâu kháng thuốc, tiết giảm công lao động.','Chai',50000,10,'1745296199Selecron-500EC.jpg','selecron-500ec',3,1,'2025-05-02 15:00:43',1,NULL),(2,'Pesieu500SC','Pesieu 500SC','Thuốc trừ sâu rầy nhện đỏ Pesieu 500SC :đặc trị sâu, rầy, nhện đỏ khó trị và đã bị kháng thuốc trên hoa hồng, hoa lan, các loại rau và cây ăn quả','Đặc trị sâu, rầy, nhện đỏ khó trị và đã bị kháng thuốc trên hoa hồng, hoa lan, các loại rau và cây ăn quả','Hộp',50000,10,'1745296414Pesieu-500SC.jpg','pesieu-500sc',3,1,'2025-05-02 15:00:43',1,NULL),(3,'NEEMNANO','NEEM NANO','Sản phẩm SẠCH. Chiết xuất 100% từ Tinh dầu Thảo Mộc','Đặc trị: Sâu ăn lá, rầy, rệp, nhện đỏ, trĩ, bọ nhẩy…','Chai',60000,10,'1745296490NEEM-NANO.jpg','neem-nano',3,1,'2025-05-02 15:00:43',1,NULL),(4,'Vidifen40EC','Vidifen 40EC','Vidifen 40EC hỗn hợp Dimethoate và Phethoate, có tác động nội hấp, tiếp xúc và vị độc','Phòng trừ rệp sáp hại cà phê, nhện đỏ hại cam, sâu xanh da láng hại đậu phộng (lạc ), bọ xít hôi hại lúa.','Chai',60000,10,'1745297157Vidifen-40EC.jpg','vidifen-40ec',3,4,'2025-05-02 15:00:43',1,NULL),(5,'Virtako40wg','Virtako 40 wg','Virtako 40 wg là dòng thuốc sâu thế hệ mới, cơ chế tác động mạnh và hiệu quả tức thì. Đặc trị sâu cuốn lá và sâu đục thân ngừng cắn phá sau 2h nhiễm thuốc, bảo vệ tối đa chồi hữu hiệu.','Chuyên phòng trừ sâu cuốn lá và đục thân bằng cơ chế gây rối loạn canxi trong hệ cơ, vừa tác động lên hệ thần kinh nên diệt các loại sâu có tính kháng thuốc với hiệu quả cao. Đặc biệt với đặc tính thấm sâu và lưu dẫn, bảo vệ cây trồng một cách toàn diện.','Túi',60000,10,'1745297245Virtako-40-wg.jpg','virtako-40-wg',3,4,'2025-05-02 15:00:43',1,NULL),(6,'DupontPrevathon5SC','Dupont Prevathon 5SC','Thuốc trừ sâu Dupont Prevathon 5SC là thuốc trừ sâu thế hệ mới. Sâu ngừng ăn ngay khi trúng thuốc. Phun 1 lần diệt cả sâu cuốn lá và sâu đục thân.','Đặc trị: Sâu cuốn lá, sâu đục thân lúa.Sâu tơ trên cải bắp.Bọ nhảy cải thìa.Dòi đục lá, sâu xanh cà chua.Dòi đục lá, sâu xanh sọc trắng dưa hấu.','Hộp chứa 6 túi',300000,10,'1745297378Dupont-Prevathon-5SC.jpg','dupont-prevathon-5sc',3,1,'2025-05-02 15:00:43',1,NULL),(7,'Danitol50EC','Danitol 50EC','Xông hơi mạnh, thẩm thấu nhanh xuyên qua lớp kitin hay lớp sáp.','Thuốc trừ sâu Danitol 50EC chuyên trị nhện và sâu rầy gây hại cây trồng.','Chai',80000,10,'1745297428Danitol-50EC.jpg','danitol-50ec',3,4,'2025-05-02 15:00:43',1,NULL),(8,'Reasgant3.6EC','Reasgant 3.6EC','Trị Rầy Hại Xoài; Bọ Cánh Tơ, Rầy Xanh, Nhện Đỏ Hại Chè','Trị Rầy Hại Xoài; Bọ Cánh Tơ, Rầy Xanh, Nhện Đỏ Hại Chè','Chai',80000,10,'1745297491Reasgant-3_6EC.jpg','reasgant-36ec',3,3,'2025-05-02 15:00:43',1,NULL),(9,'Dantotsu50WG','Dantotsu 50WG','Thuốc trừ sâu Dantotsu 50WG là thuốc diệt sâu rầy thế hệ mới, thuốc có tính lưu dẫn mạnh. Thuốc rất hiệu quả đối với côn trùng chích hút có cánh. Sản phẩm của Sumitomo Chemical TOKYO-JAPAN','Đặc trị rầy nâu gây hại. Diệt cả rầy non và rầy trưởng thành, diệt được cả sâu miệng nhai và cả công trùng chích hút nên sử dụng được trên nhiều đối tượng sâu hại, Hiệu quả ổn định và duy trì lâu dài,','Túi',50000,10,'1745297580Dantotsu-50WG.jpg','dantotsu-50wg',3,3,'2025-05-02 15:00:43',1,NULL),(10,'Storm','Thuốc diệt chuột Storm','Thuốc diệt chuột Storm dùng để diệt chuột trong nhà, trại chăn nuôi, nhà máy xay xát, kho tàng, khách sạn, nhà hàng, bệnh viện… và ngoài đồng ruộng, vườn cây ăn trái.','Thuốc diệt chuột Storm dùng để diệt chuột trong nhà, trại chăn nuôi, nhà máy xay xát, kho tàng, khách sạn, nhà hàng, bệnh viện… và ngoài đồng ruộng, vườn cây ăn trái.','Túi',35000,10,'1745298508Thuốc-diệt-chuột-Storm.jpg','thuoc-diet-chuot-storm',4,3,'2025-05-02 15:00:43',1,NULL),(11,'Killrat','Thuốc diệt chuột Killrat','Thuốc diệt chuột Killrat là thuốc trừ chuột chống đông máu thế hệ mới, diệt chuột chỉ sau một lần ăn mồi. “Can kill in one feeding”','Thuốc diệt chuột Killrat là thuốc trừ chuột chống đông máu thế hệ mới, diệt chuột chỉ sau một lần ăn mồi. “Can kill in one feeding”','Hộp',38000,0,'1745303100Thuốc-diệt-chuột-Killrat.jpg','thuoc-diet-chuot-killrat',4,2,'2025-05-02 15:00:43',1,NULL),(12,'Kokubo','Thuốc diệt chuột Kokubo','Thuốc diệt chuột Kokubo nội địa Nhật Bản gồm cấu tạo thành phần hóa học được làm từ Warfarin và lúa mạch có tác dụng thu hút khiến chuột tới để kiếm ăn và sau 2-3 ngày sẽ chết. Đặc biệt không hại cây trồng','Thuốc diệt chuột Kokubo nội địa Nhật Bản gồm cấu tạo thành phần hóa học được làm từ Warfarin và lúa mạch có tác dụng thu hút khiến chuột tới để kiếm ăn và sau 2-3 ngày sẽ chết. Đặc biệt không hại cây trồng','Hộp',40000,0,'1745303164Thuốc-diệt-chuột-Kokubo.jpg','thuoc-diet-chuot-kokubo',4,2,'2025-05-02 15:00:43',1,NULL),(13,'Forwarat','Thuốc diệt chuột Forwarat','Thuốc diệt chuột Forwarat là loại chống đông máu rất mạnh và diệt chuột chỉ sau 1 lần ăn phải. Bởi vì thời gian chết kéo dài từ 3 đên 5 ngày nên những con khác sẽ không biết mà tiếp tục ăn.','Thuốc diệt chuột Forwarat là loại chống đông máu rất mạnh và diệt chuột chỉ sau 1 lần ăn phải. Bởi vì thời gian chết kéo dài từ 3 đên 5 ngày nên những con khác sẽ không biết mà tiếp tục ăn.','Hộp',45000,0,'1745303231Thuốc-diệt-chuột-Forwarat.jpg','thuoc-diet-chuot-forwarat',4,1,'2025-05-02 15:00:43',1,NULL),(14,'RAT-K','Thuốc diệt chuột RAT-K','RAT-K là thuốc diệt chuột thuộc nhóm chóng đông máu gây xuất huyết nội tạng và chuột bị chết sau khi ăn mồi 2-3 ngày. Không mùi vị và gây chết chậm nên chuột không sợ mồi. tiện dụng giá thành rẻ, dễ bảo quản, phù hợp với tập quán của nông dân.','RAT-K là thuốc diệt chuột thuộc nhóm chóng đông máu gây xuất huyết nội tạng và chuột bị chết sau khi ăn mồi 2-3 ngày. Không mùi vị và gây chết chậm nên chuột không sợ mồi. tiện dụng giá thành rẻ, dễ bảo quản, phù hợp với tập quán của nông dân.','Túi',32000,0,'1745303322Thuốc-diệt-chuột-RAT-K.jpg','thuoc-diet-chuot-rat-k',4,4,'2025-05-02 15:00:43',1,NULL),(15,'Racumin0.75Tp20G','Racumin 0.75Tp 20G','Thuốc diệt chuột Racumin 0.75Tp 20G, không làm chết gà, vịt, chó, mèo,... CHỈ chết chuột, hấp dẫn chuột, diệt chuột thông minh và nhanh chóng.','Thuốc diệt chuột Racumin 0.75Tp 20G, không làm chết gà, vịt, chó, mèo,... CHỈ chết chuột, hấp dẫn chuột, diệt chuột thông minh và nhanh chóng.','Túi',50000,10,'1745303511Thuốc-Diệt-Chuôt-Racumin-0_75Tp-20G.jpg','racumin-075tp-20g',4,3,'2025-05-02 15:00:43',1,NULL),(16,'Cat0.25WP','Cat 0.25WP','Cat 0.25WP là thuốc diệt chuột nhóm Chống Đông Máu thế hệ mới gây xuất huyết nội tạng. Cat 0.25WP không mùi vị, không gây co giật nên chuột không bị ngán mồi','Cat 0.25WP là thuốc diệt chuột nhóm Chống Đông Máu thế hệ mới gây xuất huyết nội tạng. Cat 0.25WP không mùi vị, không gây co giật nên chuột không bị ngán mồi','Túi',35000,0,'1745303574Thuốc-diệt-chuột-Cat-0_25WP.jpg','cat-025wp',4,2,'2025-05-02 15:00:43',1,NULL),(17,'ARSRATKILLER','ARS RAT KILLER','Là loại thuốc diệt chuột đa liều, khi chuột ăn phải sẽ chết sau từ 1 đến 3 ngày. Sau khi ăn thuốc, chuột sẽ không có biểu hiện khác thường, chuột và đồng loại kéo tới tiếp tục ăn thuốc mà không có sự đề phòng. Thuốc diệt chuột Thái chứa chất Warfarin khiến chuột xuất huyết ở mắt, do đó chuột sẽ có xu hướng tìm ra chỗ sáng, nên rất dễ cho ta xử lý xác chuột. Thuốc có hương vị đặc trưng hấp dẫn loài chuột dễ dàng tiêu diệt cả đàn chuột khỏi gia đình bạn.','Là loại thuốc diệt chuột đa liều, khi chuột ăn phải sẽ chết sau từ 1 đến 3 ngày. Sau khi ăn thuốc, chuột sẽ không có biểu hiện khác thường, chuột và đồng loại kéo tới tiếp tục ăn thuốc mà không có sự đề phòng. Thuốc diệt chuột Thái chứa chất Warfarin khiế','Hộp',45000,0,'1745303678Viên-Diệt-Chuột-ARS-RAT-KILLER-Thái-Lan.jpg','ars-rat-killer',4,4,'2025-05-02 15:00:43',1,NULL),(18,'Dethmor','Thuốc diệt chuột Dethmor','Đây là thuốc diệt chuộc đa liều, Chuột ăn thuốc và chết sau 1 -3 ngày. Sau khi ăn thuốc, chuột không có biểu hiện gì, chúng và đồng loại vẫn tiếp tục ăn mà không đề phòng. Sau 1-3 ngày chúng sẽ chết. Vì thế hiệu quả diệt cả đàn chuột là rất cao.','Đây là thuốc diệt chuộc đa liều, Chuột ăn thuốc và chết sau 1 -3 ngày. Sau khi ăn thuốc, chuột không có biểu hiện gì, chúng và đồng loại vẫn tiếp tục ăn mà không đề phòng. Sau 1-3 ngày chúng sẽ chết. Vì thế hiệu quả diệt cả đàn chuột là rất cao.','Hộp',55000,0,'1745303741Thuốc-diệt-chuột-hồng-Dethmor.jpg','thuoc-diet-chuot-dethmor',2,4,'2025-05-02 15:00:43',1,NULL),(19,'Broma','Thuốc diệt chuột Broma','Thuốc diệt chuột thế hệ mới Broma hiểu quả tuyệt vời. Broma 0,005 AB là thuốc diệt chuột nhóm chống đông máu thế hệ mới gây xuất huyết nội tạng. Gói thuốc đã trộn sẵn 2 loại là hạt thóc và hạt mạch cùng phụ gia đảm bảo hấp dẫn loài chuột khiến chúng không cảnh giác. Chỉ sau 1 lần ăn chuột sẽ chết từ 90-100% trong vòng 2-5 ngày, dùng để diệt chuột đồng và những nơi có chuột.','Thuốc diệt chuột thế hệ mới Broma hiểu quả tuyệt vời. Broma 0,005 AB là thuốc diệt chuột nhóm chống đông máu thế hệ mới gây xuất huyết nội tạng. Gói thuốc đã trộn sẵn 2 loại là hạt thóc và hạt mạch cùng phụ gia đảm bảo hấp dẫn loài chuột khiến chúng không','Túi',40000,0,'1745303826Thuốc-diệt-chuột-Broma.jpg','thuoc-diet-chuot-broma',4,2,'2025-05-02 15:00:43',1,NULL),(20,'Helix®500WP','Helix® 500WP','Helix 500WP là thuốc dạng phun, đặc trị Ốc hiệu quả cao. Đặc biệt chuyên trị ốc gây hại trên cây cảnh, lúa.','Helix 500WP là thuốc dạng phun, đặc trị Ốc hiệu quả cao. Đặc biệt chuyên trị ốc gây hại trên cây cảnh, lúa.','Túi',65000,0,'1745303880THUỐC-TRỪ-ỐC-Helix®-500WP.jpg','helix®-500wp',2,1,'2025-05-02 15:00:43',1,NULL),(21,'VT-DAX700WP','VT-DAX 700WP','VT-DAX 700WP là thuốc trừ ốc bươu vàng hại lúa, có tác dụng xông hơi và vị độc, làm ức chế men hô hấp và trao đổi chất trong cơ thể của ốc, thuốc tiếp xúc với trứng, làm ung trứng, thối trứng, làm cho trứng không nở thành ốc con','VT-DAX 700WP là thuốc trừ ốc bươu vàng hại lúa, có tác dụng xông hơi và vị độc, làm ức chế men hô hấp và trao đổi chất trong cơ thể của ốc, thuốc tiếp xúc với trứng, làm ung trứng, thối trứng, làm cho trứng không nở thành ốc con','Túi',35000,0,'1745303990VT-DAX-700WP.jpg','vt-dax-700wp',2,1,'2025-05-02 15:00:43',1,NULL),(22,'CLEAR700wp','CLEAR700wp','CLEAR700wp là thuốc trừ ốc có tác dụng xông hơi và vị độc, làm ức chế hô hấp và trao đổi chất trong cơ thể của ốc , diệt trừ tận gốc tất cả các loại ốc hại lúa và rau màu thuốc có thể trộn vào cát hoặc lân đạm rắc, hoặc phun.','CLEAR700wp là thuốc trừ ốc có tác dụng xông hơi và vị độc, làm ức chế hô hấp và trao đổi chất trong cơ thể của ốc , diệt trừ tận gốc tất cả các loại ốc hại lúa và rau màu thuốc có thể trộn vào cát hoặc lân đạm rắc, hoặc phun.','Túi',65000,0,'1745304044CLEAR700wp.jpg','clear700wp',2,4,'2025-05-02 15:00:43',1,NULL),(23,'SACHOCTSC850WP','SACHOC TSC 850WP','SACHOC TSC 850WP có hàm lượng hoạt chất chính Niclosamide cao (850g / kg) có tác dụng sâu rộng đến hệ hô hấp của ốc. Kết quả là thuốc có tác dụng nhanh – ốc bươu vàng chết sau 15-20 phút. Đặc biệt, SACHOC TSC 850WP tạo ra hiệu ứng hơi nước và hương độc khi hít thở, dẫn đến ốc bươu vàng chết nhanh.','SACHOC TSC 850WP có hàm lượng hoạt chất chính Niclosamide cao (850g / kg) có tác dụng sâu rộng đến hệ hô hấp của ốc. Kết quả là thuốc có tác dụng nhanh – ốc bươu vàng chết sau 15-20 phút. Đặc biệt, SACHOC TSC 850WP tạo ra hiệu ứng hơi nước và hương độc kh','Túi',48000,0,'1745304143SACHOC-TSC-850WP.jpg','sachoc-tsc-850wp',2,3,'2025-05-02 15:00:43',1,NULL),(24,'Sun-fasti700WP','Sun-fasti 700WP','Hoạt chất Niclosamide trong Sun-fasti 700WP tác động lên cả hệ tiêu hóa và hô hấp của ốc táo vàng, cũng như khả năng tiêu diệt ốc tại chỗ do phạm vi hoạt động rộng','Hoạt chất Niclosamide trong Sun-fasti 700WP tác động lên cả hệ tiêu hóa và hô hấp của ốc táo vàng, cũng như khả năng tiêu diệt ốc tại chỗ do phạm vi hoạt động rộng','Túi',50000,0,'1745304228Sun-fasti-700WP.jpg','sun-fasti-700wp',2,2,'2025-05-02 15:00:43',1,NULL),(25,'RedDuck12BR','Red Duck 12BR','Red Duck 12BR được tạo thành từ hai hoạt chất: metaldehyde (6g / kg) và niclosamide (6g / kg). Metaldehyde vừa hấp dẫn vừa có hại cho hệ thần kinh của ốc sên táo vàng, còn Niclosamide ảnh hưởng đến hệ hô hấp và tiêu hóa của ốc.','Red Duck 12BR được tạo thành từ hai hoạt chất: metaldehyde (6g / kg) và niclosamide (6g / kg). Metaldehyde vừa hấp dẫn vừa có hại cho hệ thần kinh của ốc sên táo vàng, còn Niclosamide ảnh hưởng đến hệ hô hấp và tiêu hóa của ốc.','Túi',52000,0,'1745304312Red-Duck-12BR.jpg','red-duck-12br',2,1,'2025-05-02 15:00:43',1,NULL),(26,'BlackCarp700wp','BlackCarp 700wp','BlackCarp 700wp là thuốc trừ ốc có tác dụng xông hơi vị độc, làm ức chế men hô hấp và trao đổi chất trong cơ thể ốc, làm ốc chết nhanh.\r\nThuốc đặc trị ốc bươu vàng hại lúa, phun một lần diệt sạch ốc to, ốc nhỏ, và trứng ốc, làm tươi xốp vỏ ốc. Thuốc an toàn với lúa.','BlackCarp 700wp là thuốc trừ ốc có tác dụng xông hơi vị độc, làm ức chế men hô hấp và trao đổi chất trong cơ thể ốc, làm ốc chết nhanh.\r\nThuốc đặc trị ốc bươu vàng hại lúa, phun một lần diệt sạch ốc to, ốc nhỏ, và trứng ốc, làm tươi xốp vỏ ốc. Thuốc an to','Hộp',45000,10,'1745304395BlackCarp-700wp.jpg','blackcarp-700wp',2,1,'2025-05-02 15:00:43',1,NULL),(27,'ANTIOC777WP','ANTIOC 777WP','ANTIOC 777WP là thuốc trừ ốc cao cấp được kết hợp bởi hai hoạt chất mạnh, có tác dụng xông hơi vị độc, làm ức chế men hô hấp và trao đổi chất trong cơ thể ốc, làm ốc chết nhanh. Thuốc đặc trị ốc bươu vàng hại lúa, phun một lần diệt sạch ốc to, ốc nhỏ, và trứng ốc, làm tươi xốp vỏ ốc. Thuốc an toàn với lúa.','ANTIOC 777WP là thuốc trừ ốc cao cấp được kết hợp bởi hai hoạt chất mạnh, có tác dụng xông hơi vị độc, làm ức chế men hô hấp và trao đổi chất trong cơ thể ốc, làm ốc chết nhanh. Thuốc đặc trị ốc bươu vàng hại lúa, phun một lần diệt sạch ốc to, ốc nhỏ, và ','Hộp',48000,10,'1745304450ANTIOC-777WP.jpg','antioc-777wp',2,4,'2025-05-02 15:00:43',1,NULL),(28,'DIOTO','DIOTO','Là thuốc trừ ốc bươu vàng (Golden Apple Snail). DIOTO có nghĩa là diệt ốc tốt, hoạt chất là Niclosamide, có hai dạng chế phẩm: Dạng nhũ dầu (EC), hàm lượng hoạt chất 250gam/L, Dạng cốm (WG), hàm lượng hoạt chất 830gam/kg, DIOTO là thuốc đặc trị ốc bươu vàng. Thuốc tác động nhanh đến chức năng hô hấp và tiêu hoá, ngăn cản hấp thu đường và quá trình biến dưỡng khiến ốc không hấp thu được oxy và dưỡng chất mà chết chỉ sau khi phun 15 đến 30 phút.','Là thuốc trừ ốc bươu vàng (Golden Apple Snail). DIOTO có nghĩa là diệt ốc tốt, hoạt chất là Niclosamide, có hai dạng chế phẩm: Dạng nhũ dầu (EC), hàm lượng hoạt chất 250gam/L, Dạng cốm (WG), hàm lượng hoạt chất 830gam/kg, DIOTO là thuốc đặc trị ốc bươu v','Chai',60000,0,'1745304550DIOTO.jpg','dioto',4,1,'2025-05-02 15:00:43',1,NULL),(29,'BOLIS12GB','BOLIS 12GB','BOLIS 12GB – là thuốc đặc trị ốc bươu vàng với dạng bã mồi tiên tiến nhất hiện nay. Diệt sạch ốc lớn và ốc nhỏ. Dễ dàng trộn giống để rải. Ngoài thành phần diệt ốc thuốc còn chứa chất dẫn dụ nên diệt ốc rất triệt để. BOLIS 12GB – không độc đối với cá, ít ảnh hưởng môi trường và con người','BOLIS 12GB – là thuốc đặc trị ốc bươu vàng với dạng bã mồi tiên tiến nhất hiện nay. Diệt sạch ốc lớn và ốc nhỏ. Dễ dàng trộn giống để rải. Ngoài thành phần diệt ốc thuốc còn chứa chất dẫn dụ nên diệt ốc rất triệt để. BOLIS 12GB – không độc đối với cá, ít ','Túi',45000,10,'1745304650BOLIS-12GB.jpg','bolis-12gb',2,1,'2025-05-02 15:00:43',1,NULL),(30,'Anvil5SC','Anvil 5SC','phòng trị hiệu quả các bệnh hại quan trọng trên lúa (khô vằn, lem lép hạt) và các loại cây trồng khác, giữ xanh bộ lá thông qua hiệu quả trừ bệnh tuyệt hảo. Đóng góp tích cực cho tối ưu năng suất và chất lượng hạt lúa','phòng trị hiệu quả các bệnh hại quan trọng trên lúa (khô vằn, lem lép hạt) và các loại cây trồng khác, giữ xanh bộ lá thông qua hiệu quả trừ bệnh tuyệt hảo. Đóng góp tích cực cho tối ưu năng suất và chất lượng hạt lúa. Trị bệnh cháy lá','Chai',70000,10,'1745304815Thuốc-trừ-bệnh-Anvil-5SC.jpg','anvil-5sc',1,1,'2025-05-02 15:00:43',1,NULL),(31,'Isacop65.2WG','Isacop 65.2 WG','Isacop 65.2 WG là thuốc trừ bệnh thế hệ mới của Tập đoàn Lộc Trời. Thuốc có dụng tiếp xúc, phòng trị và ngăn chặn nấm bệnh xâm nhiễm hiệu quả. Thuốc chuyên trị bệnh ghẻ sẹo trên cây có múi và một số loại nấm bệnh khác như thán thư, sương mai, đốm lá…','Isacop 65.2 WG là thuốc trừ bệnh thế hệ mới của Tập đoàn Lộc Trời. Thuốc có dụng tiếp xúc, phòng trị và ngăn chặn nấm bệnh xâm nhiễm hiệu quả. Thuốc chuyên trị bệnh ghẻ sẹo trên cây có múi và một số loại nấm bệnh khác như thán thư, sương mai, đốm lá…','Túi',68000,10,'1745304880Isacop-65_2-WG.jpg','isacop-652-wg',1,1,'2025-05-02 15:00:43',1,NULL),(32,'Antracol70WP','Antracol 70WP','Thuốc trừ bệnh Antracol 70WP là thuốc phòng trừ bệnh phổ rộng, dạng bột thấm nước, có độ phủ tốt và có độ bám dính cao trên bề mặt lá khi phun, còn cung cấp vi lượng kẽm(Zn++) cho cây trồng giúp phát triển xanh tốt, tăng năng suất và chất lượng nông phẩm.','Thuốc trừ bệnh Antracol 70WP là thuốc phòng trừ bệnh phổ rộng, dạng bột thấm nước, có độ phủ tốt và có độ bám dính cao trên bề mặt lá khi phun, còn cung cấp vi lượng kẽm(Zn++) cho cây trồng giúp phát triển xanh tốt, tăng năng suất và chất lượng nông phẩm.','Túi',60000,10,'1745304987Antracol-70WP.jpg','antracol-70wp',1,3,'2025-05-02 15:00:43',1,NULL),(33,'Vimonyl72WP','Vimonyl72WP','Thuốc trừ bệnh Vimonyl 72WP là hỗn hợp thuốc trừ bệnh có tác động tiếp xúc và lưu dẫn; có phổ tác dụng rộng, được đăng kí phòng trừ bệnh sương mai hại rau, loét sọc mặt cạo hại cây cao su.','Thuốc trừ bệnh Vimonyl 72WP là hỗn hợp thuốc trừ bệnh có tác động tiếp xúc và lưu dẫn; có phổ tác dụng rộng, được đăng kí phòng trừ bệnh sương mai hại rau, loét sọc mặt cạo hại cây cao su.','Túi',50000,10,'1745305065Vimonyl-72WP.jpg','vimonyl72wp',1,2,'2025-05-02 15:00:43',1,NULL),(34,'Filia525SE','Filia 525SE','Thuốc trừ bệnh Filia 525SE là thuốc trừ bệnh nội hấp và lưu dẫn mạnh, phòng và trị bệnh đạo ôn hiệu quả trên cây lúa thông qua cơ chế tác động kép độc đáo.','Thuốc trừ bệnh Filia 525SE là thuốc trừ bệnh nội hấp và lưu dẫn mạnh, phòng và trị bệnh đạo ôn hiệu quả trên cây lúa thông qua cơ chế tác động kép độc đáo.','Chai',40000,10,'1745305125Filia-525SE.jpg','filia-525se',1,4,'2025-05-02 15:00:43',1,NULL),(35,'Score250EC','Score 250EC','Score 250EC thấm sâu nhanh và lưu dẫn mạnh trong thân, lá… để tầm soát và tiêu diệt nấm bệnh. Hạn chế bị rửa trôi dù bị mưa sau khi phun vài giờ, phù hợp xử lý trong mọi điều kiện thời tiết.','Score 250EC thấm sâu nhanh và lưu dẫn mạnh trong thân, lá… để tầm soát và tiêu diệt nấm bệnh. Hạn chế bị rửa trôi dù bị mưa sau khi phun vài giờ, phù hợp xử lý trong mọi điều kiện thời tiết. Trị bệnh đốm rong','Chai',35000,0,'1745305189Score-250EC.jpg','score-250ec',1,1,'2025-05-02 15:00:43',1,NULL),(36,'MANOZEB80WP','MANOZEB 80WP','Thuốc trị nấm MANOZEB 80WP\r\n có phổ phòng trừ rất rộng, phòng trừ hiệu quả trên 400 loại nấm bệnh trên hơn 70 loại cây trồng khác nhau như: bệnh chết nhanh, cháy lá, đốm vằn, đốm lá, thán thư, sương mai, đốm lá, rỉ sắt, phấn trắng, thối rễ, thối thân thối trái… trên lúa, bắp, các loại đậu đổ, rau cải, dưa, cây công nghiệp, cây ăn quả, hoa và cây kiểng…','Thuốc trị nấm MANOZEB 80WP\r\n có phổ phòng trừ rất rộng, phòng trừ hiệu quả trên 400 loại nấm bệnh trên hơn 70 loại cây trồng khác nhau như: bệnh chết nhanh, cháy lá, đốm vằn, đốm lá, thán thư, sương mai, đốm lá, rỉ sắt, phấn trắng, thối rễ, thối thân thối','Túi',65000,0,'1745305252MANOZEB-80WP.jpg','manozeb-80wp',1,2,'2025-05-02 15:00:43',1,NULL),(37,'Totan200 WP','Totan 200 WP','Totan 200 WP là thuốc trừ bệnh vi khuẩn có tác dụng tiếp xúc và tác động mạnh. Phòng trừ bệnh cháy bìa lá (cháy lá) và bệnh vàng lá chín sớm hại lúa.','Totan 200 WP là thuốc trừ bệnh vi khuẩn có tác dụng tiếp xúc và tác động mạnh. Phòng trừ bệnh cháy bìa lá (cháy lá) và bệnh vàng lá chín sớm hại lúa.','Túi',40000,0,'1745305344Totan-200-WP.jpg','totan-200-wp',1,4,'2025-05-02 15:00:43',1,NULL),(38,'CabrioTop600WG','Cabrio Top 600WG','Công dụng của Cabrio Top 600WG: bệnh sương mai trên dưa hấu, bệnh giả sương mai trên dưa chuột, bệnh thán thư trên ớt, hoa kiểng và phong lan, bệnh mốc sương trên khoai tây, đạo ôn trên lúa, thán thư trên xoài, ghẻ sẹo trên cam.','Công dụng của Cabrio Top 600WG: bệnh sương mai trên dưa hấu, bệnh giả sương mai trên dưa chuột, bệnh thán thư trên ớt, hoa kiểng và phong lan, bệnh mốc sương trên khoai tây, đạo ôn trên lúa, thán thư trên xoài, ghẻ sẹo trên cam.','Chai',55000,0,'1745305576Cabrio-Top-600WG.jpg','cabrio-top-600wg',1,3,'2025-05-02 15:00:43',1,NULL),(39,'Vitrobin320SC','Vitrobin 320SC','Thuốc đặc trị bệnh đạo ôn lá, đạo ôn cổ bông, đen lép hạt cây lúa, thán thư, phấn trắng cây Xoài, bệnh sương mai, lở cổ rễ, nứt thân xì mủ cây cà chua. Thuốc đặc trị thán thư, phấn trắng, đốm lá chết cây trên rau màu. Đặc trị sẹo ghẻ lồi trên cam quýt','Thuốc đặc trị bệnh đạo ôn lá, đạo ôn cổ bông, đen lép hạt cây lúa, thán thư, phấn trắng cây Xoài, bệnh sương mai, lở cổ rễ, nứt thân xì mủ cây cà chua. Thuốc đặc trị thán thư, phấn trắng, đốm lá chết cây trên rau màu. Đặc trị sẹo ghẻ lồi trên cam quýt, Tr','Chai',80000,0,'1745305686Vitrobin-320SC.jpg','vitrobin-320sc',1,2,'2025-05-02 15:00:43',1,NULL);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;



DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ProductID` bigint DEFAULT NULL,
  `UserID` int DEFAULT NULL,
  `rating` tinyint NOT NULL,
  `comment` text,
  `reply` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ProductID` (`ProductID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL,
  CONSTRAINT `reviews_chk_1` CHECK ((`rating` between 1 and 5))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,30,2,4,'Sản phẩm rất tốt','Cảm ơn quý khách','2025-04-24 14:41:10','2025-05-02 15:00:43',1);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `SupplierID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Contact` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`SupplierID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Công Ty TNHH Tây Trúc Xanh\n','Hồ Hữu Thuận',' 0913344479','36 Sunrise C, Đường Số 1, Khu Đô Thị The Manor CentralPark, P. Đại Kim, Q. Hoàng Mai, Hà Nội','taytrucxanh@gmail.com',0),(2,'Công Ty TNHH Đầu Tư Phát Triển Nông Nghiệp Bốn Mùa KBM','Nguyễn Tấn Tài','0988885089','Tầng 2, Tòa Nhà Số 53 Lê Lăng, Phường Phú Thọ Hòa, Quận Tân Phú, TP. Hồ Chí Minh (TPHCM)','bonmua.cskh@gmail.com',0),(3,'Công Ty TNHH Anh Dẩu - Tiền Giang','Trịnh Trần Phương Lan','0915633224','Ấp Mỹ Trung, X. Hậu Mỹ Bắc B, H. Cái Bè, Tiền Giang','congtyanhdautg@gmail.com',0),(4,'Sygenta','Trịnh Trần Phương Lan','0987654321','Ấp Mỹ Trung, X. Hậu Mỹ Bắc B, H. Cái Bè, Tiền Giang','hohuuthuan789@gmail.com',0);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;



DROP TABLE IF EXISTS `warehouse_receipt`;
CREATE TABLE `warehouse_receipt` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tax_identification_number` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name_of_delivery_person` varchar(100) NOT NULL,
  `delivery_unit` varchar(100) DEFAULT NULL,
  `address` text,
  `delivery_note_number` varchar(255) DEFAULT NULL,
  `warehouse_from` varchar(100) DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `sub_total` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_supplier_id` (`supplier_id`),
  CONSTRAINT `warehouse_receipt_fk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`SupplierID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `warehouse_receipt` WRITE;
/*!40000 ALTER TABLE `warehouse_receipt` DISABLE KEYS */;
INSERT INTO `warehouse_receipt` VALUES (1,1,'2025-04-21 17:00:00','Hồ Hữu Thuận','Đơn vị vận chuyển','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','Phiếu giao nhận số 1','Nhập nội bộ từ kho 1',1,82500000),(2,2147483647,'2025-04-23 17:00:00','Hồ Hữu Thuận','Đơn vị vận chuyển công ty cây trúc','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','Phiếu giao nhận số 2','Nhập nội bộ từ kho trung tâm',1,558900000);
/*!40000 ALTER TABLE `warehouse_receipt` ENABLE KEYS */;
UNLOCK TABLES;



DROP TABLE IF EXISTS `warehouse_receipt_items`;
CREATE TABLE `warehouse_receipt_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Receipt_id` bigint NOT NULL,
  `ProductID` bigint NOT NULL,
  `Product_Code` varchar(50) DEFAULT NULL,
  `Unit` varchar(50) NOT NULL,
  `Import_price` bigint NOT NULL,
  `Exp_date` datetime NOT NULL,
  `Quantity_doc` bigint NOT NULL,
  `Quantity_actual` bigint NOT NULL,
  `Notes` text,
  PRIMARY KEY (`id`),
  KEY `receipt_id` (`Receipt_id`),
  KEY `idx_product_id` (`ProductID`),
  KEY `idx_receipt_id` (`Receipt_id`),
  CONSTRAINT `warehouse_receipt_items_fk_1` FOREIGN KEY (`Receipt_id`) REFERENCES `warehouse_receipt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `warehouse_receipt_items_fk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE,
  CONSTRAINT `warehouse_receipt_items_chk_1` CHECK ((`Quantity_doc` >= 0)),
  CONSTRAINT `warehouse_receipt_items_chk_2` CHECK ((`Quantity_actual` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `warehouse_receipt_items` WRITE;
/*!40000 ALTER TABLE `warehouse_receipt_items` DISABLE KEYS */;
INSERT INTO `warehouse_receipt_items` VALUES (1,1,1,'Selecron500EC','Chai',20000,'2026-02-22 00:00:00',1000,1000,''),(2,1,2,'Pesieu500SC','Hộp',20000,'2026-02-22 00:00:00',1000,1000,''),(3,1,3,'NEEMNANO','Chai',20000,'2026-02-22 00:00:00',500,500,''),(4,1,14,'RAT-K','Túi',10000,'2026-12-31 00:00:00',500,500,''),(5,1,22,'CLEAR700wp','Túi',25000,'2026-11-29 00:00:00',700,700,''),(6,1,28,'DIOTO','Chai',20000,'2026-12-31 00:00:00',500,500,''),(7,2,1,'Selecron500EC','Chai',20000,'2026-12-24 00:00:00',100,100,''),(8,2,2,'Pesieu500SC','Hộp',15000,'2026-12-24 00:00:00',100,100,''),(9,2,3,'NEEMNANO','Chai',20000,'2026-12-24 00:00:00',1000,1000,''),(10,2,4,'Vidifen40EC','Chai',20000,'2026-12-24 00:00:00',1000,1000,''),(11,2,5,'Virtako40wg','Túi',18000,'2026-04-24 00:00:00',1000,1000,''),(12,2,6,'DupontPrevathon5SC','Hộp chứa 6 túi',120000,'2026-04-24 00:00:00',1000,1000,''),(13,2,7,'Danitol50EC','Chai',40000,'2026-04-24 00:00:00',100,100,''),(14,2,8,'Reasgant3.6EC','Chai',40000,'2026-04-24 00:00:00',1000,1000,''),(15,2,9,'Dantotsu50WG','Túi',20000,'2026-04-24 00:00:00',1000,1000,''),(16,2,10,'Storm','Túi',16000,'2026-04-24 00:00:00',100,100,''),(17,2,11,'Killrat','Hộp',15000,'2026-04-24 00:00:00',1000,1000,''),(18,2,12,'Kokubo','Hộp',18000,'2026-04-24 00:00:00',1000,1000,''),(19,2,13,'Forwarat','Hộp',18000,'2026-04-24 00:00:00',1000,1000,''),(20,2,14,'RAT-K','Túi',14000,'2026-04-24 00:00:00',1000,1000,''),(21,2,15,'Racumin0.75Tp20G','Túi',20000,'2026-04-24 00:00:00',100,100,''),(22,2,16,'Cat0.25WP','Túi',15000,'2026-04-24 00:00:00',1000,1000,''),(23,2,17,'ARSRATKILLER','Hộp',20000,'2026-04-24 00:00:00',1000,1000,''),(24,2,18,'Dethmor','Hộp',20000,'2026-04-24 00:00:00',1000,1000,''),(25,2,19,'Broma','Túi',16000,'2026-04-24 00:00:00',1000,1000,''),(26,2,20,'Helix®500WP','Túi',25000,'2026-04-24 00:00:00',1000,1000,''),(27,2,21,'VT-DAX700WP','Túi',15000,'2026-04-24 00:00:00',1000,1000,''),(28,2,22,'CLEAR700wp','Túi',30000,'2026-04-24 00:00:00',1000,1000,''),(29,2,23,'SACHOCTSC850WP','Túi',20000,'2026-04-24 00:00:00',1000,1000,''),(30,2,24,'Sun-fasti700WP','Túi',25000,'2026-04-24 00:00:00',1000,1000,''),(31,2,25,'RedDuck12BR','Túi',24000,'2026-04-24 00:00:00',1000,1000,''),(32,2,26,'BlackCarp700wp','Hộp',22000,'2026-04-24 00:00:00',100,100,''),(33,2,27,'ANTIOC777WP','Hộp',22000,'2026-04-24 00:00:00',100,100,''),(34,2,28,'DIOTO','Chai',22000,'2026-04-24 00:00:00',100,100,''),(35,2,29,'BOLIS12GB','Túi',23000,'2026-04-24 00:00:00',100,100,''),(36,2,30,'Anvil5SC','Chai',30000,'2026-04-24 00:00:00',100,100,''),(37,2,31,'Isacop65.2WG','Túi',30000,'2026-04-24 00:00:00',100,100,''),(38,2,32,'Antracol70WP','Túi',30000,'2026-04-24 00:00:00',100,100,''),(39,2,33,'Vimonyl72WP','Túi',20000,'2026-04-24 00:00:00',100,100,''),(40,2,34,'Filia525SE','Chai',18000,'2026-04-24 00:00:00',100,100,''),(41,2,35,'Score250EC','Chai',18000,'2026-04-24 00:00:00',100,100,''),(42,2,36,'MANOZEB80WP','Túi',30000,'2026-04-24 00:00:00',100,100,''),(43,2,37,'Totan200 WP','Túi',20000,'2026-04-24 00:00:00',100,100,''),(44,2,38,'CabrioTop600WG','Chai',25000,'2026-04-24 00:00:00',100,100,''),(45,2,39,'Vitrobin320SC','Chai',38000,'2026-04-24 00:00:00',100,100,'');
/*!40000 ALTER TABLE `warehouse_receipt_items` ENABLE KEYS */;
UNLOCK TABLES;



DROP TABLE IF EXISTS `batches`;

CREATE TABLE `batches` (
  `Batch_ID` int NOT NULL AUTO_INCREMENT,
  `Warehouse_Receipt_ID` bigint NOT NULL,
  `ProductID` bigint NOT NULL,
  `Quantity` bigint NOT NULL,
  `Import_date` datetime NOT NULL,
  `Expiry_date` datetime NOT NULL,
  `Import_price` bigint NOT NULL,
  `SupplierID` int NOT NULL,
  `remaining_quantity` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`Batch_ID`),
  KEY `ProductID` (`ProductID`),
  KEY `SupplierID` (`SupplierID`),
  KEY `batches_ibfk_3` (`Warehouse_Receipt_ID`),
  CONSTRAINT `batches_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  CONSTRAINT `batches_ibfk_2` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`),
  CONSTRAINT `batches_ibfk_3` FOREIGN KEY (`Warehouse_Receipt_ID`) REFERENCES `warehouse_receipt` (`id`),
  CONSTRAINT `batches_chk_1` CHECK ((`Quantity` >= 0)),
  CONSTRAINT `batches_chk_2` CHECK ((`Import_price` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `batches` WRITE;
/*!40000 ALTER TABLE `batches` DISABLE KEYS */;
INSERT INTO `batches` VALUES (1,1,1,1000,'2025-04-22 00:00:00','2026-02-22 00:00:00',20000,1,965),(2,1,2,1000,'2025-04-22 00:00:00','2026-02-22 00:00:00',20000,1,894),(3,1,3,500,'2025-04-22 00:00:00','2026-02-22 00:00:00',20000,1,450),(4,1,14,500,'2025-04-22 00:00:00','2026-12-31 00:00:00',10000,1,390),(5,1,22,700,'2025-04-22 00:00:00','2026-11-29 00:00:00',25000,1,678),(6,1,28,500,'2025-04-22 00:00:00','2026-12-31 00:00:00',20000,1,485),(7,2,1,100,'2025-04-24 00:00:00','2026-12-24 00:00:00',20000,1,100),(8,2,2,100,'2025-04-24 00:00:00','2026-12-24 00:00:00',15000,1,100),(9,2,3,1000,'2025-04-24 00:00:00','2026-12-24 00:00:00',20000,1,1000),(10,2,4,1000,'2025-04-24 00:00:00','2026-12-24 00:00:00',20000,1,1000),(11,2,5,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',18000,1,1000),(12,2,6,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',120000,1,1000),(13,2,7,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',40000,1,100),(14,2,8,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',40000,1,1000),(15,2,9,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',20000,1,1000),(16,2,10,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',16000,1,100),(17,2,11,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',15000,1,1000),(18,2,12,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',18000,1,1000),(19,2,13,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',18000,1,1000),(20,2,14,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',14000,1,990),(21,2,15,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',20000,1,100),(22,2,16,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',15000,1,1000),(23,2,17,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',20000,1,1000),(24,2,18,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',20000,1,999),(25,2,19,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',16000,1,1000),(26,2,20,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',25000,1,1000),(27,2,21,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',15000,1,1000),(28,2,22,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',30000,1,991),(29,2,23,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',20000,1,999),(30,2,24,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',25000,1,1000),(31,2,25,1000,'2025-04-24 00:00:00','2026-04-24 00:00:00',24000,1,1000),(32,2,26,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',22000,1,100),(33,2,27,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',22000,1,100),(34,2,28,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',22000,1,85),(35,2,29,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',23000,1,100),(36,2,30,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',30000,1,65),(37,2,31,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',30000,1,99),(38,2,32,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',30000,1,100),(39,2,33,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',20000,1,100),(40,2,34,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',18000,1,100),(41,2,35,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',18000,1,100),(42,2,36,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',30000,1,100),(43,2,37,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',20000,1,100),(44,2,38,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',25000,1,100),(45,2,39,100,'2025-04-24 00:00:00','2026-04-24 00:00:00',38000,1,100);
/*!40000 ALTER TABLE `batches` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `shipping`;
CREATE TABLE `shipping` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `checkout_method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
LOCK TABLES `shipping` WRITE;
/*!40000 ALTER TABLE `shipping` DISABLE KEYS */;
INSERT INTO `shipping` VALUES (10,1,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD'),(11,1,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD'),(12,1,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD'),(13,1,'Nguyễn Thành Tài','0987654321','102, ấp Tân Hoà, xã An Hiệp, Châu Thành, Đồng Tháp','tai@gmail.com','VNPAY'),(14,1,'Phong Vũ','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','phongvux789@gmail.com','VNPAY'),(15,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD'),(16,2,'Nguyễn Tấn Tài','0987654321','102, ấp Tân Hoà, xã An Hiệp, Châu Thành, Đồng Tháp','nguyentai789@gmail.com','VNPAY'),(17,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD'),(18,2,'Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(19,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(20,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(21,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(22,2,'Hồ Hữu Thuận test','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(23,2,'Hồ Hữu Thuận test','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(24,2,'Hồ Hữu Thuận test etst','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(25,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(26,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD'),(27,2,'Nguyễn Tấn Tài','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(28,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD'),(29,2,'Hồ Hữu Thuận VNPAY','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','VNPAY'),(30,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','admin123@gmail.com','COD'),(31,2,'Nguyễn Văn Phát','0334686901','Tân Thạnh, Tân Phước, Lai Vung, Đồng Tháp','phat@gmai.com','COD'),(32,2,'Nguyễn Văn A','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD'),(33,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD'),(34,2,'Hồ Hữu Thuận','0987654321','đường Trần Vĩnh Kiết, phường An Bình, quận Ninh Kiều, TP Cần Thơ','hohuuthuan789@gmail.com','COD');
/*!40000 ALTER TABLE `shipping` ENABLE KEYS */;
UNLOCK TABLES;



DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `OrderID` int NOT NULL AUTO_INCREMENT,
  `Order_Code` varchar(20) NOT NULL,
  `Order_Status` int NOT NULL DEFAULT '0',
  `Payment_Status` int DEFAULT '0',
  `UserID` int NOT NULL,
  `TotalAmount` bigint NOT NULL,
  `DiscountID` int DEFAULT NULL,
  `Date_Order` datetime NOT NULL,
  `Date_delivered` datetime DEFAULT NULL,
  `Payment_date_successful` datetime DEFAULT NULL,
  `ShippingID` int DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  UNIQUE KEY `Order_Code` (`Order_Code`),
  KEY `UserID` (`UserID`),
  KEY `DiscountID` (`DiscountID`),
  KEY `fk_shipping` (`ShippingID`),
  KEY `idx_payment_date` (`Payment_date_successful`),
  CONSTRAINT `fk_shipping` FOREIGN KEY (`ShippingID`) REFERENCES `shipping` (`id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`DiscountID`) REFERENCES `discount` (`DiscountID`),
  CONSTRAINT `orders_chk_1` CHECK ((`TotalAmount` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (27,'LRA253084',4,1,2,70000,NULL,'2025-04-24 08:26:08','2025-04-24 08:26:42','2025-04-24 08:26:42',28),(28,'ITQ101383',4,1,2,70000,NULL,'2025-04-24 08:29:00','2025-04-24 08:29:18','2025-04-24 08:29:18',29),(29,'JEA392887',5,0,2,1700000,NULL,'2025-04-24 08:44:02',NULL,NULL,30),(30,'GNU312311',-1,0,2,1080000,NULL,'2025-04-24 13:34:24',NULL,NULL,31),(31,'VWQ846825',-1,0,2,468000,1,'2025-04-24 14:20:58',NULL,NULL,32),(32,'XAD004343',4,1,2,600000,4,'2025-04-24 15:30:02','2025-04-24 15:35:57','2025-04-24 15:35:57',33),(33,'BOE925729',4,1,2,48000,NULL,'2025-04-24 21:29:03','2025-04-24 21:31:25','2025-04-24 21:31:25',34);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;




DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Order_Code` varchar(20) NOT NULL,
  `ProductID` bigint NOT NULL,
  `Quantity` bigint NOT NULL,
  `Selling_price` bigint NOT NULL,
  `Subtotal` bigint NOT NULL,
  `discount_amount` bigint DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `Order_Code` (`Order_Code`),
  KEY `ProductID` (`ProductID`),
  KEY `idx_order_code` (`Order_Code`),
  CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`Order_Code`) REFERENCES `orders` (`Order_Code`),
  CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  CONSTRAINT `order_detail_chk_1` CHECK ((`Quantity` >= 0)),
  CONSTRAINT `order_detail_chk_2` CHECK ((`Selling_price` >= 0)),
  CONSTRAINT `order_detail_chk_3` CHECK ((`Subtotal` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `order_detail` WRITE;
/*!40000 ALTER TABLE `order_detail` DISABLE KEYS */;
INSERT INTO `order_detail` VALUES (41,'LRA253084',30,1,70000,70000,0),(42,'ITQ101383',30,1,70000,70000,0),(43,'JEA392887',36,10,65000,650000,0),(44,'JEA392887',22,10,65000,650000,0),(45,'JEA392887',34,10,40000,400000,0),(46,'GNU312311',4,20,54000,1080000,0),(47,'VWQ846825',19,4,40000,160000,16000),(48,'VWQ846825',28,6,60000,360000,36000),(49,'XAD004343',30,10,70000,700000,100000),(50,'BOE925729',23,1,48000,48000,0);
/*!40000 ALTER TABLE `order_detail` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `order_batches`;
CREATE TABLE `order_batches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_detail_id` int NOT NULL,
  `batch_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_detail_id` (`order_detail_id`),
  KEY `batch_id` (`batch_id`),
  CONSTRAINT `order_batches_ibfk_1` FOREIGN KEY (`order_detail_id`) REFERENCES `order_detail` (`id`),
  CONSTRAINT `order_batches_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`Batch_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `order_batches` WRITE;
/*!40000 ALTER TABLE `order_batches` DISABLE KEYS */;
INSERT INTO `order_batches` VALUES (55,41,36,1),(56,42,36,1),(57,49,36,10),(58,50,29,1);
/*!40000 ALTER TABLE `order_batches` ENABLE KEYS */;
UNLOCK TABLES;




DROP TABLE IF EXISTS `vnpay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vnpay` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `ShippingID` int DEFAULT NULL,
  `vnp_Amount` varchar(50) DEFAULT NULL,
  `vnp_BankCode` varchar(50) DEFAULT NULL,
  `vnp_BankTranNo` varchar(50) DEFAULT NULL,
  `vnp_CardType` varchar(50) DEFAULT NULL,
  `vnp_OrderInfo` varchar(50) DEFAULT NULL,
  `vnp_PayDate` datetime DEFAULT NULL,
  `vnp_ResponseCode` varchar(50) DEFAULT NULL,
  `vnp_TmnCode` varchar(50) DEFAULT NULL,
  `vnp_TransactionNo` varchar(50) DEFAULT NULL,
  `vnp_TransactionStatus` varchar(50) DEFAULT NULL,
  `vnp_TxnRef` varchar(50) DEFAULT NULL,
  `vnp_SecureHash` text,
  PRIMARY KEY (`id`),
  KEY `shipping_method_vnpay` (`ShippingID`),
  KEY `shipping_method_vnpay_ordercode` (`vnp_TxnRef`),
  CONSTRAINT `shipping_method_vnpay` FOREIGN KEY (`ShippingID`) REFERENCES `shipping` (`id`),
  CONSTRAINT `shipping_method_vnpay_ordercode` FOREIGN KEY (`vnp_TxnRef`) REFERENCES `orders` (`Order_Code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `vnpay` WRITE;
/*!40000 ALTER TABLE `vnpay` DISABLE KEYS */;
INSERT INTO `vnpay` VALUES (12,29,'7000000','NCB','VNP14923609','ATM','Thanh toan don hang: ITQ101383','2025-04-24 08:29:05','00','F72UMWTL',NULL,'00','ITQ101383','388290f46b3d6642ca70dcda338fd73f839fb42d66cc90b97ae51313f68fa578c518d2de7d70c982e16e814e767da5e850b3e5cd230caea4e83f00cceda2990b');
/*!40000 ALTER TABLE `vnpay` ENABLE KEYS */;
UNLOCK TABLES;



DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (1,'Thông tin trợ giá','17454778881.jpg',1),(2,'Top 5 công ty','17454779102.jpg',1),(3,'demo product','17454779313.jpg',1),(4,'Giới thiệu Virtako 40 WG','17454779614.jpg',1);
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;



