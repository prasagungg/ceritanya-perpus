<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $numberOfRecords = $this->command->ask('Enter the number of records to generate: (default is 20 record)', 20);

        for ($i = 0; $i < $numberOfRecords; $i++) {
            $role = $faker->randomElement([
                User::ROLE_MAHASISWA_ITBS,
                User::ROLE_MAHASISWA_LUAR,
                User::ROLE_MASYARAKAT_UMUM,
            ]);

            DB::table('users')->insert([
                'nim' => $faker->unique()->numerify('##########'), // Assuming 'nim' is a 10-digit number
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'contact' => $faker->phoneNumber,
                'role' => $role,
            ]);
        }
    }
}
