<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Bank;
use Session;

class BankController extends Controller
{
    protected $modelName = 'Banks';
    protected $model;
    protected $listStatus;

    function __construct(){
        $this->model        = Bank::modelName();
        $this->listStatus   = Bank::listStatus();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title      = $this->title($this->modelName);
        $modelName  = $this->modelName;
        $model      = $this->model;
        $listStatus = $this->listStatus;
        $models     = Bank::paginate(10);
        return view('bank.lists.index', compact('title', 'models', 'modelName', 'model', 'listStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model      = Bank::findOrFail($id);
        $title      = $this->title($this->modelName, 'create a new');
        $modelName  = $this->modelName;
        $listStatus = $this->listStatus;
        $actionForm = (Str::contains($this->currentAction(), ['edit', 'create'])) ? true : false ;
        return view('bank.lists._form', compact('title', 'model', 'modelName', 'listStatus', 'actionForm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model      = Bank::findOrFail($id);
        $title      = $this->title($this->modelName, 'create a new');
        $modelName  = $this->modelName;
        $listStatus = $this->listStatus;
        $actionForm = (Str::contains($this->currentAction(), ['edit', 'create'])) ? true : false ;
        return view('bank.lists._form', compact('title', 'model', 'modelName', 'listStatus', 'actionForm'));
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
            $model      = Bank::findOrFail($id);

            if ($model->fill($data) && $model->save()) {
                Session::flash('status', 'success');
                Session::flash('head', 'Item '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." name '".$model->name."' ".$actionName.".");
                \DB::commit();
            } else {
                Session::flash('status', 'error');
                Session::flash('head', 'Item not '.$actionName.' successfully');
                Session::flash('message', $this->title($this->modelName)." name '".$model->name."' not ".$actionName.".");
            }    
        } catch (\Exception $exception) {
            \DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd( $errorInfo );
            Session::flash('status', 'error');
            Session::flash('head', 'Item not '.$actionName.' successfully');
            Session::flash('message', $errorInfo);
        }

        return redirect()->route('bank.lists.edit', $model->getKey());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
