<?php  

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Testimonial as EntityTestimonial;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimonial extends Page {

	//Metodo responsavel por obter a renderização dos items de depoimentos para a página
	private static function getTestimonialItems($request, &$obPagination)
	{	

		//Depoimentos
		$items = '';

		//Quantidade total de registros
		$qtdTotal = EntityTestimonial::getTestimonials(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
		
		//Página atual
		$queryParams = $request->getQueryParams();
		$paginaAtual = $queryParams['page'] ?? 1;
		
		//Instacia de paginação

		$obPagination =  new Pagination($qtdTotal, $paginaAtual, 2);


		//Resultados da página
		$results = EntityTestimonial::getTestimonials(null, 'id DESC', $obPagination->getLimit());
		while($obTestimonial = $results->fetchObject(EntityTestimonial::class))
		{
			$items .= View::render('pages/testimonial/item', [
			'nome'=>$obTestimonial->nome,
			'mensagem'=>$obTestimonial->mensagem,
			'data'=>date('d/m/Y H:i:s',strtotime($obTestimonial->data)),
			'id'=>$obTestimonial->id
		]);
		}


		return $items;
	}

	public static function getTestimonials($request)
	{
		
		$content = View::render('pages/testimonials', [
			'itens'=>self::getTestimonialItems($request, $obPagination),
			'pagination'=>parent::getPagination($request, $obPagination)
		]);

		return parent::getPage('DEPOIMENTOS', $content); 
	}

	//Metodo responsavel por cadastrar um depoimento
	public static function insertTestimonial($request)
	{	
		//Dados do post
		$postVars = $request->getPostVars();

		//Nova instância de depoimento
		$obTestimonial = new EntityTestimonial;

		$obTestimonial->nome = $postVars['nome'];
		$obTestimonial->mensagem = $postVars['mensagem'];

		$obTestimonial->cadastrar();


		return self::getTestimonials($request);
	}

}


?>