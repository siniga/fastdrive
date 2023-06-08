<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use App\Models\User;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'johndoe@example.com')->first();

        PaymentMethod::create([
            'user_id' => $user->id,
            'card_number' => '1234567890123456',
            'expiry_month' => '12',
            'expiry_year' => '2024',
            'cvv' => '123',
        ]);
    }
}
