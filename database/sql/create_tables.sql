-- database/sql/create_tables.sql

-- Bảng categories
CREATE TABLE categories (
                            id_category INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            deleted_at TIMESTAMP NULL DEFAULT NULL
);

-- Bảng products
CREATE TABLE products (
                          id_product INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          id_category INT UNSIGNED NOT NULL,
                          name VARCHAR(255) NOT NULL,
                          price DECIMAL(15, 2) NOT NULL,
                          description TEXT,
                          quantity INT DEFAULT 0,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                          deleted_at TIMESTAMP NULL DEFAULT NULL,
                          created_by INT UNSIGNED,
                          updated_by INT UNSIGNED,
                          FOREIGN KEY (id_category) REFERENCES categories(id_category)
);

-- Bảng product_images
CREATE TABLE product_images (
                                id_product_image INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                id_product INT UNSIGNED NOT NULL,
                                image VARCHAR(255) NOT NULL,
                                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                deleted_at TIMESTAMP NULL DEFAULT NULL,
                                FOREIGN KEY (id_product) REFERENCES products(id_product)
);

-- Bảng users (phụ trợ cho ordres)
CREATE TABLE users (
                       id_user INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                       id_role INT UNSIGNED,
                       name VARCHAR(255) NOT NULL,
                       email VARCHAR(255) NOT NULL UNIQUE,
                       phone VARCHAR(20),
                       avatar VARCHAR(255),
                       password VARCHAR(255) NOT NULL,
                       address TEXT,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                       deleted_at TIMESTAMP NULL DEFAULT NULL,
                       updated_by INT UNSIGNED,
                       created_by INT UNSIGNED
);

-- Bảng vouchers (phụ trợ cho orders)
CREATE TABLE vouchers (
                          id_voucher INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          code VARCHAR(50) NOT NULL UNIQUE,
                          discount DECIMAL(5, 2) NOT NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                          deleted_at TIMESTAMP NULL DEFAULT NULL
);

-- Bảng order_status (phụ trợ cho orders)
CREATE TABLE order_status (
                              id_order_status INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                              name VARCHAR(50) NOT NULL,
                              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                              updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                              deleted_at TIMESTAMP NULL DEFAULT NULL
);

-- Bảng orders
CREATE TABLE orders (
                        id_order INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        id_user INT UNSIGNED NOT NULL,
                        id_voucher INT UNSIGNED,
                        id_order_status INT UNSIGNED NOT NULL,
                        total_amount DECIMAL(15, 2) NOT NULL,
                        address TEXT NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        FOREIGN KEY (id_user) REFERENCES users(id_user),
                        FOREIGN KEY (id_voucher) REFERENCES vouchers(id_voucher),
                        FOREIGN KEY (id_order_status) REFERENCES order_status(id_order_status)
);

-- Bảng order_details
CREATE TABLE order_details (
                               id_order_detail INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                               id_order INT UNSIGNED NOT NULL,
                               id_product INT UNSIGNED NOT NULL,
                               quantity INT NOT NULL,
                               price DECIMAL(15, 2) NOT NULL,
                               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                               updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                               FOREIGN KEY (id_order) REFERENCES orders(id_order),
                               FOREIGN KEY (id_product) REFERENCES products(id_product)
);

-- Bảng sessions
CREATE TABLE sessions (
                          id VARCHAR(255) NOT NULL PRIMARY KEY,
                          user_id INT UNSIGNED NULL,
                          ip_address VARCHAR(45) NULL,
                          user_agent TEXT NULL,
                          payload TEXT NOT NULL,
                          last_activity INT NOT NULL,
                          INDEX sessions_user_id_index (user_id),
                          INDEX sessions_last_activity_index (last_activity)
);
