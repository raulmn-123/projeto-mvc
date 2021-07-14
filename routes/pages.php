<?php 
use \App\Controller\Pages;
use \App\Http\Response;
use \App\Http\Router;

$obRouter = new Router(URL);

$obRouter->get('/', [
	function(){
		return new Response(200,Pages\Home::getHome());
	}
]);

$obRouter->get('/sobre', [
	function(){
		return new Response(200,Pages\About::getAbout());
	}
]);

$obRouter->get('/depoimentos', [
		function($request){
		return new Response(200,Pages\Testimonial::getTestimonials($request));
	}
]);

//Rota depoimentos POST
$obRouter->post('/depoimentos', [
		function($request){
		return new Response(200,Pages\Testimonial::insertTestimonial($request));
	}
]);

?>