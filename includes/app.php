<?php  
require __DIR__.'/../vendor/autoload.php';

use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;
use \App\Http\Middleware\Queue;

//Carrega as variáveis de ambiente
Environment::load(__DIR__.'/../');

//Define as configurações do banco de dados
Database::config(
	getenv('DB_HOST'),
	getenv('DB_NAME'),
	getenv('DB_USER'),
	getenv('DB_PASS'),
	getenv('DB_PORT')
);

define('URL', getenv('URL'));


//Define o valor padrão das variaveis 
View::init([
	'URL'=> URL
]);

//Define o mapeamento de middlewares
Queue::setMap([
	'maintenance'=> \App\Http\Middleware\Maintenance::class
]);

//Define o mapeamento de middlewares padrões executados em todas as rotas
Queue::setDefault([
	'maintenance'
]);

?>