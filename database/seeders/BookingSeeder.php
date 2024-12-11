<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use DateTime;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        DB::table('bookings')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create(); 

        $hotelIds = DB::table('hotels')->pluck('hotel_id')->toArray();

        $bookingData = [];
        for ($i = 0; $i < 50; $i++) {
            $bookingData[] = [
                'hotel_id' => $faker->randomElement($hotelIds), // Random hotel association
                'customer_name' => $faker->name,
                'customer_contact' => $faker->phoneNumber,
                'checkin_time' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'checkout_time' => $faker->dateTimeBetween('+1 day', '+2 months'),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ];
        }

        // Insert data into the database
        DB::table('bookings')->insert($bookingData);

        $this->command->info("Successfully seeded 50 sample bookings.");
    }
}
