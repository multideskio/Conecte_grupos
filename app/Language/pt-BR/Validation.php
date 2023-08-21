<?php

return [
    'required'      => 'O campo {field} é obrigatório.',
    'valid_email'   => 'O campo {field} deve conter um endereço de e-mail válido.',
    'min_length'    => 'O campo {field} deve ter pelo menos {param} caracteres.',
    'max_length'    => 'O campo {field} não pode ter mais que {param} caracteres.',
    'numeric'       => 'O campo {field} deve conter apenas números.',
    'alpha'         => 'O campo {field} deve conter apenas caracteres alfabéticos.',
    'alpha_numeric' => 'O campo {field} deve conter apenas caracteres alfanuméricos.',
    'matches'       => 'O campo {field} não coincide com o campo {param}.',
    'unique'        => 'O campo {field} deve ser único.',
    'valid_date'    => 'O campo {field} deve ser uma data válida.',
    'in_list'       => 'O campo {field} deve ser um dos seguintes valores: {param}.',

    'plan' => [
        'Você ainda não tem um plano configurado!',
        'Há um problema com seu plano.<br>Entre em contato com o suporte informando o código<br> # {idCompany}',
        'vencido' => [
            'Plano vencido',
            'Após 7 dias o sistema exclui sua conta automaticamente'
        ]
    ]
    // Adicione mais mensagens de validação conforme necessário
];
