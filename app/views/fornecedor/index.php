<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-display font-bold text-gray-900 mb-4">Fornecedores Parceiros</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Conecte-se com nossa rede de fornecedores especializados em madeira de qualidade. 
                Encontre o parceiro ideal para seu projeto.
            </p>
        </div>
        
        <!-- Data Script -->
        <script>
            window.fornecedoresData = {
                fornecedores: <?= json_encode($fornecedores, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>,
                regioes: <?= json_encode(array_values($regioes), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>,
                regioesObj: <?= json_encode($regioes, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>,
                especialidades: <?= json_encode(array_values($especialidades), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>,
                especialidadesObj: <?= json_encode($especialidades, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>
            };
        </script>
        
        <!-- Filtros e Grid de Fornecedores -->
        <div x-data="{
            busca: '',
            regiao: '',
            especialidade: '',
            fornecedores: window.fornecedoresData.fornecedores,
            regioes: window.fornecedoresData.regioes,
            regioesObj: window.fornecedoresData.regioesObj,
            especialidades: window.fornecedoresData.especialidades,
            especialidadesObj: window.fornecedoresData.especialidadesObj,
            get fornecedoresFiltrados() {
                return this.fornecedores.filter(fornecedor => {
                    const matchBusca = !this.busca ||
                        (fornecedor.nome && fornecedor.nome.toLowerCase().includes(this.busca.toLowerCase())) ||
                        (fornecedor.descricao && fornecedor.descricao.toLowerCase().includes(this.busca.toLowerCase()));
                    const matchRegiao = !this.regiao || fornecedor.regiao === this.regiao;
                    const matchEspecialidade = !this.especialidade ||
                        (fornecedor.especialidades && fornecedor.especialidades.includes(this.especialidade));
                    return matchBusca && matchRegiao && matchEspecialidade;
                });
            }
        }">
            <!-- Filtros -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Busca -->
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="text" x-model="busca" placeholder="Buscar fornecedores..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                    </div>
                    
                    <!-- Região -->
                    <div class="relative">
                        <select x-model="regiao" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent appearance-none bg-white">
                            <option value="">Todas as Regiões</option>
                            <template x-for="(label, value) in regioesObj" :key="value">
                                <option :value="value" x-text="label" x-show="value !== 'todas'"></option>
                            </template>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                    </div>
                    
                    <!-- Especialidade -->
                    <div class="relative">
                        <select x-model="especialidade" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent appearance-none bg-white">
                            <option value="">Todas as Especialidades</option>
                            <template x-for="(label, value) in especialidadesObj" :key="value">
                                <option :value="value" x-text="label" x-show="value !== 'todas'"></option>
                            </template>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                    </div>
                    
                    <!-- Botão Limpar -->
                    <button @click="busca = ''; regiao = ''; especialidade = '';" 
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg transition-colors font-medium">
                        <i data-lucide="x" class="w-4 h-4 inline mr-2"></i>
                        Limpar Filtros
                    </button>
                </div>
                
                <!-- Contador de Resultados -->
                <div class="mt-4 text-sm text-gray-600">
                    <span x-text="fornecedoresFiltrados.length"></span> fornecedores encontrados
                </div>
            </div>
            
            <!-- Grid de Fornecedores -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="fornecedor in fornecedoresFiltrados" :key="fornecedor.id">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <!-- Header do Card -->
                        <div class="relative">
                            <img :src="fornecedor.imagem || fornecedor.banner" :alt="fornecedor.nome" class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4">
                                <span class="bg-forest-green text-white px-3 py-1 rounded-full text-sm font-medium" x-text="regioesObj[fornecedor.regiao] || fornecedor.regiao"></span>
                            </div>
                            <div class="absolute bottom-4 left-4">
                                <div class="flex items-center space-x-1">
                                    <template x-for="i in 5" :key="i">
                                        <i data-lucide="star" :class="i <= fornecedor.avaliacao ? 'text-yellow-400 fill-current' : 'text-gray-300'" class="w-4 h-4"></i>
                                    </template>
                                    <span class="text-white text-sm ml-2" x-text="fornecedor.avaliacao"></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Conteúdo do Card -->
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2" x-text="fornecedor.nome"></h3>
                                    <p class="text-gray-600 text-sm line-clamp-2" x-text="fornecedor.descricao"></p>
                                </div>
                                <div class="flex items-center space-x-1 text-green-600">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    <span class="text-xs font-medium">Verificado</span>
                                </div>
                            </div>
                            
                            <!-- Especialidades -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="especialidade in (fornecedor.especialidades || []).slice(0, 3)" :key="especialidade">
                                        <span class="bg-wood-light text-wood-brown px-2 py-1 rounded text-xs font-medium" x-text="especialidade"></span>
                                    </template>
                                    <span x-show="fornecedor.especialidades && fornecedor.especialidades.length > 3" class="text-gray-500 text-xs" x-text="'+' + (fornecedor.especialidades.length - 3) + ' mais'"></span>
                                </div>
                            </div>
                            
                            <!-- Certificações -->
                            <div class="mb-4" x-show="fornecedor.certificacoes && Array.isArray(fornecedor.certificacoes) && fornecedor.certificacoes.length > 0">
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="award" class="w-4 h-4 text-green-600"></i>
                                    <span class="text-sm text-gray-600">Certificações:</span>
                                    <div class="flex space-x-1">
                                        <template x-for="cert in (fornecedor.certificacoes || []).slice(0, 2)" :key="cert">
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium" x-text="cert"></span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Informações de Contato -->
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center space-x-2 text-gray-600">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                    <span class="text-sm" x-text="fornecedor.cidade + (fornecedor.estado ? ', ' + fornecedor.estado : '')"></span>
                                </div>
                                <div class="flex items-center space-x-2 text-gray-600" x-show="fornecedor.telefone">
                                    <i data-lucide="phone" class="w-4 h-4"></i>
                                    <span class="text-sm" x-text="fornecedor.telefone"></span>
                                </div>
                                <div class="flex items-center space-x-2 text-gray-600" x-show="fornecedor.email">
                                    <i data-lucide="mail" class="w-4 h-4"></i>
                                    <span class="text-sm" x-text="fornecedor.email"></span>
                                </div>
                            </div>
                            
                            <!-- Links Rápidos -->
                            <div class="grid grid-cols-2 gap-2 mb-4" x-show="fornecedor.links && Array.isArray(fornecedor.links) && fornecedor.links.length > 0">
                                <template x-for="link in (fornecedor.links || []).slice(0, 4)" :key="link.tipo">
                                    <a :href="'/fornecedor/' + fornecedor.slug + '/link/' + link.tipo" 
                                       class="flex items-center justify-center space-x-2 bg-gray-50 hover:bg-gray-100 text-gray-700 py-2 px-3 rounded-lg transition-colors text-sm">
                                        <i :data-lucide="link.icone" class="w-4 h-4"></i>
                                        <span x-text="link.titulo"></span>
                                    </a>
                                </template>
                            </div>
                            
                            <!-- Ações -->
                            <div class="flex space-x-3">
                                <a :href="'/fornecedor/' + fornecedor.slug" 
                                   class="flex-1 bg-wood-brown text-white text-center py-3 px-4 rounded-lg hover:bg-wood-dark transition-colors font-medium">
                                    Ver Perfil
                                </a>
                                <button class="bg-green-600 text-white p-3 rounded-lg hover:bg-green-700 transition-colors">
                                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Mensagem quando não há resultados -->
            <div x-show="fornecedoresFiltrados.length === 0" class="text-center py-16">
                <i data-lucide="search-x" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Nenhum fornecedor encontrado</h3>
                <p class="text-gray-600 mb-6">Tente ajustar os filtros para encontrar mais resultados.</p>
                <button @click="busca = ''; regiao = ''; especialidade = '';" 
                        class="bg-wood-brown text-white px-6 py-3 rounded-lg hover:bg-wood-dark transition-colors font-medium">
                    Limpar Filtros
                </button>
            </div>
        </div> <!-- FIM DA DIV DO ALPINE.JS -->
    </div>
</div>

<!-- Estatísticas da Rede -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-display font-bold text-gray-900 mb-4">Nossa Rede de Parceiros</h2>
            <p class="text-xl text-gray-600">
                Conectamos você aos melhores fornecedores de madeira do Brasil
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-forest-green text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2"><?= count($fornecedores) ?>+</div>
                <div class="text-gray-600">Fornecedores Ativos</div>
            </div>
            
            <div class="text-center">
                <div class="bg-wood-brown text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="map-pin" class="w-8 h-8"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2"><?= count($regioes) ?></div>
                <div class="text-gray-600">Regiões Cobertas</div>
            </div>
            
            <div class="text-center">
                <div class="bg-green-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="award" class="w-8 h-8"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">95%</div>
                <div class="text-gray-600">Fornecedores Certificados</div>
            </div>
            
            <div class="text-center">
                <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="star" class="w-8 h-8"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">4.8</div>
                <div class="text-gray-600">Avaliação Média</div>
            </div>
        </div>
    </div>
</section>

<!-- Como Funciona -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-display font-bold text-gray-900 mb-4">Como Funciona</h2>
            <p class="text-xl text-gray-600">
                Conecte-se com fornecedores em 3 passos simples
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-wood-brown text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-2xl font-bold">1</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Encontre o Fornecedor</h3>
                <p class="text-gray-600">
                    Use nossos filtros para encontrar fornecedores por região, especialidade ou tipo de madeira.
                </p>
            </div>
            
            <div class="text-center">
                <div class="bg-wood-brown text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-2xl font-bold">2</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Acesse o Perfil</h3>
                <p class="text-gray-600">
                    Veja informações detalhadas, certificações, produtos e formas de contato do fornecedor.
                </p>
            </div>
            
            <div class="text-center">
                <div class="bg-wood-brown text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-2xl font-bold">3</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Conecte-se Diretamente</h3>
                <p class="text-gray-600">
                    Entre em contato através dos canais disponíveis: WhatsApp, e-mail, telefone ou redes sociais.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA para Fornecedores -->
<section class="py-16 bg-wood-brown text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-display font-bold mb-4">É Fornecedor de Madeira?</h2>
        <p class="text-xl text-gray-200 mb-8">
            Junte-se à nossa rede de parceiros e conecte-se com milhares de clientes em potencial.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/admin/fornecedores/novo" class="bg-white text-wood-brown px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors font-semibold">
                Cadastrar Empresa
            </a>
            <a href="/contato" class="border-2 border-white text-white px-8 py-4 rounded-lg hover:bg-white hover:text-wood-brown transition-colors font-semibold">
                Falar com Consultor
            </a>
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
</style>