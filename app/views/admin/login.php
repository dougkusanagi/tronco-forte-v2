<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tronco Forte Admin</title>

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
</head>

<body class="bg-gradient-to-br from-wood-light to-warm-beige min-h-screen flex items-center justify-center font-sans">
    <div class="max-w-md w-full mx-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center space-x-2 mb-4">
                <div class="w-12 h-12 bg-wood-brown rounded-lg flex items-center justify-center">
                    <i data-lucide="tree-pine" class="w-8 h-8 text-white"></i>
                </div>
                <span class="text-3xl font-display font-bold text-wood-brown">Tronco Forte</span>
            </div>
            <h1 class="text-2xl font-semibold text-gray-800">Área Administrativa</h1>
            <p class="text-gray-600 mt-2">Faça login para acessar o painel</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-xl shadow-xl p-8" x-data="{
            username: '',
            password: '',
            loading: false,
            error: '',
            showPassword: false,
            
            async login() {
                if (!this.username || !this.password) {
                    this.error = 'Por favor, preencha todos os campos';
                    return;
                }
                
                this.loading = true;
                this.error = '';
                
                try {
                    const response = await fetch('/admin/authenticate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            username: this.username,
                            password: this.password
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        window.location.href = '/admin/dashboard';
                    } else {
                        this.error = data.message || 'Credenciais inválidas';
                    }
                } catch (error) {
                    console.error('Erro de conexão:', error);
                    this.error = 'Erro de conexão. Tente novamente.';
                } finally {
                    this.loading = false;
                }
            }
        }">
            <form @submit.prevent="login()" class="space-y-6">
                <!-- Error Message -->
                <div x-show="error" x-transition class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 mr-2"></i>
                        <span x-text="error"></span>
                    </div>
                </div>

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Usuário
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="username"
                            x-model="username"
                            class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent transition-colors"
                            placeholder="Digite seu usuário"
                            required>
                        <i data-lucide="user" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Senha
                    </label>
                    <div class="relative">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            x-model="password"
                            class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent transition-colors"
                            placeholder="Digite sua senha"
                            required>
                        <i data-lucide="lock" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :data-lucide="showPassword ? 'eye-off' : 'eye'" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-wood-brown focus:ring-wood-brown">
                        <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-wood-brown text-white py-3 px-4 rounded-lg hover:bg-wood-dark focus:ring-2 focus:ring-wood-brown focus:ring-offset-2 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Entrar</span>
                    <span x-show="loading" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Entrando...
                    </span>
                </button>
            </form>

            <!-- Default Credentials Info -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <i data-lucide="info" class="w-5 h-5 text-blue-500 mt-0.5 mr-2 flex-shrink-0"></i>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium mb-1">Credenciais padrão:</p>
                        <p><strong>Usuário:</strong> admin</p>
                        <p><strong>Senha:</strong> admin123</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Site -->
        <div class="text-center mt-6">
            <a href="/" class="text-wood-brown hover:text-wood-dark font-medium">
                ← Voltar ao site
            </a>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Re-initialize icons when Alpine updates the DOM
        document.addEventListener('alpine:updated', () => {
            lucide.createIcons();
        });
    </script>
</body>

</html>