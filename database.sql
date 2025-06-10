CREATE DATABASE IF NOT EXISTS just_eat;
USE just_eat;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(15) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(50) NOT NULL,
  surname VARCHAR(50) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS favorite_restaurants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  restaurant_id VARCHAR(255) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS menus (
  id INT AUTO_INCREMENT PRIMARY KEY,
  restaurant_id VARCHAR(255),
  category_code_start INT NOT NULL,
  category_code_end INT NOT NULL,
  title VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS menu_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  menu_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(6,2) NOT NULL,
  FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE
);

INSERT INTO menus (restaurant_id, category_code_start, category_code_end, title) VALUES
  (NULL, 13065, 13390, 'Menu Ristoranti');

INSERT INTO menus (restaurant_id, category_code_start, category_code_end, title) VALUES
  (NULL, 13064, 13064, 'Menu Pizzerie');

INSERT INTO menus (restaurant_id, category_code_start, category_code_end, title) VALUES
  (NULL, 13003, 13025, 'Menu Bar');

INSERT INTO menus (restaurant_id, category_code_start, category_code_end, title) VALUES
  (NULL, 13044, 13046, 'Menu Gelaterie');

INSERT INTO menu_items (menu_id, name, description, price) VALUES
  (1, 'Pasta al Pomodoro', 'Penne con sugo di pomodoro e basilico', 9.00),
  (1, 'Risotto ai Funghi', 'Risotto cremoso con funghi porcini', 12.00),
  (1, 'Cotoletta alla Milanese', 'Con patate al forno', 11.50),
  (1, 'Tiramisù Classico', 'Dessert al cucchiaio', 5.50),
  (1, 'Family Box', '2 primi + 2 secondi + contorno + acqua 1L', 35.00),
  (1, 'Vino della Casa', 'Bottiglia 25cl', 4.50);

INSERT INTO menu_items (menu_id, name, description, price) VALUES
  (2, 'Pizza Margherita', 'Pomodoro, mozzarella e basilico', 8.00),
  (2, 'Pizza Doppia Farina', 'Base extra croccante con 2 gusti a scelta', 12.00),
  (2, 'Fritto Misto', 'Supplì, olive ascolane e crocchette', 6.50),
  (2, 'Pizza + Bibita', '1 pizza + 1 lattina 33cl', 10.00),
  (2, 'Pizza Nutella', 'Con crema di nocciole e mascarpone', 7.00),
  (2, 'Birra + Patatine', 'Moretti 50cl + patatine', 6.00);

INSERT INTO menu_items (menu_id, name, description, price) VALUES
  (3, 'Colazione a Domicilio', '2 cappuccini + 2 cornetti + succo', 8.00),
  (3, 'Tramezzini Misti', '3 varietà a scelta', 6.00),
  (3, 'Box Merenda', '1 caffè + 1 brioche + acqua', 4.50),
  (3, 'Tè Freddo + Dolce', 'Tè pesca/mango + muffin', 5.00),
  (3, 'Birra Artigianale', 'Bottiglia 33cl', 4.00),
  (3, 'Caffè Shakerato', 'Caffè freddo con ghiaccio', 3.50);

INSERT INTO menu_items (menu_id, name, description, price) VALUES
  (4, 'Coppa Gelato', '3 gusti a scelta', 5.50),
  (4, 'Gelato in Vaschetta', '500gr, gusti classici', 8.00),
  (4, 'Brioche con Gelato', 'Brioche calda con palline gelato', 6.00),
  (4, 'Affogato al Caffè', 'Gelato alla vaniglia con caffè', 5.00),
  (4, 'Granita al Limone', 'Fresca e dissetante', 4.00),
  (4, 'Kit Gelato', '3 vaschette da 250gr + coni', 15.00);