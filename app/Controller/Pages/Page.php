<?php  

namespace App\Controller\Pages;

use \App\Utils\View;

class Page {

	private static function getHeader()
	{
		return View::render('pages/header');
	}

	//Método responsavel por renderizar o layout de paginação
	public static function getPagination($request, $obPagination)
	{
		$pages = $obPagination->getPages();
		
		//Verifica a quantidade de páginas
		if(count($pages) <= 1) return '';

		//Links
		$links = '';

		//URL atual sem gets
		$url = $request->getRouter()->getCurrentURL();

		//GET
		$queryParams = $request->getQueryParams();
		
		//Renderiza os itens
		foreach ($pages as $page) {
				//Altera página
				$queryParams['page'] = $page['page'];
				//Link

				$link = $url.'?'.http_build_query($queryParams);

				//View
				$links .= View::render('pages/pagination/link', [
					'page'=>$page['page'],
					'link'=>$link,
					'active'=>$page['current'] ? 'active' : ''
					]);
				

			}
			return View::render('pages/pagination/box', [
				'links'=>$links
				]);
		

	}

	private static function getFooter()
	{
		return View::render('pages/footer');
	}

	//método responsável por retornar conteúdo para nossa página genérica
	public static function getPage($title, $content)
	{
		return View::render('pages/page', [
			'title'=>$title,
			'header'=>self::getHeader(),
			'footer'=>self::getFooter(),
			'content'=>$content
		]);

	}

}


?>