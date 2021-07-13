<?php 
use \App\Controller\Pages;
use \App\Http\Response;
use \App\Http\Router;

$obRouter = new Router(URL);

$obRouter->get('/', [
	function(){
		return new Response(200,Pages\Home::getHome());
	}
]);

$obRouter->get('/sobre', [
	function(){
		return new Response(200,Pages\About::getAbout());
	}
]);


//Rota Dinâmica
$obRouter->get('/pagina/{idPagina}/{acao}', [
	function($idPagina, $acao){
		return new Response(200, 'Página '.$idPagina.'-'.$acao);
	}
]);

?>