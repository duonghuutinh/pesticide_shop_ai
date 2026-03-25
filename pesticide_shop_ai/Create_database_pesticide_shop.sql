CREATE TABLE `Role` (
    `Role_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `Role_name` VARCHAR(255) NOT NULL,
    `Description` VARCHAR(255) NOT NULL
);
CREATE TABLE `Users` (
    `UserID` INT AUTO_INCREMENT PRIMARY KEY,
    `Email` VARCHAR(255) NOT NULL UNIQUE,
    `Password` VARCHAR(500) NOT NULL,
    `Role_ID` INT NOT NULL,
    `Name` VARCHAR(50) NOT NULL,
    `Phone` VARCHAR(20) NOT NULL,
    `Address` VARCHAR(255) NOT NULL,
    `Status` VARCHAR(255) NOT NULL,
    `Avatar` VARCHAR(255),
    `Token_Code` VARCHAR(11),
    `Date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `Deleted_at` DATETIME NULL,
    FOREIGN KEY (`Role_ID`) REFERENCES `Role` (`Role_ID`)
);
CREATE TABLE `Category` (
    `CategoryID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(255) NOT NULL,
    `Description` VARCHAR(255),
    `Image` VARCHAR(255),
    `Slug` VARCHAR(255) NOT NULL UNIQUE,
    `Publish` INT NOT NULL DEFAULT 1
);
CREATE TABLE `Brand` (
    `BrandID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(255) NOT NULL,
    `Description` VARCHAR(255),
    `Image` VARCHAR(255),
    `Slug` VARCHAR(255) NOT NULL UNIQUE,
    `Publish` INT NOT NULL DEFAULT 1
);
CREATE TABLE `Product` (
    `ProductID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(200) NOT NULL,
    `Description` TEXT,
    `Product_uses` TEXT,
    `Unit` VARCHAR(50) NOT NULL,
    `Selling_price` BIGINT NOT NULL,
    `Promotion` INT DEFAULT 0,
    `Publish` INT DEFAULT 1,
    `Image` VARCHAR(255),
    `Slug` VARCHAR(255) NOT NULL UNIQUE,
    `CategoryID` BIGINT NOT NULL,
    `BrandID` BIGINT NOT NULL,
    `Date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `Deleted_at` DATETIME NULL,
    FOREIGN KEY (`CategoryID`) REFERENCES `Category` (`CategoryID`),
    FOREIGN KEY (`BrandID`) REFERENCES `Brand` (`BrandID`)
);
CREATE TABLE `Suppliers` (
    `SupplierID` INT AUTO_INCREMENT PRIMARY KEY,
    `Name` VARCHAR(255) NOT NULL,
    `Contact` VARCHAR(255),
    `Phone` VARCHAR(20) NOT NULL,
    `Address` VARCHAR(255) NOT NULL,
    `Email` VARCHAR(255) NOT NULL UNIQUE
);
CREATE TABLE `Batches` (
    `Batch_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `ProductID` BIGINT NOT NULL,
    `Quantity` BIGINT NOT NULL CHECK (`Quantity` >= 0),
    `Import_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `Expiry_date` DATETIME NOT NULL,
    `Import_price` BIGINT NOT NULL CHECK (`Import_price` >= 0),
    `SupplierID` INT NOT NULL,
    FOREIGN KEY (`ProductID`) REFERENCES `Product` (`ProductID`),
    FOREIGN KEY (`SupplierID`) REFERENCES `Suppliers` (`SupplierID`)
);
CREATE TABLE `Purchases` (
    `Purchase_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `Batch_ID` INT NOT NULL,
    `SupplierID` INT NOT NULL,
    `Quantity` BIGINT NOT NULL CHECK (`Quantity` >= 0),
    `Purchase_price` BIGINT NOT NULL CHECK (`Purchase_price` >= 0),
    `Purchase_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`Batch_ID`) REFERENCES `Batches` (`Batch_ID`),
    FOREIGN KEY (`SupplierID`) REFERENCES `Suppliers` (`SupplierID`)
);
CREATE TABLE `Order` (
    `OrderID` INT AUTO_INCREMENT PRIMARY KEY,
    `Order_Code` VARCHAR(20) NOT NULL UNIQUE,
    `Order_Status` VARCHAR(255) NOT NULL DEFAULT 'Pending',
    `Payment_Status` VARCHAR(255) NOT NULL DEFAULT 'Unpaid',
    `UserID` INT NOT NULL,
    `TotalAmount` BIGINT NOT NULL CHECK (`TotalAmount` >= 0),
    `Date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`)
);
CREATE TABLE `Order_detail` (
    `Order_Detail_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `Order_Code` VARCHAR(20) NOT NULL,
    `ProductID` BIGINT NOT NULL,
    `Batch_ID` INT NOT NULL,
    `Quantity` BIGINT NOT NULL CHECK (`Quantity` >= 1),
    `Selling_price` BIGINT NOT NULL CHECK (`Selling_price` >= 0),
    `Coupon_code` VARCHAR(255) DEFAULT NULL,
    `Subtotal` BIGINT NOT NULL CHECK (`Subtotal` >= 0),
    `Date_order` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`Order_Code`) REFERENCES `Order` (`Order_Code`),
    FOREIGN KEY (`ProductID`) REFERENCES `Product` (`ProductID`),
    FOREIGN KEY (`Batch_ID`) REFERENCES `Batches` (`Batch_ID`)
);