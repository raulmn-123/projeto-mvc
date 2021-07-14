<?php  
namespace App\Http;

class Request {

	//Instancia do router
	private $router;
	//Método HTTP da requisição
	private $httpMethod;
	//URI da página
	private $uri;
	//Parametros da URL ($_GET)
	private $queryParams = [];
	//Variáveis recebidas no POST da pagina ($_POST)
	private $postVars = [];
	//cabeçalho da requisição
	private $headers = [];

	//contrutor da classe
	public function __construct($router)
	{	
		$this->router = $router;
		$this->queryParams = $_GET ?? [];
		$this->postVars = $_POST ?? [];
		$this->headers = getallheaders();
		$this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
		$this->setUri();
	}

	//Método responsável por definir a uri
	private function setUri()
	{
		$this->uri = $_SERVER['REQUEST_URI'] ?? '';
		$xURI = explode('?', $this->uri);
		$this->uri = $xURI[0];
	}


	public function getRouter()
	{
		return $this->router;
	}

	public function getHttpMethod()
	{
		return $this->httpMethod;
	}

	public function getUri()
	{
		return $this->uri;
	}

	public function getHeader()
	{
		return $this->headers;
	}

	public function getQueryParams()
	{
		return $this->queryParams;
	}
	public function getPostVars()
	{
		return $this->postVars;
	}
}

?>