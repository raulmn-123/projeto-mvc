<?php  
namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimonial {

	public $id;
	public $nome;
	public $mensagem;
	public $data;

	//Método responsável por cadastrar a instância atual do banco de dados
	public function cadastrar()
	{
		//Definir a data
		$this->data = date('Y-m-d H:i:s');

		//Insere o depoimentos no banco de dados
		$this->id = (new Database('depoimentos'))->insert([
			'nome'=>$this->nome,
			'mensagem'=>$this->mensagem, 
			'data'=>$this->data
		]);
		
		//Sucesso ao inserir no banco de dados
		return true;
	}

	//Método responsavel por retornar os depoimentos
	public static function getTestimonials($where = null, $order = null, $limit = null, $fields='*')
	{
		return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
	}

}

?>