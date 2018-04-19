function alterarDisabledEditar() {
    document.getElementById("nome").disabled = false;
    document.getElementById("telefone").disabled = false;
    document.getElementById("usuario").disabled = false;
    document.getElementById("email").disabled = false;
    document.getElementById("senha").disabled = false;
    document.getElementById("btnSalvar").disabled = false;
    document.getElementById("btnProteger").disabled = false;
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
    document.getElementById("nome").focus();
}
