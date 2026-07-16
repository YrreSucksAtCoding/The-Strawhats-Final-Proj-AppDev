-- WorkNest database
-- Import this file first, then run setup_accounts.php once to create the admin account - Yrre

CREATE DATABASE IF NOT EXISTS worknest_db;
USE worknest_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    contact_no VARCHAR(30) NOT NULL,
    role ENUM('admin','buyer') NOT NULL DEFAULT 'buyer',
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    verify_token VARCHAR(64) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ship_name VARCHAR(100) NOT NULL,
    ship_address VARCHAR(255) NOT NULL,
    ship_contact VARCHAR(30) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(30) DEFAULT NULL,
    status ENUM('pending','paid') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    user_name VARCHAR(100) DEFAULT NULL,
    action VARCHAR(50) NOT NULL,
    details VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed categories
INSERT INTO categories (name) VALUES
('Chairs'),
('Tables & Desks'),
('Storage'),
('Accessories');

-- Seed products
INSERT INTO products (category_id, name, description, price, stock) VALUES
(1, 'ErgoFlex Task Chair', 'Adjustable mesh-back office chair with lumbar support and tilt lock.', 5499.00, 25),
(1, 'Executive Leather Chair', 'High-back bonded leather chair with padded armrests.', 8999.00, 12),
(1, 'Drafting Stool', 'Height-adjustable stool with foot ring, good for standing desks.', 3250.00, 18),
(2, 'OakLine Office Desk 120cm', 'Laminated oak-finish desk with cable grommet and side drawer.', 7499.00, 15),
(2, 'Conference Table 8-Seater', 'Rectangular meeting table with sturdy steel legs.', 15999.00, 5),
(2, 'Adjustable Standing Desk', 'Manual crank sit-stand desk, 70-115cm height range.', 11999.00, 8),
(3, 'Steel Filing Cabinet 4-Drawer', 'Lockable vertical filing cabinet, powder-coated steel.', 6799.00, 10),
(3, 'Mobile Pedestal', '3-drawer under-desk pedestal with casters and central lock.', 3999.00, 20),
(3, 'Open Shelf Bookcase', '5-tier laminated bookcase for files and binders.', 4599.00, 14),
(4, 'Monitor Riser Stand', 'Bamboo monitor stand with phone slot and storage space.', 899.00, 40),
(4, 'Desk Organizer Set', 'Mesh organizer set: pen holder, letter tray, and sorter.', 649.00, 50),
(4, 'Anti-Fatigue Floor Mat', 'Cushioned standing mat, 50x80cm, non-slip base.', 1299.00, 30);
