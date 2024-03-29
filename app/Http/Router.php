<?php  

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use \App\Http\Middleware\Queue;

class Router {

	//Url completa do projeto
	private $url = '';
	//Prefixo de todas as rotas
	private $prefix = '';
	//Todas as rotas organizadas em índice dentro de um array
	private $routes = [];
	//Instancia da classe Request
	private $request;

	//Método responsavel por iniciar a classe
	public function __construct($url)
	{
		$this->request = new Request($this);
		$this->url = $url;
		$this->setPrefix();
	}

	private function setPrefix()
	{	
		//Informações da URL atual
		$parseUrl = parse_url($this->url);

		//Define prefixo
		$this->prefix = $parseUrl['path'] ?? '';	
	}

	private function addRoute($method, $route,$params=[])
	{	
	//Validação dos parametros
		foreach ($params as $key => $value) {
			if($value instanceof Closure) {
				$params['controller'] = $value;
				unset($params[$key]);
				continue;
			}
		}

		//Middlewares da rota
		$params['middlewares'] = $params['middlewares'] ?? [];
		
		//Variaveis da rota
		$params['variables'] = [];

		//Padrão de validação das variaveis das rotas
		$patternVariable = '/{(.*?)}/';

		if(preg_match_all($patternVariable, $route, $matches))
		{
			$route = preg_replace($patternVariable,'(.*?)', $route);
			$params['variables'] = $matches[1];
		}

		//Padrão de validação da URL
		$patternRoute = '/^'.str_replace('/', '\/', $route).'$/';

		//Adiciona a rota dentro da classe
		$this->routes[$patternRoute][$method] = $params;
	}

	public function get($route, $params = [])
	{
		return $this->addRoute('GET', $route, $params);
	}	

	public function post($route, $params = [])
	{
		return $this->addRoute('POST', $route, $params);
	}	

	public function put($route, $params = [])
	{
		return $this->addRoute('DELETE', $route, $params);
	}	
	

	//Metodo responsavel por retornar a URI desconsiderando o prefixo
	private function getUri()
	{
		$uri = $this->request->getUri();

		$xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

		//retorna a uri sem prefixo
		return end($xUri);  
	}
	//Método responsávl por retornar os dados da rota atual
	private function getRoute()
	{
		//URI
		$uri = $this->getUri();

		$httpMethod = $this->request->getHttpMethod();

		//valida as rotas
		foreach ($this->routes as $patternRoute => $methods) {
			if(preg_match($patternRoute, $uri,$matches)){
				//Verifica o metodo
				if(isset($methods[$httpMethod])){

					unset($matches[0]);

					//Variaveis processadas
					$keys = $methods[$httpMethod]['variables'];
					$methods[$httpMethod]['variables'] = array_combine($keys, $matches);
					$methods[$httpMethod]['variables']['request'] = $this->request;
				

					//retorno dos parametros da rota
					return $methods[$httpMethod];
				}

				throw new Exception("Método não permitido.",405);
				
			}
		}
		
		//URL não encontrada
		throw new Exception("URL nao encontrada",404);
		
	}

	//Método responsavel por executar a rota atual
	public function run()
	{
		try {

			//Obtem a rota atual
			$route = $this->getRoute();

			//verifica o controlador 
			if(!isset($route['controller'])) {
				throw new Exception("A URL não pode ser processada.", 500);
			}



			$args = [];

			//Reflection

			$reflection = new ReflectionFunction($route['controller']);
			foreach ($reflection->getParameters() as $parameter) {

				$name = $parameter->getName();

				$args[$name] = $route['variables'][$name] ?? '';

			}

			

			//Retorna a execução da fila de middlewares
			return (new Queue($route['middlewares'], $route['controller'], $args))->next($this->request);
			

		} catch(Exception $e) {

			return new Response($e->getCode(), $e->getMessage());

		}
	}

	//metodo responsável por retornar a url atual
	public function getCurrentURL()
	{
		return $this->url.$this->getUri();
	}
}


?>