<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CountrySubdivisionTypesTableSeeder::class);
        $this->call(CountrySubdivisionItemsTableSeeder::class);
        $this->call(EducationLevelsTableSeeder::class);
    }
}
