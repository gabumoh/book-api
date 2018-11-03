<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Book;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Clear Books table first
        Book::truncate();

        $faker = \Faker\Factory::create();

        /**
         * We are going to make a thousand records of books.
         *
         */

        for ($i=0; $i < 1000 ; $i++) { 
        	Book::create([
        		'name' => $faker->unique()->sentence,
        		'description' => $faker->text($maxNbChars = 1000),
        	]);
        }
    }
}
