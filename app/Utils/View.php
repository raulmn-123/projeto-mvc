<?php  

namespace App\Utils;

class View {

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

		$keys = array_keys($vars);

		$keys = array_map(function($item) {

			return '{{'.$item.'}}';

		}, $keys);



		//RETORNA CONTEUDO RENDERIZADO
		return str_replace($keys, array_values($vars), $contentView);
	}
}

?>