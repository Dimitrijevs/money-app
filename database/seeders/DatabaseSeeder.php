<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserType;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // TODO
        // php artisan migrate:fresh && php artisan db:seed

        $user = new User();
        $user->user_type = 3; // super admin == 3, admin == 2, user == 1
        $user->subscription_id = 3; // subscription_id 1 == free, 2 == basic, 3 == premium
        $user->name = 'Gļebs Dimitrijevs';
        $user->email = 'dimitrijevgleb@gmail.com';
        $user->email_verified_at = now();
        $user->password = '12345678';
        $user->avatar_path = 'avatars/default.png';
        $user->save();

        $userTypes = [
            "USER",
            "ADMIN",
            "SUPER ADMIN",
        ];

        foreach ($userTypes as $type) {
            UserType::create([
                'name' => $type,
            ]);
        }

        $subscriptionTypes = [
            [
                'name' => 'FREE',
                'description' => 'Free subscription',
                'price' => 0.00,
                'icon' => 'heroicon-o-play-circle',
            ],
            [
                'name' => 'BASIC',
                'description' => 'Basic subscription',
                'price' => 9.99,
                'icon' => 'heroicon-o-currency-euro',
            ],
            [
                'name' => 'PREMIUM',
                'description' => 'Premium subscription',
                'price' => 19.99,
                'icon' => 'heroicon-o-banknotes',
            ],
        ];

        foreach ($subscriptionTypes as $type) {
            Subscription::create($type);
        }
    }
}
