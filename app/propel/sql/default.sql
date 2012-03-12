
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- book
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(100),
	`ISBN` VARCHAR(20),
	`author_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `book_FI_1` (`author_id`),
	CONSTRAINT `book_FK_1`
		FOREIGN KEY (`author_id`)
		REFERENCES `author` (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- author
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `author`;

CREATE TABLE `author`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`first_name` VARCHAR(100),
	`last_name` VARCHAR(100),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
