<?php  

namespace App\Utils;

class View {

	//Variaveis padrões da view	
	private static $vars = [];

	//Metodo responsável por definir os dados iniciais da classe
	public static function init($vars = [])
	{
		self::$vars = $vars;
	}

	//método responsável por retornar o conteudo de uma view 
	private static function getContentView($view)
	{
		$file = __DIR__.'./../../resources/view/'.$view.'.html';
		return file_exists($file) ? file_get_contents($file) : '';

	}

	//método responsável por retornar o conteudo renderizado de uma view 
	public static function render($view, $vars = [])
	{

		//CONTEUDO DA VIEW
		$contentView = self::getContentView($view);


		$vars = array_merge(self::$vars, $vars);
		

		$keys = array_keys($vars);
		$keys = array_map(function($item) {
			return '{{'.$item.'}}';
		}, $keys);



		//RETORNA CONTEUDO RENDERIZADO
		return str_replace($keys, array_values($vars), $contentView);
	}
}

?>