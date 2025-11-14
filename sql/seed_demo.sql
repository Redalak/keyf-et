USE `keyf-et`;

-- Users (admin demo)
INSERT INTO `users` (`name`, `email`, `phone`, `password_hash`, `role`)
VALUES
('Admin', 'admin@keyfet.local', NULL, '$2y$10$9pUj7k2t4r5pO0yqF4ZrpeTq8xWcYx2Q2gq0TQ0m6yS7Yc1bR2tqm', 'admin')
ON DUPLICATE KEY UPDATE `email` = `email`;

-- Menu categories
INSERT INTO `menu_categories` (`name`, `description`, `position`, `active`) VALUES
('Entrées', 'Pour commencer', 1, 1),
('Plats', 'Les incontournables', 2, 1),
('Desserts', 'Douceurs', 3, 1),
('Boissons', 'Pour se désaltérer', 4, 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Menu items
INSERT INTO `menu_items` (`category_id`, `name`, `description`, `image_url`, `price`, `position`, `active`) VALUES
((SELECT id FROM menu_categories WHERE name='Entrées'), 'Salade César', 'Poulet, parmesan, croûtons', 'assets/img/videoframe_2626.png', 9.90, 1, 1),
((SELECT id FROM menu_categories WHERE name='Entrées'), 'Soupe à l''oignon', 'Gratinée au fromage', 'assets/img/videoframe_2626.png', 7.50, 2, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Burger Signature', 'Boeuf, cheddar affiné, sauce maison', 'assets/img/image.resto.jpg', 15.90, 1, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Pâtes aux truffes', 'Crème de truffe, parmesan', 'assets/img/image.resto.jpg', 18.50, 2, 1),
((SELECT id FROM menu_categories WHERE name='Desserts'), 'Tiramisu', 'Mascarpone, café', 'assets/img/videoframe_2626.png', 6.90, 1, 1),
((SELECT id FROM menu_categories WHERE name='Desserts'), 'Moelleux chocolat', 'Coeur coulant', 'assets/img/videoframe_2626.png', 6.90, 2, 1),
((SELECT id FROM menu_categories WHERE name='Boissons'), 'Eau pétillante 50cl', NULL, 'assets/img/videoframe_2626.png', 3.50, 1, 1),
((SELECT id FROM menu_categories WHERE name='Boissons'), 'Limonade artisanale', NULL, 'assets/img/videoframe_2626.png', 4.20, 2, 1);

-- Sample reservation
INSERT INTO `reservations` (`user_id`, `name`, `email`, `phone`, `date`, `time`, `guests`, `notes`, `status`)
VALUES (NULL, 'Jean Dupont', 'jean.dupont@example.com', '+33601020304', CURDATE() + INTERVAL 1 DAY, '19:30:00', 2, 'Table près de la fenêtre', 'pending');
