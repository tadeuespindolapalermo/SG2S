var sg2s = angular.module('sg2s', ['ngRoute']);

//$(document).ready(onBrowserReady);

/*function onBrowserReady() {
    angular.bootstrap(document, ['sg2s']);
}*/

sg2s.config(function($routeProvider) {

	$routeProvider

    .when("/login",{
		templateUrl:"index.php",
		controller: "indexController"
	})
    .when("/admin",{
		templateUrl:"view/view_admin.php?pagina=view_home.php",
		controller: "adminController"
	})
	.when("/coordenador",{
		templateUrl:"view/view_coordenador.php?pagina=view_home.php",
		controller:"coordenadorController"
	})
	.otherwise({redirectTo:"/"});
})

/*
 * Diretivas
 */
sg2s.directive('exportToExcelUsuario', function() {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var el = element[0];
            element.bind('click', function(e) {
                var table = document.getElementById(attrs.exportToExcelUsuario);
                var excelString = '';
                for(var i = 0; i < table.rows.length; i++) {
                    var rowData = table.rows[i].cells;
                    for(var j = 0; j < 5; j++) { // apenas as 5 primeiras colunas da tabela
					//for(var j = 0; j < rowData.length; j++){ // todas as colunas da tabela
						//console.log(rowData.length);
                        excelString = excelString + rowData[j].innerHTML + ",";
                    }
                    excelString = excelString.substring(0,excelString.length - 1);
                    excelString = excelString + "\n";
                }
                excelString = excelString.substring(0, excelString.length - 1);
                var date = new Date();
                var a = $('<a/>', {
                    style:'display:none',
                    href:'data:application/octet-stream; base64,' + btoa(excelString),
                    download: date + '.xlsx'
                }).appendTo('body')
                a[0].click()
                a.remove();
            });
        }
    }
});

sg2s.directive('exportToExcelCurso', function() {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var el = element[0];
            element.bind('click', function(e) {
                var table = document.getElementById(attrs.exportToExcelCurso);
                var excelString = '';
                for(var i = 0; i < table.rows.length; i++) {
                    var rowData = table.rows[i].cells;
                    for(var j = 0; j < 6; j++) { // apenas as 6 primeiras colunas da tabela
					//for(var j = 0; j < rowData.length; j++){ // todas as colunas da tabela
						//console.log(rowData.length);
                        excelString = excelString + rowData[j].innerHTML + ",";
                    }
                    excelString = excelString.substring(0,excelString.length - 1);
                    excelString = excelString + "\n";
                }
                excelString = excelString.substring(0, excelString.length - 1);
                var date = new Date();
                var a = $('<a/>', {
                    style:'display:none',
                    href:'data:application/octet-stream; base64,' + btoa(excelString),
                    download: date + '.xlsx'
                }).appendTo('body')
                a[0].click()
                a.remove();
            });
        }
    }
});

sg2s.directive('exportToExcelDisciplina', function() {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var el = element[0];
            element.bind('click', function(e) {
                var table = document.getElementById(attrs.exportToExcelDisciplina);
                var excelString = '';
                for(var i = 0; i < table.rows.length; i++) {
                    var rowData = table.rows[i].cells;
                    for(var j = 0; j < 4; j++) { // apenas as 4 primeiras colunas da tabela
					//for(var j = 0; j < rowData.length; j++){ // todas as colunas da tabela
						//console.log(rowData.length);
                        excelString = excelString + rowData[j].innerHTML + ",";
                    }
                    excelString = excelString.substring(0,excelString.length - 1);
                    excelString = excelString + "\n";
                }
                excelString = excelString.substring(0, excelString.length - 1);
                var date = new Date();
                var a = $('<a/>', {
                    style:'display:none',
                    href:'data:application/octet-stream; base64,' + btoa(excelString),
                    download: date + '.xlsx'
                }).appendTo('body')
                a[0].click()
                a.remove();
            });
        }
    }
});

sg2s.directive('exportToExcelGradeHoraria', function() {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var el = element[0];
            element.bind('click', function(e) {
                var table = document.getElementById(attrs.exportToExcelGradeHoraria);
                var excelString = '';
                for(var i = 0; i < table.rows.length; i++) {
                    var rowData = table.rows[i].cells;
                    for(var j = 0; j < 11; j++) { // apenas as 11 primeiras colunas da tabela
					//for(var j = 0; j < rowData.length; j++){ // todas as colunas da tabela
						//console.log(rowData.length);
                        excelString = excelString + rowData[j].innerHTML + ",";
                    }
                    excelString = excelString.substring(0,excelString.length - 1);
                    excelString = excelString + "\n";
                }
                excelString = excelString.substring(0, excelString.length - 1);
                var date = new Date();
                var a = $('<a/>', {
                    style:'display:none',
                    href:'data:application/octet-stream; base64,' + btoa(excelString),
                    download: date + '.xlsx'
                }).appendTo('body')
                a[0].click()
                a.remove();
            });
        }
    }
});
