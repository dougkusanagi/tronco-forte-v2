<div class="bg-gray-50 min-h-screen" x-data="{
    stats: <?= json_encode($estatisticas) ?>,
    activities: <?= json_encode($atividades_recentes) ?>,
    alerts: <?= json_encode($alertas) ?>
}">
    <div class="max-w-7xl mx-auto p-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total de Produtos</p>
                            <p class="text-3xl font-bold text-gray-900" x-text="stats.total_produtos"></p>
                            <p class="text-sm text-green-600 mt-1">+12% este mês</p>
                        </div>
                        <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-lg flex items-center justify-center">
                            <i data-lucide="package" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Fornecedores Ativos</p>
                            <p class="text-3xl font-bold text-gray-900" x-text="stats.fornecedores_ativos"></p>
                            <p class="text-sm text-green-600 mt-1">+5% este mês</p>
                        </div>
                        <div class="bg-green-100 text-green-600 w-12 h-12 rounded-lg flex items-center justify-center">
                            <i data-lucide="users" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Artigos Publicados</p>
                            <p class="text-3xl font-bold text-gray-900" x-text="stats.artigos_publicados"></p>
                            <p class="text-sm text-green-600 mt-1">+8% este mês</p>
                        </div>
                        <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-lg flex items-center justify-center">
                            <i data-lucide="edit" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Visitantes Únicos</p>
                            <p class="text-3xl font-bold text-gray-900" x-text="stats.visitantes_unicos"></p>
                            <p class="text-sm text-green-600 mt-1">+23% este mês</p>
                        </div>
                        <div class="bg-orange-100 text-orange-600 w-12 h-12 rounded-lg flex items-center justify-center">
                            <i data-lucide="eye" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Activities -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Atividades Recentes</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <template x-for="activity in activities" :key="activity.id">
                                <div class="flex items-start space-x-4">
                                    <div :class="{
                                        'bg-blue-100 text-blue-600': activity.tipo === 'produto',
                                        'bg-green-100 text-green-600': activity.tipo === 'fornecedor',
                                        'bg-purple-100 text-purple-600': activity.tipo === 'blog',
                                        'bg-orange-100 text-orange-600': activity.tipo === 'sistema'
                                    }" class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i :data-lucide="activity.icone" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-900" x-text="activity.descricao"></p>
                                        <p class="text-sm text-gray-500" x-text="activity.tempo"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Ações Rápidas</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="/admin/produtos/novo" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                <i data-lucide="plus" class="w-8 h-8 text-blue-600 mb-2"></i>
                                <span class="text-sm font-medium text-blue-600">Novo Produto</span>
                            </a>
                            
                            <a href="/admin/fornecedores/novo" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                                <i data-lucide="user-plus" class="w-8 h-8 text-green-600 mb-2"></i>
                                <span class="text-sm font-medium text-green-600">Novo Fornecedor</span>
                            </a>
                            
                            <a href="/admin/blog/novo" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                                <i data-lucide="edit" class="w-8 h-8 text-purple-600 mb-2"></i>
                                <span class="text-sm font-medium text-purple-600">Novo Artigo</span>
                            </a>
                            
                            <a href="/admin/relatorios" class="flex flex-col items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors">
                                <i data-lucide="bar-chart" class="w-8 h-8 text-orange-600 mb-2"></i>
                                <span class="text-sm font-medium text-orange-600">Ver Relatórios</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <!-- Traffic Chart -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Tráfego do Site</h3>
                    </div>
                    <div class="p-6">
                        <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                            <div class="text-center">
                                <i data-lucide="trending-up" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                                <p class="text-gray-600">Gráfico de tráfego seria exibido aqui</p>
                                <p class="text-sm text-gray-500">Integração com Google Analytics</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Popular Products -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Produtos Mais Visualizados</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <?php 
                            $produtos_populares = [
                                ['nome' => 'Eucalipto Tratado', 'visualizacoes' => 1250, 'crescimento' => '+15%'],
                                ['nome' => 'Pinus Autoclavado', 'visualizacoes' => 980, 'crescimento' => '+8%'],
                                ['nome' => 'Ipê Amarelo', 'visualizacoes' => 750, 'crescimento' => '+22%'],
                                ['nome' => 'Cumaru', 'visualizacoes' => 650, 'crescimento' => '+5%'],
                                ['nome' => 'Jatobá', 'visualizacoes' => 580, 'crescimento' => '+12%']
                            ];
                            foreach ($produtos_populares as $index => $produto): 
                            ?>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-wood-brown text-white w-6 h-6 rounded-full flex items-center justify-center text-sm font-bold">
                                        <?= $index + 1 ?>
                                    </div>
                                    <span class="font-medium text-gray-900"><?= $produto['nome'] ?></span>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-gray-900"><?= number_format($produto['visualizacoes']) ?></div>
                                    <div class="text-sm text-green-600"><?= $produto['crescimento'] ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- System Status -->
            <div class="mt-8">
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Status do Sistema</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="flex items-center space-x-3">
                                <div class="bg-green-100 text-green-600 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i data-lucide="server" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Servidor</div>
                                    <div class="text-sm text-green-600">Online - 99.9% uptime</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <div class="bg-green-100 text-green-600 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i data-lucide="database" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Banco de Dados</div>
                                    <div class="text-sm text-green-600">Conectado - 45ms latência</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <div class="bg-yellow-100 text-yellow-600 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i data-lucide="shield" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Backup</div>
                                    <div class="text-sm text-yellow-600">Último: há 2 horas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false"></div>

<script>
// Auto-refresh stats every 30 seconds
setInterval(() => {
    fetch('/api/admin/stats')
        .then(response => response.json())
        .then(data => {
            Alpine.store('dashboard').stats = data;
        })
        .catch(error => console.log('Erro ao atualizar estatísticas:', error));
}, 30000);

// Initialize Lucide icons
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});
</script>