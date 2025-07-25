<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Tronco Forte - Madeiras Legalizadas' ?></title>
    <meta name="description" content="<?= $meta_description ?? 'Fornecedor de madeiras certificadas e legalizadas para construção civil. Pinus, eucalipto, ipê, cumaru e mais espécies com garantia de origem.' ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'wood-brown': '#8B4513',
                        'wood-light': '#D2B48C',
                        'wood-dark': '#654321',
                        'forest-green': '#228B22',
                        'earth-orange': '#CD853F',
                        'warm-beige': '#F5F5DC'
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                        'display': ['Poppins', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- GlideJS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.theme.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/glide.min.js"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%238B4513'%3E%3Cpath d='M12 2L2 7v10c0 5.55 3.84 10 9 11 1.16.21 2.76.21 3.92 0 5.16-1 9-5.45 9-11V7l-10-5z'/%3E%3C/svg%3E">
    
    <!-- SEO Meta Tags -->
    <meta property="og:title" content="<?= $page_title ?? 'Tronco Forte - Madeiras Legalizadas' ?>">
    <meta property="og:description" content="<?= $meta_description ?? 'Fornecedor de madeiras certificadas e legalizadas para construção civil.' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $_SERVER['REQUEST_URI'] ?? '' ?>">
    <meta property="og:image" content="https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=tronco%20forte%20logo%20wood%20company%20professional%20brand&image_size=square">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $page_title ?? 'Tronco Forte - Madeiras Legalizadas' ?>">
    <meta name="twitter:description" content="<?= $meta_description ?? 'Fornecedor de madeiras certificadas e legalizadas para construção civil.' ?>">
    
    <!-- Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Tronco Forte",
        "description": "Fornecedor de madeiras certificadas e legalizadas para construção civil",
        "url": "<?= $_SERVER['HTTP_HOST'] ?? '' ?>",
        "logo": "https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=tronco%20forte%20logo%20wood%20company%20professional%20brand&image_size=square",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+55-11-3333-4444",
            "contactType": "customer service"
        }
    }
    </script>
</head>
<body class="bg-warm-beige text-gray-900 font-sans">
    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="<?= $base_path ?? '/' ?>" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-wood-brown rounded-lg flex items-center justify-center">
                            <i data-lucide="tree-pine" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="text-2xl font-display font-bold text-wood-brown">Tronco Forte</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="<?= $base_path ?? '/' ?>" class="text-gray-700 hover:text-wood-brown px-3 py-2 text-sm font-medium transition-colors">Início</a>
                    <a href="<?= $base_path ?>/catalogo" class="text-gray-700 hover:text-wood-brown px-3 py-2 text-sm font-medium transition-colors">Catálogo</a>
                    <a href="<?= $base_path ?>/blog" class="text-gray-700 hover:text-wood-brown px-3 py-2 text-sm font-medium transition-colors">Blog</a>
                    <a href="<?= $base_path ?>/fornecedores" class="text-gray-700 hover:text-wood-brown px-3 py-2 text-sm font-medium transition-colors">Fornecedores</a>
                    <a href="<?= $base_path ?>/sobre" class="text-gray-700 hover:text-wood-brown px-3 py-2 text-sm font-medium transition-colors">Sobre</a>
                    <a href="<?= $base_path ?>/contato" class="text-gray-700 hover:text-wood-brown px-3 py-2 text-sm font-medium transition-colors">Contato</a>
                </nav>
                
                <!-- CTA Button -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="#orcamento" class="bg-wood-brown text-white px-4 py-2 rounded-lg hover:bg-wood-dark transition-colors font-medium">
                        Solicitar Orçamento
                    </a>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-wood-brown">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="<?= $base_path ?? '/' ?>" class="block px-3 py-2 text-gray-700 hover:text-wood-brown font-medium">Início</a>
                <a href="<?= $base_path ?>/catalogo" class="block px-3 py-2 text-gray-700 hover:text-wood-brown font-medium">Catálogo</a>
                <a href="<?= $base_path ?>/blog" class="block px-3 py-2 text-gray-700 hover:text-wood-brown font-medium">Blog</a>
                <a href="<?= $base_path ?>/fornecedores" class="block px-3 py-2 text-gray-700 hover:text-wood-brown font-medium">Fornecedores</a>
                <a href="<?= $base_path ?>/sobre" class="block px-3 py-2 text-gray-700 hover:text-wood-brown font-medium">Sobre</a>
                <a href="<?= $base_path ?>/contato" class="block px-3 py-2 text-gray-700 hover:text-wood-brown font-medium">Contato</a>
                <a href="#orcamento" class="block mx-3 my-2 px-4 py-2 bg-wood-brown text-white rounded-lg text-center font-medium">Solicitar Orçamento</a>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main>
        <?= $content ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-wood-dark text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-wood-brown rounded-lg flex items-center justify-center">
                            <i data-lucide="tree-pine" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="text-2xl font-display font-bold">Tronco Forte</span>
                    </div>
                    <p class="text-gray-300 mb-4 max-w-md">
                        Fornecedor de madeiras certificadas e legalizadas para construção civil. 
                        Garantimos origem sustentável e qualidade superior em todos os nossos produtos.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i data-lucide="linkedin" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i data-lucide="youtube" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="/catalogo" class="text-gray-300 hover:text-white transition-colors">Catálogo</a></li>
                        <li><a href="/blog" class="text-gray-300 hover:text-white transition-colors">Blog Técnico</a></li>
                        <li><a href="/fornecedores" class="text-gray-300 hover:text-white transition-colors">Fornecedores</a></li>
                        <li><a href="#calculadora" class="text-gray-300 hover:text-white transition-colors">Calculadora m³</a></li>
                        <li><a href="#quiz" class="text-gray-300 hover:text-white transition-colors">Quiz de Madeiras</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contato</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center space-x-2">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                            <span>(11) 3333-4444</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            <span>contato@troncoforte.com.br</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            <span>São Paulo, SP</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>Seg-Sex: 7h às 17h</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-600 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-300 text-sm">
                    &copy; 2024 Tronco Forte. Todos os direitos reservados.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Política de Privacidade</a>
                    <a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Termos de Uso</a>
                    <a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Certificações</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- WhatsApp Float Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="https://wa.me/5511999999999" target="_blank" 
           class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg transition-all duration-300 hover:scale-110 flex items-center justify-center">
            <i data-lucide="message-circle" class="w-6 h-6"></i>
        </a>
    </div>
    
    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
    
    <!-- Custom Scripts -->
    <script>
        // Smooth scroll for anchor links
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
        
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('shadow-xl');
            } else {
                header.classList.remove('shadow-xl');
            }
        });
        
        // Volume Calculator Alpine.js component
        document.addEventListener('alpine:init', () => {
            Alpine.data('volumeCalculator', () => ({
                comprimento: '',
                largura: '',
                altura: '',
                resultado: null,
                
                calcular() {
                    if (this.comprimento && this.largura && this.altura) {
                        const volume = (parseFloat(this.comprimento) * parseFloat(this.largura) * parseFloat(this.altura)) / 1000000;
                        this.resultado = volume.toFixed(3);
                    }
                },
                
                limpar() {
                    this.comprimento = '';
                    this.largura = '';
                    this.altura = '';
                    this.resultado = null;
                }
            }));
            
            // Wood Quiz Alpine.js component
            Alpine.data('woodQuiz', () => ({
                currentQuestion: 0,
                answers: [],
                showResult: false,
                result: '',
                
                questions: [
                    {
                        question: 'Qual o tipo de construção?',
                        options: ['Residencial', 'Comercial', 'Industrial', 'Reforma']
                    },
                    {
                        question: 'Qual a aplicação principal?',
                        options: ['Estrutural', 'Acabamento', 'Móveis', 'Decoração']
                    },
                    {
                        question: 'Qual o orçamento disponível?',
                        options: ['Até R$ 5.000', 'R$ 5.000 - R$ 15.000', 'R$ 15.000 - R$ 30.000', 'Acima de R$ 30.000']
                    }
                ],
                
                selectAnswer(answer) {
                    this.answers[this.currentQuestion] = answer;
                    
                    if (this.currentQuestion < this.questions.length - 1) {
                        this.currentQuestion++;
                    } else {
                        this.calculateResult();
                    }
                },
                
                calculateResult() {
                    // Simple logic to recommend wood type based on answers
                    const [construction, application, budget] = this.answers;
                    
                    if (application === 'Estrutural') {
                        this.result = 'Eucalipto Tratado - Ideal para estruturas com excelente resistência.';
                    } else if (application === 'Acabamento') {
                        this.result = 'Pinus Aparelhado - Perfeito para acabamentos e revestimentos.';
                    } else if (application === 'Móveis') {
                        this.result = 'Madeira de Lei - Qualidade superior para móveis duráveis.';
                    } else {
                        this.result = 'Pinus Bruto - Versátil e econômico para diversas aplicações.';
                    }
                    
                    this.showResult = true;
                },
                
                restart() {
                    this.currentQuestion = 0;
                    this.answers = [];
                    this.showResult = false;
                    this.result = '';
                }
            }));
        });
    </script>
</body>
</html>