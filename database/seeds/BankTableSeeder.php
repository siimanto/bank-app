<?php

use Illuminate\Database\Seeder;
use App\Imports\BankImport;
use App\Bank;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::truncate();
        Excel::import(new BankImport, public_path('docs/domestic-bank-list.xlsx'));
    }
}
