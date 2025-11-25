<?php
echo password_hash("admin123", PASSWORD_DEFAULT);
?>

<!-- INSERT INTO users (name, email, password, phone, address, role)
VALUES (
  'Admin User',
  'admin@foodshare.com',
  '$2y$10$EukjRiD/BRy8LhQ4vmmo.B4758AJfjzEsxo0JRRkP7eO5OBmBz6yW',
  '03001234567',
  'Karachi',
  'admin'
);
(Replace the password hash with your own generated one!) -->