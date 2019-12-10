-- MySQL Script generated by MySQL Workbench
-- mar 13 giu 2017 10:47:06 CEST
-- Model: SeatBeach    Version: 1.5

-- aggiunto codice_fiscale e provincia in clienti

-- 11/06/2017
-- Invertito relazione account -> cliente, operatore
-- Corretto indice unique coordinate postazione

-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema dbspiaggie
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `dbspiaggie` ;

-- -----------------------------------------------------
-- Schema dbspiaggie
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbspiaggie` DEFAULT CHARACTER SET utf8 ;
SHOW WARNINGS;
USE `dbspiaggie` ;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`clienti`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`clienti` (
  `id_cliente` INT(11) NOT NULL AUTO_INCREMENT,
  `da_saldare` DECIMAL(7,2) NULL DEFAULT NULL,
  `note` VARCHAR(100) NULL DEFAULT NULL,
  `indirizzo` VARCHAR(100) NULL,
  `cap` VARCHAR(10) NULL,
  `citta` VARCHAR(45) NULL,
  `provincia` VARCHAR(45) NULL,
  `stato` VARCHAR(45) NULL,
  `codice_fiscale` VARCHAR(16) NULL,
  PRIMARY KEY (`id_cliente`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`profili`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`profili` (
  `id_profilo` INT(11) NOT NULL AUTO_INCREMENT,
  `descrizione` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_profilo`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`account` (
  `id_account` INT(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` INT(11) NULL,
  `id_profilo` INT(11) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NULL,
  `nome` VARCHAR(45) NOT NULL,
  `indirizzo` VARCHAR(45) NULL,
  `telefono` VARCHAR(45) NULL,
  `abilitato` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_account`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_account_cliente1_idx` (`id_cliente` ASC),
  INDEX `fk_account_profilo1_idx` (`id_profilo` ASC),
  CONSTRAINT `fk_account_cliente1`
    FOREIGN KEY (`id_cliente`)
    REFERENCES `dbspiaggie`.`clienti` (`id_cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_account_profilo1`
    FOREIGN KEY (`id_profilo`)
    REFERENCES `dbspiaggie`.`profili` (`id_profilo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`tipi_servizio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`tipi_servizio` (
  `id_tipo_servizio` INT(11) NOT NULL AUTO_INCREMENT,
  `descrizione` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_tipo_servizio`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`costi_servizio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`costi_servizio` (
  `id_costo` INT(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_servizio` INT(11) NOT NULL,
  `inizio_periodo` DATE NULL DEFAULT NULL,
  `fine_periodo` DATE NULL DEFAULT NULL,
  `costo` FLOAT NOT NULL,
  PRIMARY KEY (`id_costo`),
  INDEX `fk_CostoServizi_TipoServizio1_idx` (`id_tipo_servizio` ASC),
  CONSTRAINT `fk_CostoServizi_TipoServizio1`
    FOREIGN KEY (`id_tipo_servizio`)
    REFERENCES `dbspiaggie`.`tipi_servizio` (`id_tipo_servizio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`postazioni`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`postazioni` (
  `id_postazione` INT(11) NOT NULL AUTO_INCREMENT,
  `fila` VARCHAR(4) NOT NULL,
  `colonna` VARCHAR(4) NOT NULL,
  `settore` VARCHAR(4) NULL DEFAULT NULL,
  `x` INT(11) NOT NULL,
  `y` INT(11) NOT NULL,
  `note` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_postazione`),
  UNIQUE INDEX `sfc` USING BTREE (`fila` ASC, `colonna` ASC, `settore` ASC),
  UNIQUE INDEX `xy` USING BTREE (`y` ASC, `x` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`abbonamenti`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`abbonamenti` (
  `id_abbonamento` INT(11) NOT NULL AUTO_INCREMENT,
  `codice` VARCHAR(45) NOT NULL,
  `costo` FLOAT NOT NULL,
  PRIMARY KEY (`id_abbonamento`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`assegnamenti_postazione`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`assegnamenti_postazione` (
  `id_assegnamento_postazione` INT(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` INT(11) NOT NULL,
  `id_postazione` INT(11) NOT NULL,
  `id_abbonamento` INT(11) NOT NULL,
  `data_inizio` DATETIME NOT NULL,
  `data_fine` DATETIME NOT NULL,
  `autorizzati` VARCHAR(100) NULL,
  `note` VARCHAR(100) NULL,
  INDEX `fk_Postazioni Assegnate_clienti1_idx` (`id_cliente` ASC),
  PRIMARY KEY (`id_assegnamento_postazione`),
  INDEX `fk_Postazioni Assegnate_Mappa_postazioni1_idx` (`id_postazione` ASC),
  INDEX `fk_assegnamenti_postazione_abbonamenti1_idx` (`id_abbonamento` ASC),
  CONSTRAINT `fk_Postazioni Assegnate_Mappa_postazioni1`
    FOREIGN KEY (`id_postazione`)
    REFERENCES `dbspiaggie`.`postazioni` (`id_postazione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Postazioni Assegnate_clienti1`
    FOREIGN KEY (`id_cliente`)
    REFERENCES `dbspiaggie`.`clienti` (`id_cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_assegnamenti_postazione_abbonamenti1`
    FOREIGN KEY (`id_abbonamento`)
    REFERENCES `dbspiaggie`.`abbonamenti` (`id_abbonamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`disponibilita_postazione`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`disponibilita_postazione` (
  `id_disponibilita_postazione` INT(11) NOT NULL AUTO_INCREMENT,
  `id_assegnamento_postazione` INT(11) NOT NULL,
  `data_inizio` DATETIME NOT NULL,
  `data_fine` DATETIME NOT NULL,
  PRIMARY KEY (`id_disponibilita_postazione`),
  INDEX `fk_disponibilita_postazione_assegnamento_postazione1_idx` (`id_assegnamento_postazione` ASC),
  CONSTRAINT `fk_disponibilita_postazione_assegnamento_postazione1`
    FOREIGN KEY (`id_assegnamento_postazione`)
    REFERENCES `dbspiaggie`.`assegnamenti_postazione` (`id_assegnamento_postazione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `data` DATETIME NOT NULL,
  `entita` VARCHAR(45) NOT NULL,
  `proprieta` VARCHAR(45) NOT NULL,
  `valore_precedente` VARCHAR(45) NULL DEFAULT NULL,
  `valore_nuovo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`privilegi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`privilegi` (
  `id_privilegio` INT(11) NOT NULL AUTO_INCREMENT,
  `descrizione` VARCHAR(45) NOT NULL,
  `note_interne` VARCHAR(100) NULL,
  PRIMARY KEY (`id_privilegio`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`privilegi_profilo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`privilegi_profilo` (
  `id_privilegio` INT(11) NOT NULL,
  `id_profilo` INT(11) NOT NULL,
  PRIMARY KEY (`id_privilegio`, `id_profilo`),
  INDEX `fk_privilegi_profilo_id_profilo_idx` (`id_profilo` ASC),
  CONSTRAINT `fk_privilegi_profilo_id_privilegio`
    FOREIGN KEY (`id_privilegio`)
    REFERENCES `dbspiaggie`.`privilegi` (`id_privilegio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_privilegi_profilo_id_profilo`
    FOREIGN KEY (`id_profilo`)
    REFERENCES `dbspiaggie`.`profili` (`id_profilo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`schede`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`schede` (
  `id_scheda` INT(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` INT(11) NULL DEFAULT NULL,
  `codice_scheda` VARCHAR(45) NOT NULL,
  `importo_scheda` FLOAT NULL DEFAULT NULL,
  `data_rilascio` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id_scheda`),
  UNIQUE INDEX `codice_scheda` (`codice_scheda` ASC),
  INDEX `fk_schede_clienti1_idx` (`id_cliente` ASC),
  CONSTRAINT `fk_schede_clienti1`
    FOREIGN KEY (`id_cliente`)
    REFERENCES `dbspiaggie`.`clienti` (`id_cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`servizi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`servizi` (
  `id_servizio` INT(11) NOT NULL AUTO_INCREMENT,
  `id_assegnamento_postazione` INT(11) NOT NULL,
  `id_tipo_servizio` INT(11) NOT NULL,
  `data_inizio` DATETIME NOT NULL,
  `data_fine` DATETIME NOT NULL,
  `qta` INT(11) NOT NULL,
  `costo_finale` FLOAT NOT NULL,
  `note` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_servizio`),
  INDEX `fk_Servizi_Assegnamento_Postazione_idx` (`id_assegnamento_postazione` ASC),
  INDEX `fk_Servizi_TipoServizio1_idx` (`id_tipo_servizio` ASC),
  CONSTRAINT `fk_Servizi_Assegnamento_Postazione_idx`
    FOREIGN KEY (`id_assegnamento_postazione`)
    REFERENCES `dbspiaggie`.`assegnamenti_postazione` (`id_assegnamento_postazione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Servizi_TipoServizio1`
    FOREIGN KEY (`id_tipo_servizio`)
    REFERENCES `dbspiaggie`.`tipi_servizio` (`id_tipo_servizio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`subaffitti_postazione`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`subaffitti_postazione` (
  `id_subaffitto_postazione` INT(11) NOT NULL AUTO_INCREMENT,
  `id_disponibilita_postazioni` INT(11) NOT NULL,
  `data_inizio` DATETIME NOT NULL,
  `data_fine` DATETIME NOT NULL,
  PRIMARY KEY (`id_subaffitto_postazione`),
  INDEX `fk_SubAffitto_Postazione_Mappa_postazioni1_idx` (`id_subaffitto_postazione` ASC),
  INDEX `fk_SubAffitto_Postazione_DisponibilitaPostazioni1_idx` (`id_disponibilita_postazioni` ASC),
  CONSTRAINT `fk_SubAffitto_Postazione_DisponibilitaPostazioni1`
    FOREIGN KEY (`id_disponibilita_postazioni`)
    REFERENCES `dbspiaggie`.`disponibilita_postazione` (`id_disponibilita_postazione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dbspiaggie`.`pagamenti`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbspiaggie`.`pagamenti` (
  `id_pagamento` INT NOT NULL AUTO_INCREMENT,
  `id_cliente` INT(11) NOT NULL,
  `data` DATETIME NOT NULL,
  `importo` FLOAT NOT NULL,
  PRIMARY KEY (`id_pagamento`),
  INDEX `fk_pagamenti_clienti1_idx` (`id_cliente` ASC),
  CONSTRAINT `fk_pagamenti_clienti1`
    FOREIGN KEY (`id_cliente`)
    REFERENCES `dbspiaggie`.`clienti` (`id_cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;