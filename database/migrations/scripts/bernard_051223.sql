ALTER TABLE `registrants` ADD `need_counseling` INT NOT NULL DEFAULT '2' AFTER `paymentphone_id`,
    ADD `area_of_counseling` INT NULL DEFAULT NULL AFTER `need_counseling`;

ALTER TABLE `registrants_staging` ADD `need_counseling` INT NOT NULL DEFAULT '2' AFTER `paymentphone_id`,
    ADD `area_of_counseling` INT NULL DEFAULT NULL AFTER `need_counseling`;

ALTER TABLE `records` ADD `need_counseling` INT NOT NULL DEFAULT '2' AFTER `paymentphone_id`,
    ADD `area_of_counseling` INT NULL DEFAULT NULL AFTER `need_counseling`;