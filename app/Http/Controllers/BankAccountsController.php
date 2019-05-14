<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\BankUser;
use App\BankAccount;
use Session;

class BankAccountsController extends Controller
{
    protected $modelName = 'Bank Accounts';
    protected $model;
    protected $listStatus;
    protected $listBank;
    protected $listDailyStatus;

    function __construct(){
        parent::__construct();
        $this->model        = BankAccount::modelName();
        $this->listType     = BankAccount::listType();
        $this->listBankUser = BankUser::lists();
        $this->listStatus   = BankAccount::listStatus();
        $this->listDailyStatus    = BankAccount::listDailyStatus();
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
        $modelName  = $this->modelName;
        $models     = BankAccount::paginate(5);
        return view('bank.accounts.index', compact('title', 'models', 'modelName', 'model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model          = new BankAccount();

        $title          = $this->title($this->modelName);
        $modelName      = $this->modelName;
        $listBankUser   = $this->listBankUser;
        $listType       = $this->listType;
        $listStatus     = $this->listStatus;
        $listDailyStatus    = $this->listDailyStatus;
        $actionForm         = (Str::contains($this->currentAction(), ['edit', 'create'])) ? true : false ;
        return view('bank.accounts._form', compact('title', 'model', 'modelName', 'actionForm', 'listBankUser', 'listType', 'listDailyStatus', 'listStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $actionName = 'created';
            $data       = $request->except('bank_user');
            $data['bank_user_id'] = $request->bank_user;
            $model      = new BankAccount();

            if ($model->fill($data) && $model->save()) {
                Session::flash('status', 'success');
                Session::flash('head', 'Item '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." number '".$model->number."' ".$actionName.".");
                \DB::commit();
            } else {
                Session::flash('status', 'error');
                Session::flash('head', 'Item not '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." number '".$model->number."' not ".$actionName.".");
                return redirect()->route('bank.accounts.create');
            }    
        } catch (\Exception $exception) {
            \DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd( $errorInfo );
            Session::flash('status', 'error');
            Session::flash('head', 'Item not '.$actionName.' successfully');
            Session::flash('message', $errorInfo);
        }

        return redirect()->route('bank.accounts.edit', $model->getKey());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model          = BankAccount::findOrFail($id);

        $title          = $this->title($this->modelName);
        $modelName      = $this->modelName;
        $listBankUser   = $this->listBankUser;
        $listType       = $this->listType;
        $listStatus     = $this->listStatus;
        $listDailyStatus    = $this->listDailyStatus;
        $actionForm         = (Str::contains($this->currentAction(), ['edit', 'create'])) ? true : false ;
        return view('bank.accounts._form', compact('title', 'model', 'modelName', 'actionForm', 'listBankUser', 'listType', 'listDailyStatus', 'listStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model          = BankAccount::findOrFail($id);

        $title          = $this->title($this->modelName);
        $modelName      = $this->modelName;
        $listBankUser   = $this->listBankUser;
        $listType       = $this->listType;
        $listStatus     = $this->listStatus;
        $listDailyStatus    = $this->listDailyStatus;
        $actionForm         = (Str::contains($this->currentAction(), ['edit', 'create'])) ? true : false ;
        return view('bank.accounts._form', compact('title', 'model', 'modelName', 'actionForm', 'listBankUser', 'listType', 'listDailyStatus', 'listStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $actionName = 'updated';
            $data       = $request->all();
            $model = BankAccount::findOrFail($id);

            if ($model->fill($data) && $model->save()) {
                Session::flash('status', 'success');
                Session::flash('head', 'Item '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." number '".$model->number."' ".$actionName.".");
                \DB::commit();
            } else {
                Session::flash('status', 'error');
                Session::flash('head', 'Item not '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." number '".$model->number."' not ".$actionName.".");
            }    
        } catch (\Exception $exception) {
            \DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd( $errorInfo );
            Session::flash('status', 'error');
            Session::flash('head', 'Item not '.$actionName.' successfully');
            Session::flash('message', $errorInfo);
        }

        return redirect()->route('bank.accounts.edit', $model->getKey());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model  = BankAccount::findOrFail($id);
        $actionName = 'deleted';
        if ( $model->delete() ) {
            Session::flash('status', 'success');
            Session::flash('head', 'Item '.$actionName.' successfully');
            Session::flash('message', $this->title($this->modelName)." number '".$model->number."' ".$actionName.".");
        } else {
            Session::flash('status', 'error');
            Session::flash('head', 'Item not '.$actionName.' successfully');
            Session::flash('message', $this->title($this->modelName)." number '".$model->number."' not ".$actionName.".");
        }

        return redirect()->route('bank.accounts.index');
    }
}
