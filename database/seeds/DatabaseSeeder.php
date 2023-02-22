<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // $faker = Faker::create();
        // $user_id = 10000700;
        // $cnic = 700;
        // $m = 923004007000;
        // // $refered_by = $faker->randomElement(range(4,50));
        // foreach (range(1,2000) as $index) {
        //     DB::table('users')->insert([
        //     'name' => $faker->name,
        //     'user_id' => $user_id,
        //     'email' => $faker->email,
        //     'national_id'=>$cnic,
        //     'mobile'=>$m,
        //     'address'=>'Lahore',
        //     'refered_by' => '3',
        //     'package_name' => '10MBPS',
        //     'package_price' => '2000',
        //     'payment_date' => '2023-02-21',
        //     'city_id' => '1',
        //     'area_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime()
        //     ]);
        //     $user_id++;
        //     $cnic++;
        //     $m++;
        // }
        DB::table('cities')->insert([
            'city_id' => '100',
            'city_name' => 'Lahore',           
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('admins')->insert([
            'name' => 'SuperAdmin',
            'username' => 'superadmin',
            'admin_id' => '10000001',
            'email' => 'superadmin@gmail.com',
            'national_id'=>'00000-0000000-0',
            'mobile'=>'923004002830',
            'address'=>'Lahore',
            'password' => Hash::make('12345'),  
            'role' => '1',
            'refered_by' => '1',
            'city_id' => '1',
            'expiry_date' =>'2030-12-30',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
    }
}
