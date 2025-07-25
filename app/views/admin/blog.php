<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Gerenciar Blog</h1>
                    <p class="text-gray-600 mt-1">Crie, edite e gerencie artigos do blog técnico</p>
                </div>
                <a href="/admin/blog/novo" class="bg-wood-brown text-white px-6 py-3 rounded-lg hover:bg-wood-dark transition-colors font-medium inline-flex items-center">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Novo Artigo
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8" x-data="{
            busca: '',
            categoria: '',
            status: ''
        }">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" x-model="busca" placeholder="Título do artigo..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                    <select x-model="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="">Todas as categorias</option>
                        <?php foreach ($categorias_blog as $categoria): ?>
                        <option value="<?= $categoria ?>"><?= $categoria ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select x-model="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="">Todos os status</option>
                        <option value="Publicado">Publicado</option>
                        <option value="Rascunho">Rascunho</option>
                        <option value="Agendado">Agendado</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                        <i data-lucide="filter-x" class="w-4 h-4 inline mr-2"></i>
                        Limpar Filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Lista de Artigos -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artigo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualizações</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($artigos as $artigo): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-wood-brown flex items-center justify-center">
                                            <i data-lucide="file-text" class="w-5 h-5 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 max-w-xs truncate"><?= htmlspecialchars($artigo['titulo']) ?></div>
                                        <div class="text-sm text-gray-500">Por <?= htmlspecialchars($artigo['autor']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($artigo['categoria']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?= $artigo['status'] === 'Publicado' ? 'bg-green-100 text-green-800' : 
                                        ($artigo['status'] === 'Rascunho' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') ?>">
                                    <?= htmlspecialchars($artigo['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= number_format($artigo['visualizacoes']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= $artigo['data_publicacao'] ? date('d/m/Y', strtotime($artigo['data_publicacao'])) : '-' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="/admin/blog/editar/<?= $artigo['id'] ?>" class="text-wood-brown hover:text-wood-dark" title="Editar">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <a href="/blog/<?= $artigo['slug'] ?? '#' ?>" target="_blank" class="text-blue-600 hover:text-blue-900" title="Visualizar">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <button onclick="excluirArtigo(<?= $artigo['id'] ?>, '<?= htmlspecialchars($artigo['titulo'], ENT_QUOTES) ?>')" class="text-red-600 hover:text-red-900" title="Excluir">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Estatísticas do Blog -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total de Artigos</p>
                        <p class="text-2xl font-semibold text-gray-900"><?= count($artigos) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="eye" class="w-5 h-5 text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total de Visualizações</p>
                        <p class="text-2xl font-semibold text-gray-900"><?= number_format(array_sum(array_column($artigos, 'visualizacoes'))) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="edit-3" class="w-5 h-5 text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Rascunhos</p>
                        <p class="text-2xl font-semibold text-gray-900"><?= count(array_filter($artigos, fn($a) => $a['status'] === 'Rascunho')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
    
    // Function to delete article
    async function excluirArtigo(id, titulo) {
        if (!confirm(`Tem certeza que deseja excluir o artigo "${titulo}"? Esta ação não pode ser desfeita.`)) {
            return;
        }
        
        try {
            const response = await fetch('/api/admin/artigo', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id })
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert(result.message);
                location.reload(); // Reload the page to update the list
            } else {
                alert('Erro: ' + result.message);
            }
        } catch (error) {
            console.error('Erro ao excluir artigo:', error);
            alert('Erro ao excluir artigo. Tente novamente.');
        }
    }
</script>