<?php

namespace App\Imports;

use App\Bank;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BankImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $allowBank      = ['CENAIDJA', 'BMRIIDJA', 'BRINIDJA', 'BNINIDJA'];
        $personalLibs   = [
            'CENAIDJA'  => 'App\\MantoServices\\Bank\\Personals\\BCAParser',
            // 'BMRIIDJA', 
            // 'BRINIDJA', 
            // 'BNINIDJA'
        ];

        $corporateLibs   = [
            // 'CENAIDJA'  => 'App\\MantoServices\\Bank\\Personals\\BCAParser',
            // 'BMRIIDJA', 
            'BRINIDJA'  => 'App\\MantoServices\\Bank\\Corporates\\BRIParser', 
            'BNINIDJA'  => 'App\\MantoServices\\Bank\\Corporates\\BNIParser'
        ];

        return new Bank([
            'rtgs_code'     => $row['rtgs_code'],
            'full_code'     => $row['domestic_bank_code'],
            'code'          => substr($row['domestic_bank_code'], 0, 3),
            'name'          => strtoupper($row['bank_name']),
            'city'          => $row['city'],
            'status'        => (in_array($row['rtgs_code'], $allowBank)) ? 1 : 2,
            'personal_lib'  => isset($personalLibs[$row['rtgs_code']]) ? $personalLibs[$row['rtgs_code']] : null,
            'corporate_lib' => isset($corporateLibs[$row['rtgs_code']]) ? $corporateLibs[$row['rtgs_code']] : null
        ]);
    }
}
