-- MySQL Script generated by MySQL Workbench
-- Seg 26 Mar 2018 03:02:14 -03
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema codigofonteonline1
-- -----------------------------------------------------
-- SG2S - Sistema de Geração da Grade Semestral

-- -----------------------------------------------------
-- Schema codigofonteonline1
--
-- SG2S - Sistema de Geração da Grade Semestral
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `codigofonteonline1` DEFAULT CHARACTER SET utf8 ;
USE `codigofonteonline1` ;

-- -----------------------------------------------------
-- Table `codigofonteonline1`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `codigofonteonline1`.`usuarios` (
  `idusuarios` INT NOT NULL,
  `nome` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `fone` VARCHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Haverá máscara jQuery no campo do formulário.\nFormato: (99) 9 9999-9999',
  `email` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Será validado por atributo no campo do formulário.',
  `usuario` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `senha` VARCHAR(32) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Permitido no máximo até 32 caracteres (md5).',
  PRIMARY KEY (`idusuarios`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabela para cadastro de usuários no sistema.';


-- -----------------------------------------------------
-- Table `codigofonteonline1`.`perfil`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `codigofonteonline1`.`perfil` (
  `idperfil` INT NOT NULL,
  `descricao` VARCHAR(25) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Administrador - (acesso de admin)\nCoordenador - (acesso de coordenação)\n\n\n',
  PRIMARY KEY (`idperfil`),
  UNIQUE INDEX `descricao_UNIQUE` (`descricao` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabela para cadastro de perfil de usuário.';


-- -----------------------------------------------------
-- Table `codigofonteonline1`.`curso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `codigofonteonline1`.`curso` (
  `idcurso` INT NOT NULL,
  `nome` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `portaria` VARCHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `duracao` DECIMAL(2,1) NOT NULL COMMENT 'Formato: 2.0, 2.5...\n2.0: dois anos\n2.5: dois anos e meio',
  `grau` VARCHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Tecnólogo\nBacharelado\nLicenciatura\n',
  `data_portaria` DATE NOT NULL COMMENT 'Formato: DD/MM/AAAA',
  PRIMARY KEY (`idcurso`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabela para cadastro de cursos.';


-- -----------------------------------------------------
-- Table `codigofonteonline1`.`matriz_curricular`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `codigofonteonline1`.`matriz_curricular` (
  `idmatriz_curricular` INT NOT NULL,
  `curso_idcurso` INT NOT NULL,
  `nome` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `carga_horaria` DECIMAL(5,2) NOT NULL COMMENT 'Formato: 999.99\nEx.:\n100.00 - 100 horas\n105.30 - 105 horas e 30 minutos',
  `credito` INT(1) NOT NULL COMMENT 'Peso da disciplina',
  PRIMARY KEY (`idmatriz_curricular`, `curso_idcurso`),
  INDEX `fk_matriz_curricular_curso1_idx` (`curso_idcurso` ASC),
  CONSTRAINT `fk_matriz_curricular_curso1`
    FOREIGN KEY (`curso_idcurso`)
    REFERENCES `codigofonteonline1`.`curso` (`idcurso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabela para cadastro de matriz curricular (disciplinas).';


-- -----------------------------------------------------
-- Table `codigofonteonline1`.`usuario_perfil`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `codigofonteonline1`.`usuario_perfil` (
  `idusuario_perfil` INT NOT NULL,
  `usuarios_idusuarios` INT NOT NULL,
  `perfil_idperfil` INT NOT NULL,
  PRIMARY KEY (`idusuario_perfil`, `usuarios_idusuarios`, `perfil_idperfil`),
  INDEX `fk_usuario_perfil_usuarios1_idx` (`usuarios_idusuarios` ASC),
  INDEX `fk_usuario_perfil_perfil1_idx` (`perfil_idperfil` ASC),
  CONSTRAINT `fk_usuario_perfil_usuarios1`
    FOREIGN KEY (`usuarios_idusuarios`)
    REFERENCES `codigofonteonline1`.`usuarios` (`idusuarios`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_perfil_perfil1`
    FOREIGN KEY (`perfil_idperfil`)
    REFERENCES `codigofonteonline1`.`perfil` (`idperfil`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Associação entre as tabelas usuarios e perfil';


-- -----------------------------------------------------
-- Table `codigofonteonline1`.`pre_requisito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `codigofonteonline1`.`pre_requisito` (
  `idpre_requisito` INT NULL DEFAULT NULL,
  `matriz_curricular_idmatriz_curricular` INT NOT NULL,
  `matriz_curricular_curso_idcurso` INT NOT NULL,
  UNIQUE INDEX `idpre_requisito_UNIQUE` (`idpre_requisito` ASC),
  PRIMARY KEY (`matriz_curricular_idmatriz_curricular`, `matriz_curricular_curso_idcurso`),
  CONSTRAINT `fk_pre_requisito_matriz_curricular1`
    FOREIGN KEY (`matriz_curricular_idmatriz_curricular` , `matriz_curricular_curso_idcurso`)
    REFERENCES `codigofonteonline1`.`matriz_curricular` (`idmatriz_curricular` , `curso_idcurso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabela que representa disciplinas que são pré requisitos para outras disciplinas.';


-- -----------------------------------------------------
-- Table `codigofonteonline1`.`grade_semestral`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `codigofonteonline1`.`grade_semestral` (
  `idgrade_semestral` INT NOT NULL,
  `ano_letivo` INT(4) NOT NULL,
  `semestre` INT(1) NOT NULL COMMENT '1 - (1º semestre)\n2 - (2º semestre)',
  `periodo` VARCHAR(12) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Matutino\nVespertino\nNoturno',
  `horario` VARCHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT '19:15 às 22:00\n- ...\n- ... ',
  `sala` INT(2) NOT NULL,
  `quantidade_alunos` INT(3) NOT NULL,
  `turmas` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `curso_idcurso` INT NOT NULL,
  PRIMARY KEY (`idgrade_semestral`, `curso_idcurso`),
  INDEX `fk_grade_semestral_curso1_idx` (`curso_idcurso` ASC),
  CONSTRAINT `fk_grade_semestral_curso1`
    FOREIGN KEY (`curso_idcurso`)
    REFERENCES `codigofonteonline1`.`curso` (`idcurso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabela para cadastro das informações presentes na grade semestral.';


-- -----------------------------------------------------
-- Table `codigofonteonline1`.`professor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `codigofonteonline1`.`professor` (
  `idprofessor` INT NOT NULL,
  `nome` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `CPF` VARCHAR(14) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Haverá máscara jQuery no campo do formulário.\nFormato: 999.999.999-99',
  `RG` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Formato livre.',
  `email` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Será validado por atributo no campo do formulário.',
  `fone` VARCHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Haverá máscara jQuery no campo do formulário.\nFormato: (99) 9 9999-9999',
  `exclusao` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`idprofessor`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabela de Cadastro e Identificação de Professores';


-- -----------------------------------------------------
-- Table `codigofonteonline1`.`disciplina_professor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `codigofonteonline1`.`disciplina_professor` (
  `iddisciplina_professor` INT NOT NULL,
  `professor_idprofessor` INT NOT NULL,
  `matriz_curricular_idmatriz_curricular` INT NOT NULL,
  `matriz_curricular_curso_idcurso` INT NOT NULL,
  PRIMARY KEY (`iddisciplina_professor`, `professor_idprofessor`, `matriz_curricular_idmatriz_curricular`, `matriz_curricular_curso_idcurso`),
  INDEX `fk_disciplina_professor_professor1_idx` (`professor_idprofessor` ASC),
  INDEX `fk_disciplina_professor_matriz_curricular1_idx` (`matriz_curricular_idmatriz_curricular` ASC, `matriz_curricular_curso_idcurso` ASC),
  CONSTRAINT `fk_disciplina_professor_professor1`
    FOREIGN KEY (`professor_idprofessor`)
    REFERENCES `codigofonteonline1`.`professor` (`idprofessor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_disciplina_professor_matriz_curricular1`
    FOREIGN KEY (`matriz_curricular_idmatriz_curricular` , `matriz_curricular_curso_idcurso`)
    REFERENCES `codigofonteonline1`.`matriz_curricular` (`idmatriz_curricular` , `curso_idcurso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabela associativa entre as tabelas disciplina (matriz curricular) e professor.';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
