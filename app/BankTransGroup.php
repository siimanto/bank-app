<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankTransGroup extends Model
{
    protected $guarded = [];

    public static function lists($attr='name') {
        $lists = BankTransGroup::orderBy($attr)
                    ->pluck( $attr, 'id' );

        return $lists;
    }
}
