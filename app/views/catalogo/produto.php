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
                    <a href="/catalogo" class="text-gray-500 hover:text-gray-700">Catálogo</a>
                </li>
                <li>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                </li>
                <li>
                    <span class="text-gray-900 font-medium"><?= $produto['nome'] ?></span>
                </li>
            </ol>
        </nav>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Galeria de Imagens -->
            <div>
                <div class="glide" id="produto-gallery">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <?php foreach ($produto['galeria'] as $imagem): ?>
                            <li class="glide__slide">
                                <img src="<?= $imagem ?>" alt="<?= $produto['nome'] ?>" class="w-full h-96 object-cover rounded-2xl shadow-lg">
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="glide__arrows" data-glide-el="controls">
                        <button class="glide__arrow glide__arrow--left absolute left-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full flex items-center justify-center" data-glide-dir="<">
                            <i data-lucide="chevron-left" class="w-5 h-5 text-gray-800"></i>
                        </button>
                        <button class="glide__arrow glide__arrow--right absolute right-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full flex items-center justify-center" data-glide-dir=">">
                            <i data-lucide="chevron-right" class="w-5 h-5 text-gray-800"></i>
                        </button>
                    </div>
                    
                    <div class="glide__bullets flex justify-center space-x-2 mt-4" data-glide-el="controls[nav]">
                        <?php foreach ($produto['galeria'] as $index => $imagem): ?>
                        <button class="glide__bullet w-3 h-3 bg-gray-300 rounded-full" data-glide-dir="=<?= $index ?>"></button>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Certificações -->
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Certificações</h3>
                    <div class="flex flex-wrap gap-3">
                        <?php foreach ($produto['certificacoes'] as $cert): ?>
                        <div class="bg-forest-green text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            <span class="font-medium"><?= $cert ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Informações do Produto -->
            <div>
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="bg-<?= $produto['categoria'] === 'nobre' ? 'yellow' : 'forest-green' ?>-100 text-<?= $produto['categoria'] === 'nobre' ? 'yellow' : 'forest-green' ?>-800 px-3 py-1 rounded-full text-sm font-medium">
                            <?= ucfirst($produto['categoria']) ?>
                        </span>
                        <div class="flex items-center space-x-1">
                            <div class="flex text-yellow-400">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-gray-600 text-sm ml-1">(4.8)</span>
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-display font-bold text-gray-900 mb-4"><?= $produto['nome'] ?></h1>
                    <p class="text-lg text-gray-600 mb-6"><?= $produto['descricao'] ?></p>
                    
                    <div class="mb-8">
                        <div class="text-4xl font-bold text-wood-brown mb-2"><?= $produto['preco'] ?><span class="text-lg text-gray-600">/m³</span></div>
                        <p class="text-sm text-gray-500">Preço pode variar conforme especificações e quantidade</p>
                    </div>
                    
                    <!-- Calculadora Rápida -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-8" x-data="calculadoraProduto()">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Calcular Quantidade</h3>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Área (m²)</label>
                                <input type="number" x-model="area" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Ex: 25">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Espessura (cm)</label>
                                <select x-model="espessura" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                                    <option value="2.5">2,5 cm</option>
                                    <option value="3">3,0 cm</option>
                                    <option value="4">4,0 cm</option>
                                    <option value="5">5,0 cm</option>
                                </select>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Volume necessário:</span>
                                <span class="font-bold text-wood-brown" x-text="volumeNecessario.toFixed(3) + ' m³'"></span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-gray-600">Custo estimado:</span>
                                <span class="font-bold text-wood-brown" x-text="'R$ ' + custoEstimado.toLocaleString('pt-BR')"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ações -->
                    <div class="space-y-4">
                        <button class="w-full bg-wood-brown text-white py-4 rounded-lg hover:bg-wood-dark transition-colors font-semibold text-lg">
                            Solicitar Orçamento
                        </button>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="border-2 border-wood-brown text-wood-brown hover:bg-wood-brown hover:text-white py-3 rounded-lg transition-colors font-medium">
                                <i data-lucide="heart" class="w-4 h-4 inline mr-2"></i>
                                Favoritar
                            </button>
                            <button class="border-2 border-gray-300 text-gray-700 hover:bg-gray-50 py-3 rounded-lg transition-colors font-medium">
                                <i data-lucide="share-2" class="w-4 h-4 inline mr-2"></i>
                                Compartilhar
                            </button>
                        </div>
                    </div>
                    
                    <!-- Contato Direto -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Precisa de Ajuda?</h3>
                        <div class="space-y-3">
                            <a href="tel:+5511999999999" class="flex items-center space-x-3 text-gray-600 hover:text-wood-brown transition-colors">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                                <span>(11) 99999-9999</span>
                            </a>
                            <a href="https://wa.me/5511999999999" class="flex items-center space-x-3 text-gray-600 hover:text-green-600 transition-colors">
                                <i data-lucide="message-circle" class="w-5 h-5"></i>
                                <span>WhatsApp</span>
                            </a>
                            <a href="mailto:vendas@troncoforte.com.br" class="flex items-center space-x-3 text-gray-600 hover:text-wood-brown transition-colors">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                                <span>vendas@troncoforte.com.br</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabs de Informações -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ activeTab: 'especificacoes' }">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-8">
                    <button @click="activeTab = 'especificacoes'" :class="activeTab === 'especificacoes' ? 'border-wood-brown text-wood-brown' : 'border-transparent text-gray-500 hover:text-gray-700'" class="py-4 px-1 border-b-2 font-medium text-sm">
                        Especificações
                    </button>
                    <button @click="activeTab = 'aplicacoes'" :class="activeTab === 'aplicacoes' ? 'border-wood-brown text-wood-brown' : 'border-transparent text-gray-500 hover:text-gray-700'" class="py-4 px-1 border-b-2 font-medium text-sm">
                        Aplicações
                    </button>
                    <button @click="activeTab = 'cuidados'" :class="activeTab === 'cuidados' ? 'border-wood-brown text-wood-brown' : 'border-transparent text-gray-500 hover:text-gray-700'" class="py-4 px-1 border-b-2 font-medium text-sm">
                        Cuidados
                    </button>
                    <button @click="activeTab = 'origem'" :class="activeTab === 'origem' ? 'border-wood-brown text-wood-brown' : 'border-transparent text-gray-500 hover:text-gray-700'" class="py-4 px-1 border-b-2 font-medium text-sm">
                        Origem
                    </button>
                </nav>
            </div>
            
            <div class="p-8">
                <!-- Especificações -->
                <div x-show="activeTab === 'especificacoes'">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Especificações Técnicas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <?php foreach ($produto['especificacoes'] as $key => $valor): ?>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600 capitalize"><?= str_replace('_', ' ', $key) ?>:</span>
                                <span class="font-medium text-gray-900"><?= $valor ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-4">Características Principais</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-4 h-4 text-green-500"></i>
                                    <span class="text-gray-600">Alta resistência à umidade</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-4 h-4 text-green-500"></i>
                                    <span class="text-gray-600">Fácil trabalhabilidade</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-4 h-4 text-green-500"></i>
                                    <span class="text-gray-600">Excelente acabamento</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i data-lucide="check" class="w-4 h-4 text-green-500"></i>
                                    <span class="text-gray-600">Durabilidade comprovada</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Aplicações -->
                <div x-show="activeTab === 'aplicacoes'">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Aplicações Recomendadas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($produto['aplicacoes'] as $aplicacao): ?>
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="w-12 h-12 bg-wood-brown rounded-lg flex items-center justify-center mb-4">
                                <i data-lucide="hammer" class="w-6 h-6 text-white"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-2"><?= $aplicacao ?></h4>
                            <p class="text-gray-600 text-sm">Ideal para projetos que exigem qualidade e durabilidade.</p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Cuidados -->
                <div x-show="activeTab === 'cuidados'">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Cuidados e Manutenção</h3>
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Armazenamento</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Mantenha em local seco e arejado</li>
                                <li>• Evite contato direto com o solo</li>
                                <li>• Proteja da chuva e umidade excessiva</li>
                                <li>• Use separadores entre as peças</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Instalação</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Faça pré-furação para evitar rachaduras</li>
                                <li>• Use fixadores adequados para madeira</li>
                                <li>• Mantenha espaçamento para dilatação</li>
                                <li>• Aplique selador ou verniz conforme necessário</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Manutenção</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Limpeza regular com pano úmido</li>
                                <li>• Reaplicação de verniz a cada 2-3 anos</li>
                                <li>• Inspeção periódica para sinais de desgaste</li>
                                <li>• Tratamento preventivo contra pragas</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Origem -->
                <div x-show="activeTab === 'origem'">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Origem e Sustentabilidade</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <img src="<?= $produto['origem']['mapa'] ?>" alt="Mapa de Origem" class="w-full h-64 object-cover rounded-xl mb-4">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-2">Localização</h4>
                                    <p class="text-gray-600"><?= $produto['origem']['localizacao'] ?></p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-2">Fornecedor</h4>
                                    <p class="text-gray-600"><?= $produto['origem']['fornecedor'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-4">Práticas Sustentáveis</h4>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <i data-lucide="leaf" class="w-5 h-5 text-green-500 mt-1"></i>
                                    <div>
                                        <h5 class="font-medium text-gray-900">Manejo Florestal</h5>
                                        <p class="text-gray-600 text-sm">Extração responsável seguindo plano de manejo aprovado pelo IBAMA.</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i data-lucide="recycle" class="w-5 h-5 text-green-500 mt-1"></i>
                                    <div>
                                        <h5 class="font-medium text-gray-900">Reflorestamento</h5>
                                        <p class="text-gray-600 text-sm">Para cada árvore extraída, 3 novas mudas são plantadas.</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i data-lucide="users" class="w-5 h-5 text-green-500 mt-1"></i>
                                    <div>
                                        <h5 class="font-medium text-gray-900">Comunidade Local</h5>
                                        <p class="text-gray-600 text-sm">Geração de empregos e desenvolvimento das comunidades locais.</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <i data-lucide="shield-check" class="w-5 h-5 text-green-500 mt-1"></i>
                                    <div>
                                        <h5 class="font-medium text-gray-900">Certificações</h5>
                                        <p class="text-gray-600 text-sm">FSC, PEFC e IBAMA garantem a legalidade e sustentabilidade.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Produtos Relacionados -->
        <div class="mt-16">
            <h2 class="text-3xl font-display font-bold text-gray-900 mb-8 text-center">Produtos Relacionados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($produtos_relacionados as $relacionado): ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <img src="<?= $relacionado['imagem'] ?>" alt="<?= $relacionado['nome'] ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2"><?= $relacionado['nome'] ?></h3>
                        <p class="text-gray-600 text-sm mb-3"><?= substr($relacionado['descricao'], 0, 80) ?>...</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-wood-brown"><?= $relacionado['preco'] ?></span>
                            <a href="/catalogo/produto/<?= $relacionado['id'] ?>" class="bg-wood-brown text-white px-3 py-1 rounded text-sm hover:bg-wood-dark transition-colors">
                                Ver
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
function calculadoraProduto() {
    return {
        area: 0,
        espessura: 2.5,
        precoBase: <?= (int)str_replace(['R$ ', '.'], '', $produto['preco']) ?>,
        
        get volumeNecessario() {
            return (this.area * this.espessura) / 100; // espessura em cm para m
        },
        
        get custoEstimado() {
            return this.volumeNecessario * this.precoBase;
        }
    }
}

// Inicializar Glide.js para galeria do produto
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('produto-gallery')) {
        new Glide('#produto-gallery', {
            type: 'carousel',
            startAt: 0,
            perView: 1,
            autoplay: 4000,
            hoverpause: true,
            animationDuration: 600
        }).mount();
    }
});
</script>