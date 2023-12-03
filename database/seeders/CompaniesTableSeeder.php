<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name' => 'Your Company',
            'email' => 'admin@admin.com',
            'logo' => '', // You may want to provide a default logo
            'website' => 'https://yourcompany.com',
        ]);
    }
}
