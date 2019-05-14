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
                    'url' => route('bank.users.update', ['id'=>$model->getKey()]),
                ]) !!}
                {!! Form::hidden('id', $model->getKey()) !!}
            @else
            {!! Form::open([
                'method' => 'FETCH',
                'url' => route('bank.users.store'),
                ]) !!}
            @endif
        @endif

        <div class="form-group">
            <label>Type</label>
            {!! Form::select('type', $listType, $model->type, [
                    'class'         => 'form-control',
                    'id'            => 'type',
                    'disabled'      => (!$actionForm) ? true : false,
                    'placeholder'   => 'Choose Bank Type',
                ]) 
            !!}

            @if ($errors->has('type'))
                <small class="form-text text-danger">
                    {{ $errors->first('type') }}
                </small>
            @endif
        </div>

        <div class="form-group corpId">
            <label>Corp ID</label>
            {!! Form::text('corp_id', $model->corp_id, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'    =>'Corp ID',
                ]) 
            !!}
            @if ($errors->has('corp_id'))
                <small class="form-text text-danger">
                    {{ $errors->first('corp_id') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Username</label>
            {!! Form::text('username', $model->username, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'    =>'Username',
                ]) 
            !!}
            @if ($errors->has('username'))
                <small class="form-text text-danger">
                    {{ $errors->first('username') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Password</label>
            {!! Form::password('password', [
                    'class'         =>'form-control', 
                    'disabled'      => (!$actionForm) ? true : false,
                    'placeholder'   => '************'
                ]) 
            !!}
            @if ($model->exists)
                <small class="form-text text-muted">
                    Leave empty to keep the same.
                </small>
            @endif
            @if ($errors->has('password'))
                <small class="form-text text-danger">
                    {{ $errors->first('password') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Repeat Password</label>
            {!! Form::password('password_confirmation', [
                    'class'         =>'form-control', 
                    'disabled'      => (!$actionForm) ? true : false,
                    'placeholder'   => '************'
                ]) 
            !!}
            @if ($errors->has('password_confirmation'))
                <small class="form-text text-danger">
                    {{ $errors->first('password_confirmation') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Bank Name</label>
            {!! Form::select('bank_id', $listBank, $model->bank_id, [
                    'class'         => 'form-control',
                    'disabled'      => (!$actionForm) ? true : false,
                    'placeholder'   => 'Choose Bank'
                ]) 
            !!}

            @if ($errors->has('bank_id'))
                <small class="form-text text-danger">
                    {{ $errors->first('bank_id') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Status</label>
            {!! Form::select('status', $listStatus, $model->status, [
                    'class'         => 'form-control',
                    'disabled'      => (!$actionForm) ? true : false,
                    'placeholder'   => 'Choose Status'
                ]) 
            !!}

            @if ($errors->has('status'))
                <small class="form-text text-danger">
                    {{ $errors->first('status') }}
                </small>
            @endif
        </div>

        <div class="col-sm-6 col-sm-offset-2">
            <a href="{{ route('bank.users.index') }}" class="btn btn-secondary btn-sm">
                <span class="fa fa-list"></span>
                Return to list
            </a>
            @if ($actionForm)
                {!! Form::submit($model->exists ? 'Save changes' : 'Save', ['class' => 'btn btn-success btn-sm']) !!}
            @else
                <a href="#" class="btn btn-danger btn-sm btn-delete" data-id='{{ $model->getKey() }}' data-title='{{ $model->username }}'>
                    <span class="fa fa-trash"></span>
                    Delete
                </a>
                <a href="{{ route('bank.users.edit', ['id'=>$model->getKey()]) }}" class="btn btn-warning btn-sm">
                    <span class="fa fa-pencil"></span>
                    Edit
                </a>
            @endif
        </div>

        {!! Form::close() !!}

        @if ($model->exists)
            @include('bank.users._delete')
        @endif
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function toggle(a, b){
            if(a.val() == '1'){
                b.hide(500).prop('disabled', true);
            }else{
                b.show(500).prop('disabled', false);
            }
        }
        $(document).ready(function(){
            const a = $('#type');
            const b = $('.corpId');

            toggle(a, b);
            $('#type').change(function () {
                toggle($(this), b);
            });
        });
    </script>
@endsection