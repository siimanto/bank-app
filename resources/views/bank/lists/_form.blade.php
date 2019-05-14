@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">{{ $modelName }}</div>

    <div class="card-body">
        @include('layouts.flash-session')

        @if ($actionForm)
            @if( $model->exists )
                {!! Form::open([
                    'method' => 'PATCH',
                    'url' => route('bank.lists.update', ['id'=>$model->getKey()]),
                ]) !!}
                {!! Form::hidden('id', $model->getKey()) !!}
            @else
            {!! Form::open([
                'method' => 'FETCH',
                'url' => route('bank.lists.store'),
                ]) !!}
            @endif
        @endif

        <div class="form-group">
            <label>Full Code</label>
            {!! Form::text('full_code', $model->full_code, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'    =>'full_code',
                ]) 
            !!}
            @if ($errors->has('full_code'))
                <small class="form-text text-danger">
                    {{ $errors->first('full_code') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Code</label>
            {!! Form::text('code', $model->code, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'    =>'code',
                ]) 
            !!}
            @if ($errors->has('code'))
                <small class="form-text text-danger">
                    {{ $errors->first('code') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>RTGS Code</label>
            {!! Form::text('rtgs_code', $model->rtgs_code, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'    =>'rtgs_code',
                ]) 
            !!}
            @if ($errors->has('rtgs_code'))
                <small class="form-text text-danger">
                    {{ $errors->first('rtgs_code') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Full Code</label>
            {!! Form::text('full_code', $model->full_code, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'    =>'full_code',
                ]) 
            !!}
            @if ($errors->has('full_code'))
                <small class="form-text text-danger">
                    {{ $errors->first('full_code') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Name</label>
            {!! Form::text('name', $model->name, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'    =>'name',
                ]) 
            !!}
            @if ($errors->has('name'))
                <small class="form-text text-danger">
                    {{ $errors->first('name') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>City</label>
            {!! Form::text('city', $model->city, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'    =>'city',
                ]) 
            !!}
            @if ($errors->has('city'))
                <small class="form-text text-danger">
                    {{ $errors->first('city') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Personal Library Path</label>
            {!! Form::text('personal_lib', $model->personal_lib, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm) ? true : false,
                    'placeholder'    =>'App\MantoServices\Bank\Personals\BCAParser',
                ]) 
            !!}
            @if ($errors->has('personal_lib'))
                <small class="form-text text-danger">
                    {{ $errors->first('personal_lib') }}
                </small>
            @endif
        </div>
        
        <div class="form-group">
            <label>Corporate Library Path</label>
            {!! Form::text('corporate_lib', $model->corporate_lib, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm) ? true : false,
                    'placeholder'    =>'App\MantoServices\Bank\Corporates\MandiriParser',
                ]) 
            !!}
            @if ($errors->has('corporate_lib'))
                <small class="form-text text-danger">
                    {{ $errors->first('corporate_lib') }}
                </small>
            @endif
        </div>


        
        <div class="form-group">
            <label>Status</label>
            {!! Form::select('status', $listStatus, $model->status, [
                    'class'         => 'form-control',
                    'disabled'      => (!$actionForm) ? true : false,
                    'placeholder'   => 'Choose Bank Status'
                ]) 
            !!}

            @if ($errors->has('status'))
                <small class="form-text text-danger">
                    {{ $errors->first('status') }}
                </small>
            @endif
        </div>

        <div class="col-sm-6 col-sm-offset-2">
            <a href="{{ route('bank.lists.index') }}" class="btn btn-secondary btn-sm">
                <span class="fa fa-list"></span>
                Return to list
            </a>
            @if ($actionForm)
                {!! Form::submit($model->exists ? 'Save changes' : 'Save', ['class' => 'btn btn-success btn-sm']) !!}
            @else
                <a href="{{ route('bank.lists.edit', ['id'=>$model->getKey()]) }}" class="btn btn-warning btn-sm">
                    <span class="fa fa-pencil"></span>
                    Edit
                </a>
            @endif
        </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection