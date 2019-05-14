<?php

use Illuminate\Database\Seeder;
use App\BankTransGroup;

class BankTransGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankTransGroup::truncate();
        BankTransGroup::create([
            'name'          => 'Lain-lain',
            'description'   => 'Transaksi yang belum diketahui grup nya',
            'status'        => 1
        ]);
    }
}
