<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus user non-admin lama jika ada, pastikan hanya 1 akun admin utama
        User::where('level', '!=', 1)->delete();

        User::query()->updateOrCreate(
            ['email' => 'admin@porto.test'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('admin12345'),
                'level' => 1,
                'email_verified_at' => now(),
            ]
        );
    }
}
