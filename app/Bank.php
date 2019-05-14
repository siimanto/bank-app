<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelScopes;

class Bank extends Model
{
    use ModelScopes;
    use SoftDeletes;

    /* Bank Status */
    const BANK_ST_ACTIVE    = 1;
    const BANK_ST_INACTIVE  = 2;
    
    protected $fillable = [
        'full_code',
        'code',
        'rtgs_code',
        'personal_lib',
        'corporate_lib',
        'name',
        'city',
        'status'
    ];
    
    protected $appends = [
        'statusName'
    ];

    public static function lists($attr='name') {
        $lists = Bank::where(['status' => 1])
                    ->orderBy($attr)
                    ->pluck( $attr, 'id' );

        return $lists;
    }

    public static function listStatus(){
        return [
            self::BANK_ST_ACTIVE   => 'Active',
            self::BANK_ST_INACTIVE => 'Inactive',
        ];
    }

    public function getStatusNameAttribute(){
        $status = '';
        switch($this->attributes['status']){
            case self::BANK_ST_ACTIVE:
                $status = 'Active';
                break;
            case self::BANK_ST_INACTIVE :
                $status = 'Inactive';
                break;
        }
        return $status;
    }

    public static function getStatusName($code){
        $status = '';
        switch($code){
            case self::BANK_ST_ACTIVE:
                $status = 'Active';
                break;
            case self::BANK_ST_INACTIVE :
                $status = 'Inactive';
                break;
        }
        return $status;
    }
}
