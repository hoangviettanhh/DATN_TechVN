-- Thêm dữ liệu mẫu cho bảng order_status
INSERT INTO order_status (name) VALUES 
('Pending'),
('Success'),
('Processing'),
('Shipped'),
('Delivered'),
('Cancelled');

-- Thêm dữ liệu mẫu cho bảng vouchers
INSERT INTO vouchers (code, discount) VALUES 
('WELCOME10', 10),
('SUMMER20', 20),
('SPECIAL30', 30); 

ALTER TABLE orders ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE order_details ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

ALTER TABLE orders 
ADD COLUMN payment_details JSON NULL 
AFTER payment_method;

-- Thêm cột status vào bảng categories và products
ALTER TABLE categories ADD COLUMN status TINYINT NOT NULL DEFAULT 1;
ALTER TABLE products ADD COLUMN status TINYINT NOT NULL DEFAULT 1;
ALTER TABLE users ADD COLUMN status TINYINT NOT NULL DEFAULT 1;