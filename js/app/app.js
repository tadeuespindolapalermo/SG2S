angular.module("sg2s", ['ngRoute']).config(function($routeProvider) {

	$routeProvider

    .when("/",{
		templateUrl:"index.php",
		controller: "indexController"
	})
    /*.when("/inscrevase",{
		templateUrl:"autenticacao/inscrevase.php",
		controller: "inscricaoController"
	})
	.when("/home",{
		templateUrl:"view/home.php",
		controller:"homeController"
	})*/
	.otherwise({redirectTo:"/"});
})
