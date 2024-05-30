<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = \App\Models\User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
        ]);

        // Generate access token for admin user
        $token = $admin->createToken('Admin Access Token')->accessToken;

        // Set token expiration time (e.g., 1 year)
        $expiresAt = Carbon::now()->addYear();

        // Update token expiration time
        $accessToken = $admin->tokens()->where('id', $token->id)->update(['expires_at' => $expiresAt]);

        $this->command->info('Admin user created with access token: ' . $token);
    }
}
