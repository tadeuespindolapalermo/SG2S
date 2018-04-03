var ajax;
// função para iniciar o objeto Ajax
// Ajax por padrão é assíncrono,
function iniciaRequisitaAjax (tipo,url,assinc) {

	if (window.XMLHttpRequest) {	  // Mozilla, Safari,...

		/*criar objeto XMLHttpRequest*/
		ajax = new XMLHttpRequest();

	} else if (window.ActiveXObject) {	// IE

		/*criar objeto ActiveXObject com Msxml2.XMLHTTP */
		ajax = new ActiveXObject("Msxml2.XMLHTTP");

		if (!ajax) {

			/*criar objeto ActiveXObject com Microsoft.XMLHTTP */
			ajax = new ActiveXObject("Microsoft.XMLHTTP");
	    }
    }

	if (ajax) {
		// iniciou com sucesso
		requisicao(tipo,url,assinc);
	} else {
		alert("Seu navegador não possui suporte a essa aplicação!");
	}
}

// ------- Inicializa o objeto criado e envia os dados (se existirem) -------
function requisicao(tipo,url,bool) {
	ajax.onreadystatechange = trataResposta;
	ajax.open(tipo,url,bool);
	ajax.send();
}

// ------- Trata a resposta do servidor -------
function trataResposta() {
	if (ajax.readyState == 4) { // passo 4 (terminou a requisição)
		if (ajax.status == 200) { // requisição deu certo
			trataDados();  // criar essa função no seu programa
		} else {
			alert("Problema na comunicação com o objeto XMLHttpRequest.");
		}
	}
}

function trataDados() {
	/*tratar a resposta*/
	var resposta = ajax.responseText;
	var elemento = document.getElementById('conteudo');
	elemento.innerHTML = resposta;
	resposta = null;
	ajax = null;
}
