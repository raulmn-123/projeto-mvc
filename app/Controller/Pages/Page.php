<?php  

namespace App\Controller\Pages;

use \App\Utils\View;

class Page {

	private static function getHeader()
	{
		return View::render('pages/header');
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