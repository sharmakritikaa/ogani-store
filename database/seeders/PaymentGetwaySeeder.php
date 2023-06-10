<?php

namespace Database\Seeders;

use App\Models\paymentGetway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGetwaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        paymentGetway::create([
            'name'=> "Cash on Delivery",
            'code'=>"cod",

        ]);
        paymentGetway::create([
            'name'=> "Khalti",
            'code'=>"cod",

        ]);
    }
}
