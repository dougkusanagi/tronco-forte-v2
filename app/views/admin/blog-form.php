<?php

use app\utils\UrlHelper;
?>
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900"><?= $artigo ? 'Editar Artigo' : 'Novo Artigo' ?></h1>
                    <p class="text-gray-600 mt-1"><?= $artigo ? 'Edite as informações do artigo' : 'Crie um novo artigo para o blog' ?></p>
                </div>
                <a href="/admin/blog" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 inline mr-2"></i>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Form -->
        <form id="articleForm" class="space-y-8">
            <?php
            if ($artigo): ?>
                <input type="hidden" name="id" value="<?= $artigo['id'] ?>">
            <?php endif; ?>

            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Informações Básicas</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                        <input type="text" id="title" name="title" required
                            value="<?= htmlspecialchars($artigo['title'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent"
                            placeholder="Digite o título do artigo">
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                        <select id="category_id" name="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                            <option value="">Selecione uma categoria</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id'] ?? '' ?>" <?= ($artigo['category_id'] ?? '') == ($categoria['id'] ?? '') ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($categoria['name'] ?? $categoria) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent">
                            <option value="draft" <?= ($artigo['status'] ?? 'draft') == 'draft' ? 'selected' : '' ?>>Rascunho</option>
                            <option value="published" <?= ($artigo['status'] ?? '') == 'published' ? 'selected' : '' ?>>Publicado</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Resumo</label>
                        <textarea id="excerpt" name="excerpt" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent"
                            placeholder="Breve descrição do artigo (opcional)"><?= htmlspecialchars($artigo['excerpt'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Conteúdo</h2>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Conteúdo do Artigo *</label>
                    <textarea id="content" name="content" rows="20" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-wood-brown focus:border-transparent"
                        placeholder="Digite o conteúdo do artigo em HTML ou Markdown"><?= htmlspecialchars($artigo['content'] ?? '') ?></textarea>
                    <p class="text-sm text-gray-500 mt-2">Você pode usar HTML ou Markdown para formatar o conteúdo.</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <?php if ($artigo): ?>
                            Última atualização: <?= date('d/m/Y H:i', strtotime($artigo['updated_at'])) ?>
                        <?php endif; ?>
                    </div>
                    <div class="flex space-x-4">
                        <button type="button" onclick="salvarRascunho()"
                            class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                            Salvar como Rascunho
                        </button>
                        <button type="submit"
                            class="bg-wood-brown text-white px-6 py-2 rounded-lg hover:bg-wood-dark transition-colors">
                            <?= $artigo ? 'Atualizar Artigo' : 'Publicar Artigo' ?>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Form submission
    document.getElementById('articleForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        await salvarArtigo('published');
    });

    // Save as draft
    async function salvarRascunho() {
        await salvarArtigo('draft');
    }

    // Save article function
    async function salvarArtigo(status) {
        const form = document.getElementById('articleForm');
        const formData = new FormData(form);

        // Set status
        formData.set('status', status);

        // Convert FormData to JSON
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        try {
            const response = await fetch(<?= UrlHelper::url('/api/admin/artigo') ?>, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                window.location.href = <?= UrlHelper::url('/admin/blog'); ?>;
            } else {
                alert('Erro: ' + result.message);
            }
        } catch (error) {
            console.error('Erro ao salvar artigo:', error);
            alert('Erro ao salvar artigo. Tente novamente.');
        }
    }
</script>