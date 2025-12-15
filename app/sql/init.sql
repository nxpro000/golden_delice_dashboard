CREATE DATABASE IF NOT EXISTS golden_delice CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE golden_delice;

-- Catégories
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  is_active BOOLEAN DEFAULT TRUE
);

-- Plats
CREATE TABLE dishes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2),
  image VARCHAR(255),
  category_id INT,
  is_configurable BOOLEAN DEFAULT FALSE,
  is_active BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE dish_options (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dish_id INT,
  type ENUM('base','accompagnement','sauce') NOT NULL,
  name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) DEFAULT 0,
  is_default BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (dish_id) REFERENCES dishes(id)
);

CREATE TABLE tables (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  status ENUM('libre','occupee','en_attente_addition','fermee') DEFAULT 'libre'
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type ENUM('interne','emporter') NOT NULL,
  table_id INT NULL,
  covers INT DEFAULT 0,
  status ENUM('en_cours','envoye_cuisine','pret','servi','en_attente_paiement','paid','cancelled') DEFAULT 'en_cours',
  total_ht DECIMAL(10,2) DEFAULT 0,
  total_ttc DECIMAL(10,2) DEFAULT 0,
  discount DECIMAL(10,2) DEFAULT 0,
  payment_method ENUM('cash','mobile_money','carte','avoir') NULL,
  amount_paid DECIMAL(10,2) DEFAULT 0,
  change_amount DECIMAL(10,2) DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  closed_at DATETIME NULL
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  dish_id INT NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  options JSON NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (dish_id) REFERENCES dishes(id)
);

CREATE TABLE ingredients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  unit VARCHAR(20),
  stock_initial DECIMAL(10,2) DEFAULT 0,
  stock_current DECIMAL(10,2) DEFAULT 0,
  alert_threshold DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE stock_movements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ingredient_id INT NOT NULL,
  type ENUM('entry','exit') NOT NULL,
  quantity DECIMAL(10,2) NOT NULL,
  reason VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
);

CREATE TABLE preparations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  total_portions INT NOT NULL,
  portions_remaining INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE dish_components (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dish_id INT NOT NULL,
  preparation_id INT NOT NULL,
  quantity_required DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (dish_id) REFERENCES dishes(id),
  FOREIGN KEY (preparation_id) REFERENCES preparations(id)
);

CREATE TABLE invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  number VARCHAR(50) NOT NULL,
  total_ttc DECIMAL(10,2) NOT NULL,
  paid_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  payment_method ENUM('cash','mobile_money','carte','avoir') NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Catégories
INSERT INTO categories (name) VALUES
('Petit déjeuner'),
('Grillades & braisés'),
('Plats frits'),
('Plats à sauce'),
('Samedi Placali'),
('Boissons');

-- Plats
INSERT INTO dishes (name, description, price, category_id, is_configurable, is_active) VALUES
('Omelette pain café', 'Omelette dorée, pain croustillant et café au lait', 1000, 1, 0, 1),
('Poulet braisé entier', 'Avec attiéké', 5000, 2, 0, 1),
('Tchèp au poulet', 'Riz sénégalais + quart de poulet frit', 2000, 3, 0, 1),
('Plat à sauce', 'Riz/Foutou + accompagnement + sauce', 0, 4, 1, 1);

-- Options pour Plat à sauce (dish_id = 4 selon auto_increment)
INSERT INTO dish_options (dish_id, type, name, price) VALUES
(4, 'base', 'Riz parfumé', 0),
(4, 'base', 'Foutou banane', 0),
(4, 'base', 'Foutou igname', 0),
(4, 'accompagnement', 'Patte de boeuf', 1500),
(4, 'accompagnement', 'Viande de boeuf', 2000),
(4, 'accompagnement', 'Poulet fumé', 2000),
(4, 'accompagnement', 'Soupe de cabri', 2500),
(4, 'sauce', 'Graine', 0),
(4, 'sauce', 'Aubergine', 0),
(4, 'sauce', 'Pistache', 0),
(4, 'sauce', 'Biekesusseu', 0);

-- Tables restaurant
INSERT INTO tables (name) VALUES
('Table 1'),
('Table 2'),
('Table 3'),
('Table 4');

-- Ingrédients
INSERT INTO ingredients (name, unit, stock_initial, stock_current, alert_threshold) VALUES
('Riz cru', 'kg', 20, 20, 5),
('Graine', 'kg', 10, 10, 3);

-- Préparations de test
INSERT INTO preparations (name, total_portions, portions_remaining) VALUES
('Riz cuit', 50, 50),
('Sauce graine', 40, 40);

