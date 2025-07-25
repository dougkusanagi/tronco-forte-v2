<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto p-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Relatórios e Analytics</h1>
                    <p class="text-gray-600 mt-1">Acompanhe o desempenho do site e dos negócios</p>
                </div>
                <div class="flex space-x-3">
                    <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                        <i data-lucide="download" class="w-4 h-4 inline mr-2"></i>
                        Exportar
                    </button>
                    <button class="bg-wood-brown text-white px-4 py-2 rounded-lg hover:bg-wood-dark transition-colors">
                        <i data-lucide="refresh-cw" class="w-4 h-4 inline mr-2"></i>
                        Atualizar
                    </button>
                </div>
            </div>
        </div>

        <!-- Métricas do Site -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Métricas do Site</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="eye" class="w-5 h-5 text-blue-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Pageviews (Mês)</p>
                            <p class="text-2xl font-semibold text-gray-900"><?= number_format($metricas_site['pageviews_mes']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="users" class="w-5 h-5 text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Usuários Únicos</p>
                            <p class="text-2xl font-semibold text-gray-900"><?= number_format($metricas_site['usuarios_unicos']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="trending-down" class="w-5 h-5 text-red-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Taxa de Rejeição</p>
                            <p class="text-2xl font-semibold text-gray-900"><?= $metricas_site['taxa_rejeicao'] ?>%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="clock" class="w-5 h-5 text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Tempo Médio</p>
                            <p class="text-2xl font-semibold text-gray-900"><?= $metricas_site['tempo_medio_sessao'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Páginas Mais Visitadas -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Páginas Mais Visitadas</h3>
                <div class="space-y-4">
                    <?php foreach ($metricas_site['paginas_mais_visitadas'] as $pagina): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i data-lucide="file" class="w-5 h-5 text-gray-400 mr-3"></i>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($pagina['pagina']) ?></span>
                        </div>
                        <span class="text-sm font-semibold text-wood-brown"><?= number_format($pagina['visualizacoes']) ?> views</span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Relatórios de Vendas e Fornecedores -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Relatório de Vendas -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Relatório de Vendas</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Orçamentos (Mês)</span>
                        <span class="font-semibold text-gray-900"><?= $relatorio_vendas['orcamentos_mes'] ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Taxa de Conversão</span>
                        <span class="font-semibold text-gray-900"><?= $relatorio_vendas['conversao_orcamentos'] ?>%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Ticket Médio</span>
                        <span class="font-semibold text-gray-900"><?= $relatorio_vendas['ticket_medio'] ?></span>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Produtos Mais Cotados</h4>
                    <div class="space-y-2">
                        <?php foreach ($relatorio_vendas['produtos_mais_cotados'] as $produto): ?>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600"><?= htmlspecialchars($produto['produto']) ?></span>
                            <span class="font-medium text-gray-900"><?= $produto['cotacoes'] ?> cotações</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Relatório de Fornecedores -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Relatório de Fornecedores</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total de Cliques</span>
                        <span class="font-semibold text-gray-900"><?= number_format($relatorio_fornecedores['total_cliques']) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Mais Acessado</span>
                        <span class="font-semibold text-gray-900"><?= htmlspecialchars($relatorio_fornecedores['fornecedor_mais_acessado']) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Região Mais Ativa</span>
                        <span class="font-semibold text-gray-900"><?= htmlspecialchars($relatorio_fornecedores['regiao_mais_ativa']) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Crescimento (Mês)</span>
                        <span class="font-semibold text-green-600">+<?= $relatorio_fornecedores['crescimento_mes'] ?>%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Performance -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance Mensal</h3>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center">
                    <i data-lucide="bar-chart-3" class="w-12 h-12 text-gray-400 mx-auto mb-2"></i>
                    <p class="text-gray-500">Gráfico de performance seria implementado aqui</p>
                    <p class="text-sm text-gray-400">Integração com Chart.js ou similar</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>