SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `ping_pong` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ping_pong` ;

-- -----------------------------------------------------
-- Table `ping_pong`.`games`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ping_pong`.`games` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NULL ,
  `set_number` TINYINT NULL ,
  `set_points` TINYINT NULL ,
  `id_winner` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ping_pong`.`players`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ping_pong`.`players` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ping_pong`.`games_players`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ping_pong`.`games_players` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `games_id` INT NOT NULL ,
  `players_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_games_players_games_idx` (`games_id` ASC) ,
  INDEX `fk_games_players_players1_idx` (`players_id` ASC) ,
  CONSTRAINT `fk_games_players_games`
    FOREIGN KEY (`games_id` )
    REFERENCES `ping_pong`.`games` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_games_players_players1`
    FOREIGN KEY (`players_id` )
    REFERENCES `ping_pong`.`players` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `ping_pong` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
