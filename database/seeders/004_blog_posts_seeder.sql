-- Seeder: Blog posts data
-- Created: 2024-01-01
-- Description: Posts iniciais para o blog

REPLACE INTO blog_posts (
    title, slug, excerpt, content, featured_image, category_id, author_id, 
    status, featured, views, published_at
) VALUES
(
    'Certificação FSC: O que você precisa saber',
    'certificacao-fsc-guia-completo',
    'Entenda a importância da certificação FSC para a sustentabilidade na indústria madeireira e como ela impacta o mercado.',
    '<h2>O que é a Certificação FSC?</h2><p>A certificação FSC (Forest Stewardship Council) é um sistema de certificação florestal que garante que os produtos de madeira são provenientes de florestas manejadas de forma responsável.</p><h3>Benefícios da Certificação</h3><ul><li>Garantia de origem sustentável</li><li>Preservação da biodiversidade</li><li>Respeito aos direitos dos trabalhadores</li><li>Benefícios para comunidades locais</li></ul><p>A certificação FSC é reconhecida mundialmente como o padrão ouro em manejo florestal responsável.</p>',
    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=FSC%20certification%20sustainable%20forestry%20logo%20forest%20management&image_size=landscape_16_9',
    4,
    1,
    'published',
    1,
    342,
    DATE_SUB(NOW(), INTERVAL 7 DAY)
),
(
    'Tendências do Mercado Madeireiro em 2024',
    'tendencias-mercado-madeireiro-2024',
    'Análise das principais tendências que estão moldando o mercado madeireiro brasileiro e mundial em 2024.',
    '<h2>Panorama do Mercado</h2><p>O mercado madeireiro brasileiro tem mostrado sinais de recuperação e crescimento em 2024, impulsionado por diversos fatores.</p><h3>Principais Tendências</h3><ol><li><strong>Sustentabilidade em Foco:</strong> Crescente demanda por madeira certificada</li><li><strong>Tecnologia e Inovação:</strong> Adoção de novas tecnologias de processamento</li><li><strong>Mercado Externo:</strong> Expansão das exportações</li><li><strong>Construção Civil:</strong> Retomada do setor impulsiona demanda</li></ol><p>Essas tendências indicam um futuro promissor para o setor.</p>',
    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=lumber%20market%20trends%202024%20charts%20graphs%20business%20analysis&image_size=landscape_16_9',
    3,
    1,
    'published',
    0,
    198,
    DATE_SUB(NOW(), INTERVAL 3 DAY)
),
(
    'Técnicas Modernas de Secagem de Madeira',
    'tecnicas-modernas-secagem-madeira',
    'Conheça as técnicas mais avançadas para secagem de madeira e como elas melhoram a qualidade do produto final.',
    '<h2>Importância da Secagem</h2><p>A secagem adequada da madeira é fundamental para garantir a qualidade e durabilidade dos produtos finais.</p><h3>Métodos de Secagem</h3><h4>1. Secagem Natural</h4><p>Método tradicional que utiliza condições ambientais naturais.</p><h4>2. Secagem em Estufa</h4><p>Processo controlado que permite maior precisão na umidade final.</p><h4>3. Secagem a Vácuo</h4><p>Técnica moderna que reduz o tempo de secagem mantendo a qualidade.</p><p>A escolha do método depende do tipo de madeira e uso final.</p>',
    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=modern%20wood%20drying%20kiln%20lumber%20processing%20industrial&image_size=landscape_16_9',
    2,
    2,
    'published',
    0,
    156,
    DATE_SUB(NOW(), INTERVAL 1 DAY)
);