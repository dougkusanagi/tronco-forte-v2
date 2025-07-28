<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Gerenciar Produtos</h1>
                    <p class="text-gray-600 mt-1">Adicione, edite e gerencie os produtos do catálogo</p>
                </div>
                <button class="bg-wood-brown text-white px-6 py-3 rounded-lg hover:bg-wood-dark transition-colors font-medium" 
                        @click="modalNovoProduto = true">
                    <i data-lucide="plus" class="w-4 h-4 inline mr-2"></i>
                    Novo Produto
                </button>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Produtos</label>
                    <input type="text" x-model="busca" placeholder="Nome, código ou descrição..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                    <select x-model="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="">Todas as Categorias</option>
                        <?php foreach ($categorias as $cat): ?>
                        <option value="<?= strtolower(str_replace(' ', '-', $cat)) ?>"><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select x-model="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        <option value="">Todos os Status</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                        <option value="esgotado">Esgotado</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button @click="busca = ''; categoria = ''; status = '';" 
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                        Limpar Filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Lista de Produtos -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden" x-data="{
            produtos: <?= json_encode($produtos) ?>,
            modalNovoProduto: false,
            modalEditarProduto: false,
            produtoSelecionado: null,
            novoProduto: {
                nome: '',
                categoria: '',
                preco: '',
                descricao: '',
                especificacoes: '',
                disponibilidade: 'disponivel'
            }
        }">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="produto in produtos" :key="produto.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-lg bg-wood-brown flex items-center justify-center mr-4">
                                            <i data-lucide="tree-pine" class="w-6 h-6 text-white"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900" x-text="produto.nome"></div>
                                            <div class="text-sm text-gray-500" x-text="'ID: ' + produto.id"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" x-text="produto.categoria"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="'R$ ' + produto.preco.toLocaleString('pt-BR', {minimumFractionDigits: 2}) + '/m³'"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="{
                                        'bg-green-100 text-green-800': produto.status === 'Ativo',
                                        'bg-red-100 text-red-800': produto.status === 'Inativo',
                                        'bg-yellow-100 text-yellow-800': produto.estoque === 'Baixo'
                                    }" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" x-text="produto.status"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button @click="produtoSelecionado = produto; modalEditarProduto = true" 
                                                class="text-wood-brown hover:text-wood-dark">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Modal Novo Produto -->
            <div x-show="modalNovoProduto" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-cloak>
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Novo Produto</h3>
                        <button @click="modalNovoProduto = false" class="text-gray-400 hover:text-gray-600">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    
                    <form @submit.prevent="salvarProduto()" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Produto</label>
                                <input type="text" x-model="novoProduto.nome" required 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                                <select x-model="novoProduto.categoria" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                                    <option value="">Selecione uma categoria</option>
                                    <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= strtolower(str_replace(' ', '-', $cat)) ?>"><?= $cat ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preço por m³ (R$)</label>
                                <input type="number" x-model="novoProduto.preco" step="0.01" required 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Disponibilidade</label>
                                <select x-model="novoProduto.disponibilidade" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                                    <option value="disponivel">Disponível</option>
                                    <option value="sob-consulta">Sob Consulta</option>
                                    <option value="esgotado">Esgotado</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                            <textarea x-model="novoProduto.descricao" rows="3" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Especificações Técnicas</label>
                            <textarea x-model="novoProduto.especificacoes" rows="4" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent"></textarea>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" @click="modalNovoProduto = false" 
                                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-wood-brown text-white rounded-lg hover:bg-wood-dark transition-colors">
                                Salvar Produto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal Editar Produto -->
            <div x-show="modalEditarProduto" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-cloak>
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Editar Produto</h3>
                        <button @click="modalEditarProduto = false" class="text-gray-400 hover:text-gray-600">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    
                    <form @submit.prevent="atualizarProduto()" class="space-y-4">
                        <input type="hidden" x-model="produtoSelecionado.id">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Produto</label>
                                <input type="text" x-model="produtoSelecionado.nome" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                                <select x-model="produtoSelecionado.categoria" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                                    <option value="">Selecione uma categoria</option>
                                    <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= strtolower(str_replace(' ', '-', $cat)) ?>"><?= $cat ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preço por m³ (R$)</label>
                                <input type="number" x-model="novoProduto.preco" step="0.01" required 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Disponibilidade</label>
                                <select x-model="novoProduto.disponibilidade" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                                    <option value="disponivel">Disponível</option>
                                    <option value="sob-consulta">Sob Consulta</option>
                                    <option value="esgotado">Esgotado</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                            <textarea x-model="novoProduto.descricao" rows="3" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Especificações Técnicas</label>
                            <textarea x-model="novoProduto.especificacoes" rows="4" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent"></textarea>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" @click="modalEditarProduto = false" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-wood-brown text-white rounded-lg hover:bg-wood-dark transition-colors">Atualizar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function salvarProduto() {
    try {
        const response = await fetch('/admin/produtos/salvar', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(this.novoProduto)
        });
        const result = await response.json();
        if (result.success) {
            alert(result.message);
            location.reload();
        } else {
            alert('Erro: ' + result.message);
        }
    } catch (error) {
        alert('Erro ao salvar produto');
    }
    this.modalNovoProduto = false;
    this.novoProduto = {nome: '', categoria: '', preco: '', descricao: '', especificacoes: '', disponibilidade: 'disponivel'};
}
async function atualizarProduto() {
    try {
        const response = await fetch('/admin/produtos/salvar', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(this.produtoSelecionado)
        });
        const result = await response.json();
        if (result.success) {
            alert(result.message);
            location.reload();
        } else {
            alert('Erro: ' + result.message);
        }
    } catch (error) {
        alert('Erro ao atualizar produto');
    }
    this.modalEditarProduto = false;
}
async function excluirProduto(id) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        try {
            const response = await fetch('/admin/produtos/excluir', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: id})
            });
            const result = await response.json();
            if (result.success) {
                alert(result.message);
                location.reload();
            } else {
                alert('Erro: ' + result.message);
            }
        } catch (error) {
            alert('Erro ao excluir produto');
        }
    }
}
</script>