<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto p-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Configurações do Sistema</h1>
                    <p class="text-gray-600 mt-1">Gerencie as configurações gerais do site e SEO</p>
                </div>
                <button class="bg-wood-brown text-white px-6 py-3 rounded-lg hover:bg-wood-dark transition-colors font-medium">
                    <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                    Salvar Alterações
                </button>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Configurações Gerais -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Configurações Gerais</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Site</label>
                        <input type="text" value="<?= htmlspecialchars($configuracoes_site['nome_site']) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email de Contato</label>
                        <input type="email" value="<?= htmlspecialchars($configuracoes_site['email_contato']) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telefone de Contato</label>
                        <input type="tel" value="<?= htmlspecialchars($configuracoes_site['telefone_contato']) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Endereço</label>
                        <input type="text" value="<?= htmlspecialchars($configuracoes_site['endereco']) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Redes Sociais -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Redes Sociais</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="instagram" class="w-4 h-4 inline mr-2"></i>
                            Instagram
                        </label>
                        <input type="text" value="<?= htmlspecialchars($configuracoes_site['redes_sociais']['instagram']) ?>" 
                               placeholder="@usuario" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="linkedin" class="w-4 h-4 inline mr-2"></i>
                            LinkedIn
                        </label>
                        <input type="text" value="<?= htmlspecialchars($configuracoes_site['redes_sociais']['linkedin']) ?>" 
                               placeholder="nome-da-empresa" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="youtube" class="w-4 h-4 inline mr-2"></i>
                            YouTube
                        </label>
                        <input type="text" value="<?= htmlspecialchars($configuracoes_site['redes_sociais']['youtube']) ?>" 
                               placeholder="canal" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Configurações de SEO -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Configurações de SEO</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title (Página Inicial)</label>
                        <input type="text" value="<?= htmlspecialchars($configuracoes_seo['meta_title_home']) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Recomendado: 50-60 caracteres</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description (Página Inicial)</label>
                        <textarea rows="3" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent"><?= htmlspecialchars($configuracoes_seo['meta_description_home']) ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Recomendado: 150-160 caracteres</p>
                    </div>
                </div>
            </div>

            <!-- Códigos de Tracking -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Códigos de Tracking</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="bar-chart" class="w-4 h-4 inline mr-2"></i>
                            Google Analytics ID
                        </label>
                        <input type="text" value="<?= htmlspecialchars($configuracoes_seo['google_analytics']) ?>" 
                               placeholder="G-XXXXXXXXXX" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="tag" class="w-4 h-4 inline mr-2"></i>
                            Google Tag Manager ID
                        </label>
                        <input type="text" value="<?= htmlspecialchars($configuracoes_seo['google_tag_manager']) ?>" 
                               placeholder="GTM-XXXXXXX" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="facebook" class="w-4 h-4 inline mr-2"></i>
                            Facebook Pixel ID
                        </label>
                        <input type="text" value="<?= htmlspecialchars($configuracoes_seo['facebook_pixel']) ?>" 
                               placeholder="1234567890" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Configurações de Email -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Configurações de Email</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Servidor SMTP</label>
                        <input type="text" placeholder="smtp.gmail.com" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Porta SMTP</label>
                        <input type="number" placeholder="587" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Usuário SMTP</label>
                        <input type="email" placeholder="seu-email@gmail.com" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Senha SMTP</label>
                        <input type="password" placeholder="••••••••" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Configurações de Backup -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Backup e Manutenção</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">Backup Automático</h3>
                            <p class="text-sm text-gray-600">Fazer backup dos dados automaticamente</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-wood-brown/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-wood-brown"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">Modo de Manutenção</h3>
                            <p class="text-sm text-gray-600">Ativar página de manutenção</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-wood-brown/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-wood-brown"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="flex justify-end space-x-4 mt-8">
            <button class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Cancelar
            </button>
            <button class="px-6 py-3 bg-wood-brown text-white rounded-lg hover:bg-wood-dark transition-colors">
                <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                Salvar Configurações
            </button>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>