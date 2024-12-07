<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::where('email', 'beyza.basatogrul12@gmail.com')->update(['role' => 'admin']);
    }
}
