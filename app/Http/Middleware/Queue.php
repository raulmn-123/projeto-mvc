<?php  

namespace App\Http\Middleware;

class Queue {

	//Mapeamento de middlewares
	private static $map = [];

	//Mapeamento de middlewares padrões em todas as rotas
	private static $default = [];

	//Fila de middleware a serem executados
	private $middlewares = [];

	//Função de execução do controlador
	private $controller;

	//Argumentos da função do controlador
	private $controllerArgs = [];

	//Método responsavel por contruir a classe de fila de middlewares
	public function __construct($middlewares, $controller, $controllerArgs)
	{
		$this->middlewares = array_merge(self::$default, $middlewares);
		$this->controller = $controller;
		$this->controllerArgs = $controllerArgs;

	}


	//Método responsável por definir o mapeamento de middlewares
	public static function setMap($map)
	{
		self::$map = $map;
	}

	//Método responsável por executar o próximo nível da fila de middlewares
	public function next($request)
	{
		//Verifica se a fila está vazia
		if(empty($this->middlewares)) return call_user_func_array($this->controller,$this->controllerArgs);
		
		$middleware = array_shift($this->middlewares);
		
		//Verifica o mapeamento
		if(!isset(self::$map[$middleware]))
		{
			throw new \Exception("Problemas ao processar o middleware da requisição.", 500);
			
		}

		//NEXT DE FATO
		$queue = $this;
		$next = function($request) use ($queue) {

			return $queue->next($request);
		};
	
		//Executa o middleware
		return (new self::$map[$middleware])->handle($request, $next);
	}

	//Responsável por definir o mapeamento de middlewares padrões 
	public static function setDefault($default)
	{
		self::$default = $default;
	}

}


?>