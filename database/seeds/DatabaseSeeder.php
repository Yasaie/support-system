<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call(CitiesTableSeeder::class);
		$this->call(ConfigsTableSeeder::class);
		$this->call(CountriesTableSeeder::class);
		$this->call(PermissionsTableSeeder::class);
		$this->call(ProvincesTableSeeder::class);
    }
}
