USE `keyf-et`;

ALTER TABLE `menu_items`
  ADD COLUMN `image_url` VARCHAR(255) NULL AFTER `description`;
