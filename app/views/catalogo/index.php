<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="filtrosCatalogo()">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-display font-bold text-gray-900 mb-4">Catálogo de Madeiras</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Explore nossa ampla seleção de madeiras certificadas, todas com garantia de origem e qualidade superior.</p>
        </div>
        
        <!-- Filtros -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                    <select x-model="filtros.categoria" @change="aplicarFiltros()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="">Todas as categorias</option>
                        <option value="estrutural">Estrutural</option>
                        <option value="deck">Deck</option>
                        <option value="nobre">Nobre</option>
                        <option value="tratada">Tratada</option>
                        <option value="laminada">Laminada</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Aplicação</label>
                    <select x-model="filtros.aplicacao" @change="aplicarFiltros()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="">Todas as aplicações</option>
                        <option value="construcao">Construção</option>
                        <option value="moveis">Móveis</option>
                        <option value="revestimento">Revestimento</option>
                        <option value="paisagismo">Paisagismo</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Faixa de Preço</label>
                    <select x-model="filtros.preco" @change="aplicarFiltros()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="">Todos os preços</option>
                        <option value="0-300">Até R$ 300/m³</option>
                        <option value="300-600">R$ 300 - R$ 600/m³</option>
                        <option value="600-1000">R$ 600 - R$ 1.000/m³</option>
                        <option value="1000+">Acima de R$ 1.000/m³</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <div class="relative">
                        <input type="text" x-model="filtros.busca" @input="aplicarFiltros()" placeholder="Nome da madeira..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-3"></i>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-4">
                <span class="text-sm text-gray-600" x-text="`${produtosFiltrados.length} produtos encontrados`"></span>
                <button @click="limparFiltros()" class="text-wood-brown hover:text-wood-dark text-sm font-medium">
                    Limpar Filtros
                </button>
            </div>
        </div>
        
        <!-- Grid de Produtos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <template x-for="produto in produtosFiltrados" :key="produto.id">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="relative">
                        <img :src="produto.imagem" :alt="produto.nome" class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4 bg-forest-green text-white px-3 py-1 rounded-full text-sm font-medium" x-text="produto.categoria"></div>
                        <div class="absolute top-4 left-4">
                            <div class="flex space-x-1">
                                <template x-for="cert in produto.certificacoes" :key="cert">
                                    <span class="bg-white text-forest-green px-2 py-1 rounded text-xs font-medium" x-text="cert"></span>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2" x-text="produto.nome"></h3>
                        <p class="text-gray-600 mb-4" x-text="produto.descricao"></p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Densidade:</span>
                                <span class="font-medium" x-text="produto.especificacoes.Densidade || 'N/A'"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Umidade:</span>
                                <span class="font-medium" x-text="produto.especificacoes.Umidade || 'N/A'"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Durabilidade:</span>
                                <span class="font-medium" x-text="produto.especificacoes.Durabilidade || 'N/A'"></span>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2 mb-4">
                            <template x-for="aplicacao in produto.aplicacoes.slice(0, 2)" :key="aplicacao">
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs" x-text="aplicacao"></span>
                            </template>
                            <span x-show="produto.aplicacoes.length > 2" class="text-gray-500 text-xs" x-text="`+${produto.aplicacoes.length - 2} mais`"></span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-2xl font-bold text-wood-brown" x-text="produto.preco_formatado"></span>
                                <span class="text-gray-600">/m³</span>
                            </div>
                            <a :href="`/catalogo/produto/${produto.id}`" class="bg-wood-brown text-white px-4 py-2 rounded-lg hover:bg-wood-dark transition-colors font-medium">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        
        <!-- Paginação -->
        <div class="flex justify-center mt-12">
            <nav class="flex space-x-2">
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button class="px-4 py-2 bg-wood-brown text-white rounded-lg">1</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">2</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">3</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </nav>
        </div>
    </div>
</div>

<!-- CTA Section -->
<section class="py-20 bg-wood-brown text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-display font-bold mb-4">Não Encontrou o que Procura?</h2>
        <p class="text-xl text-gray-200 mb-8">
            Nossa equipe especializada pode ajudar você a encontrar a madeira perfeita para seu projeto.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#orcamento" class="bg-white text-wood-brown px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors font-semibold">
                Solicitar Orçamento
            </a>
            <a href="tel:+5511999999999" class="border-2 border-white text-white hover:bg-white hover:text-wood-brown px-8 py-4 rounded-lg transition-colors font-semibold">
                Falar com Especialista
            </a>
        </div>
    </div>
</section>

<script>
function filtrosCatalogo() {
    return {
        filtros: {
            categoria: '',
            aplicacao: '',
            preco: '',
            busca: ''
        },
        
        produtos: <?= json_encode($produtos) ?>,
        
        init() {
            console.log('Alpine.js initialized');
            console.log('Products data:', this.produtos);
            console.log('Products count:', this.produtos.length);
        },
        
        get produtosFiltrados() {
            let resultado = this.produtos;
            
            // Filtro por categoria
            if (this.filtros.categoria) {
                resultado = resultado.filter(p => p.categoria.toLowerCase() === this.filtros.categoria);
            }
            
            // Filtro por aplicação
            if (this.filtros.aplicacao) {
                resultado = resultado.filter(p => p.aplicacoes.some(a => a.toLowerCase().includes(this.filtros.aplicacao)));
            }
            
            // Filtro por preço
            if (this.filtros.preco) {
                const [min, max] = this.filtros.preco.split('-').map(p => p.replace('+', '999999'));
                resultado = resultado.filter(p => {
                    const preco = p.preco_m3;
                    if (max) {
                        return preco >= parseInt(min) && preco <= parseInt(max);
                    } else {
                        return preco >= parseInt(min);
                    }
                });
            }
            
            // Filtro por busca
            if (this.filtros.busca) {
                const termo = this.filtros.busca.toLowerCase();
                resultado = resultado.filter(p => 
                    p.nome.toLowerCase().includes(termo) ||
                    p.descricao.toLowerCase().includes(termo) ||
                    p.aplicacoes.some(a => a.toLowerCase().includes(termo))
                );
            }
            
            return resultado;
        },
        
        aplicarFiltros() {
            // Função chamada quando filtros mudam
            // Pode ser usada para analytics ou outras ações
        },
        
        limparFiltros() {
            this.filtros = {
                categoria: '',
                aplicacao: '',
                preco: '',
                busca: ''
            };
        }
    }
}
</script>