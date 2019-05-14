@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">{{ $modelName }}</div>

    <div class="card-body">
        @include('layouts.flash-session')

        <div class="form-group">
            <label>Username</label>
            {!! Form::text('username', $model->bank_username, [
                    'class'          =>'form-control bank', 
                    'disabled'       => true,
                ]) 
            !!}
        </div>

        <div class="form-group">
            <label>Account Number</label>
            {!! Form::text('account_number', $model->bank_account_number, [
                    'class'          =>'form-control', 
                    'disabled'       => true,
                ]) 
            !!}
        </div>

        <div class="form-group">
            <label>Event</label>
            {!! Form::text('event', $model->event, [
                    'class'          =>'form-control', 
                    'disabled'       => true,
                ]) 
            !!}
        </div>

        <div class="form-group">
            <label>URL</label>
            {!! Form::text('username', $model->url, [
                    'class'          =>'form-control bank', 
                    'disabled'       => true,
                ]) 
            !!}
        </div>

        <div class="form-group">
            <label>HTTP Code</label>
            {!! Form::text('username', $model->http_code, [
                    'class'          =>'form-control bank', 
                    'disabled'       => true,
                ]) 
            !!}
        </div>

        <div class="form-group">
            <label>Response Code</label>
            {!! Form::text('username', $model->response_code, [
                    'class'          =>'form-control bank', 
                    'disabled'       => true,
                ]) 
            !!}
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" {{ (!$actionForm) ? 'disabled' : '' }} class="form-control" rows="3">{{ $model->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Status</label>
            {!! Form::select('status', $listStatus, $model->status, [
                    'class'         => 'form-control',
                    'disabled'      => true,
                ]) 
            !!}
        </div>

        <div class="col-sm-6 col-sm-offset-2">
            <a href="{{ route('bank.logs.index') }}" class="btn btn-secondary btn-sm">
                <span class="fa fa-list"></span>
                Return to list
            </a>
            @if ($actionForm)
                <a href="#" class="btn btn-danger btn-sm btn-delete" data-id='{{ $model->getKey() }}' data-title='{{ $model->number }}'>
                    <span class="fa fa-trash"></span>
                    Delete
                </a>
            @endif
        </div>

        @if ($model->exists)
            @include('bank.logs._delete')
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