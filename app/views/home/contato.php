<!-- Hero Section -->
<section class="relative bg-cover bg-center text-white overflow-hidden" style="background-image: url('https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20contact%20us%20background%20wood%20industry%20office%20team&image_size=landscape_16_9');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 text-center">
        <h1 class="text-4xl lg:text-6xl font-display font-bold leading-tight">
            Entre em Contato
        </h1>
        <p class="text-xl lg:text-2xl text-gray-200 leading-relaxed mt-4">
            Fale com nossos especialistas e descubra a madeira ideal para seu projeto.
        </p>
    </div>
</section>

<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-display font-bold text-gray-900 mb-4">Entre em Contato</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Fale com nossos especialistas e descubra a madeira ideal para seu projeto. Atendimento personalizado e orçamentos sem compromisso.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Formulário de Contato -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Solicite seu Orçamento</h2>
                
                <form class="space-y-6" x-data="contatoForm()" @submit.prevent="enviarFormulario()">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                            <input type="text" x-model="form.nome" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                            <input type="text" x-model="form.empresa" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                            <input type="email" x-model="form.email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Telefone *</label>
                            <input type="tel" x-model="form.telefone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Projeto</label>
                        <select x-model="form.tipo_projeto" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                            <option value="">Selecione o tipo de projeto</option>
                            <option value="construcao_civil">Construção Civil</option>
                            <option value="marcenaria">Marcenaria</option>
                            <option value="deck">Deck/Área Externa</option>
                            <option value="estrutural">Estrutural</option>
                            <option value="acabamento">Acabamento</option>
                            <option value="outros">Outros</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mensagem *</label>
                        <textarea x-model="form.mensagem" required rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent" placeholder="Descreva seu projeto, quantidade necessária e outras informações relevantes..."></textarea>
                    </div>
                    
                    <button type="submit" :disabled="enviando" class="w-full bg-wood-brown text-white py-3 px-6 rounded-lg font-semibold hover:bg-wood-brown-dark transition-colors disabled:opacity-50">
                        <span x-show="!enviando">Enviar Solicitação</span>
                        <span x-show="enviando" class="flex items-center justify-center">
                            <i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i>
                            Enviando...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Informações de Contato -->
            <div class="space-y-8">
                <!-- Contato Direto -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Fale Conosco Diretamente</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="bg-wood-brown/10 p-3 rounded-lg mr-4">
                                <i data-lucide="phone" class="w-5 h-5 text-wood-brown"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Telefone</p>
                                <p class="text-gray-600">(11) 3456-7890</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="bg-wood-brown/10 p-3 rounded-lg mr-4">
                                <i data-lucide="message-circle" class="w-5 h-5 text-wood-brown"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">WhatsApp</p>
                                <p class="text-gray-600">(11) 99999-8888</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="bg-wood-brown/10 p-3 rounded-lg mr-4">
                                <i data-lucide="mail" class="w-5 h-5 text-wood-brown"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">E-mail</p>
                                <p class="text-gray-600">contato@troncoforte.com.br</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-wood-brown/10 p-3 rounded-lg mr-4">
                                <i data-lucide="map-pin" class="w-5 h-5 text-wood-brown"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Endereço</p>
                                <p class="text-gray-600">Rua das Madeiras, 123<br>Distrito Industrial<br>São Paulo - SP, 01234-567</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horário de Funcionamento -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Horário de Funcionamento</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Segunda a Sexta</span>
                            <span class="font-semibold text-gray-900">7:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sábado</span>
                            <span class="font-semibold text-gray-900">7:00 - 12:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Domingo</span>
                            <span class="font-semibold text-gray-900">Fechado</span>
                        </div>
                    </div>
                </div>

                <!-- Certificações -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Nossas Certificações</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-2 flex items-center justify-center">
                                <i data-lucide="shield-check" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <p class="font-semibold text-sm">FSC</p>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-2 flex items-center justify-center">
                                <i data-lucide="leaf" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <p class="font-semibold text-sm">IBAMA</p>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-2 flex items-center justify-center">
                                <i data-lucide="award" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <p class="font-semibold text-sm">PEFC</p>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-2 flex items-center justify-center">
                                <i data-lucide="globe" class="w-6 h-6 text-green-600"></i>
                            </div>
                            <p class="font-semibold text-sm">CITES</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function contatoForm() {
    return {
        enviando: false,
        form: {
            nome: '',
            empresa: '',
            email: '',
            telefone: '',
            tipo_projeto: '',
            mensagem: ''
        },
        
        async enviarFormulario() {
            this.enviando = true;
            
            try {
                const response = await fetch('/api/contato', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });
                
                if (response.ok) {
                    alert('Mensagem enviada com sucesso! Entraremos em contato em breve.');
                    this.form = {
                        nome: '',
                        empresa: '',
                        email: '',
                        telefone: '',
                        tipo_projeto: '',
                        mensagem: ''
                    };
                } else {
                    alert('Erro ao enviar mensagem. Tente novamente.');
                }
            } catch (error) {
                alert('Erro ao enviar mensagem. Tente novamente.');
            } finally {
                this.enviando = false;
            }
        }
    }
}
</script>