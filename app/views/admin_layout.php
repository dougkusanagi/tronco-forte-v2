<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Dashboard - Tronco Forte Admin' ?></title>
    
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
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js for dashboard charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans" x-data="{ sidebarOpen: false }">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-wood-dark transform transition-transform duration-300 ease-in-out lg:translate-x-0" 
         :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
        
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-wood-brown">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <i data-lucide="tree-pine" class="w-5 h-5 text-wood-brown"></i>
                </div>
                <span class="text-xl font-display font-bold text-white">Admin</span>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-8">
            <div class="px-4 space-y-2">
                <a href="/admin/dashboard" class="flex items-center px-4 py-3 text-gray-300 hover:bg-wood-brown hover:text-white rounded-lg transition-colors group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="/admin/produtos" class="flex items-center px-4 py-3 text-gray-300 hover:bg-wood-brown hover:text-white rounded-lg transition-colors group">
                    <i data-lucide="package" class="w-5 h-5 mr-3"></i>
                    <span>Catálogo</span>
                </a>
                
                <a href="/admin/fornecedores" class="flex items-center px-4 py-3 text-gray-300 hover:bg-wood-brown hover:text-white rounded-lg transition-colors group">
                    <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                    <span>Fornecedores</span>
                </a>
                
                <a href="/admin/blog" class="flex items-center px-4 py-3 text-gray-300 hover:bg-wood-brown hover:text-white rounded-lg transition-colors group">
                    <i data-lucide="file-text" class="w-5 h-5 mr-3"></i>
                    <span>Blog</span>
                </a>
                
                
                
                <a href="/admin/configuracoes" class="flex items-center px-4 py-3 text-gray-300 hover:bg-wood-brown hover:text-white rounded-lg transition-colors group">
                    <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
                    <span>Configurações</span>
                </a>
            </div>
            
            <!-- User Section -->
            <div class="absolute bottom-0 w-full p-4">
                <div class="flex items-center space-x-3 p-3 bg-wood-brown rounded-lg">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                        <i data-lucide="user" class="w-4 h-4 text-wood-brown"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">Admin</p>
                        <p class="text-xs text-gray-300">Administrador</p>
                    </div>
                    <a href="/admin/logout" class="text-gray-300 hover:text-white">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-4 py-3">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h1 class="ml-4 lg:ml-0 text-xl font-semibold text-gray-900"><?= $page_title ?? 'Dashboard' ?></h1>
                </div>
                
                <div class="flex items-center space-x-3">
                    <!-- Notifications -->
                    <button class="relative text-gray-500 hover:text-gray-700">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <!-- Quick Actions -->
                    <a href="/" target="_blank" class="text-gray-500 hover:text-gray-700" title="Ver Site">
                        <i data-lucide="external-link" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main>
            <?= $content ?>
        </main>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Auto-close mobile sidebar when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('[x-data]');
            const sidebarElement = document.querySelector('.fixed.inset-y-0.left-0');
            const menuButton = document.querySelector('[\@click="sidebarOpen = !sidebarOpen"]');
            
            if (window.innerWidth < 1024 && 
                !sidebarElement.contains(e.target) && 
                !menuButton.contains(e.target)) {
                Alpine.store('sidebarOpen', false);
            }
        });
    </script>
</body>
</html>