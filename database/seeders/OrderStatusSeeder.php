<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'Pending'],
            ['name' => 'Processing'],
            ['name' => 'Shipped'],
            ['name' => 'Delivered'],
            ['name' => 'Cancelled']
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
} 