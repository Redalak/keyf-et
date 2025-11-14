USE `keyf-et`;

-- Ensure categories exist
INSERT INTO `menu_categories` (`name`, `description`, `position`, `active`) VALUES
('Entrées', 'Pour commencer', 1, 1),
('Plats', 'Les incontournables', 2, 1),
('Desserts', 'Douceurs', 3, 1),
('Boissons', 'Pour se désaltérer', 4, 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Helper: resolve category id by name
-- Items mapped roughly from https://keyfet.fr/galerie-2/

-- Plats
INSERT INTO `menu_items` (`category_id`,`name`,`description`,`image_url`,`price`,`position`,`active`) VALUES
((SELECT id FROM menu_categories WHERE name='Plats'), 'Assiette de Mezze', NULL, 'assets/img/carte/assiette-de-mezze.jpg', 0.00, 1, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Beyti', NULL, 'assets/img/carte/beyti.jpg', 0.00, 2, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Kebab adana', NULL, 'assets/img/carte/kebab-adana.jpg', 0.00, 3, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Grillades Mixte 3 personnes', NULL, 'assets/img/carte/grillades-mixte-3p.jpg', 0.00, 4, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Assiettes grillades 4 personnes', NULL, 'assets/img/carte/assiettes-grillades-4p.jpg', 0.00, 5, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Planche familial', NULL, 'assets/img/carte/planche-familial.jpg', 0.00, 6, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Brochette d’agneau', NULL, 'assets/img/carte/brochette-agneau.jpg', 0.00, 7, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Pizza turc', NULL, 'assets/img/carte/pizza-turc.jpg', 0.00, 8, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Soupes aux tripes', NULL, 'assets/img/carte/soupes-tripes.jpg', 0.00, 9, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Soupe de lentille au corail', NULL, 'assets/img/carte/soupe-lentille-corail.jpg', 0.00, 10, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Plat du jour', NULL, 'assets/img/carte/plat-du-jour.jpg', 0.00, 11, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Kefta', NULL, 'assets/img/carte/kefta.jpg', 0.00, 12, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Grillade Mixte', NULL, 'assets/img/carte/grillade-mixte.jpg', 0.00, 13, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Ali Nazik', NULL, 'assets/img/carte/ali-nazik.jpg', 0.00, 14, 1),
((SELECT id FROM menu_categories WHERE name='Plats'), 'Kebab d’aubergine', NULL, 'assets/img/carte/kebab-aubergine.jpg', 0.00, 15, 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Boissons
INSERT INTO `menu_items` (`category_id`,`name`,`description`,`image_url`,`price`,`position`,`active`) VALUES
((SELECT id FROM menu_categories WHERE name='Boissons'), 'Café turc', NULL, 'assets/img/carte/cafe-turc.jpg', 0.00, 1, 1),
((SELECT id FROM menu_categories WHERE name='Boissons'), 'Expresso', NULL, 'assets/img/carte/expresso.jpg', 0.00, 2, 1),
((SELECT id FROM menu_categories WHERE name='Boissons'), 'Thé noir', NULL, 'assets/img/carte/the-noir.jpg', 0.00, 3, 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Desserts
INSERT INTO `menu_items` (`category_id`,`name`,`description`,`image_url`,`price`,`position`,`active`) VALUES
((SELECT id FROM menu_categories WHERE name='Desserts'), 'Kunefe', NULL, 'assets/img/carte/kunefe.jpg', 0.00, 1, 1),
((SELECT id FROM menu_categories WHERE name='Desserts'), 'Riz au lait', NULL, 'assets/img/carte/riz-au-lait.jpg', 0.00, 2, 1),
((SELECT id FROM menu_categories WHERE name='Desserts'), 'Baklava pistache', NULL, 'assets/img/carte/baklava-pistache.jpg', 0.00, 3, 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Entrées / autres
INSERT INTO `menu_items` (`category_id`,`name`,`description`,`image_url`,`price`,`position`,`active`) VALUES
((SELECT id FROM menu_categories WHERE name='Entrées'), 'Assiette Mezze', NULL, 'assets/img/carte/assiette-mezze.jpg', 0.00, 1, 1),
((SELECT id FROM menu_categories WHERE name='Entrées'), 'Salade Coban', NULL, 'assets/img/carte/salade-coban.jpg', 0.00, 2, 1),
((SELECT id FROM menu_categories WHERE name='Entrées'), 'Pidet Aux Fromages', NULL, 'assets/img/carte/pidet-aux-fromages.jpg', 0.00, 3, 1),
((SELECT id FROM menu_categories WHERE name='Entrées'), 'Pidet Agneaux', NULL, 'assets/img/carte/pidet-agneaux.jpg', 0.00, 4, 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);
