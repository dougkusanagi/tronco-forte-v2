<?php

namespace app\database\seeders;

use app\database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $adminData = [
            'name' => 'Administrador',
            'email' => 'admin@troncoforte.com.br',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'avatar' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20admin%20avatar%20business%20person&image_size=square',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->insert('users', $adminData);
        
        // Create editor user
        $editorData = [
            'name' => 'Editor de Conteúdo',
            'email' => 'editor@troncoforte.com.br',
            'password' => password_hash('editor123', PASSWORD_DEFAULT),
            'role' => 'editor',
            'avatar' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20editor%20avatar%20content%20creator&image_size=square',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->insert('users', $editorData);
    }
}