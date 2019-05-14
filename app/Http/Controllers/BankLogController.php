<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\BankLog;
use Session;

class BankLogController extends Controller
{
    protected $modelName = 'Bank Logs';
    protected $listStatus;

    function __construct(){
        parent::__construct();
        $this->model        = BankLog::modelName();
        $this->listStatus   = BankLog::listStatus();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title      = $this->title($this->modelName);
        $model      = $this->model;
        $models     = BankLog::paginate(10);
        $modelName  = $this->modelName;

        return view('bank.logs.index', compact('title', 'modelName', 'models', 'model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model      = BankLog::findOrFail($id);

        $title      = $this->title($this->modelName);
        $listStatus = $this->listStatus;
        $modelName  = $this->modelName;

        $actionForm         = (Str::contains($this->currentAction(), ['edit', 'create'])) ? true : false ;
        return view('bank.logs._form', compact('title', 'modelName', 'model', 'listStatus', 'actionForm'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model  = BankLog::findOrFail($id);
        $actionName = 'deleted';
        if ( $model->delete() ) {
            Session::flash('status', 'success');
            Session::flash('head', 'Item '.$actionName.' successfully');
            Session::flash('message', $this->title($this->modelName)." Username Event '".$model->bank_username." ".$model->event."' ".$actionName.".");
        } else {
            Session::flash('status', 'error');
            Session::flash('head', 'Item not '.$actionName.' successfully');
            Session::flash('message', $this->title($this->modelName)." Username Event '".$model->bank_username." ".$model->event."' not ".$actionName.".");
        }

        return redirect()->route('bank.logs.index');
    }
}
