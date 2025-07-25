<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-display font-bold text-gray-900 mb-4">Blog Técnico Tronco Forte</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Conhecimento especializado para construtores e carpinteiros. Dicas, técnicas e tendências do mercado madeireiro.</p>
        </div>
        
        <!-- Filtros e Busca -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8" x-data="filtrosBlog()">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Artigos</label>
                    <div class="relative">
                        <input type="text" x-model="filtros.busca" @input="aplicarFiltros()" placeholder="Busque por título, conteúdo ou tags..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-3"></i>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                    <select x-model="filtros.categoria" @change="aplicarFiltros()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="">Todas as categorias</option>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= htmlspecialchars($categoria['slug']) ?>"><?= htmlspecialchars($categoria['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                    <select x-model="filtros.ordenacao" @change="aplicarFiltros()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="recente">Mais Recentes</option>
                        <option value="popular">Mais Populares</option>
                        <option value="alfabetico">A-Z</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-4">
                <span class="text-sm text-gray-600" x-text="`${artigosFiltrados.length} artigos encontrados`"></span>
                <button @click="limparFiltros()" class="text-wood-brown hover:text-wood-dark text-sm font-medium">
                    Limpar Filtros
                </button>
            </div>
        </div>
        
        <!-- Artigo em Destaque -->
        <?php if (!empty($artigo_destaque)): ?>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="relative">
                    <img src="<?= $artigo_destaque['imagem_destaque'] ?? 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wooden%20construction%20materials%20lumber%20yard&image_size=landscape_16_9' ?>" alt="<?= htmlspecialchars($artigo_destaque['titulo']) ?>" class="w-full h-80 lg:h-full object-cover">
                    <div class="absolute top-4 left-4">
                        <span class="bg-wood-brown text-white px-3 py-1 rounded-full text-sm font-medium">Em Destaque</span>
                    </div>
                </div>
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="bg-forest-green text-white px-3 py-1 rounded-full text-sm font-medium"><?= ucfirst($artigo_destaque['categoria']) ?></span>
                        <span class="text-gray-500 text-sm"><?= $artigo_destaque['tempo_leitura'] ?> min de leitura</span>
                        <span class="text-gray-500 text-sm"><?= date('d/m/Y', strtotime($artigo_destaque['data_publicacao'])) ?></span>
                    </div>
                    <h2 class="text-3xl font-display font-bold text-gray-900 mb-4"><?= $artigo_destaque['titulo'] ?></h2>
                    <p class="text-lg text-gray-600 mb-6"><?= $artigo_destaque['resumo'] ?></p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="<?= $artigo_destaque['autor']['avatar'] ?? 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20carpenter%20avatar%20portrait&image_size=square' ?>" alt="<?= htmlspecialchars($artigo_destaque['autor']['nome'] ?? 'Autor') ?>" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <div class="font-medium text-gray-900"><?= htmlspecialchars($artigo_destaque['autor']['nome'] ?? 'Autor') ?></div>
                                <div class="text-sm text-gray-500"><?= htmlspecialchars($artigo_destaque['autor']['cargo'] ?? 'Especialista') ?></div>
                            </div>
                        </div>
                        <a href="/blog/<?= $artigo_destaque['slug'] ?>" class="bg-wood-brown text-white px-6 py-3 rounded-lg hover:bg-wood-dark transition-colors font-medium">
                            Ler Artigo
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Grid de Artigos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <template x-for="artigo in artigosFiltrados" :key="artigo.id">
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="relative">
                        <img :src="artigo.imagem_destaque" :alt="artigo.titulo" class="w-full h-48 object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-forest-green text-white px-3 py-1 rounded-full text-sm font-medium" x-text="artigo.categoria"></span>
                        </div>
                        <div class="absolute top-4 right-4 bg-white bg-opacity-90 px-2 py-1 rounded text-xs font-medium text-gray-700" x-text="artigo.tempo_leitura + ' min'"></div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="text-gray-500 text-sm" x-text="new Date(artigo.data_publicacao).toLocaleDateString('pt-BR')"></span>
                            <span class="text-gray-300">•</span>
                            <div class="flex items-center space-x-1">
                                <i data-lucide="eye" class="w-3 h-3 text-gray-400"></i>
                                <span class="text-gray-500 text-sm" x-text="artigo.visualizacoes"></span>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2" x-text="artigo.titulo"></h3>
                        <p class="text-gray-600 mb-4 line-clamp-3" x-text="artigo.resumo"></p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <template x-for="tag in artigo.tags.slice(0, 3)" :key="tag">
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs" x-text="tag"></span>
                            </template>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <img :src="artigo.autor.avatar" :alt="artigo.autor.nome" class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-medium text-gray-700" x-text="artigo.autor.nome"></span>
                            </div>
                            <a :href="'/blog/' + artigo.slug" class="text-wood-brown hover:text-wood-dark font-medium text-sm">
                                Ler mais →
                            </a>
                        </div>
                    </div>
                </article>
            </template>
        </div>
        
        <!-- Paginação -->
        <div class="flex justify-center mt-12" x-show="totalPaginas > 1">
            <nav class="flex items-center space-x-2">
                <button @click="irParaPagina(paginaAtual - 1)" :disabled="paginaAtual === 1" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                
                <template x-for="pagina in paginasVisiveis" :key="pagina">
                    <button 
                        x-show="pagina !== '...'" 
                        @click="irParaPagina(pagina)" 
                        :class="pagina === paginaAtual ? 'px-4 py-2 bg-wood-brown text-white rounded-lg' : 'px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'"
                        x-text="pagina">
                    </button>
                    <span x-show="pagina === '...'" class="px-2 text-gray-500">...</span>
                </template>
                
                <button @click="irParaPagina(paginaAtual + 1)" :disabled="paginaAtual === totalPaginas" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </nav>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<section class="py-16 bg-wood-brown text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-display font-bold mb-4">Receba Conteúdo Exclusivo</h2>
        <p class="text-xl text-gray-200 mb-8">
            Assine nossa newsletter e receba artigos técnicos, dicas profissionais e novidades do setor madeireiro.
        </p>
        
        <form class="max-w-md mx-auto" x-data="{ email: '', nome: '' }">
            <div class="space-y-4">
                <input type="text" x-model="nome" placeholder="Seu nome" class="w-full px-4 py-3 rounded-lg text-gray-900 focus:ring-2 focus:ring-white focus:outline-none">
                <input type="email" x-model="email" placeholder="Seu e-mail" class="w-full px-4 py-3 rounded-lg text-gray-900 focus:ring-2 focus:ring-white focus:outline-none">
                <button type="submit" class="w-full bg-white text-wood-brown py-3 rounded-lg hover:bg-gray-100 transition-colors font-semibold">
                    Assinar Newsletter
                </button>
            </div>
            <p class="text-sm text-gray-300 mt-4">Sem spam. Cancele quando quiser.</p>
        </form>
    </div>
</section>

<!-- Categorias Populares -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-display font-bold text-gray-900 mb-4">Explore por Categoria</h2>
            <p class="text-lg text-gray-600">Encontre conteúdo específico para suas necessidades profissionais</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6" x-data="{ categorias: <?= json_encode($categorias) ?> }">
            <template x-for="categoria in categorias" :key="categoria.slug">
                <a :href="'/blog?categoria=' + categoria.slug" class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div :class="'w-16 h-16 bg-' + categoria.cor + '-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-' + categoria.cor + '-200 transition-colors'">
                        <i :data-lucide="categoria.icone" :class="'w-8 h-8 text-' + categoria.cor + '-600'"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2" x-text="categoria.name"></h3>
                    <p class="text-gray-600 text-sm mb-3" x-text="categoria.descricao"></p>
                    <span :class="'text-' + categoria.cor + '-600 text-sm font-medium'" x-text="categoria.total_artigos + ' artigos'"></span>
                </a>
            </template>
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
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
function filtrosBlog() {
    return {
        artigos: <?= json_encode($artigos ?? []) ?>.map(artigo => ({
            ...artigo,
            imagem_destaque: artigo.imagem_destaque || 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wooden%20construction%20materials%20lumber%20yard&image_size=landscape_4_3',
            tags: artigo.tags || [],
            visualizacoes: artigo.visualizacoes || 0,
            autor: {
                nome: artigo.autor?.nome || 'Autor',
                avatar: artigo.autor?.avatar || 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20carpenter%20avatar%20portrait&image_size=square',
                cargo: artigo.autor?.cargo || 'Especialista'
            }
        })),
        filtros: {
            busca: '',
            categoria: '',
            ordenacao: 'recente'
        },
        paginaAtual: 1,
        porPagina: 6,
        
        get artigosFiltradosCompletos() {
            let resultado = this.artigos;
            
            // Filtro por busca
            if (this.filtros.busca) {
                const termo = this.filtros.busca.toLowerCase();
                resultado = resultado.filter(artigo => 
                    artigo.titulo.toLowerCase().includes(termo) ||
                    artigo.resumo.toLowerCase().includes(termo) ||
                    (artigo.tags && artigo.tags.some(tag => tag.toLowerCase().includes(termo)))
                );
            }
            
            // Filtro por categoria
            if (this.filtros.categoria) {
                resultado = resultado.filter(artigo => 
                    artigo.categoria_slug === this.filtros.categoria
                );
            }
            
            // Ordenação
            switch (this.filtros.ordenacao) {
                case 'popular':
                    resultado.sort((a, b) => (b.visualizacoes || 0) - (a.visualizacoes || 0));
                    break;
                case 'alfabetico':
                    resultado.sort((a, b) => a.titulo.localeCompare(b.titulo));
                    break;
                case 'recente':
                default:
                    resultado.sort((a, b) => new Date(b.data_publicacao) - new Date(a.data_publicacao));
                    break;
            }
            
            return resultado;
        },
        
        get artigosFiltrados() {
            const inicio = (this.paginaAtual - 1) * this.porPagina;
            const fim = inicio + this.porPagina;
            return this.artigosFiltradosCompletos.slice(inicio, fim);
        },
        
        get totalPaginas() {
            return Math.ceil(this.artigosFiltradosCompletos.length / this.porPagina);
        },
        
        get paginasVisiveis() {
            const total = this.totalPaginas;
            const atual = this.paginaAtual;
            const paginas = [];
            
            if (total <= 7) {
                for (let i = 1; i <= total; i++) {
                    paginas.push(i);
                }
            } else {
                if (atual <= 4) {
                    for (let i = 1; i <= 5; i++) {
                        paginas.push(i);
                    }
                    paginas.push('...');
                    paginas.push(total);
                } else if (atual >= total - 3) {
                    paginas.push(1);
                    paginas.push('...');
                    for (let i = total - 4; i <= total; i++) {
                        paginas.push(i);
                    }
                } else {
                    paginas.push(1);
                    paginas.push('...');
                    for (let i = atual - 1; i <= atual + 1; i++) {
                        paginas.push(i);
                    }
                    paginas.push('...');
                    paginas.push(total);
                }
            }
            
            return paginas;
        },
        
        irParaPagina(pagina) {
            if (pagina >= 1 && pagina <= this.totalPaginas) {
                this.paginaAtual = pagina;
                // Scroll to top of articles
                document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3').scrollIntoView({ behavior: 'smooth' });
            }
        },
        
        aplicarFiltros() {
            // Reset pagination when filters change
            this.paginaAtual = 1;
        },
        
        limparFiltros() {
            this.filtros.busca = '';
            this.filtros.categoria = '';
            this.filtros.ordenacao = 'recente';
            this.paginaAtual = 1;
        }
    }
}
</script>