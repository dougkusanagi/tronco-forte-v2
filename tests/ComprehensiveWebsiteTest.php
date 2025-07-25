<?php

/**
 * Comprehensive Website Test Suite
 * Tests all pages, forms, and functionality of the Tronco Forte website
 */
class ComprehensiveWebsiteTest
{
    private $baseUrl;
    private $passed = 0;
    private $failed = 0;
    private $errors = [];

    public function __construct($baseUrl = 'http://localhost:8080')
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Run all tests
     */
    public function runAllTests(): void
    {
        echo "\n=== Tronco Forte Website Test Suite ===\n\n";
        
        $this->testPublicPages();
        $this->testAdminPages();
        $this->testApiEndpoints();
        $this->testFormSubmissions();
        $this->testErrorHandling();
        
        $this->printResults();
    }

    /**
     * Test all public pages
     */
    private function testPublicPages(): void
    {
        echo "Testing Public Pages...\n";
        
        $pages = [
            '/' => 'Home Page',
            '/catalogo' => 'Catálogo',
            '/blog' => 'Blog',
            '/fornecedores' => 'Fornecedores',
            '/contato' => 'Contato',
            '/sobre' => 'Sobre'
        ];

        foreach ($pages as $path => $name) {
            $this->testPage($path, $name);
        }
    }

    /**
     * Test admin pages
     */
    private function testAdminPages(): void
    {
        echo "\nTesting Admin Pages...\n";
        
        $adminPages = [
            '/admin' => 'Admin Dashboard',
            '/admin/dashboard' => 'Admin Dashboard Alt',
            '/admin/produtos' => 'Admin Produtos',
            '/admin/fornecedores' => 'Admin Fornecedores',
            '/admin/blog' => 'Admin Blog',
            '/admin/relatorios' => 'Admin Relatórios',
            '/admin/configuracoes' => 'Admin Configurações'
        ];

        foreach ($adminPages as $path => $name) {
            $this->testPage($path, $name);
        }
    }

    /**
     * Test API endpoints
     */
    private function testApiEndpoints(): void
    {
        echo "\nTesting API Endpoints...\n";
        
        // Test volume calculator API
        $this->testApiEndpoint('/api/calcular-volume', 'POST', [
            'comprimento' => 2.5,
            'largura' => 1.2,
            'altura' => 0.05
        ], 'Volume Calculator API');
        
        // Test wood quiz API
        $this->testApiEndpoint('/api/quiz-madeira', 'POST', [
            'respostas' => ['estrutural', 'resistencia']
        ], 'Wood Quiz API');
        
        // Test catalog filter API
        $this->testApiEndpoint('/api/catalogo/filtrar', 'POST', [
            'categoria' => 'Estrutural',
            'preco_max' => 1000
        ], 'Catalog Filter API');
        
        // Test blog search API
        $this->testApiEndpoint('/api/blog/buscar', 'POST', [
            'termo' => 'madeira'
        ], 'Blog Search API');
        
        // Test supplier filter API
        $this->testApiEndpoint('/api/fornecedores/filtrar', 'POST', [
            'regiao' => 'Sudeste'
        ], 'Supplier Filter API');
    }

    /**
     * Test form submissions
     */
    private function testFormSubmissions(): void
    {
        echo "\nTesting Form Submissions...\n";
        
        // Test admin product save
        $this->testApiEndpoint('/api/admin/produto', 'POST', [
            'nome' => 'Teste Produto',
            'categoria' => 'Estrutural',
            'preco' => 500,
            'descricao' => 'Produto de teste',
            'especificacoes' => 'Especificações de teste',
            'disponibilidade' => 'disponivel'
        ], 'Admin Product Save');
        
        // Test admin supplier save
        $this->testApiEndpoint('/api/admin/fornecedor', 'POST', [
            'nome' => 'Teste Fornecedor',
            'slug' => 'teste-fornecedor',
            'descricao' => 'Fornecedor de teste',
            'regiao' => 'Sudeste',
            'cidade' => 'São Paulo',
            'especialidades' => ['Estrutural'],
            'links' => []
        ], 'Admin Supplier Save');
        
        // Test admin article save
        $this->testApiEndpoint('/api/admin/artigo', 'POST', [
            'titulo' => 'Teste Artigo',
            'slug' => 'teste-artigo',
            'categoria' => 'Técnico',
            'resumo' => 'Resumo de teste',
            'conteudo' => 'Conteúdo de teste',
            'tags' => ['teste'],
            'em_destaque' => false
        ], 'Admin Article Save');
    }

    /**
     * Test error handling
     */
    private function testErrorHandling(): void
    {
        echo "\nTesting Error Handling...\n";
        
        // Test 404 pages
        $this->testPage('/pagina-inexistente', '404 Error Page', 404);
        $this->testPage('/catalogo/produto-inexistente', '404 Product Page', 404);
        $this->testPage('/blog/artigo-inexistente', '404 Blog Article', 404);
        $this->testPage('/fornecedor/fornecedor-inexistente', '404 Supplier Page', 404);
    }

    /**
     * Test a single page
     */
    private function testPage(string $path, string $name, int $expectedStatus = 200): void
    {
        $url = $this->baseUrl . $path;
        $response = $this->makeRequest($url);
        
        if ($response['status'] === $expectedStatus) {
            $this->passed++;
            echo "✓ {$name} - OK\n";
            
            // Additional checks for 200 responses
            if ($expectedStatus === 200) {
                $this->validatePageContent($response['body'], $name);
            }
        } else {
            $this->failed++;
            $error = "✗ {$name} - Expected status {$expectedStatus}, got {$response['status']}";
            echo $error . "\n";
            $this->errors[] = $error;
        }
    }

    /**
     * Test an API endpoint
     */
    private function testApiEndpoint(string $path, string $method, array $data, string $name): void
    {
        $url = $this->baseUrl . $path;
        $response = $this->makeRequest($url, $method, $data);
        
        if ($response['status'] === 200) {
            $this->passed++;
            echo "✓ {$name} - OK\n";
            
            // Try to decode JSON response
            $json = json_decode($response['body'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->errors[] = "Warning: {$name} - Response is not valid JSON";
            }
        } else {
            $this->failed++;
            $error = "✗ {$name} - Status: {$response['status']}";
            echo $error . "\n";
            $this->errors[] = $error;
        }
    }

    /**
     * Validate page content
     */
    private function validatePageContent(string $body, string $pageName): void
    {
        // Check for basic HTML structure
        if (!str_contains($body, '<html') || !str_contains($body, '</html>')) {
            $this->errors[] = "Warning: {$pageName} - Missing HTML structure";
        }
        
        // Check for title tag
        if (!str_contains($body, '<title>')) {
            $this->errors[] = "Warning: {$pageName} - Missing title tag";
        }
        
        // Check for meta viewport (responsive design)
        if (!str_contains($body, 'viewport')) {
            $this->errors[] = "Warning: {$pageName} - Missing viewport meta tag";
        }
        
        // Check for Tailwind CSS
        if (!str_contains($body, 'tailwindcss') && !str_contains($body, 'class=')) {
            $this->errors[] = "Warning: {$pageName} - Tailwind CSS may not be loaded";
        }
    }

    /**
     * Make HTTP request
     */
    private function makeRequest(string $url, string $method = 'GET', array $data = []): array
    {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json, text/html'
            ]
        ]);
        
        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $body = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_error($ch)) {
            $status = 0;
            $body = 'cURL Error: ' . curl_error($ch);
        }
        
        curl_close($ch);
        
        return [
            'status' => $status,
            'body' => $body
        ];
    }

    /**
     * Print test results
     */
    private function printResults(): void
    {
        echo "\n=== Test Results ===\n";
        echo "Passed: {$this->passed}\n";
        echo "Failed: {$this->failed}\n";
        
        if ($this->failed > 0) {
            echo "\nErrors:\n";
            foreach ($this->errors as $error) {
                echo "- {$error}\n";
            }
        } else {
            echo "\n🎉 All tests passed!\n";
        }
        
        $total = $this->passed + $this->failed;
        $percentage = $total > 0 ? round(($this->passed / $total) * 100, 1) : 0;
        echo "\nSuccess Rate: {$percentage}%\n";
    }
}

// Run tests if called directly
if (php_sapi_name() === 'cli') {
    $baseUrl = $argv[1] ?? 'http://localhost:8080';
    $tester = new ComprehensiveWebsiteTest($baseUrl);
    $tester->runAllTests();
} else {
    // Web interface
    echo "<pre>";
    $baseUrl = 'http://localhost:8080';
    $tester = new ComprehensiveWebsiteTest($baseUrl);
    $tester->runAllTests();
    echo "</pre>";
}