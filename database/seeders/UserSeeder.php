<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use function Tinify\fromFile;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 45; $i++) {
            $filename = uniqid() . '.jpg';
            $path = public_path('uploads/photos/' . $filename);

            fromFile('https://thispersondoesnotexist.com/')
                ->resize([
                    "method" => "fit",
                    "width" => 70,
                    "height" => 70
                ])->toFile($path);

            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => '+380' . $faker->numberBetween(500000000, 999999999),
                'position_id' => rand(1, 4),
                'photo' => $filename,
                'password' => 'password',
            ]);
        }
    }
}
