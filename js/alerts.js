function msgUpdateUsuarios() {
    alert('Atenção: o usuário da sessão atual deve realizar a alteração de seus dados cadastrais somente através da opção no Dashboard para que seus dados de sessão sejam atualizados!');
}

//-------------------------------------------------------
/**
 * Mensagens de Confirmação de Deleção de Registros
 */

 // Delete Usuário
function msgConfirmaDeleteUsuario(idUsuario) {
    var deletarUsuario = confirm('Deseja realmente excluir este usuário?');
    if (deletarUsuario) {
        location.href = 'view_admin.php?pagina=../controller/controller_usuario_remove.php&idUsuario=' + idUsuario;
    }
}

// Delete Grade (ADMIN)
function msgConfirmaDeleteGradeSemestralAdmin(idGradeSemestral) {
    var deletarGradeSemestral = confirm('Deseja realmente excluir esta grade semestral?');
    if (deletarGradeSemestral) {
        location.href = 'view_admin.php?pagina=../controller/controller_grade_semestral_remove.php&idGradeSemestral=' + idGradeSemestral;
    }
}

// Delete Grade (COORDENADOR)
function msgConfirmaDeleteGradeSemestralCoordenador(idGradeSemestral) {
    var deletarGradeSemestral = confirm('Deseja realmente excluir esta grade semestral?');
    if (deletarGradeSemestral) {
        location.href = 'view_coordenador.php?pagina=../controller/controller_grade_semestral_remove.php&idGradeSemestral=' + idGradeSemestral;
    }
}

// Delete Curso (ADMIN)
function msgConfirmaDeleteCursoAdmin(idCurso) {
    var deletarCurso = confirm('Deseja realmente excluir este curso?');
    if (deletarCurso) {
        location.href = 'view_admin.php?pagina=../controller/controller_curso_remove.php&idCurso=' + idCurso;
    }
}

// Delete Curso (COORDENADOR)
function msgConfirmaDeleteCursoCoordenador(idCurso) {
    var deletarCurso = confirm('Deseja realmente excluir este curso?');
    if (deletarCurso) {
        location.href = 'view_coordenador.php?pagina=../controller/controller_curso_remove.php&idCurso=' + idCurso;
    }
}

// Delete Disciplina (ADMIN)
function msgConfirmaDeleteDisciplinaAdmin(idDisciplina) {
    var deletarDisciplina = confirm('Deseja realmente excluir esta disciplina?');
    if (deletarDisciplina) {
        location.href = 'view_admin.php?pagina=../controller/controller_disciplina_remove.php&idDisciplina=' + idDisciplina;
    }
}

// Delete Disciplina (COORDENADOR)
function msgConfirmaDeleteDisciplinaCoordenador(idDisciplina) {
    var deletarDisciplina = confirm('Deseja realmente excluir esta disciplina?');
    if (deletarDisciplina) {
        location.href = 'view_coordenador.php?pagina=../controller/controller_disciplina_remove.php&idDisciplina=' + idDisciplina;
    }
}

// Delete Professor Provisório (Lixeira) (ADMIN)
function msgConfirmaDeleteProfessorProvisorioLixeiraAdmin(idProfessor) {
    var deletarProfessor = confirm('Deseja realmente enviar este professor para a lixeira?');
    if (deletarProfessor) {
        location.href = 'view_admin.php?pagina=../controller/controller_professor_remove.php&idProfessor=' + idProfessor;
    }
}

// Delete Professor Provisório (Lixeira) (COORDENADOR)
function msgConfirmaDeleteProfessorProvisorioLixeiraCoordenador(idProfessor) {
    var deletarProfessor = confirm('Deseja realmente enviar este professor para a lixeira?');
    if (deletarProfessor) {
        location.href = 'view_coordenador.php?pagina=../controller/controller_professor_remove.php&idProfessor=' + idProfessor;
    }
}

// Delete Professor Definitivo (Banco de Dados) (ADMIN)
function msgConfirmaDeleteProfessorDefinitivoBancoDadosAdmin(idProfessor) {
    var deletarProfessor = confirm('Deseja realmente eliminar este professor permanentemente?');
    if (deletarProfessor) {
        location.href = 'view_admin.php?pagina=../controller/controller_professor_remove_definitivo.php&idProfessor=' + idProfessor;
    }
}

// Delete Professor Definitivo (Banco de Dados) (COORDENADOR)
function msgConfirmaDeleteProfessorDefinitivoBancoDadosCoordenador(idProfessor) {
    var deletarProfessor = confirm('Deseja realmente eliminar este professor permanentemente?');
    if (deletarProfessor) {
        location.href = 'view_coordenador.php?pagina=../controller/controller_professor_remove_definitivo.php&idProfessor=' + idProfessor;
    }
}
//-------------------------------------------------------
