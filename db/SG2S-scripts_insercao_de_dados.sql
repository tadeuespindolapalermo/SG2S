
/* TABELA curso - Cursos da Faculdade JK*/

INSERT INTO curso (nome, portaria, duracao, grau, data_portaria, versao_matriz)
VALUES ('Análise e Desenvolvimento de Sistemas', '2554-6', 2.5, 'Tecnólogo', '1992-03-24', 12018);

INSERT INTO curso (nome, portaria, duracao, grau, data_portaria, versao_matriz)
VALUES ('Tecnologia em Redes de Computadores', '7715-6', 2.5, 'Tecnólogo', '1998-05-14', 22018);

INSERT INTO curso (nome, portaria, duracao, grau, data_portaria, versao_matriz)
VALUES ('Sistemas de Informação', '5597-8	', 4.0, 'Bacharelado', '1998-07-18', 12019);

/* --------------------------------------------------------------------------------------------------------- */

/* TABELA disciplinas - Disciplinas do Curso de TADS*/

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Fundamentos de Redes de Computadores I', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Metodologia Científica', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Lógica de Programação e Algoritmos', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Organização e Arquitetura de Computadores', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Sistemas Operacionais', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Estrutura de Dados', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Língua Portuguesa', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Banco de Dados', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Desenvolvimento Pessoal e Profissional', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Inglês Instrumental', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Projeto Integrador I', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Optativa I - Libras', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Introdução à Orientação a Objetos', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Psicologia Geral', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Programação para Dispositivos Móveis', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Linguagem de Programação Web I', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Software Livre (Portal do Software Público)', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Design para Web', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Engenharia de Software', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Sociedade, Ética, Cidadania e Direitos Humanos', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Progamação Orientada a Objetos', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Fundamentos de Teste de Software', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Gerencia de Projetos', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Segurança da Informação', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Processo de Desenvolvimento de Software', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Linguagem de Programação Web II', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Projeto Integrador II', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Engenharia de Requisitos e Métricas de Software', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Empreendedorismo', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Estágio Supervisionado', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Atividades Complementares I', 72.00, 4);

INSERT INTO disciplinas (nome_disciplina, carga_horaria, credito)
VALUES ('Atividades Complementares II', 72.00, 4);
/* ----------------------------------------------------------------------------- */

/* TABELA professor - Professores da JK*/

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('George H. R. Escobar Mendonça', '065.465.985-98', '9569856', 'george.mendonca@jk.edu.br', '(61) 9 9287 0130', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Deusilene Santos Lima', '325.985.654-65', '8874623', 'deusilenesl@gmail.com', '(61) 9 9931-6138', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Estevão Ribeiro Monti', '498.985.265-95', '7795265', 'estevor46@gmail.com', '(61) 9 8546-6598', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Carlos Maurício de Borges Mello', '065.865.746-98', '9956324', 'profecmauricio@gmail.com', '(61) 9 4598-9832', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Altair Martins', '325.654.259-65', '3059874', 'altermartins@gmail.com', '(61) 9 9386-7653', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Samira Rahhal', '497.265.165-95', '5716254', 'prof.samira.rahhal@gmail.com', '(61) 9 8416-9465', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Salvina Maria de Jesus', '497.298.654-65', '6975248', 'salvinamaria28@gmail.com', '(61) 9 9855-4393', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Gleidson Porto Batista', '205.971.625-96', '3298524', 'gleidsonporto@gmail.com ', '(61) 9 8417-3444', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Jardel Cruz Silva', '226.974.265-98', '9287521', 'jardelcruzsilva@gmail.com', '(61) 9 9308-1792', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Alyne Dayane P. Souza', '449.326.987-65', '8265974', 'alynevet@yahoo.com.br', '(61) 9 9258-1123', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Eduardo C. M. Borges', '498.826.965-65', '0974256', 'eduardo.borges@inbd.com.br', '(61) 9 9347-2947', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Juliete Moreira Rebordão', '444.652.985-98', '8716529', 'juliete.psi@gmail.com', '(61) 9 9258-1123', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Edimar Gomes Nogueira', '654.328.716-65', '5741986', 'nogueiraguerra@gmail.com', '(61) 9 8569-4578', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Henderson Matsuura Sanches', '049.795.198-98', '8712598', 'henderson@jk.edu.br', '(61) 9 9977-0522', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Ismael Rômulo', '669.258.656-98', '1097528', 'prof.ismaelromulo@gmail.com', '(61) 9 9658-1254', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Lucélia Vieira Mota', '647.258.698-98', '2874256', 'luceliafn@gmail.com', '(61) 9 8597-6532', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Gabriel Miranda Carvalho', '149.824.698-75', '3985625', 'gabrielm.car@gmail.com', '(61) 9 8119-2084', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('João Fernando', '257.639.529-98', '1974256', 'joaofernando@espiritolivre.org', '(61) 9 9465-2536', 1);

INSERT INTO professor (nome, CPF, RG, email, fone, exclusao)
VALUES ('Carlos Fernandez', '028.985.147-94', '2974582', 'kaufernandez@gmail.com', '(61) 9 8465-6598', 1);

/* ------------------------------------------------------------------------------------------------------- */

/* TABELA PERFIL */

INSERT INTO perfil (idperfil, descricao)
VALUES (1, 'Administrador');

INSERT INTO perfil (idperfil, descricao)
VALUES (2, 'Coordenador');

/* ------------------------------------------------------------------------------------------------------- */

/* TABELA usuarios - Usuários do SG2S*/

/* ADMINISTRADOR */
INSERT INTO usuarios (nome, fone, email, usuario, senha)
VALUES ('Tadeu Espíndola Palermo', '(61) 9 8647-3913', 'tadeupalermoti@gmail.com', 'tadeuespindolapalermo', md5('Tadeu198'));
INSERT INTO usuario_perfil (usuarios_idusuarios, perfil_idperfil)
VALUES (1, 1);

/* ADMINISTRADOR */
INSERT INTO usuarios (nome, fone, email, usuario, senha)
VALUES ('George Mendonça', '(61) 9 9287-0130', 'george.mendonca@jk.edu.br', 'georgemendonca', md5('George45'));
INSERT INTO usuario_perfil (usuarios_idusuarios, perfil_idperfil)
VALUES (2, 1);

/* COORDENADOR */
INSERT INTO usuarios (nome, fone, email, usuario, senha)
VALUES ('Joelinda Silva', '(61) 9 9282-8855', 'joelinda@jk.edu.br', 'joelinda', md5('Joe19851'));
INSERT INTO usuario_perfil (usuarios_idusuarios, perfil_idperfil)
VALUES (3, 2);

/* ADMINISTRADOR */
INSERT INTO usuarios (nome, fone, email, usuario, senha)
VALUES ('Marcos Alexandre da S. Lima', '(61) 9 9848-6698', '01marcosalexandre@gmail.com', 'marcos', md5('Marcos23'));
INSERT INTO usuario_perfil (usuarios_idusuarios, perfil_idperfil)
VALUES (4, 1);

/* ADMINISTRADOR */
INSERT INTO usuarios (nome, fone, email, usuario, senha)
VALUES ('Eduardo Borges', '(61) 9 9347-2947', 'eduardo.borges@inbd.com.br', 'ecesarmiranda', md5('Eduardo9'));
INSERT INTO usuario_perfil (usuarios_idusuarios, perfil_idperfil)
VALUES (5, 1);

/* --------------------------------------------------------------------------------------------------------- */


/* TABELA grade_semestral - Grades cadastradas pelo Coordenador*/

INSERT INTO grade_semestral (ano_letivo, semestre_letivo, turno, horario, curso_idcurso)
VALUES (2018, 1, 'Noturno', '19:15 às 22:00', 1);

INSERT INTO grade_semestral (ano_letivo, semestre_letivo, turno, horario, curso_idcurso)
VALUES (2018, 2, 'Matutino', '08:00 às 12:00', 2);

INSERT INTO grade_semestral (ano_letivo, semestre_letivo, turno, horario, curso_idcurso)
VALUES (2019, 1, 'Vespertino', '13:00 às 18:00', 3);

/* --------------------------------------------------------------------------------------------------------- */

/* TABELA curso_disciplinas - Disciplinas associadas à um determinado curso ou Cursos associados à uma determinada disciplina*/
   --MATRIZ CURRICULAR
   -- TADS
INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (1, 1, 1);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (2, 1, 2);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (3, 1, 3);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (4, 1, 4);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (5, 1, 5);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (6, 1, 6);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (7, 1, 7);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (8, 1, 8);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (9, 1, 9);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (10, 1, 10);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (11, 1, 11);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (12, 1, 12);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (13, 1, 13);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (14, 1, 14);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (15, 1, 15);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (16, 1, 16);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (17, 1, 17);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (18, 1, 18);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (19, 1, 19);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (20, 1, 20);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (21, 1, 21);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (22, 1, 22);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (23, 1, 23);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (24, 1, 24);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (25, 1, 25);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (26, 1, 26);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (27, 1, 27);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (28, 1, 28);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (29, 1, 29);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (30, 1, 30);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (31, 1, 31);

INSERT INTO curso_disciplinas (idcurso_disciplinas, curso_idcurso, disciplinas_iddisciplinas)
VALUES (32, 1, 32);

/* --------------------------------------------------------------------------------------------------------- */

/* TABELA disciplina_professor - Disciplinas associadas à um determinado professor*/

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (1, 2, 1);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (2, 3, 2);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (3, 1, 3);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (4, 4, 4);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (5, 4, 5);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (6, 1, 6);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (7, 7, 7);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (8, 5, 8);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (9, 6, 9);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (10, 1, 10);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (11, 2, 11);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (12, 10, 12);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (13, 8, 13);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (14, 12, 14);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (15, 11, 15);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (16, 9, 16);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (17, 1, 17);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (18, 13, 18);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (19, 14, 19);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (20, 19, 20);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (21, 17, 21);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (22, 15, 22);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (23, 16, 23);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (24, 18, 24);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (25, 8, 25);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (26, 9, 26);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (27, 4, 27);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (28, 16, 28);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (29, 18, 29);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (30, 14, 30);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (31, 1, 31);

INSERT INTO disciplina_professor (iddisciplina_professor, professor_idprofessor, disciplinas_iddisciplinas)
VALUES (32, 1, 32);

/* --------------------------------------------------------------------------------------------------------- */
