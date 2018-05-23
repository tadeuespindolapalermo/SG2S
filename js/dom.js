function alterarDisabledEditar() {
    document.getElementById("nome").disabled = false;
    document.getElementById("telefone").disabled = false;
    document.getElementById("usuario").disabled = false;
    document.getElementById("email").disabled = false;
    document.getElementById("senha").disabled = false;
    document.getElementById("btnSalvar").disabled = false;
    document.getElementById("btnProteger").disabled = false;
    document.getElementById("btnVoltarInicio").disabled = true;
    document.getElementById("btnEditar").disabled = true;
    document.getElementById("nome").focus();
}

function alterarDisabledProteger() {
    document.getElementById("nome").disabled = true;
    document.getElementById("telefone").disabled = true;
    document.getElementById("usuario").disabled = true;
    document.getElementById("email").disabled = true;
    document.getElementById("senha").disabled = true;
    document.getElementById("btnSalvar").disabled = true;
    document.getElementById("btnProteger").disabled = true;
    document.getElementById("btnEditar").disabled = false;
    document.getElementById("btnVoltarInicio").disabled = false;
    document.getElementById("nome").focus();
}

function alterarDisabledSearch() {
    document.getElementById("searchListagens").disabled = false;
    document.getElementById("btnSearch").disabled = true;
}

function voltarInicioAdmin() {
    location.href = 'view_admin.php?pagina=view_home.php';
}

function voltarInicioCoordenador() {
    location.href = 'view_coordenador.php?pagina=view_home.php';
}

function alterarDisabledCadastroGradeHoraria() {
    document.getElementById("idGradeSemestral").disabled = false;
    document.getElementById("idCursoGradeSemestral").disabled = false;
}
