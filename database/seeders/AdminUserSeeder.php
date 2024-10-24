<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Pessoa;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{

    public function run(): void
    {
        if (!Pessoa::where('email', 'admin@email.com')->exists()) {
            Pessoa::create([
                'id' => 1,
                'nome' => 'admin',
                'email' => 'admin@email.com',
                'senha' => bcrypt('admin'),
                'cargo' => 'admin'
            ]);
        }
    }
}
