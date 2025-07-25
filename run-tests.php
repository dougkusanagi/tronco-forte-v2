<?php

/**
 * Simple test runner for Tronco Forte website
 * This script runs basic functionality tests without requiring PHPUnit
 */

class SimpleTestRunner
{
    private $baseUrl = 'http://localhost:8080';
    private $passed = 0;
    private $failed = 0;
    private $errors = [];
    
    public function run()
    {
        echo "\n=== Tronco Forte Website Test Suite ===\n\n";
        
        $this->testHomepage();
        $this->testCatalogPage();
        $this->testBlogPage();
        $this->testFornecedoresPage();
        $this->testAdminPages();
        $this->testContactPage();
        $this->testAboutPage();
        $this->testIndividualPages();
        $this->testApiEndpoints();
        $this->testLayoutStructure();
        $this->test404Handling();
        
        $this->printResults();
    }
    
    private function testHomepage()
    {
        echo "Testing Homepage...\n";
        $response = $this->makeRequest('/');
        
        $this->assert($response['status'] === 200, 'Homepage should return 200 status');
        $this->assert(strpos($response['body'], 'Tronco Forte') !== false, 'Homepage should contain site title');
        $this->assert(strpos($response['body'], 'Madeira de Qualidade') !== false, 'Homepage should contain tagline');
        $this->assert(strpos($response['body'], 'TypeError') === false, 'Homepage should not have TypeError');
        $this->assert(strpos($response['body'], 'Undefined') === false, 'Homepage should not have undefined errors');
    }
    
    private function testCatalogPage()
    {
        echo "Testing Catalog Page...\n";
        $response = $this->makeRequest('/catalogo');
        
        $this->assert($response['status'] === 200, 'Catalog page should return 200 status');
        $this->assert(strpos($response['body'], 'Catálogo') !== false, 'Catalog page should contain title');
    }
    
    private function testBlogPage()
    {
        echo "Testing Blog Page...\n";
        $response = $this->makeRequest('/blog');
        
        $this->assert($response['status'] === 200, 'Blog page should return 200 status');
        $this->assert(strpos($response['body'], 'Blog') !== false, 'Blog page should contain title');
        $this->assert(strpos($response['body'], 'TypeError') === false, 'Blog page should not have TypeError');
        $this->assert(strpos($response['body'], 'Undefined') === false, 'Blog page should not have undefined errors');
    }
    
    private function testFornecedoresPage()
    {
        echo "Testing Fornecedores Page...\n";
        $response = $this->makeRequest('/fornecedores');
        
        $this->assert($response['status'] === 200, 'Fornecedores page should return 200 status');
        $this->assert(strpos($response['body'], 'Fornecedores') !== false, 'Fornecedores page should contain title');
        $this->assert(strpos($response['body'], 'const matchBusca') === false, 'Fornecedores page should not show raw JavaScript');
    }
    
    private function testAdminPages()
    {
        echo "Testing Admin Pages...\n";
        
        // Test admin dashboard
        $response = $this->makeRequest('/admin');
        $this->assert(in_array($response['status'], [200, 302]), 'Admin dashboard should return 200 or 302 status');
        
        // Test admin produtos
        $response = $this->makeRequest('/admin/produtos');
        $this->assert(in_array($response['status'], [200, 302]), 'Admin produtos should return 200 or 302 status');
        if ($response['status'] === 200) {
            $this->assert(strpos($response['body'], 'Template file not found') === false, 'Admin produtos should not show template error');
        }
        
        // Test admin fornecedores
        $response = $this->makeRequest('/admin/fornecedores');
        $this->assert(in_array($response['status'], [200, 302]), 'Admin fornecedores should return 200 or 302 status');
        
        // Test admin blog
        $response = $this->makeRequest('/admin/blog');
        $this->assert(in_array($response['status'], [200, 302]), 'Admin blog should return 200 or 302 status');
    }
    
    private function testContactPage()
    {
        echo "Testing Contact Page...\n";
        $response = $this->makeRequest('/contato');
        
        $this->assert($response['status'] === 200, 'Contact page should return 200 status');
        $this->assert(strpos($response['body'], 'Contato') !== false, 'Contact page should contain title');
    }
    
    private function testAboutPage()
    {
        echo "Testing About Page...\n";
        $response = $this->makeRequest('/sobre');
        
        $this->assert($response['status'] === 200, 'About page should return 200 status');
        $this->assert(strpos($response['body'], 'Sobre') !== false, 'About page should contain title');
    }
    
    private function testIndividualPages()
    {
        echo "Testing Individual Pages...\n";
        
        // Test blog article
        $response = $this->makeRequest('/blog/guia-escolher-madeira-estruturas');
        $this->assert($response['status'] === 200, 'Blog article should return 200 status');
        
        // Test product page
        $response = $this->makeRequest('/catalogo/pinus-tratado-autoclave');
        $this->assert($response['status'] === 200, 'Product page should return 200 status');
        
        // Test fornecedor profile
        $response = $this->makeRequest('/fornecedor/madeireira-sao-paulo');
        $this->assert($response['status'] === 200, 'Fornecedor profile should return 200 status');
    }
    
    private function testApiEndpoints()
    {
        echo "Testing API Endpoints...\n";
        
        // Test volume calculator
        $response = $this->makeRequest('/api/calcular-volume', 'POST', [
            'comprimento' => 10,
            'largura' => 5,
            'altura' => 2
        ]);
        $this->assert($response['status'] === 200, 'Volume calculator API should work');
        
        // Test wood quiz
        $response = $this->makeRequest('/api/quiz-madeira', 'POST', [
            'uso' => 'estrutural',
            'ambiente' => 'interno',
            'orcamento' => 'medio'
        ]);
        $this->assert($response['status'] === 200, 'Wood quiz API should work');
    }
    
    private function testLayoutStructure()
    {
        echo "Testing Layout Structure...\n";
        
        $pages = ['/', '/catalogo', '/blog', '/fornecedores', '/contato', '/sobre'];
        
        foreach ($pages as $page) {
            $response = $this->makeRequest($page);
            $this->assert($response['status'] === 200, "Page {$page} should load successfully");
            
            // Check for essential layout elements
            $this->assert(strpos($response['body'], '<html') !== false, "Page {$page} should have HTML tag");
            $this->assert(strpos($response['body'], '</html>') !== false, "Page {$page} should close HTML tag");
            $this->assert(strpos($response['body'], '<head>') !== false, "Page {$page} should have head section");
            $this->assert(strpos($response['body'], '<body>') !== false, "Page {$page} should have body section");
            
            // Check for CSS and JS includes
            $this->assert(strpos($response['body'], 'tailwindcss') !== false, "Page {$page} should include Tailwind CSS");
            $this->assert(strpos($response['body'], 'alpinejs') !== false, "Page {$page} should include Alpine.js");
            
            // Check for no PHP errors
            $this->assert(strpos($response['body'], 'Fatal error') === false, "Page {$page} should not have fatal errors");
            $this->assert(strpos($response['body'], 'Parse error') === false, "Page {$page} should not have parse errors");
            $this->assert(strpos($response['body'], 'Warning:') === false, "Page {$page} should not have warnings");
            $this->assert(strpos($response['body'], 'Notice:') === false, "Page {$page} should not have notices");
        }
    }
    
    private function test404Handling()
    {
        echo "Testing 404 Error Handling...\n";
        $response = $this->makeRequest('/non-existent-page');
        $this->assert($response['status'] === 404, '404 page should return 404 status');
    }
    
    private function makeRequest($path, $method = 'GET', $data = null)
    {
        $url = $this->baseUrl . $path;
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
            ]);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_error($ch)) {
            $httpCode = 0;
            $response = 'cURL Error: ' . curl_error($ch);
        }
        
        curl_close($ch);
        
        return [
            'status' => $httpCode,
            'body' => $response
        ];
    }
    
    private function assert($condition, $message)
    {
        if ($condition) {
            $this->passed++;
            echo "  ✓ {$message}\n";
        } else {
            $this->failed++;
            $this->errors[] = $message;
            echo "  ✗ {$message}\n";
        }
    }
    
    private function printResults()
    {
        echo "\n=== Test Results ===\n";
        echo "Passed: {$this->passed}\n";
        echo "Failed: {$this->failed}\n";
        
        if ($this->failed > 0) {
            echo "\nFailed Tests:\n";
            foreach ($this->errors as $error) {
                echo "  - {$error}\n";
            }
            echo "\n❌ Some tests failed. Please check the issues above.\n";
        } else {
            echo "\n✅ All tests passed! Website is working correctly.\n";
        }
    }
}

// Run the tests
if (php_sapi_name() === 'cli') {
    $runner = new SimpleTestRunner();
    $runner->run();
} else {
    echo "This script should be run from the command line.\n";
}