<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Bank;
use App\BankUser;
use Session;

class BankUsersController extends Controller
{
    protected $modelName = 'Bank Users';
    protected $model;
    protected $listStatus;
    protected $listBank;

    function __construct(){
        parent::__construct();
        $this->model        = BankUser::modelName();
        $this->listStatus   = BankUser::listStatus();
        $this->listType     = BankUser::listType();
        $this->listBank     = Bank::lists();
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
        $listStatus = $this->listStatus;
        $listBank   = $this->listBank;
        $listType   = $this->listType;
        $models     = BankUser::paginate(5);
        return view('bank.users.index', compact('title', 'models', 'modelName', 'model', 'listStatus', 'listType', 'listBank'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model      = new BankUser();
        $title      = $this->title($this->modelName);
        $modelName  = $this->modelName;
        $listStatus = $this->listStatus;
        $listBank   = $this->listBank;
        $listType   = $this->listType;
        $actionForm = (Str::contains($this->currentAction(), ['edit', 'create'])) ? true : false ;
        return view('bank.users._form', compact('title', 'model', 'modelName', 'actionForm', 'listBank', 'listStatus', 'listType'));
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
            if(trim($request->password) == ''){
                $data = $request->except('password');
            }else{
                $data               = $request->all();
                $data['password']   = encrypt($request->password);
            }
            $model      = new BankUser();

            if ($model->fill($data) && $model->save()) {
                Session::flash('status', 'success');
                Session::flash('head', 'Item '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." username '".$model->username."' ".$actionName.".");
                \DB::commit();
            } else {
                Session::flash('status', 'error');
                Session::flash('head', 'Item not '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." username '".$model->username."' not ".$actionName.".");
                return redirect()->route('admin.bank.users.create');
            }    
        } catch (\Exception $exception) {
            \DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd( $errorInfo );
            Session::flash('status', 'error');
            Session::flash('head', 'Item not '.$actionName.' successfully');
            Session::flash('message', json_encode($errorInfo));
        }

        return redirect()->route('bank.users.edit', $model->getKey());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model      = BankUser::findOrFail($id);
        $title      = $this->title($this->modelName);
        $modelName  = $this->modelName;
        $listStatus = $this->listStatus;
        $listBank   = $this->listBank;
        $listType   = $this->listType;
        $actionForm = (Str::contains($this->currentAction(), ['edit', 'create'])) ? true : false ;
        return view('bank.users._form', compact('title', 'model', 'modelName', 'actionForm', 'listBank', 'listStatus', 'listType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model      = BankUser::findOrFail($id);
        $title      = $this->title($this->modelName);
        $modelName  = $this->modelName;
        $listStatus = $this->listStatus;
        $listBank   = $this->listBank;
        $listType   = $this->listType;
        $actionForm = (Str::contains($this->currentAction(), ['edit', 'create'])) ? true : false ;
        return view('bank.users._form', compact('title', 'model', 'modelName', 'actionForm', 'listBank', 'listStatus', 'listType'));
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
            if(trim($request->password) == ''){
                $data = $request->except('password');
            }else{
                $data               = $request->all();
                $data['password']   = encrypt($request->password);
            }
            $model = BankUser::findOrFail($id);

            if ($model->fill($data) && $model->save()) {
                Session::flash('status', 'success');
                Session::flash('head', 'Item '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." username '".$model->username."' ".$actionName.".");
                \DB::commit();
            } else {
                Session::flash('status', 'error');
                Session::flash('head', 'Item not '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." username '".$model->username."' not ".$actionName.".");
            }    
        } catch (\Exception $exception) {
            \DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd( $errorInfo );
            Session::flash('status', 'error');
            Session::flash('head', 'Item not '.$actionName.' successfully');
            Session::flash('message', $errorInfo);
        }

        return redirect()->route('bank.users.edit', $model->getKey());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model  = BankUser::findOrFail($id);
        $actionName = 'deleted';
        if ( $model->delete() ) {
            Session::flash('status', 'success');
            Session::flash('head', 'Item '.$actionName.' successfully');
            Session::flash('message', $this->title($this->modelName)." username '".$model->username."' ".$actionName.".");
        } else {
            Session::flash('status', 'error');
            Session::flash('head', 'Item not '.$actionName.' successfully');
            Session::flash('message', $this->title($this->modelName)." username '".$model->username."' not ".$actionName.".");
        }

        return redirect()->route('bank.users.index');
    }

    public function get_bank($user)
    {
        $model = BankUser::find($user);
        
        if(!$model){
            return 'false';
        }else {
            $json = ['name' => $model->bank->full_code.' - '.$model->bank->name];
            return response()->json($json);
        }
    }
}
