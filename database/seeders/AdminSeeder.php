<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exist=User::where('email', 'admin@gmail.com')->first();

        if (!$exist){
            User::create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => ADMIN_ROLE,
                'user_slug'=>Carbon::now()->format('d-m-Y') . '-' . 'ADMIN' . '-' . ADMIN_ROLE,
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
            ]);
        }

    }
}
