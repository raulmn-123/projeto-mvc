<?php  

namespace App\Http;

class Response {
	//Códido do status HTTP da resposta
	private $httpCode = 200;
	//Cabeçalho da resposta
	private $headers = [];
	//Tipo de conteudo da resposta
	private $contentType = 'text/html';
	//Conteúdo da resposta
	private $content;

	public function __construct($httpCode, $content, $contentType = 'text/html')
	{
		$this->httpCode = $httpCode;
		$this->content = $content;
		$this->setContentType($contentType);

	}

	//Metodo responsavel por alterar o content type do response
	public function setContentType($contentType)
	{
		$this->contentType = $contentType;
		$this->addHeader('Content-Type', $contentType);
	}

	public function addHeader($key, $value)
	{
		$this->headers[$key] = $value;
	}

	private function sendHeaders()
	{
		//Status
		http_response_code($this->httpCode);
		//Enviar headers da página
		foreach ($this->headers as $key => $value) {
			header($key.': '.$value);
		}


	}

	public function sendResponse()
	{
		$this->sendHeaders();
		
		switch ($this->contentType) {
			case 'text/html':
				echo $this->content;
				exit;
		}
	}
}

?>