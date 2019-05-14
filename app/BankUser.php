<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelScopes;

class BankUser extends Model
{
    use ModelScopes;
    use SoftDeletes;

    /* Bank User Status */
    const BANK_USER_ACTIVE      = 1;
    const BANK_USER_INACTIVE    = 2;
    const BANK_USER_BLOCKED     = 3;

    /* Bank User Type */
    const BANK_USER_TY_PERSON   = 1;
    const BANK_USER_TY_CORP     = 2;
    
    protected $fillable = [
        'corp_id', 
        'username', 
        'password', 
        'type',
        'bank_id',
        'status'
    ];

    protected $hidden = [
        'password',
    ];

    protected $appends = [
        'statusName', 'typeName'
    ];

    public static function lists($attr='username') {
        $lists = BankUser::orderBy($attr)
                    ->pluck( $attr, 'id' );

        return $lists;
    }

    public static function listStatus(){
        return [
            self::BANK_USER_ACTIVE      => 'Active',
            self::BANK_USER_INACTIVE    => 'Inactive',
            self::BANK_USER_BLOCKED     => 'Blocked',
        ];
    }

    public function getStatusNameAttribute(){
        $value = '';
        foreach (self::listStatus() as $key => $type) {
            if($this->status == $key){
                return $type;
            }
        }
        return $value;
    }

    public static function listType(){
        return [
            self::BANK_USER_TY_PERSON   => 'Personal',
            self::BANK_USER_TY_CORP     => 'Corporate',
        ];
    }

    public function getTypeNameAttribute(){
        $value = '';
        foreach (self::listType() as $key => $type) {
            if($this->type == $key){
                return $type;
            }
        }
        return $value;
    }

    public function bank(){
        return $this->belongsTo('App\Bank');
    }

    public function bankAccounts(){
        return $this->hasMany('App\BankAccount');
    }
}
