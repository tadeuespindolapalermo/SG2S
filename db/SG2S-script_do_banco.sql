/* Criando o Banco de Dados com codificação de caracteres e collate UTF-8 */
CREATE DATABASE SG2S
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

/* Ativando o uso do banco de dados criado */
/* USE SG2S; */

/* Criando a tabela de usuarios */
CREATE TABLE usuarios ( /* Comando de criação da tabela */
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL, /* Chave primária, tipo inteiro, auto incremento e não aceita campos nulos */
	acesso VARCHAR(15) CHARACTER SET utf8 NOT NULL DEFAULT 'Aluno', /* não aceita campos nulos, tipo texto, padrão assume o valor aluno */
	matricula VARCHAR(10) CHARACTER SET utf8 NOT NULL, /* não aceita campos nulos, tipo texto */
    nome VARCHAR(50) CHARACTER SET utf8 NOT NULL, /* não aceita campos nulos, tipo texto */
    sobrenome VARCHAR(50) CHARACTER SET utf8 NOT NULL, /* não aceita campos nulos, tipo texto */
	telefone VARCHAR(16) CHARACTER SET utf8 NOT NULL, /* não aceita campos nulos, tipo texto */
    usuario VARCHAR(50) CHARACTER SET utf8 NOT NULL, /* não aceita campos nulos, tipo texto */
    email VARCHAR(100) CHARACTER SET utf8 NOT NULL, /* não aceita campos nulos, tipo texto */
    senha VARCHAR(32)/*32-md5*/ CHARACTER SET utf8 NOT NULL, /* não aceita campos nulos, tipo texto */
	chave VARCHAR(20) CHARACTER SET utf8 NOT NULL /* não aceita campos nulos, tipo texto */
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* deleta todos os registros da tabela */
/* TRUNCATE usuarios; */

/* dropa ou excluir a tabela e todos os registros */
/* DROP TABLE usuarios; */
