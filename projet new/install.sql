-- Utilisateurs
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(32) UNIQUE,
  email VARCHAR(128) UNIQUE,
  password VARCHAR(255),
  phone VARCHAR(32),
  role ENUM('user', 'admin') DEFAULT 'user',
  status ENUM('actif','bloque') DEFAULT 'actif',
  code_recup VARCHAR(64),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Transactions
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  from_currency VARCHAR(8),
  to_currency VARCHAR(8),
  amount DECIMAL(18,2),
  rate DECIMAL(18,6),
  result_amount DECIMAL(18,2),
  payment_receipt VARCHAR(128),
  status ENUM('en_attente','verifie','rejete','paye') DEFAULT 'en_attente',
  comment VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Taux de change (CFA base)
CREATE TABLE exchange_rates (
  currency VARCHAR(8) PRIMARY KEY,
  rate DECIMAL(18,6) NOT NULL
);

-- Ajout taux par défaut
INSERT INTO exchange_rates VALUES
  ('CFA', 1),
  ('NGN', 0.22),
  ('XOF', 1),
  ('USDT', 0.0014),
  ('BTC', 0.00000003),
  ('XRP', 0.25),
  ('TRX', 0.3),
  ('SOL', 0.00003);