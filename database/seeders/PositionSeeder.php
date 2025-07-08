<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = ['Lawyer', 'Content manager', 'Security', 'Designer'];

        foreach ($positions as $name) {
            Position::create(['name' => $name]);
        }
    }
}
