<div class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                    <a href="/blog" class="text-gray-500 hover:text-gray-700">Blog</a>
                </li>
                <li>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                </li>
                <li>
                    <span class="text-gray-900 font-medium"><?= $artigo['titulo'] ?></span>
                </li>
            </ol>
        </nav>
        
        <!-- Header do Artigo -->
        <header class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="relative">
                <img src="<?= $artigo['imagem'] ?>" alt="<?= $artigo['titulo'] ?>" class="w-full h-80 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-end">
                    <div class="p-8 text-white">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="bg-forest-green px-3 py-1 rounded-full text-sm font-medium"><?= ucfirst($artigo['categoria']) ?></span>
                            <span class="text-gray-200 text-sm"><?= $artigo['tempo_leitura'] ?> min de leitura</span>
                            <span class="text-gray-200 text-sm"><?= date('d/m/Y', strtotime($artigo['data_publicacao'])) ?></span>
                        </div>
                        <h1 class="text-4xl font-display font-bold mb-4"><?= $artigo['titulo'] ?></h1>
                        <p class="text-xl text-gray-200"><?= $artigo['resumo'] ?></p>
                    </div>
                </div>
            </div>
            
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <img src="<?= $artigo['autor']['avatar'] ?>" alt="<?= $artigo['autor']['nome'] ?>" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <div class="font-bold text-gray-900"><?= $artigo['autor']['nome'] ?></div>
                            <div class="text-gray-600"><?= $artigo['autor']['cargo'] ?></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-1 text-gray-500">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            <span class="text-sm"><?= $artigo['visualizacoes'] ?></span>
                        </div>
                        <div class="flex items-center space-x-1 text-gray-500">
                            <i data-lucide="heart" class="w-4 h-4"></i>
                            <span class="text-sm"><?= $artigo['likes'] ?></span>
                        </div>
                        <button class="flex items-center space-x-1 text-gray-500 hover:text-wood-brown transition-colors">
                            <i data-lucide="share-2" class="w-4 h-4"></i>
                            <span class="text-sm">Compartilhar</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Conteúdo do Artigo -->
        <article class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <!-- Índice -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="list" class="w-5 h-5 mr-2"></i>
                    Índice do Artigo
                </h2>
                <nav class="space-y-2">
                    <?php foreach ($artigo['indice'] as $item): ?>
                    <a href="#<?= $item['anchor'] ?>" class="block text-gray-600 hover:text-wood-brown transition-colors pl-<?= $item['nivel'] * 4 ?>">
                        <?= $item['titulo'] ?>
                    </a>
                    <?php endforeach; ?>
                </nav>
            </div>
            
            <!-- Conteúdo Principal -->
            <div class="prose prose-lg max-w-none">
                <?= $artigo['conteudo'] ?>
            </div>
            
            <!-- Tags -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Tags</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($artigo['tags'] as $tag): ?>
                    <a href="/blog?busca=<?= urlencode($tag) ?>" class="bg-gray-100 hover:bg-wood-brown hover:text-white text-gray-700 px-3 py-1 rounded-full text-sm transition-colors">
                        #<?= $tag ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Ações do Artigo -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button class="flex items-center space-x-2 bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg transition-colors">
                            <i data-lucide="heart" class="w-4 h-4"></i>
                            <span>Curtir (<?= $artigo['likes'] ?>)</span>
                        </button>
                        <button class="flex items-center space-x-2 bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg transition-colors">
                            <i data-lucide="bookmark" class="w-4 h-4"></i>
                            <span>Salvar</span>
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 text-sm">Compartilhar:</span>
                        <button class="w-8 h-8 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center transition-colors">
                            <i data-lucide="facebook" class="w-4 h-4"></i>
                        </button>
                        <button class="w-8 h-8 bg-blue-400 hover:bg-blue-500 text-white rounded-full flex items-center justify-center transition-colors">
                            <i data-lucide="twitter" class="w-4 h-4"></i>
                        </button>
                        <button class="w-8 h-8 bg-blue-700 hover:bg-blue-800 text-white rounded-full flex items-center justify-center transition-colors">
                            <i data-lucide="linkedin" class="w-4 h-4"></i>
                        </button>
                        <button class="w-8 h-8 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center transition-colors">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </article>
        
        <!-- Sobre o Autor -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Sobre o Autor</h2>
            <div class="flex items-start space-x-6">
                <img src="<?= $artigo['autor']['avatar'] ?>" alt="<?= $artigo['autor']['nome'] ?>" class="w-20 h-20 rounded-full object-cover">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?= $artigo['autor']['nome'] ?></h3>
                    <p class="text-gray-600 mb-4"><?= $artigo['autor']['bio'] ?></p>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500"><?= $artigo['autor']['total_artigos'] ?> artigos publicados</span>
                        <div class="flex items-center space-x-2">
                            <?php if (!empty($artigo['autor']['linkedin'])): ?>
                            <a href="<?= $artigo['autor']['linkedin'] ?>" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i data-lucide="linkedin" class="w-4 h-4"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($artigo['autor']['twitter'])): ?>
                            <a href="<?= $artigo['autor']['twitter'] ?>" class="text-gray-400 hover:text-blue-400 transition-colors">
                                <i data-lucide="twitter" class="w-4 h-4"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Comentários -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Comentários (<?= count($artigo['comentarios']) ?>)</h2>
            
            <!-- Formulário de Comentário -->
            <form class="mb-8 p-6 bg-gray-50 rounded-xl" x-data="{ nome: '', email: '', comentario: '' }">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Deixe seu Comentário</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                        <input type="text" x-model="nome" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Seu nome">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                        <input type="email" x-model="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="seu@email.com">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comentário</label>
                    <textarea x-model="comentario" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Compartilhe sua opinião ou dúvida..."></textarea>
                </div>
                <button type="submit" class="bg-wood-brown text-white px-6 py-3 rounded-lg hover:bg-wood-dark transition-colors font-medium">
                    Publicar Comentário
                </button>
            </form>
            
            <!-- Lista de Comentários -->
            <div class="space-y-6">
                <?php foreach ($artigo['comentarios'] as $comentario): ?>
                <div class="border-b border-gray-100 pb-6">
                    <div class="flex items-start space-x-4">
                        <img src="<?= $comentario['avatar'] ?>" alt="<?= $comentario['nome'] ?>" class="w-10 h-10 rounded-full object-cover">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h4 class="font-bold text-gray-900"><?= $comentario['nome'] ?></h4>
                                <span class="text-gray-500 text-sm"><?= date('d/m/Y H:i', strtotime($comentario['data'])) ?></span>
                            </div>
                            <p class="text-gray-600 mb-3"><?= $comentario['texto'] ?></p>
                            <div class="flex items-center space-x-4">
                                <button class="text-gray-500 hover:text-wood-brown text-sm transition-colors">
                                    <i data-lucide="thumbs-up" class="w-3 h-3 inline mr-1"></i>
                                    Útil (<?= $comentario['likes'] ?>)
                                </button>
                                <button class="text-gray-500 hover:text-wood-brown text-sm transition-colors">
                                    <i data-lucide="message-circle" class="w-3 h-3 inline mr-1"></i>
                                    Responder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Navegação entre Artigos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <?php if (!empty($artigo_anterior)): ?>
            <a href="/blog/<?= $artigo_anterior['slug'] ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                <div class="flex items-center space-x-3 mb-3">
                    <i data-lucide="chevron-left" class="w-4 h-4 text-gray-400 group-hover:text-wood-brown transition-colors"></i>
                    <span class="text-sm text-gray-500">Artigo Anterior</span>
                </div>
                <h3 class="font-bold text-gray-900 group-hover:text-wood-brown transition-colors"><?= $artigo_anterior['titulo'] ?></h3>
            </a>
            <?php endif; ?>
            
            <?php if (!empty($proximo_artigo)): ?>
            <a href="/blog/<?= $proximo_artigo['slug'] ?>" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group text-right">
                <div class="flex items-center justify-end space-x-3 mb-3">
                    <span class="text-sm text-gray-500">Próximo Artigo</span>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 group-hover:text-wood-brown transition-colors"></i>
                </div>
                <h3 class="font-bold text-gray-900 group-hover:text-wood-brown transition-colors"><?= $proximo_artigo['titulo'] ?></h3>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Sidebar com Artigos Relacionados -->
<aside class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-display font-bold text-gray-900 mb-8 text-center">Artigos Relacionados</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($artigos_relacionados as $relacionado): ?>
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <img src="<?= $relacionado['imagem'] ?>" alt="<?= $relacionado['titulo'] ?>" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="bg-forest-green text-white px-2 py-1 rounded text-xs font-medium"><?= ucfirst($relacionado['categoria']) ?></span>
                        <span class="text-gray-500 text-sm"><?= $relacionado['tempo_leitura'] ?> min</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-3 line-clamp-2"><?= $relacionado['titulo'] ?></h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?= $relacionado['resumo'] ?></p>
                    <a href="/blog/<?= $relacionado['slug'] ?>" class="text-wood-brown hover:text-wood-dark font-medium text-sm">
                        Ler artigo →
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</aside>

<!-- CTA Newsletter -->
<section class="py-16 bg-wood-brown text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-display font-bold mb-4">Gostou do Conteúdo?</h2>
        <p class="text-xl text-gray-200 mb-8">
            Assine nossa newsletter e receba mais artigos técnicos como este diretamente no seu e-mail.
        </p>
        
        <form class="max-w-md mx-auto" x-data="{ email: '' }">
            <div class="flex space-x-4">
                <input type="email" x-model="email" placeholder="Seu e-mail" class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:ring-2 focus:ring-white focus:outline-none">
                <button type="submit" class="bg-white text-wood-brown px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors font-semibold">
                    Assinar
                </button>
            </div>
        </form>
    </div>
</section>

<style>
.prose {
    color: #374151;
    line-height: 1.75;
}

.prose h2 {
    font-size: 1.5em;
    font-weight: 700;
    margin-top: 2em;
    margin-bottom: 1em;
    color: #111827;
}

.prose h3 {
    font-size: 1.25em;
    font-weight: 600;
    margin-top: 1.6em;
    margin-bottom: 0.6em;
    color: #111827;
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

.prose blockquote {
    border-left: 4px solid #8B4513;
    padding-left: 1em;
    margin: 1.6em 0;
    font-style: italic;
    background-color: #f9fafb;
    padding: 1em;
    border-radius: 0.5rem;
}

.prose code {
    background-color: #f3f4f6;
    padding: 0.2em 0.4em;
    border-radius: 0.25rem;
    font-size: 0.875em;
}

.prose pre {
    background-color: #1f2937;
    color: #f9fafb;
    padding: 1em;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1.5em 0;
}

.prose img {
    border-radius: 0.5rem;
    margin: 1.5em 0;
}

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
// Smooth scroll para links do índice
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Highlight do índice baseado na posição do scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                document.querySelectorAll('nav a').forEach(link => {
                    link.classList.remove('text-wood-brown', 'font-medium');
                    link.classList.add('text-gray-600');
                });
                const activeLink = document.querySelector(`nav a[href="#${id}"]`);
                if (activeLink) {
                    activeLink.classList.remove('text-gray-600');
                    activeLink.classList.add('text-wood-brown', 'font-medium');
                }
            }
        });
    }, { threshold: 0.5 });
    
    document.querySelectorAll('h2[id], h3[id]').forEach(heading => {
        observer.observe(heading);
    });
});
</script>