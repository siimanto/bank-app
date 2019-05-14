<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function currentController(){
        $c = Route::getCurrentRoute()->getController();
        return $c ? get_class($c) : "";
    }

    public function currentAction(){
        $r = Route::getCurrentRoute()->getAction();//['as'];
        return $r && isset($r['as']) ? $r['as'] : '';
    }

    public function title($modelName = '', $prefix = '', $index = 'before', $last = ''){
        switch ($index) {
            case 'after':
                $title = $modelName." ".$prefix;
                break;
            
            case 'middle':
                $title = $prefix." ".$modelName." ".$last;
                break;

            default:
                $title = ($prefix == '' || $prefix == ' ') ? $modelName : $prefix." ".$modelName ;
                break;
        }
        return ucfirst(strtolower($title));
    }
}
