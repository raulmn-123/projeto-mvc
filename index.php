<?php 

require __DIR__.'/vendor/autoload.php';

use \App\Controller\Pages\Home;
use \App\Http\Router;
use \App\Http\Response;
use \App\Utils\View;

define('URL', 'http://localhost/mvc');

//Define o valor padrão das variaveis 
View::init([
	'URL'=> URL
]);

//Inicia o router
$obRouter = new Router(URL);

//Inclui as rotas das paginas
include __DIR__.'/routes/pages.php';

//Imprime o response da rota
$obRouter->run()->sendResponse();

?>