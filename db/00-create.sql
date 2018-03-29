SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `admins`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `admins` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(64) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `last_name` VARCHAR(255) NULL ,
  `first_name` VARCHAR(255) NULL ,
  `is_mark` TINYINT NOT NULL DEFAULT 0 ,
  `last_login` VARCHAR(25) NULL ,
  `login_hash` VARCHAR(255) NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `removed` TINYINT NOT NULL DEFAULT 0 ,
  `removed_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `subjects`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `subjects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `no` VARCHAR(45) NOT NULL ,
  `subject_no` VARCHAR(64) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `presenter_last_name` VARCHAR(45) NULL ,
  `presenter_last_name_en` VARCHAR(45) NULL ,
  `presenter_first_name` VARCHAR(45) NULL ,
  `presenter_first_name_en` VARCHAR(45) NULL ,
  `presenter_email` VARCHAR(255) NULL ,
  `session_name` VARCHAR(255) NULL ,
  `present_date` DATE NULL ,
  `present_start_time` TIME NULL ,
  `present_end_time` TIME NULL ,
  `place_id` INT NULL ,
  `belong_name` VARCHAR(255) NULL ,
  `belong_name_en` VARCHAR(255) NULL ,
  `title_ja` VARCHAR(255) NULL ,
  `title_en` VARCHAR(255) NULL ,
  `category` VARCHAR(45) NULL ,
  `poster_file_name` VARCHAR(255) NULL ,
  `poster_file_count` INT NULL DEFAULT 0 ,
  `announce_file_name` VARCHAR(255) NULL ,
  `announce_file_count` INT NULL DEFAULT 0 ,
  `prize` TINYINT NOT NULL DEFAULT 0 ,
  `cancel` TINYINT NOT NULL DEFAULT 0 ,
  `sort` INT NOT NULL DEFAULT 0 ,
  `not_warter_mark` TINYINT NOT NULL DEFAULT 0 ,
  `type_warter_mark` TINYINT NOT NULL DEFAULT 0 ,
  `last_login` VARCHAR(25) NULL ,
  `login_hash` VARCHAR(255) NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `removed` TINYINT NOT NULL DEFAULT 0 ,
  `removed_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE INDEX `i_subjects_subject_no` ON `subjects` (`subject_no` ASC) ;


-- -----------------------------------------------------
-- Table `publics`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `publics` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(64) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `last_login` VARCHAR(255) NULL ,
  `login_hash` VARCHAR(255) NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `removed` TINYINT NOT NULL DEFAULT 0 ,
  `removed_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `places`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `places` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `place_name` VARCHAR(255) NULL ,
  `place_name_en` VARCHAR(255) NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `removed` TINYINT NOT NULL DEFAULT 0 ,
  `removed_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `marks`
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `marks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `subject_id` INT NOT NULL ,
  `mark` INT NOT NULL ,
  `removed` TINYINT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
