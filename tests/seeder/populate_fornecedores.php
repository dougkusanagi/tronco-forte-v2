<?php

require_once '../../vendor/autoload.php';
require_once '../../app/config/bootstrap.php';

// Get database connection
$db = Flight::db();

// Clear existing data
$db->exec("DELETE FROM fornecedores");

// Insert fornecedores data
$fornecedores = [
    [
        'nome' => 'Madeiras do Norte',
        'slug' => 'madeiras-do-norte',
        'descricao' => 'Especializada em madeiras nobres da região amazônica, oferecemos produtos sustentáveis e certificados para construção civil e marcenaria de alta qualidade.',
        'email' => 'contato@madeirasnorte.com.br',
        'telefone' => '(11) 3456-7890',
        'whatsapp' => '(11) 99876-5432',
        'website' => 'https://madeirasnorte.com.br',
        'endereco' => 'Rua das Madeiras, 123',
        'cidade' => 'Manaus',
        'estado' => 'AM',
        'cep' => '69000-000',
        'regiao' => 'norte',
        'cnpj' => '12.345.678/0001-90',
        'inscricao_estadual' => '123456789',
        'especialidades' => json_encode(['Madeira Nobre', 'Construção Civil', 'Marcenaria']),
        'certificacoes' => json_encode(['FSC', 'CERFLOR']),
        'produtos' => json_encode(['Tábuas', 'Vigas', 'Pranchas']),
        'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=lumber%20yard%20amazon%20rainforest%20sustainable%20wood%20supplier&image_size=landscape_4_3',
        'banner' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=amazon%20rainforest%20sustainable%20lumber%20mill%20operation&image_size=landscape_16_9',
        'avaliacao' => 4.8,
        'total_avaliacoes' => 127,
        'ativo' => 1,
        'verificado' => 1,
        'destaque' => 1
    ],
    [
        'nome' => 'Pinus Sul Reflorestamento',
        'slug' => 'pinus-sul-reflorestamento',
        'descricao' => 'Fornecedor líder em madeira de pinus reflorestado no Sul do Brasil. Oferecemos soluções completas para construção, móveis e embalagens.',
        'email' => 'vendas@pinussul.com.br',
        'telefone' => '(47) 3234-5678',
        'whatsapp' => '(47) 99123-4567',
        'website' => 'https://pinussul.com.br',
        'endereco' => 'Estrada do Reflorestamento, 456',
        'cidade' => 'Curitiba',
        'estado' => 'PR',
        'cep' => '80000-000',
        'regiao' => 'sul',
        'cnpj' => '23.456.789/0001-01',
        'inscricao_estadual' => '234567890',
        'especialidades' => json_encode(['Pinus', 'Reflorestamento', 'Móveis', 'Embalagens']),
        'certificacoes' => json_encode(['FSC', 'PEFC']),
        'produtos' => json_encode(['Tábuas de Pinus', 'Compensados', 'Pallets']),
        'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=pine%20forest%20sustainable%20lumber%20mill%20southern%20brazil&image_size=landscape_4_3',
        'banner' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=pine%20tree%20plantation%20lumber%20processing%20facility&image_size=landscape_16_9',
        'avaliacao' => 4.6,
        'total_avaliacoes' => 89,
        'ativo' => 1,
        'verificado' => 1,
        'destaque' => 1
    ],
    [
        'nome' => 'Eucalipto Forte Sudeste',
        'slug' => 'eucalipto-forte-sudeste',
        'descricao' => 'Especializada em eucalipto tratado e beneficiado. Atendemos grandes obras de infraestrutura e projetos residenciais com qualidade garantida.',
        'email' => 'comercial@eucaliptoforte.com.br',
        'telefone' => '(11) 4567-8901',
        'whatsapp' => '(11) 98765-4321',
        'website' => 'https://eucaliptoforte.com.br',
        'endereco' => 'Avenida Industrial, 789',
        'cidade' => 'São Paulo',
        'estado' => 'SP',
        'cep' => '01000-000',
        'regiao' => 'sudeste',
        'cnpj' => '34.567.890/0001-12',
        'inscricao_estadual' => '345678901',
        'especialidades' => json_encode(['Eucalipto', 'Tratamento', 'Infraestrutura']),
        'certificacoes' => json_encode(['ABNT', 'ISO 9001']),
        'produtos' => json_encode(['Mourões', 'Postes', 'Madeira Tratada']),
        'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=eucalyptus%20lumber%20yard%20treated%20wood%20industrial%20facility&image_size=landscape_4_3',
        'banner' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=eucalyptus%20forest%20industrial%20wood%20processing%20plant&image_size=landscape_16_9',
        'avaliacao' => 4.7,
        'total_avaliacoes' => 156,
        'ativo' => 1,
        'verificado' => 1,
        'destaque' => 0
    ]
];

$stmt = $db->prepare("
    INSERT INTO fornecedores (
        nome, slug, descricao, email, telefone, whatsapp, website, endereco, cidade, estado, cep, regiao,
        cnpj, inscricao_estadual, especialidades, certificacoes, produtos, imagem, banner, avaliacao,
        total_avaliacoes, ativo, verificado, destaque, created_at, updated_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, datetime('now'), datetime('now')
    )
");

foreach ($fornecedores as $fornecedor) {
    $stmt->execute([
        $fornecedor['nome'],
        $fornecedor['slug'],
        $fornecedor['descricao'],
        $fornecedor['email'],
        $fornecedor['telefone'],
        $fornecedor['whatsapp'],
        $fornecedor['website'],
        $fornecedor['endereco'],
        $fornecedor['cidade'],
        $fornecedor['estado'],
        $fornecedor['cep'],
        $fornecedor['regiao'],
        $fornecedor['cnpj'],
        $fornecedor['inscricao_estadual'],
        $fornecedor['especialidades'],
        $fornecedor['certificacoes'],
        $fornecedor['produtos'],
        $fornecedor['imagem'],
        $fornecedor['banner'],
        $fornecedor['avaliacao'],
        $fornecedor['total_avaliacoes'],
        $fornecedor['ativo'],
        $fornecedor['verificado'],
        $fornecedor['destaque']
    ]);
}

echo "Fornecedores inseridos com sucesso!\n";
echo "Total de fornecedores: " . count($fornecedores) . "\n";