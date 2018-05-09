$(function() {
	$(".input-search").keyup(function() {
		// Pega o css da tabela
		var tabela = $(this).attr('alt');
		if ( $(this).val() != ""){
			$("."+tabela+" tbody>tr").hide();
			$("."+tabela+" td:contains('" + $(this).val() + "')").parent("tr").show();
		} else {
			$("."+tabela+" tbody>tr").show();
		}
	});
});
$.extend($.expr[":"], {
	"contains-ci": function(elem, i, match, array) {
		return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
	}
});
