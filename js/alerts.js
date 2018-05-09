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

// Delete Grade
function msgConfirmaDeleteGrade(idGrade) {
    var deletarGrade = confirm('Deseja realmente excluir esta grade?');
    if (deletarGrade) {
        location.href = 'view_admin.php?pagina=../controller/controller_grade_remove.php&idGrade=' + idGrade;
    }
}

// Delete Curso
function msgConfirmaDeleteCurso(idCurso) {
    var deletarCurso = confirm('Deseja realmente excluir este curso?');
    if (deletarCurso) {
        location.href = 'view_admin.php?pagina=../controller/controller_curso_remove.php&idCurso=' + idCurso;
    }
}

// Delete Matriz
function msgConfirmaDeleteMatriz(idMatriz) {
    var deletarMatriz = confirm('Deseja realmente excluir esta matriz?');
    if (deletarMatriz) {
        location.href = 'view_admin.php?pagina=../controller/controller_matriz_remove.php&idMatriz=' + idMatriz;
    }
}

// Delete Professor Provisório (Lixeira)
function msgConfirmaDeleteProfessorProvisorioLixeira(idProfessor) {
    var deletarProfessor = confirm('Deseja realmente enviar este professor para a lixeira?');
    if (deletarProfessor) {
        location.href = 'view_admin.php?pagina=../controller/controller_professor_remove.php&idProfessor=' + idProfessor;
    }
}

// Delete Professor Definitivo (Banco de Dados)
function msgConfirmaDeleteProfessorDefinitivoBancoDados(idProfessor) {
    var deletarProfessor = confirm('Deseja realmente eliminar este professor permanentemente?');
    if (deletarProfessor) {
        location.href = 'view_admin.php?pagina=../controller/controller_professor_remove_definitivo.php&idProfessor=' + idProfessor;
    }
}
//-------------------------------------------------------
