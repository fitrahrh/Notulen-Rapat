<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cek apakah tabel users sudah ada
        if (Schema::hasTable('users')) {
            $adminExists = User::where('role', 'admin')->exists();

            if (!$adminExists) {
                // Buat akun admin baru
                User::create([
                    // Ambil email dan password dari file .env
                    'name' => 'Admin',
                    'email' => env('ADMIN_EMAIL'),
                    'password' => Hash::make(env('ADMIN_PASSWORD')),
                    'role' => 'admin',
                ]);
            }
        }
    }
}