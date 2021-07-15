<?php  

namespace App\Http\Middleware;

class Maintenance {

	//Método responsável por executar o middleware
	public function handle($request, $next)
	{
		//Verifica o estado de manutenção da página
		if(getenv('MAINTENANCE') === 'true')
		{
			throw new \Exception("Página em manutenção, tente novamente mais tarde.", 200);
			
		}

		//Executa o próximo nível do middleware
		return $next($request);
	}

}

?>