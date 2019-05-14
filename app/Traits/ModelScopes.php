<?php
namespace App\Traits;

/**
 * 
 */
trait ModelScopes
{
    public function scopeTableName(){
        return self::getTable();
    }

    public function scopeModelName(){
        return $this;
    }
}
