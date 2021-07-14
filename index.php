<?php 

require __DIR__.'/includes/app.php';

use \App\Http\Router;

//Inicia o router
$obRouter = new Router(URL);

//Inclui as rotas das paginas
include __DIR__.'/routes/pages.php';

//Imprime o response da rota
$obRouter->run()->sendResponse();

?>