<?php

namespace App\Services;

use App\Models\SuperModel;
use App\Models\CompanyModel;

class AuthService
{
    public function authenticate($id_chatwoot, $apiDashboard)
    {
        // Instancia o modelo SuperModel para verificar a validade do apiDashboard
        $superModel = new SuperModel();
        $isValidApiDashboard = $this->validateApiDashboard($superModel, $apiDashboard);

        if ($isValidApiDashboard) {
            // Instancia o modelo CompanyModel para buscar os dados da empresa
            $companyModel = new CompanyModel();
            $companyData = $this->findCompanyData($companyModel, $id_chatwoot);

            if ($companyData) {
                // Define uma sessão autenticada com os dados da empresa
                $this->setAuthenticatedSession($companyData);
                // Retorna o ID da sessão como resposta
                return session('user');
            } else {
                // Lança uma exceção se não for encontrada uma empresa correspondente
                throw new \Exception('Acesso não autorizado: Empresa não encontrada.');
            }
        } else {
            // Lança uma exceção se o apiDashboard não for válido
            throw new \Exception('Acesso não autorizado: Painel de API inválido.');
        }
    }

    // Verifica se o apiDashboard é válido usando o modelo SuperModel
    private function validateApiDashboard($superModel, $apiDashboard)
    {
        $countAll = $superModel->select('apikey')->where('apikey', $apiDashboard)->countAllResults();
        // Retorna verdadeiro se o apiDashboard for válido (contagem maior que zero)
        return $countAll > 0;
    }

    // Busca os dados da empresa com base no id_chatwoot usando o modelo CompanyModel
    private function findCompanyData($companyModel, $id_chatwoot)
    {
        $companyData = $companyModel->select("name, email, id, company")->where('id_chatwoot', $id_chatwoot)->first();
        // Retorna os dados da empresa ou nulo se não for encontrada
        return $companyData;
    }

    // Define uma sessão autenticada com os dados da empresa
    private function setAuthenticatedSession($companyData)
    {
        session()->set([
            "user" => [
                'isConnected' => true,
                'name' => $companyData['name'],
                'email' => $companyData['email'],
                'id' => intval($companyData['id']),
                'company' => $companyData['company']
            ]
        ]);
    }
}
