@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $modelName }}

        <a href="{{route('bank.accounts.create')}}" class="btn btn-default btn-xs float-right">
            <em class="fa fa-plus"></em>
            Create a new {{ $title }}
        </a>
    </div>

    <div class="card-body">
        @include('layouts.flash-session')

        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
                <th class="">Account Name / Created Date</th>
                <th class="">Account Number</th>
                <th class="">Bank Name</th>
                <th class="">Type</th>
                <th class="">Status</th>
                <th class="text-center">Updated</th>
                <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
                @if ($models->count() == 0)
                    <tr>
                        <td colspan="7">No available {{ $title }}</td>
                    </tr>    
                @else
                    @foreach ($models as $model)
                    <tr>
                        <td>
                            <a href="{{ route('bank.accounts.show', $model->getKey()) }}">{{ $model->name }}</a>
                            <br/>
                            <small>Added at {{ $model->created_at->format('D, d-m-Y h:i') }}</small>
                        </td>
                        <td>
                            {{ $model->number }}
                        </td>
                        <td>
                            {{ $model->bank->name }}
                        </td>
                        <td class="text-center">
                            {{ $model->typeName }}
                        </td>
                        <td class="text-center">
                            {{ $model->statusName }}
                        </td>
                        <td class="text-center">
                            <a href="#">{{ $model->updated_at->diffForHumans() }}</a>
                        </td>
                        <td>
                            <a href="{{route('bank.accounts.show', $model->getKey())}}" class="btn btn-primary btn-sm"><em class="fa fa-folder"></em> View </a>
                            <a href="{{route('bank.accounts.edit', $model->getKey())}}" class="btn btn-warning btn-sm"><em class="fa fa-pencil"></em> Edit </a>
                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id='{{ $model->getKey() }}' data-title='{{ $model->number }}'><em class="fa fa-trash"></em> Delete </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
          </tbody>
        </table>
        {{ $models->onEachSide(1)->links() }}
    </div>
</div>
@include('bank.accounts._delete')
@endsection