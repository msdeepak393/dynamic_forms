<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('option_types')->insert([
            ['name' => "Text"],
            ['name' => "Number"],
            ['name' => "Select"]
        ]);
    }
}
