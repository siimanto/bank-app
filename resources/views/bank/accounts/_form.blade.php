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
                    'url' => route('bank.accounts.update', ['id'=>$model->getKey()]),
                ]) !!}
                {!! Form::hidden('id', $model->getKey()) !!}
            @else
            {!! Form::open([
                'method' => 'FETCH',
                'url' => route('bank.accounts.store'),
                ]) !!}
            @endif
        @endif

        <div class="form-group">
            <label>Type</label>
            {!! Form::select('bank_user', $listBankUser, $model->bank_user_id, [
                    'class'         => 'form-control',
                    'disabled'      => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'   => 'Choose User Bank',
                ]) 
            !!}

            @if ($errors->has('bank_user'))
                <small class="form-text text-danger">
                    {{ $errors->first('bank_user') }}
                </small>
            @endif
        </div>

        <div class="form-group corpId">
            <label>Bank Name</label>
            {!! Form::text('bank', ($model->bank) ? $model->bank->name : '', [
                    'class'          =>'form-control bank', 
                    'disabled'       => true,
                ]) 
            !!}
            @if ($errors->has('bank'))
                <small class="form-text text-danger">
                    {{ $errors->first('bank') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Account Number</label>
            {!! Form::text('number', $model->number, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm || $model->exists) ? true : false,
                    'placeholder'    =>'400293421xxxx',
                ]) 
            !!}
            @if ($errors->has('number'))
                <small class="form-text text-danger">
                    {{ $errors->first('number') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Account Name</label>
            {!! Form::text('name', $model->name, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm) ? true : false,
                    'placeholder'    =>'Budi Santoso',
                ]) 
            !!}
            @if ($errors->has('name'))
                <small class="form-text text-danger">
                    {{ $errors->first('name') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Saldo</label>
            {!! Form::text('saldo', $model->saldo, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm) ? true : false,
                    'placeholder'    =>'5.600.000',
                ]) 
            !!}
            @if ($errors->has('saldo'))
                <small class="form-text text-danger">
                    {{ $errors->first('saldo') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Bank Name</label>
            {!! Form::select('type', $listType, $model->type, [
                    'class'         => 'form-control',
                    'disabled'      => (!$actionForm) ? true : false,
                ]) 
            !!}

            @if ($errors->has('type'))
                <small class="form-text text-danger">
                    {{ $errors->first('type') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Telegram ID (for notification)</label>
            {!! Form::text('telegram_id', $model->telegram_id, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm) ? true : false,
                    'placeholder'    =>'128123xxx (Optional)',
                ]) 
            !!}
            @if ($errors->has('telegram_id'))
                <small class="form-text text-danger">
                    {{ $errors->first('telegram_id') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Delay Cron (in minutes)</label>
            {!! Form::text('delay_job_minutes', $model->delay_job_minutes, [
                    'class'          =>'form-control', 
                    'disabled'       => (!$actionForm) ? true : false,
                    'placeholder'    =>'10',
                ]) 
            !!}
            <small class="form-text text-muted">
                *minimal 5 minutes, recomendation is 30 minutes.
            </small>
            @if ($errors->has('delay_job_minutes'))
                <small class="form-text text-danger">
                    {{ $errors->first('delay_job_minutes') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Status Daily Run</label>
            {!! Form::select('daily_job_status', $listDailyStatus, $model->daily_job_status, [
                    'class'         => 'form-control',
                    'disabled'      => (!$actionForm) ? true : false,
                    'placeholder'   => 'Choose Status Daily Run'
                ]) 
            !!}

            @if ($errors->has('daily_job_status'))
                <small class="form-text text-danger">
                    {{ $errors->first('daily_job_status') }}
                </small>
            @endif
        </div>

        <div class="form-group">
            <label>Status</label>
            {!! Form::select('status', $listDailyStatus, $model->status, [
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
            <a href="{{ route('bank.accounts.index') }}" class="btn btn-secondary btn-sm">
                <span class="fa fa-list"></span>
                Return to list
            </a>
            @if ($actionForm)
                {!! Form::submit($model->exists ? 'Save changes' : 'Save', ['class' => 'btn btn-success btn-sm']) !!}
            @else
                <a href="#" class="btn btn-danger btn-sm btn-delete" data-id='{{ $model->getKey() }}' data-title='{{ $model->number }}'>
                    <span class="fa fa-trash"></span>
                    Delete
                </a>
                <a href="{{ route('bank.accounts.edit', ['id'=>$model->getKey()]) }}" class="btn btn-warning btn-sm">
                    <span class="fa fa-pencil"></span>
                    Edit
                </a>
            @endif
        </div>

        {!! Form::close() !!}

        @if ($model->exists)
            @include('bank.accounts._delete')
        @endif
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('select[name=bank_user]').change(function(){
                const data  = {_token: '{{ csrf_token() }}'};
                const bui   = $(this).val();
                const url   = "{{ route('bank.users.getBank', 'userx') }}".replace('userx', bui);
                if(bui != ''){
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(data)
                    })
                    .catch(res => {
                        $('input[name=bank]').val('Bank not found');
                    })
                    .then(response => response.json())
                    .then(res => {
                        $('input[name=bank]').val(res.name);
                    });
                }else{
                    $('input[name=bank]').val('');
                }
            });
        });
</script>
@endsection