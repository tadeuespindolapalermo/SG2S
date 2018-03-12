/* Criando o Banco de Dados */
CREATE DATABASE SG2S
DEFAULT CHARACTER SET utf8 
DEFAULT COLLATE utf8_general_ci;

/* Ativando o uso do banco de dados criado */
USE SG2S;

/* Criando a tabela usuarios */
CREATE TABLE usuarios ( /* Comando de criação da tabela */
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL, /* Chave primária, tipo inteiro, auto incremento e não aceita campos nulos */ 
    usuario VARCHAR(50) CHARACTER SET utf8 NOT NULL , /* não aceita campos nulos, tipo texto */
    email VARCHAR(100) CHARACTER SET utf8 NOT NULL, /* não aceita campos nulos, tipo texto */
    senha VARCHAR(32)/*32-md5*/ CHARACTER SET utf8 NOT NULL /* não aceita campos nulos, tipo texto */    
);

TRUNCATE usuarios; /* deleta todos os registros da tabela */
