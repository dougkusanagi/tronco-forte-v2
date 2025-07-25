<!-- Hero Section -->
<section class="relative bg-cover bg-center text-white overflow-hidden" style="background-image: url('<?= $hero['image'] ?>');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <h1 class="text-4xl lg:text-6xl font-display font-bold leading-tight">
                    <?= $hero['titulo'] ?>
                </h1>
                <p class="text-xl lg:text-2xl text-gray-200 leading-relaxed">
                    <?= $hero['subtitulo'] ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#orcamento" class="bg-earth-orange hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 hover:scale-105 text-center">
                        <?= $hero['cta_primario'] ?>
                    </a>
                    <a href="/catalogo" class="border-2 border-white text-white hover:bg-white hover:text-wood-brown px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 text-center">
                        <?= $hero['cta_secundario'] ?>
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -bottom-6 -right-6 bg-forest-green text-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i data-lucide="shield-check" class="w-8 h-8"></i>
                        <div>
                            <div class="font-bold text-lg">100% Legal</div>
                            <div class="text-sm opacity-90">Certificado IBAMA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($stats as $key => $stat): ?>
            <div class="text-center">
                <div class="text-4xl lg:text-5xl font-bold text-wood-brown mb-2" data-counter="<?= $stat ?>">0</div>
                <div class="text-gray-600 font-medium"><?= ucfirst(str_replace('_', ' ', $key)) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Produtos em Destaque -->
<section class="py-20 bg-gray-50 animate-on-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">Produtos em Destaque</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Conheça nossa seleção de madeiras premium, todas com certificação de origem e qualidade garantida.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($produtos_destaque as $produto): ?>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="relative">
                    <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>" class="w-full h-64 object-cover">
                    <div class="absolute top-4 right-4 bg-forest-green text-white px-3 py-1 rounded-full text-sm font-medium">
                        <?= ucfirst($produto['categoria']) ?>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?= $produto['nome'] ?></h3>
                    <p class="text-gray-600 mb-4">Ideal para: <?= implode(', ', $produto['aplicacoes']) ?></p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-wood-brown"><?= $produto['preco_m3'] ?></span>
                        <a href="/catalogo/produto/<?= $produto['id'] ?>" class="bg-wood-brown text-white px-4 py-2 rounded-lg hover:bg-wood-dark transition-colors">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="/catalogo" class="bg-wood-brown text-white px-8 py-4 rounded-lg hover:bg-wood-dark transition-colors font-semibold text-lg">
                Ver Catálogo Completo
            </a>
        </div>
    </div>
</section>

<!-- Calculadora de Volume -->
<section id="calculadora" class="py-20 bg-wood-brown text-white animate-on-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-display font-bold mb-4">Calculadora de Volume</h2>
            <p class="text-xl text-gray-200">Calcule rapidamente o volume de madeira necessário para seu projeto</p>
        </div>
        
        <div class="bg-white rounded-2xl p-8 text-gray-900" x-data="calculadoraVolume()">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comprimento (m)</label>
                    <input type="number" x-model="comprimento" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Ex: 3.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Largura (m)</label>
                    <input type="number" x-model="largura" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Ex: 0.20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Altura (m)</label>
                    <input type="number" x-model="altura" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Ex: 0.05">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade de Peças</label>
                    <input type="number" x-model="quantidade" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Ex: 10">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Margem de Segurança (%)</label>
                    <select x-model="margem" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="0">0% - Sem margem</option>
                        <option value="5">5% - Pequenos projetos</option>
                        <option value="10" selected>10% - Recomendado</option>
                        <option value="15">15% - Projetos complexos</option>
                        <option value="20">20% - Máxima segurança</option>
                    </select>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-wood-brown" x-text="volumeTotal.toFixed(3)">0.000</div>
                        <div class="text-sm text-gray-600">Volume Total (m³)</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-wood-brown" x-text="volumeComMargem.toFixed(3)">0.000</div>
                        <div class="text-sm text-gray-600">Com Margem (m³)</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-wood-brown" x-text="'R$ ' + custoEstimado.toLocaleString('pt-BR')">R$ 0</div>
                        <div class="text-sm text-gray-600">Custo Estimado*</div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4 text-center">*Baseado em preço médio de R$ 500/m³. Solicite orçamento para valores exatos.</p>
            </div>
            
            <div class="text-center">
                <button @click="solicitarOrcamento()" class="bg-wood-brown text-white px-8 py-3 rounded-lg hover:bg-wood-dark transition-colors font-semibold">
                    Solicitar Orçamento Detalhado
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Quiz de Madeiras -->
<section id="quiz" class="py-20 bg-gray-50 animate-on-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">Quiz: Qual Madeira é Ideal?</h2>
            <p class="text-xl text-gray-600">Responda algumas perguntas e descubra a madeira perfeita para seu projeto</p>
        </div>
        
        <div class="bg-white rounded-2xl p-8 shadow-lg" x-data="quizMadeira()">
            <div x-show="!quizCompleto">
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm font-medium text-gray-600">Pergunta <span x-text="perguntaAtual + 1">1</span> de <span x-text="perguntas.length">5</span></span>
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-wood-brown h-2 rounded-full transition-all duration-300" :style="`width: ${((perguntaAtual + 1) / perguntas.length) * 100}%`"></div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6" x-text="perguntas[perguntaAtual]?.pergunta"></h3>
                </div>
                
                <div class="space-y-3 mb-8">
                    <template x-for="(opcao, index) in perguntas[perguntaAtual]?.opcoes" :key="index">
                        <button @click="responder(opcao.valor)" class="w-full text-left p-4 border-2 border-gray-200 rounded-lg hover:border-wood-brown hover:bg-wood-brown hover:text-white transition-all duration-300">
                            <span x-text="opcao.texto"></span>
                        </button>
                    </template>
                </div>
            </div>
            
            <div x-show="quizCompleto" class="text-center">
                <div class="mb-8">
                    <div class="w-20 h-20 bg-forest-green rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="check" class="w-10 h-10 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Recomendação Personalizada</h3>
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h4 class="text-xl font-bold text-wood-brown mb-2" x-text="resultado.madeira"></h4>
                        <p class="text-gray-600 mb-4" x-text="resultado.descricao"></p>
                        <div class="text-2xl font-bold text-wood-brown" x-text="resultado.preco"></div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a :href="'/catalogo/produto/' + resultado.id" class="bg-wood-brown text-white px-6 py-3 rounded-lg hover:bg-wood-dark transition-colors font-semibold">
                        Ver Produto
                    </a>
                    <button @click="reiniciarQuiz()" class="border-2 border-wood-brown text-wood-brown hover:bg-wood-brown hover:text-white px-6 py-3 rounded-lg transition-colors font-semibold">
                        Fazer Novo Quiz
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mapa de Origem -->
<section class="py-20 bg-white animate-on-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">Rastreabilidade e Origem</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Todas as nossas madeiras possuem certificação de origem. Veja de onde vêm nossos produtos.</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=brazil%20map%20forest%20regions%20sustainable%20logging%20certification%20tracking&image_size=landscape_4_3" alt="Mapa de Origem" class="rounded-2xl shadow-lg">
            </div>
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-forest-green rounded-lg flex items-center justify-center flex-shrink-0">
                        <i data-lucide="map-pin" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Origem Certificada</h3>
                        <p class="text-gray-600">Todas as madeiras possuem documentação completa de origem, com certificações FSC e IBAMA.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-earth-orange rounded-lg flex items-center justify-center flex-shrink-0">
                        <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Manejo Sustentável</h3>
                        <p class="text-gray-600">Trabalhamos apenas com fornecedores que praticam manejo florestal responsável e sustentável.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-wood-brown rounded-lg flex items-center justify-center flex-shrink-0">
                        <i data-lucide="search" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Rastreamento Completo</h3>
                        <p class="text-gray-600">Sistema de rastreamento que permite acompanhar toda a cadeia produtiva, da floresta à obra.</p>
                    </div>
                </div>
                
                <div class="pt-4">
                    <a href="#certificacoes" class="bg-forest-green text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                        Ver Certificações
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Sustentável -->
<section class="py-20 bg-forest-green text-white animate-on-scroll">
<script>
    // Counter animation
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('[data-counter]');
        const options = { threshold: 0.5 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.getAttribute('data-counter'));
                    let count = 0;
                    const increment = target / 100;
                    const update = () => {
                        count += increment;
                        if (count < target) {
                            entry.target.textContent = Math.floor(count);
                            requestAnimationFrame(update);
                        } else {
                            entry.target.textContent = target;
                        }
                    };
                    update();
                    observer.unobserve(entry.target);
                }
            });
        }, options);
        counters.forEach(counter => observer.observe(counter));

        // Scroll animations
        const animateElements = document.querySelectorAll('.animate-on-scroll');
        const animateObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-10');
                }
            });
        }, { threshold: 0.1 });
        animateElements.forEach(el => {
            el.classList.add('opacity-0', 'translate-y-10', 'transition-all', 'duration-500');
            animateObserver.observe(el);
        });
    });
</script>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-bold mb-4">Nossa Jornada Sustentável</h2>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto">Conheça nosso compromisso com a sustentabilidade e as práticas responsáveis.</p>
        </div>
        
        <div class="relative">
            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-white opacity-20"></div>
            
            <div class="space-y-12">
                <div class="flex items-center justify-center">
                    <div class="flex-1 text-right pr-8">
                        <div class="bg-white text-forest-green p-6 rounded-xl shadow-lg">
                            <h3 class="text-xl font-bold mb-2">Certificação FSC</h3>
                            <p class="text-gray-600">Obtivemos a certificação FSC, garantindo que todas as madeiras vêm de florestas manejadas de forma responsável.</p>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center z-10">
                        <i data-lucide="award" class="w-6 h-6 text-forest-green"></i>
                    </div>
                    <div class="flex-1 pl-8">
                        <div class="text-white opacity-75">
                            <span class="text-2xl font-bold">2020</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-center">
                    <div class="flex-1 text-right pr-8">
                        <div class="text-white opacity-75">
                            <span class="text-2xl font-bold">2021</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center z-10">
                        <i data-lucide="recycle" class="w-6 h-6 text-forest-green"></i>
                    </div>
                    <div class="flex-1 pl-8">
                        <div class="bg-white text-forest-green p-6 rounded-xl shadow-lg">
                            <h3 class="text-xl font-bold mb-2">Programa de Reflorestamento</h3>
                            <p class="text-gray-600">Lançamos nosso programa de reflorestamento, plantando 10 árvores para cada m³ vendido.</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-center">
                    <div class="flex-1 text-right pr-8">
                        <div class="bg-white text-forest-green p-6 rounded-xl shadow-lg">
                            <h3 class="text-xl font-bold mb-2">Energia Renovável</h3>
                            <p class="text-gray-600">100% da energia utilizada em nossos processos vem de fontes renováveis.</p>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center z-10">
                        <i data-lucide="zap" class="w-6 h-6 text-forest-green"></i>
                    </div>
                    <div class="flex-1 pl-8">
                        <div class="text-white opacity-75">
                            <span class="text-2xl font-bold">2022</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-center">
                    <div class="flex-1 text-right pr-8">
                        <div class="text-white opacity-75">
                            <span class="text-2xl font-bold">2024</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center z-10">
                        <i data-lucide="target" class="w-6 h-6 text-forest-green"></i>
                    </div>
                    <div class="flex-1 pl-8">
                        <div class="bg-white text-forest-green p-6 rounded-xl shadow-lg">
                            <h3 class="text-xl font-bold mb-2">Carbono Neutro</h3>
                            <p class="text-gray-600">Meta de tornar toda nossa operação carbono neutro até o final de 2024.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard de Entrega -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">Acompanhe sua Entrega</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Sistema completo de rastreamento para você acompanhar seu pedido em tempo real.</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Rastreamento em Tempo Real</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <i data-lucide="check" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Pedido Confirmado</div>
                                <div class="text-sm text-gray-600">15/01/2024 - 09:30</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <i data-lucide="check" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Em Preparação</div>
                                <div class="text-sm text-gray-600">15/01/2024 - 14:20</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <i data-lucide="truck" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Em Transporte</div>
                                <div class="text-sm text-gray-600">16/01/2024 - 08:00</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg border-l-4 border-gray-300">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <i data-lucide="home" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-500">Entregue</div>
                                <div class="text-sm text-gray-400">Previsão: 17/01/2024</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <a href="#" class="bg-wood-brown text-white px-6 py-3 rounded-lg hover:bg-wood-dark transition-colors font-semibold">
                            Rastrear Meu Pedido
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Informações da Entrega</h3>
                    
                    <div class="space-y-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Detalhes do Pedido</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Número do Pedido:</span>
                                    <span class="font-medium">#TF-2024-001</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Produto:</span>
                                    <span class="font-medium">Pinus Tratado</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Quantidade:</span>
                                    <span class="font-medium">2.5 m³</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Previsão de Entrega:</span>
                                    <span class="font-medium">17/01/2024</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Endereço de Entrega</h4>
                            <p class="text-sm text-gray-600">
                                Rua das Construções, 456<br>
                                Vila Industrial - São Paulo, SP<br>
                                CEP: 01234-567
                            </p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Contato do Motorista</h4>
                            <div class="flex items-center space-x-3">
                                <i data-lucide="phone" class="w-4 h-4 text-gray-600"></i>
                                <span class="text-sm text-gray-600">(11) 99999-8888</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Galeria de Transformação -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">Da Floresta à Obra</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Acompanhe todo o processo de transformação da madeira, desde a floresta até sua aplicação final.</p>
        </div>
        
        <div class="glide" id="transformacao-gallery">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <li class="glide__slide">
                        <div class="relative group">
                            <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=sustainable%20forest%20management%20tree%20cutting%20responsible%20logging&image_size=landscape_16_9" alt="Manejo Florestal" class="w-full h-80 object-cover rounded-2xl">
                            <div class="absolute inset-0 bg-black bg-opacity-40 rounded-2xl flex items-end p-6">
                                <div class="text-white">
                                    <h3 class="text-2xl font-bold mb-2">1. Manejo Florestal</h3>
                                    <p class="text-gray-200">Seleção responsável das árvores seguindo critérios de sustentabilidade</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="glide__slide">
                        <div class="relative group">
                            <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=lumber%20mill%20wood%20processing%20sawmill%20industrial&image_size=landscape_16_9" alt="Processamento" class="w-full h-80 object-cover rounded-2xl">
                            <div class="absolute inset-0 bg-black bg-opacity-40 rounded-2xl flex items-end p-6">
                                <div class="text-white">
                                    <h3 class="text-2xl font-bold mb-2">2. Processamento</h3>
                                    <p class="text-gray-200">Beneficiamento da madeira com tecnologia de ponta</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="glide__slide">
                        <div class="relative group">
                            <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wood%20treatment%20autoclave%20chemical%20preservation&image_size=landscape_16_9" alt="Tratamento" class="w-full h-80 object-cover rounded-2xl">
                            <div class="absolute inset-0 bg-black bg-opacity-40 rounded-2xl flex items-end p-6">
                                <div class="text-white">
                                    <h3 class="text-2xl font-bold mb-2">3. Tratamento</h3>
                                    <p class="text-gray-200">Tratamento químico para maior durabilidade e resistência</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="glide__slide">
                        <div class="relative group">
                            <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=quality%20control%20wood%20inspection%20certification&image_size=landscape_16_9" alt="Controle de Qualidade" class="w-full h-80 object-cover rounded-2xl">
                            <div class="absolute inset-0 bg-black bg-opacity-40 rounded-2xl flex items-end p-6">
                                <div class="text-white">
                                    <h3 class="text-2xl font-bold mb-2">4. Controle de Qualidade</h3>
                                    <p class="text-gray-200">Rigorosa inspeção para garantir os mais altos padrões</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="glide__slide">
                        <div class="relative group">
                            <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=construction%20site%20wooden%20structure%20building%20framework&image_size=landscape_16_9" alt="Aplicação Final" class="w-full h-80 object-cover rounded-2xl">
                            <div class="absolute inset-0 bg-black bg-opacity-40 rounded-2xl flex items-end p-6">
                                <div class="text-white">
                                    <h3 class="text-2xl font-bold mb-2">5. Aplicação Final</h3>
                                    <p class="text-gray-200">Madeira pronta para uso em construções e projetos</p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full flex items-center justify-center transition-all duration-300" data-glide-dir="<">
                    <i data-lucide="chevron-left" class="w-6 h-6 text-gray-800"></i>
                </button>
                <button class="glide__arrow glide__arrow--right absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full flex items-center justify-center transition-all duration-300" data-glide-dir=">">
                    <i data-lucide="chevron-right" class="w-6 h-6 text-gray-800"></i>
                </button>
            </div>
            
            <div class="glide__bullets flex justify-center space-x-2 mt-8" data-glide-el="controls[nav]">
                <button class="glide__bullet w-3 h-3 bg-gray-300 rounded-full" data-glide-dir="=0"></button>
                <button class="glide__bullet w-3 h-3 bg-gray-300 rounded-full" data-glide-dir="=1"></button>
                <button class="glide__bullet w-3 h-3 bg-gray-300 rounded-full" data-glide-dir="=2"></button>
                <button class="glide__bullet w-3 h-3 bg-gray-300 rounded-full" data-glide-dir="=3"></button>
                <button class="glide__bullet w-3 h-3 bg-gray-300 rounded-full" data-glide-dir="=4"></button>
            </div>
        </div>
    </div>
</section>

<!-- Blog Técnico -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">Blog Técnico</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Artigos especializados para construtores e carpinteiros. Dicas, técnicas e conhecimento profissional.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=construction%20engineer%20selecting%20wood%20lumber%20structural%20beams&image_size=landscape_4_3" alt="Artigo" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="bg-wood-brown text-white px-2 py-1 rounded text-xs font-medium">Técnico</span>
                        <span class="text-gray-500 text-sm">8 min de leitura</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Como Escolher Madeira para Estruturas</h3>
                    <p class="text-gray-600 mb-4">Guia completo com critérios técnicos para seleção de madeira estrutural...</p>
                    <a href="/blog/guia-escolher-madeira-estruturas" class="text-wood-brown hover:text-wood-dark font-semibold">
                        Ler Artigo →
                    </a>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=sustainable%20forest%20management%20FSC%20certification%20environmental&image_size=landscape_4_3" alt="Artigo" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="bg-forest-green text-white px-2 py-1 rounded text-xs font-medium">Sustentabilidade</span>
                        <span class="text-gray-500 text-sm">5 min de leitura</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Certificações FSC e PEFC</h3>
                    <p class="text-gray-600 mb-4">Entenda a importância das certificações ambientais na construção...</p>
                    <a href="/blog/sustentabilidade-certificacoes-fsc-pefc" class="text-wood-brown hover:text-wood-dark font-semibold">
                        Ler Artigo →
                    </a>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=carpenter%20installing%20wooden%20deck%20outdoor%20construction&image_size=landscape_4_3" alt="Artigo" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="bg-earth-orange text-white px-2 py-1 rounded text-xs font-medium">Prático</span>
                        <span class="text-gray-500 text-sm">12 min de leitura</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Instalação de Deck Profissional</h3>
                    <p class="text-gray-600 mb-4">Passo a passo completo para instalação de decks de madeira...</p>
                    <a href="/blog/instalacao-deck-passo-passo" class="text-wood-brown hover:text-wood-dark font-semibold">
                        Ler Artigo →
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="/blog" class="bg-wood-brown text-white px-8 py-4 rounded-lg hover:bg-wood-dark transition-colors font-semibold text-lg">
                Ver Todos os Artigos
            </a>
        </div>
    </div>
</section>

<!-- Fornecedores Parceiros -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">Rede de Fornecedores</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Conecte-se com nossa rede de fornecedores especializados em todo o Brasil.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 bg-wood-brown rounded-full flex items-center justify-center mx-auto mb-4">
                    <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=lumber%20company%20logo%20professional%20wood%20business&image_size=square" alt="Fornecedor" class="w-12 h-12 rounded-full object-cover">
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Madeireira São Paulo</h3>
                <p class="text-gray-600 text-sm mb-4">Especialista em madeiras estruturais</p>
                <div class="flex items-center justify-center space-x-1 mb-4">
                    <div class="flex text-yellow-400">
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    </div>
                    <span class="text-gray-600 text-sm ml-1">4.8</span>
                </div>
                <a href="/fornecedor/madeireira-sao-paulo" class="bg-wood-brown text-white px-4 py-2 rounded-lg hover:bg-wood-dark transition-colors text-sm font-medium">
                    Ver Perfil
                </a>
            </div>
            
            <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 bg-wood-brown rounded-full flex items-center justify-center mx-auto mb-4">
                    <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=premium%20deck%20company%20logo%20luxury%20wood&image_size=square" alt="Fornecedor" class="w-12 h-12 rounded-full object-cover">
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Deck Premium Rio</h3>
                <p class="text-gray-600 text-sm mb-4">Especialista em decks e madeiras nobres</p>
                <div class="flex items-center justify-center space-x-1 mb-4">
                    <div class="flex text-yellow-400">
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    </div>
                    <span class="text-gray-600 text-sm ml-1">4.9</span>
                </div>
                <a href="/fornecedor/deck-premium-rio" class="bg-wood-brown text-white px-4 py-2 rounded-lg hover:bg-wood-dark transition-colors text-sm font-medium">
                    Ver Perfil
                </a>
            </div>
            
            <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 bg-wood-brown rounded-full flex items-center justify-center mx-auto mb-4">
                    <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=amazon%20wood%20company%20logo%20sustainable%20forest&image_size=square" alt="Fornecedor" class="w-12 h-12 rounded-full object-cover">
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Madeiras do Norte</h3>
                <p class="text-gray-600 text-sm mb-4">Madeiras amazônicas certificadas</p>
                <div class="flex items-center justify-center space-x-1 mb-4">
                    <div class="flex text-yellow-400">
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    </div>
                    <span class="text-gray-600 text-sm ml-1">4.7</span>
                </div>
                <a href="/fornecedor/madeiras-do-norte" class="bg-wood-brown text-white px-4 py-2 rounded-lg hover:bg-wood-dark transition-colors text-sm font-medium">
                    Ver Perfil
                </a>
            </div>
            
            <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 bg-wood-brown rounded-full flex items-center justify-center mx-auto mb-4">
                    <img src="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=pine%20reforestation%20company%20logo%20sustainable&image_size=square" alt="Fornecedor" class="w-12 h-12 rounded-full object-cover">
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Pinus Sul</h3>
                <p class="text-gray-600 text-sm mb-4">Maior fornecedor de pinus tratado</p>
                <div class="flex items-center justify-center space-x-1 mb-4">
                    <div class="flex text-yellow-400">
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    </div>
                    <span class="text-gray-600 text-sm ml-1">4.6</span>
                </div>
                <a href="/fornecedor/pinus-sul-reflorestamento" class="bg-wood-brown text-white px-4 py-2 rounded-lg hover:bg-wood-dark transition-colors text-sm font-medium">
                    Ver Perfil
                </a>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="/fornecedores" class="bg-wood-brown text-white px-8 py-4 rounded-lg hover:bg-wood-dark transition-colors font-semibold text-lg">
                Ver Todos os Fornecedores
            </a>
        </div>
    </div>
</section>

<!-- Depoimentos -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-bold text-gray-900 mb-4">O que Nossos Clientes Dizem</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Depoimentos reais de construtores e carpinteiros que confiam na Tronco Forte.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($depoimentos as $depoimento): ?>
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <div class="flex text-yellow-400 mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600 mb-6 italic">"<?= $depoimento['texto'] ?>"</p>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-wood-brown text-white flex items-center justify-center font-bold text-lg"><?= strtoupper(substr($depoimento['nome'], 0, 1)) ?></div>
                    <div>
                        <div class="font-bold text-gray-900"><?= $depoimento['nome'] ?></div>
                        <div class="text-sm text-gray-600"><?= $depoimento['empresa'] ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section id="orcamento" class="py-20 bg-wood-brown text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-display font-bold mb-4">Pronto para Começar seu Projeto?</h2>
        <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
            Solicite um orçamento personalizado e descubra como podemos ajudar a tornar seu projeto realidade com madeiras de qualidade superior.
        </p>
        
        <div class="bg-white rounded-2xl p-8 text-gray-900 max-w-2xl mx-auto" x-data="{ nome: '', email: '', telefone: '', projeto: '', mensagem: '' }">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Solicitar Orçamento</h3>
            
            <form class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                        <input type="text" x-model="nome" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Seu nome">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                        <input type="email" x-model="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="seu@email.com">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                        <input type="tel" x-model="telefone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="(11) 99999-9999">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Projeto</label>
                        <select x-model="projeto" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                            <option value="">Selecione...</option>
                            <option value="residencial">Residencial</option>
                            <option value="comercial">Comercial</option>
                            <option value="industrial">Industrial</option>
                            <option value="deck">Deck</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Detalhes do Projeto</label>
                    <textarea x-model="mensagem" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Descreva seu projeto, quantidade estimada, prazo, etc."></textarea>
                </div>
                
                <button type="submit" class="w-full bg-wood-brown text-white py-4 rounded-lg hover:bg-wood-dark transition-colors font-semibold text-lg">
                    Enviar Solicitação
                </button>
            </form>
            
            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600 mb-4">Ou entre em contato diretamente:</p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-6">
                    <a href="tel:+5511999999999" class="flex items-center space-x-2 text-wood-brown hover:text-wood-dark">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                        <span>(11) 99999-9999</span>
                    </a>
                    <a href="mailto:contato@troncoforte.com.br" class="flex items-center space-x-2 text-wood-brown hover:text-wood-dark">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        <span>contato@troncoforte.com.br</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Calculadora de Volume
function calculadoraVolume() {
    return {
        comprimento: 0,
        largura: 0,
        altura: 0,
        quantidade: 1,
        margem: 10,
        
        get volumeTotal() {
            return this.comprimento * this.largura * this.altura * this.quantidade;
        },
        
        get volumeComMargem() {
            return this.volumeTotal * (1 + this.margem / 100);
        },
        
        get custoEstimado() {
            return this.volumeComMargem * 500; // R$ 500 por m³
        },
        
        solicitarOrcamento() {
            const dados = {
                volume: this.volumeComMargem.toFixed(3),
                custo: this.custoEstimado,
                dimensoes: {
                    comprimento: this.comprimento,
                    largura: this.largura,
                    altura: this.altura,
                    quantidade: this.quantidade,
                    margem: this.margem
                }
            };
            
            // Scroll para o formulário de orçamento
            document.getElementById('orcamento').scrollIntoView({ behavior: 'smooth' });
            
            // Preencher dados no formulário se existir
            const mensagemField = document.querySelector('textarea[x-model="mensagem"]');
            if (mensagemField) {
                mensagemField.value = `Calculadora de Volume:\n- Volume necessário: ${dados.volume} m³\n- Custo estimado: R$ ${dados.custo.toLocaleString('pt-BR')}\n- Dimensões: ${this.comprimento}m x ${this.largura}m x ${this.altura}m\n- Quantidade: ${this.quantidade} peças\n- Margem de segurança: ${this.margem}%`;
            }
        }
    }
}

// Quiz de Madeiras
function quizMadeira() {
    return {
        perguntaAtual: 0,
        respostas: [],
        quizCompleto: false,
        resultado: {},
        
        perguntas: [
            {
                pergunta: "Qual é o tipo de projeto?",
                opcoes: [
                    { texto: "Estrutura/Construção", valor: "estrutural" },
                    { texto: "Deck/Área Externa", valor: "deck" },
                    { texto: "Móveis/Marcenaria", valor: "moveis" },
                    { texto: "Revestimento/Acabamento", valor: "revestimento" }
                ]
            },
            {
                pergunta: "Onde será utilizada a madeira?",
                opcoes: [
                    { texto: "Área interna", valor: "interna" },
                    { texto: "Área externa coberta", valor: "externa_coberta" },
                    { texto: "Área externa descoberta", valor: "externa_descoberta" },
                    { texto: "Contato com solo/umidade", valor: "umidade" }
                ]
            },
            {
                pergunta: "Qual é o seu orçamento por m³?",
                opcoes: [
                    { texto: "Até R$ 300", valor: "economico" },
                    { texto: "R$ 300 - R$ 600", valor: "medio" },
                    { texto: "R$ 600 - R$ 1.000", valor: "alto" },
                    { texto: "Acima de R$ 1.000", valor: "premium" }
                ]
            },
            {
                pergunta: "Qual característica é mais importante?",
                opcoes: [
                    { texto: "Resistência e durabilidade", valor: "resistencia" },
                    { texto: "Beleza e aparência", valor: "beleza" },
                    { texto: "Facilidade de trabalho", valor: "facilidade" },
                    { texto: "Sustentabilidade", valor: "sustentabilidade" }
                ]
            },
            {
                pergunta: "Qual é o prazo do projeto?",
                opcoes: [
                    { texto: "Urgente (até 1 semana)", valor: "urgente" },
                    { texto: "Normal (2-4 semanas)", valor: "normal" },
                    { texto: "Flexível (mais de 1 mês)", valor: "flexivel" },
                    { texto: "Planejamento futuro", valor: "futuro" }
                ]
            }
        ],
        
        responder(valor) {
            this.respostas.push(valor);
            
            if (this.perguntaAtual < this.perguntas.length - 1) {
                this.perguntaAtual++;
            } else {
                this.calcularResultado();
            }
        },
        
        calcularResultado() {
            // Lógica simplificada de recomendação
            const respostas = this.respostas;
            
            if (respostas.includes('estrutural') && respostas.includes('resistencia')) {
                this.resultado = {
                    id: 'eucalipto-tratado',
                    madeira: 'Eucalipto Tratado',
                    descricao: 'Ideal para estruturas, com excelente resistência e custo-benefício.',
                    preco: 'R$ 450/m³'
                };
            } else if (respostas.includes('deck') && respostas.includes('externa_descoberta')) {
                this.resultado = {
                    id: 'cumaru',
                    madeira: 'Cumaru',
                    descricao: 'Perfeita para decks externos, resistente à umidade e intempéries.',
                    preco: 'R$ 850/m³'
                };
            } else if (respostas.includes('moveis') && respostas.includes('beleza')) {
                this.resultado = {
                    id: 'mogno',
                    madeira: 'Mogno Africano',
                    descricao: 'Madeira nobre com beleza excepcional, ideal para móveis finos.',
                    preco: 'R$ 1.200/m³'
                };
            } else if (respostas.includes('economico')) {
                this.resultado = {
                    id: 'pinus-tratado',
                    madeira: 'Pinus Tratado',
                    descricao: 'Opção econômica e versátil, tratada para maior durabilidade.',
                    preco: 'R$ 280/m³'
                };
            } else {
                this.resultado = {
                    id: 'ipê',
                    madeira: 'Ipê',
                    descricao: 'Madeira brasileira de alta qualidade, resistente e durável.',
                    preco: 'R$ 950/m³'
                };
            }
            
            this.quizCompleto = true;
        },
        
        reiniciarQuiz() {
            this.perguntaAtual = 0;
            this.respostas = [];
            this.quizCompleto = false;
            this.resultado = {};
        }
    }
}

// Inicializar Glide.js quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar carrossel da galeria de transformação
    if (document.getElementById('transformacao-gallery')) {
        new Glide('#transformacao-gallery', {
            type: 'carousel',
            startAt: 0,
            perView: 1,
            autoplay: 5000,
            hoverpause: true,
            animationDuration: 800,
            animationTimingFunc: 'ease-in-out'
        }).mount();
    }
    
    // Smooth scroll para links internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>