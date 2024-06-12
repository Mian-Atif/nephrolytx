<?php

use App\Country;
use Illuminate\Database\Seeder;
use App\DataProviders\CountryStateCityDataProvider;


class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::insert(CountryStateCityDataProvider::Countries());

    }
}
