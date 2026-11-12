<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@fixora.test'],
            [
                'name' => 'Admin FIXORA',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'account_status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Customer (individual)
        User::updateOrCreate(
            ['email' => 'customer@fixora.test'],
            [
                'name' => 'Youssef Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'account_status' => 'active',
                'customer_type' => 'individual',
                'email_verified_at' => now(),
            ]
        );

        // Customer (business)
        User::updateOrCreate(
            ['email' => 'business@fixora.test'],
            [
                'name' => 'TechCo SARL',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'account_status' => 'active',
                'customer_type' => 'business',
                'email_verified_at' => now(),
            ]
        );

        // Professional 1 (electrician)
        User::updateOrCreate(
            ['email' => 'pro1@fixora.test'],
            [
                'name' => 'Ahmed Electrician',
                'password' => Hash::make('password'),
                'role' => 'professional',
                'account_status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Professional 2 (plumber)
        User::updateOrCreate(
            ['email' => 'pro2@fixora.test'],
            [
                'name' => 'Karim Plumber',
                'password' => Hash::make('password'),
                'role' => 'professional',
                'account_status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
