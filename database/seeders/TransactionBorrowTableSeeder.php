<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionBorrow;
use App\Models\User;
use App\Models\Book;

class TransactionBorrowTableSeeder extends Seeder
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
            $user = User::inRandomOrder()->first();
            $book = Book::inRandomOrder()->first();

            DB::table('transaction_borrow')->insert([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrow_start' => $faker->dateTimeThisYear(), // Generate random datetime within the current year
                'borrow_end' => $faker->dateTimeBetween('now', '+30 days')
                    ->format('Y-m-d H:i:s'), // Generate random datetime within the next 30 days
                'return_on' => optional($faker->optional(0.7)
                    ->dateTimeBetween('now', '+30 days'))
                    ->format('Y-m-d H:i:s'), // Nullable with 70% probability within the next 30 days
            ]);
        }
    }
}
