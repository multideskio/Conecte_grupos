<?php

namespace App\Filters;

use App\Services\PlanService;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PlanFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        //
        try{
            
            $servicePlan = new PlanService();

            $servicePlan->verify();

        }catch(\Exception $e){
            
            // Trata erros de autenticação
            $errorMessage = $e->getMessage();
            session()->setFlashdata('error', $errorMessage);
            // Redirecionar de volta para a página anterior
            return redirect()->to('dashboard/block');
            // Exiba a mensagem de erro para o usuário ou realize outras ações necessárias
        
        }
        
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
