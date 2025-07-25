<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="/" class="text-gray-500 hover:text-gray-700">Início</a>
                </li>
                <li>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                </li>
                <li>
                    <a href="/fornecedores" class="text-gray-500 hover:text-gray-700">Fornecedores</a>
                </li>
                <li>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                </li>
                <li>
                    <span class="text-gray-900 font-medium"><?= $fornecedor['nome'] ?></span>
                </li>
            </ol>
        </nav>
        
        <!-- Header do Perfil -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="relative">
                <img src="<?= $fornecedor['imagem'] ?>" alt="<?= $fornecedor['nome'] ?>" class="w-full h-80 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-end">
                    <div class="p-8 text-white w-full">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center space-x-3 mb-4">
                                    <span class="bg-forest-green px-3 py-1 rounded-full text-sm font-medium"><?= $fornecedor['regiao'] ?></span>
                                    <div class="flex items-center space-x-1">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i data-lucide="star" class="w-4 h-4 <?= $i <= $fornecedor['avaliacao'] ? 'text-yellow-400 fill-current' : 'text-gray-300' ?>"></i>
                                        <?php endfor; ?>
                                        <span class="ml-2"><?= $fornecedor['avaliacao'] ?></span>
                                    </div>
                                    <div class="flex items-center space-x-1 text-green-400">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        <span class="text-sm font-medium">Verificado</span>
                                    </div>
                                </div>
                                <h1 class="text-4xl font-display font-bold mb-4"><?= $fornecedor['nome'] ?></h1>
                                <p class="text-xl text-gray-200 mb-4"><?= $fornecedor['descricao'] ?></p>
                                <div class="flex items-center space-x-4 text-gray-200">
                                    <div class="flex items-center space-x-1">
                                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                                        <span><?= $fornecedor['cidade'] ?>, <?= $fornecedor['estado'] ?></span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                        <span>Desde <?= $fornecedor['ano_fundacao'] ?></span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i data-lucide="users" class="w-4 h-4"></i>
                                        <span><?= $fornecedor['funcionarios'] ?> funcionários</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-4">
                                    <div class="text-2xl font-bold mb-1"><?= $fornecedor['total_avaliacoes'] ?></div>
                                    <div class="text-sm">Avaliações</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Conteúdo Principal -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Sobre a Empresa -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Sobre a Empresa</h2>
                    <div class="prose max-w-none text-gray-600">
                        <?= $fornecedor['sobre'] ?>
                    </div>
                </div>
                
                <!-- Especialidades -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Especialidades</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach ($fornecedor['especialidades'] as $especialidade): ?>
                        <div class="bg-wood-light text-wood-brown p-4 rounded-lg text-center font-medium">
                            <?= $especialidade ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Certificações -->
                <?php if (!empty($fornecedor['certificacoes'])): ?>
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Certificações</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($fornecedor['certificacoes'] as $cert): ?>
                        <div class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg">
                            <div class="bg-green-600 text-white w-12 h-12 rounded-full flex items-center justify-center">
                                <i data-lucide="award" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900"><?= $cert ?></div>
                                <div class="text-green-600 text-sm">Certificação Ativa</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Produtos em Destaque -->
                <?php if (!empty($fornecedor['produtos_destaque'])): ?>
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Produtos em Destaque</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($fornecedor['produtos_destaque'] as $produto): ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                            <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-2"><?= $produto['nome'] ?></h3>
                                <p class="text-gray-600 text-sm mb-3"><?= $produto['descricao'] ?></p>
                                <div class="flex items-center justify-between">
                                    <span class="text-wood-brown font-bold"><?= $produto['preco'] ?></span>
                                    <button class="bg-wood-brown text-white px-4 py-2 rounded-lg hover:bg-wood-dark transition-colors text-sm">
                                        Ver Detalhes
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Avaliações -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Avaliações dos Clientes</h2>
                    
                    <!-- Resumo das Avaliações -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-gray-900 mb-2"><?= $fornecedor['avaliacao'] ?></div>
                                <div class="flex items-center justify-center space-x-1 mb-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i data-lucide="star" class="w-5 h-5 <?= $i <= $fornecedor['avaliacao'] ? 'text-yellow-400 fill-current' : 'text-gray-300' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="text-gray-600"><?= $fornecedor['total_avaliacoes'] ?> avaliações</div>
                            </div>
                            
                            <div class="space-y-2">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm text-gray-600 w-8"><?= $i ?> ★</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: <?= rand(60, 95) ?>%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 w-8"><?= rand(10, 50) ?></span>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lista de Avaliações -->
                    <div class="space-y-6">
                        <?php foreach ($fornecedor['avaliacoes'] as $avaliacao): ?>
                        <div class="border-b border-gray-100 pb-6">
                            <div class="flex items-start space-x-4">
                                <img src="<?= $avaliacao['avatar'] ?>" alt="<?= $avaliacao['nome'] ?>" class="w-12 h-12 rounded-full object-cover">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h4 class="font-bold text-gray-900"><?= $avaliacao['nome'] ?></h4>
                                        <div class="flex items-center space-x-1">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i data-lucide="star" class="w-3 h-3 <?= $i <= $avaliacao['nota'] ? 'text-yellow-400 fill-current' : 'text-gray-300' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="text-gray-500 text-sm"><?= date('d/m/Y', strtotime($avaliacao['data'])) ?></span>
                                    </div>
                                    <p class="text-gray-600 mb-3"><?= $avaliacao['comentario'] ?></p>
                                    <div class="flex items-center space-x-4">
                                        <button class="text-gray-500 hover:text-wood-brown text-sm transition-colors">
                                            <i data-lucide="thumbs-up" class="w-3 h-3 inline mr-1"></i>
                                            Útil (<?= $avaliacao['likes'] ?>)
                                        </button>
                                        <span class="text-gray-400 text-sm">Compra verificada</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Informações de Contato -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Informações de Contato</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i data-lucide="phone" class="w-5 h-5 text-gray-400"></i>
                            <div>
                                <div class="text-sm text-gray-500">Telefone</div>
                                <div class="font-medium text-gray-900"><?= $fornecedor['telefone'] ?></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                            <div>
                                <div class="text-sm text-gray-500">E-mail</div>
                                <div class="font-medium text-gray-900"><?= $fornecedor['email'] ?></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <i data-lucide="map-pin" class="w-5 h-5 text-gray-400"></i>
                            <div>
                                <div class="text-sm text-gray-500">Endereço</div>
                                <div class="font-medium text-gray-900"><?= $fornecedor['endereco'] ?></div>
                                <div class="text-gray-600"><?= $fornecedor['cidade'] ?>, <?= $fornecedor['estado'] ?></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <i data-lucide="globe" class="w-5 h-5 text-gray-400"></i>
                            <div>
                                <div class="text-sm text-gray-500">Website</div>
                                <a href="<?= $fornecedor['website'] ?>" target="_blank" class="font-medium text-wood-brown hover:text-wood-dark"><?= $fornecedor['website'] ?></a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botões de Ação -->
                    <div class="mt-6 space-y-3">
                        <a href="tel:<?= $fornecedor['telefone'] ?>" class="w-full bg-wood-brown text-white py-3 px-4 rounded-lg hover:bg-wood-dark transition-colors font-medium text-center block">
                            <i data-lucide="phone" class="w-4 h-4 inline mr-2"></i>
                            Ligar Agora
                        </a>
                        <a href="mailto:<?= $fornecedor['email'] ?>" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium text-center block">
                            <i data-lucide="mail" class="w-4 h-4 inline mr-2"></i>
                            Enviar E-mail
                        </a>
                        <a href="<?= $fornecedor['whatsapp'] ?>" target="_blank" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium text-center block">
                            <i data-lucide="message-circle" class="w-4 h-4 inline mr-2"></i>
                            WhatsApp
                        </a>
                    </div>
                </div>
                
                <!-- Links Rápidos -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Links Rápidos</h3>
                    
                    <div class="space-y-3">
                        <?php foreach ($fornecedor['links'] as $link): ?>
                        <a href="/fornecedor/<?= $fornecedor['slug'] ?>/link/<?= $link['tipo'] ?>" 
                           target="_blank"
                           class="flex items-center space-x-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors group">
                            <i data-lucide="<?= $link['icone'] ?>" class="w-5 h-5 text-gray-400 group-hover:text-wood-brown"></i>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900"><?= $link['titulo'] ?></div>
                                <div class="text-sm text-gray-500"><?= $link['descricao'] ?></div>
                            </div>
                            <i data-lucide="external-link" class="w-4 h-4 text-gray-400 group-hover:text-wood-brown"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Horário de Funcionamento -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Horário de Funcionamento</h3>
                    
                    <div class="space-y-3">
                        <?php 
                        $horarios = [
                            'Segunda-feira' => '08:00 - 18:00',
                            'Terça-feira' => '08:00 - 18:00',
                            'Quarta-feira' => '08:00 - 18:00',
                            'Quinta-feira' => '08:00 - 18:00',
                            'Sexta-feira' => '08:00 - 18:00',
                            'Sábado' => '08:00 - 12:00',
                            'Domingo' => 'Fechado'
                        ];
                        foreach ($horarios as $dia => $horario): 
                        ?>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600"><?= $dia ?></span>
                            <span class="font-medium text-gray-900 <?= $horario === 'Fechado' ? 'text-red-600' : '' ?>"><?= $horario ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Compartilhar -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Compartilhar</h3>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i data-lucide="facebook" class="w-4 h-4 mx-auto"></i>
                        </button>
                        <button class="flex-1 bg-blue-400 text-white p-3 rounded-lg hover:bg-blue-500 transition-colors">
                            <i data-lucide="twitter" class="w-4 h-4 mx-auto"></i>
                        </button>
                        <button class="flex-1 bg-blue-700 text-white p-3 rounded-lg hover:bg-blue-800 transition-colors">
                            <i data-lucide="linkedin" class="w-4 h-4 mx-auto"></i>
                        </button>
                        <button class="flex-1 bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition-colors">
                            <i data-lucide="share-2" class="w-4 h-4 mx-auto"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fornecedores Relacionados -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-display font-bold text-gray-900 mb-8 text-center">Outros Fornecedores da Região</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($fornecedores_relacionados as $relacionado): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <img src="<?= $relacionado['imagem'] ?>" alt="<?= $relacionado['nome'] ?>" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-forest-green text-white px-2 py-1 rounded text-xs font-medium"><?= $relacionado['regiao'] ?></span>
                        <div class="flex items-center space-x-1">
                            <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                            <span class="text-sm text-gray-600"><?= $relacionado['avaliacao'] ?></span>
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2"><?= $relacionado['nome'] ?></h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?= $relacionado['descricao'] ?></p>
                    <a href="/fornecedor/<?= $relacionado['slug'] ?>" class="text-wood-brown hover:text-wood-dark font-medium text-sm">
                        Ver perfil →
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    color: #374151;
    line-height: 1.75;
}

.prose p {
    margin-bottom: 1.25em;
}

.prose ul, .prose ol {
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}

.prose li {
    margin-bottom: 0.5em;
}
</style>

<script>
// Registrar clique nos links
function registrarClique(fornecedorSlug, tipoLink) {
    fetch(`/api/fornecedor/${fornecedorSlug}/clique`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            tipo: tipoLink,
            timestamp: new Date().toISOString()
        })
    }).catch(error => {
        console.log('Erro ao registrar clique:', error);
    });
}

// Adicionar event listeners para os links
document.addEventListener('DOMContentLoaded', function() {
    const fornecedorSlug = '<?= $fornecedor['slug'] ?>';
    
    // Links rápidos
    document.querySelectorAll('a[href*="/link/"]').forEach(link => {
        link.addEventListener('click', function() {
            const tipoLink = this.href.split('/link/')[1];
            registrarClique(fornecedorSlug, tipoLink);
        });
    });
    
    // Botões de contato
    document.querySelector('a[href^="tel:"]')?.addEventListener('click', function() {
        registrarClique(fornecedorSlug, 'telefone');
    });
    
    document.querySelector('a[href^="mailto:"]')?.addEventListener('click', function() {
        registrarClique(fornecedorSlug, 'email');
    });
    
    document.querySelector('a[href*="whatsapp"]')?.addEventListener('click', function() {
        registrarClique(fornecedorSlug, 'whatsapp');
    });
});
</script>