CREATE DATABASE IF NOT EXISTS chef_food;
USE chef_food;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE menu (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  category VARCHAR(50) NOT NULL,
  image VARCHAR(255) DEFAULT 'https://via.placeholder.com/300',
  is_special TINYINT DEFAULT 0
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  items TEXT NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  status ENUM('Order Received','Preparing','Out for Delivery','Delivered') DEFAULT 'Order Received',
  address TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO menu (name, description, price, category, image, is_special) VALUES
('Chicken Biryani', 'Fragrant basmati rice with tender chicken, traditional spices', 350, 'Biryani', 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=500', 1),
('Beef Biryani', 'Rich beef biryani with raita and salad', 400, 'Biryani', 'https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=500', 1),
('Chicken Karahi', 'Traditional karahi cooked in desi ghee with naan', 600, 'Karahi', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500', 0),
('Mutton Karahi', 'Premium mutton karahi with fresh naan', 900, 'Karahi', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=500', 0),
('Chicken Tikka', 'Juicy grilled chicken tikka with mint chutney', 450, 'BBQ', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=500', 1),
('Seekh Kebab', 'Soft seekh kebabs with paratha', 350, 'BBQ', 'https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?w=500', 0),
('Naan', 'Fresh tandoor naan', 40, 'Bread', 'https://images.unsplash.com/photo-1628840042765-356cda07504e?w=500', 0),
('Raita', 'Cooling yogurt raita', 80, 'Sides', 'https://images.unsplash.com/photo-1505253758473-96b7015fcd40?w=500', 0);

INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@chef.com', 'admin123', 'admin'),
('Test User', 'user@test.com', 'user123', 'user');
