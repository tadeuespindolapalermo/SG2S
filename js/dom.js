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
    document.getElementById("searchListagens").placeholder = "Digite o que deseja pesquisar...";
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

function validarCPF() {
	cpf = formProfessor.cpf.value.replace(/[^\d]+/g,'');
	if(cpf == '') return false;
	// Elimina CPFs invalidos conhecidos
	if (cpf.length != 11 ||
		cpf == "00000000000" ||
		cpf == "11111111111" ||
		cpf == "22222222222" ||
		cpf == "33333333333" ||
		cpf == "44444444444" ||
		cpf == "55555555555" ||
		cpf == "66666666666" ||
		cpf == "77777777777" ||
		cpf == "88888888888" ||
		cpf == "99999999999") {
        alert("O CPF INFORMADO É INVÁLIDO! FAVOR DIGITE UM CPF VÁLIDO!!!");        
		return false;
    }
	// Valida 1o digito
	add = 0;
	for (i=0; i < 9; i ++)
		add += parseInt(cpf.charAt(i)) * (10 - i);
		rev = 11 - (add % 11);
		if (rev == 10 || rev == 11)
			rev = 0;
		if (rev != parseInt(cpf.charAt(9))) {
            alert("O CPF INFORMADO É INVÁLIDO! FAVOR DIGITE UM CPF VÁLIDO!!!");
			return false;
        }
	// Valida 2o digito
	add = 0;
	for (i = 0; i < 10; i ++)
		add += parseInt(cpf.charAt(i)) * (11 - i);
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11)
		rev = 0;
	if (rev != parseInt(cpf.charAt(10))) {
        alert("O CPF INFORMADO É INVÁLIDO! FAVOR DIGITE UM CPF VÁLIDO!!!");
		return false;
    }
    //alert("CPF VÁLIDO!");
	return true;
}
