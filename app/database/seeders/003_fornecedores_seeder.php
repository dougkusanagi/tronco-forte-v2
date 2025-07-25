<?php

namespace app\database\seeders;

use app\database\Seeder;

class FornecedoresSeeder extends Seeder
{
    public function run(): void
    {
        $fornecedores = [
            [
                'nome' => 'Madeireira São Paulo',
                'slug' => 'madeireira-sao-paulo',
                'descricao' => 'Especializada em madeiras de reflorestamento e nativas com certificação FSC.',
                'email' => 'contato@madeireirasaopaulo.com.br',
                'telefone' => '(11) 3333-4444',
                'whatsapp' => '11999999999',
                'website' => 'https://madeireirasaopaulo.com.br',
                'endereco' => 'Rua das Madeiras, 123',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01234-567',
                'regiao' => 'sudeste',
                'cnpj' => '12.345.678/0001-90',
                'inscricao_estadual' => '123.456.789.012',
                'especialidades' => json_encode(['Pinus', 'Eucalipto', 'Madeiras Tratadas']),
                'certificacoes' => json_encode(['FSC', 'CERFLOR']),
                'produtos' => json_encode(['Vigas', 'Tábuas', 'Caibros', 'Ripas']),
                'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=modern%20lumber%20yard%20wood%20supplier%20facility&image_size=landscape_16_9',
                'banner' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wood%20lumber%20yard%20stacks%20organized%20professional&image_size=landscape_16_9',
                'avaliacao' => 4.8,
                'total_avaliacoes' => 127,
                'ativo' => 1,
                'verificado' => 1,
                'destaque' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Florestal Minas',
                'slug' => 'florestal-minas',
                'descricao' => 'Fornecedor de eucalipto tratado e madeiras para construção civil.',
                'email' => 'vendas@florestalminas.com.br',
                'telefone' => '(31) 2222-3333',
                'whatsapp' => '31888888888',
                'website' => 'https://florestalminas.com.br',
                'endereco' => 'Rodovia BR-040, Km 15',
                'cidade' => 'Belo Horizonte',
                'estado' => 'MG',
                'cep' => '30000-000',
                'regiao' => 'sudeste',
                'cnpj' => '98.765.432/0001-10',
                'inscricao_estadual' => '987.654.321.098',
                'especialidades' => json_encode(['Eucalipto', 'Madeiras Tratadas', 'Mourões']),
                'certificacoes' => json_encode(['CERFLOR']),
                'produtos' => json_encode(['Mourões', 'Postes', 'Vigas Tratadas']),
                'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=eucalyptus%20wood%20processing%20facility%20industrial&image_size=landscape_16_9',
                'banner' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=treated%20wood%20eucalyptus%20lumber%20stacks&image_size=landscape_16_9',
                'avaliacao' => 4.5,
                'total_avaliacoes' => 89,
                'ativo' => 1,
                'verificado' => 1,
                'destaque' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Amazônia Sustentável',
                'slug' => 'amazonia-sustentavel',
                'descricao' => 'Madeiras nobres da Amazônia com manejo sustentável e certificação.',
                'email' => 'contato@amazoniasustentavel.com.br',
                'telefone' => '(91) 1111-2222',
                'whatsapp' => '91777777777',
                'website' => 'https://amazoniasustentavel.com.br',
                'endereco' => 'Av. Amazônia, 456',
                'cidade' => 'Belém',
                'estado' => 'PA',
                'cep' => '66000-000',
                'regiao' => 'norte',
                'cnpj' => '11.222.333/0001-44',
                'inscricao_estadual' => '111.222.333.444',
                'especialidades' => json_encode(['Ipê', 'Cumaru', 'Jatobá', 'Madeiras Nobres']),
                'certificacoes' => json_encode(['FSC', 'IBAMA']),
                'produtos' => json_encode(['Decks', 'Assoalhos', 'Móveis', 'Estruturas']),
                'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=amazon%20sustainable%20wood%20facility%20tropical%20lumber&image_size=landscape_16_9',
                'banner' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=premium%20tropical%20hardwood%20lumber%20amazon&image_size=landscape_16_9',
                'avaliacao' => 4.9,
                'total_avaliacoes' => 156,
                'ativo' => 1,
                'verificado' => 1,
                'destaque' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        foreach ($fornecedores as $fornecedor) {
            $this->insert('fornecedores', $fornecedor);
        }
    }
}