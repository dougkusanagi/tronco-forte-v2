<?php

use PHPUnit\Framework\TestCase;

class WebsiteTest extends TestCase
{
    private $baseUrl = 'http://localhost:8080';
    
    /**
     * Test homepage loads successfully
     */
    public function testHomepageLoads()
    {
        $response = $this->makeRequest('/');
        $this->assertEquals(200, $response['status']);
        $this->assertStringContainsString('Tronco Forte', $response['body']);
        $this->assertStringContainsString('Madeira de Qualidade', $response['body']);
    }
    
    /**
     * Test catalog page loads successfully
     */
    public function testCatalogPageLoads()
    {
        $response = $this->makeRequest('/catalogo');
        $this->assertEquals(200, $response['status']);
        $this->assertStringContainsString('Catálogo', $response['body']);
    }
    
    /**
     * Test blog page loads successfully
     */
    public function testBlogPageLoads()
    {
        $response = $this->makeRequest('/blog');
        $this->assertEquals(200, $response['status']);
        $this->assertStringContainsString('Blog Técnico', $response['body']);
        $this->assertStringNotContainsString('TypeError', $response['body']);
        $this->assertStringNotContainsString('Undefined', $response['body']);
    }
    
    /**
     * Test fornecedores page loads successfully
     */
    public function testFornecedoresPageLoads()
    {
        $response = $this->makeRequest('/fornecedores');
        $this->assertEquals(200, $response['status']);
        $this->assertStringContainsString('Fornecedores Parceiros', $response['body']);
        $this->assertStringNotContainsString('const matchBusca', $response['body']); // Should not show raw JS
    }
    
    /**
     * Test admin dashboard loads (should redirect to login or show dashboard)
     */
    public function testAdminDashboardLoads()
    {
        $response = $this->makeRequest('/admin');
        // Should either show login form or dashboard (both are valid)
        $this->assertTrue($response['status'] === 200 || $response['status'] === 302);
    }
    
    /**
     * Test admin produtos page loads
     */
    public function testAdminProdutosPageLoads()
    {
        $response = $this->makeRequest('/admin/produtos');
        // Should either show login form, dashboard, or produtos page
        $this->assertTrue($response['status'] === 200 || $response['status'] === 302);
        if ($response['status'] === 200) {
            $this->assertStringNotContainsString('Template file not found', $response['body']);
        }
    }
    
    /**
     * Test admin fornecedores page loads
     */
    public function testAdminFornecedoresPageLoads()
    {
        $response = $this->makeRequest('/admin/fornecedores');
        $this->assertTrue($response['status'] === 200 || $response['status'] === 302);
    }
    
    /**
     * Test admin blog page loads
     */
    public function testAdminBlogPageLoads()
    {
        $response = $this->makeRequest('/admin/blog');
        $this->assertTrue($response['status'] === 200 || $response['status'] === 302);
    }
    
    /**
     * Test contact page loads
     */
    public function testContactPageLoads()
    {
        $response = $this->makeRequest('/contato');
        $this->assertEquals(200, $response['status']);
        $this->assertStringContainsString('Contato', $response['body']);
    }
    
    /**
     * Test about page loads
     */
    public function testAboutPageLoads()
    {
        $response = $this->makeRequest('/sobre');
        $this->assertEquals(200, $response['status']);
        $this->assertStringContainsString('Sobre', $response['body']);
    }
    
    /**
     * Test individual blog article loads
     */
    public function testBlogArticleLoads()
    {
        $response = $this->makeRequest('/blog/guia-escolher-madeira-estruturas');
        $this->assertEquals(200, $response['status']);
        $this->assertStringContainsString('Guia Completo', $response['body']);
    }
    
    /**
     * Test individual product page loads
     */
    public function testProductPageLoads()
    {
        $response = $this->makeRequest('/catalogo/pinus-tratado-autoclave');
        $this->assertEquals(200, $response['status']);
    }
    
    /**
     * Test individual fornecedor profile loads
     */
    public function testFornecedorProfileLoads()
    {
        $response = $this->makeRequest('/fornecedor/madeireira-sao-paulo');
        $this->assertEquals(200, $response['status']);
        $this->assertStringContainsString('Madeireira São Paulo', $response['body']);
    }
    
    /**
     * Test API endpoints
     */
    public function testApiEndpoints()
    {
        // Test volume calculator API
        $response = $this->makeRequest('/api/calcular-volume', 'POST', [
            'comprimento' => 10,
            'largura' => 5,
            'altura' => 2
        ]);
        $this->assertEquals(200, $response['status']);
        
        // Test wood quiz API
        $response = $this->makeRequest('/api/quiz-madeira', 'POST', [
            'uso' => 'estrutural',
            'ambiente' => 'interno',
            'orcamento' => 'medio'
        ]);
        $this->assertEquals(200, $response['status']);
    }
    
    /**
     * Test that all pages have proper layout structure
     */
    public function testPagesHaveProperLayout()
    {
        $pages = ['/', '/catalogo', '/blog', '/fornecedores', '/contato', '/sobre'];
        
        foreach ($pages as $page) {
            $response = $this->makeRequest($page);
            $this->assertEquals(200, $response['status'], "Page {$page} should load successfully");
            
            // Check for essential layout elements
            $this->assertStringContainsString('<html', $response['body'], "Page {$page} should have HTML tag");
            $this->assertStringContainsString('</html>', $response['body'], "Page {$page} should close HTML tag");
            $this->assertStringContainsString('<head>', $response['body'], "Page {$page} should have head section");
            $this->assertStringContainsString('<body>', $response['body'], "Page {$page} should have body section");
            
            // Check for CSS and JS includes
            $this->assertStringContainsString('tailwindcss', $response['body'], "Page {$page} should include Tailwind CSS");
            $this->assertStringContainsString('alpinejs', $response['body'], "Page {$page} should include Alpine.js");
            
            // Check for navigation
            $this->assertStringContainsString('Tronco Forte', $response['body'], "Page {$page} should have site title");
            
            // Check for no PHP errors
            $this->assertStringNotContainsString('Fatal error', $response['body'], "Page {$page} should not have fatal errors");
            $this->assertStringNotContainsString('Parse error', $response['body'], "Page {$page} should not have parse errors");
            $this->assertStringNotContainsString('Warning:', $response['body'], "Page {$page} should not have warnings");
            $this->assertStringNotContainsString('Notice:', $response['body'], "Page {$page} should not have notices");
        }
    }
    
    /**
     * Test form submissions
     */
    public function testFormSubmissions()
    {
        // Test contact form
        $response = $this->makeRequest('/api/contato', 'POST', [
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'telefone' => '(11) 99999-9999',
            'mensagem' => 'Test message'
        ]);
        $this->assertTrue($response['status'] === 200 || $response['status'] === 422); // Success or validation error
        
        // Test newsletter subscription
        $response = $this->makeRequest('/api/newsletter', 'POST', [
            'nome' => 'Test User',
            'email' => 'test@example.com'
        ]);
        $this->assertTrue($response['status'] === 200 || $response['status'] === 422);
    }
    
    /**
     * Test admin form submissions (if authenticated)
     */
    public function testAdminFormSubmissions()
    {
        // Test product creation
        $response = $this->makeRequest('/admin/api/produtos', 'POST', [
            'nome' => 'Test Product',
            'categoria' => 'estrutural',
            'preco' => 150.00,
            'descricao' => 'Test product description'
        ]);
        $this->assertTrue(in_array($response['status'], [200, 401, 403])); // Success, unauthorized, or forbidden
        
        // Test fornecedor creation
        $response = $this->makeRequest('/admin/api/fornecedores', 'POST', [
            'nome' => 'Test Fornecedor',
            'slug' => 'test-fornecedor',
            'descricao' => 'Test description',
            'regiao' => 'sudeste'
        ]);
        $this->assertTrue(in_array($response['status'], [200, 401, 403]));
    }
    
    /**
     * Test 404 error handling
     */
    public function test404ErrorHandling()
    {
        $response = $this->makeRequest('/non-existent-page');
        $this->assertEquals(404, $response['status']);
    }
    
    /**
     * Helper method to make HTTP requests
     */
    private function makeRequest($path, $method = 'GET', $data = null)
    {
        $url = $this->baseUrl . $path;
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
            ]);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return [
            'status' => $httpCode,
            'body' => $response
        ];
    }
}