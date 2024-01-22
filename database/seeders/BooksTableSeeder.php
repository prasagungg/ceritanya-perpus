<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

class BooksTableSeeder extends Seeder
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
            $title = $faker->unique()->sentence($nbWords = 6, $variableNbWords = true);

            // Add a theme or genre to the title
            $theme = $faker->randomElement(['Science Fiction', 'Mystery', 'Fantasy', 'Romance', 'Thriller']);
            $titleWithTheme = "$title - $theme";

            DB::table('books')->insert([
                'title' => $titleWithTheme,
                'no_isbn' => $faker->unique()->isbn13, // Generating ISBN as a string
                'no_catalog' => $faker->unique()->numerify('CAT####'), // Adjust pattern as needed
            ]);
        }
    }
}
