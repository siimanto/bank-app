@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $modelName }}
    </div>

    <div class="card-body">
        @include('layouts.flash-session')

        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
                <th class="">Account Name / Created Date</th>
                <th class="">Account Number</th>
                <th class="">Bank Name</th>
                <th class="">Status</th>
                <th class="text-center">Updated</th>
                <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
                @if ($models->count() == 0)
                    <tr>
                        <td colspan="6">No available {{ $title }}</td>
                    </tr>    
                @else
                    @foreach ($models as $model)
                    <tr>
                        <td>
                            <a href="{{ route('bank.logs.show', $model->getKey()) }}">{{ $model->bank_username }}</a>
                            <br/>
                            <small>Added at {{ $model->created_at->format('D, d-m-Y h:i') }}</small>
                        </td>
                        <td>
                            {{ $model->bank_account_number }}
                        </td>
                        <td>
                            {{ $model->event }}
                        </td>
                        <td class="text-center">
                            {{ $model->statusName }}
                        </td>
                        <td class="text-center">
                            <a href="#">{{ $model->updated_at->diffForHumans() }}</a>
                        </td>
                        <td>
                            <a href="{{route('bank.logs.show', $model->getKey())}}" class="btn btn-primary btn-sm"><em class="fa fa-folder"></em> View </a>
                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id='{{ $model->getKey() }}' data-title='{{ $model->bank_username." event ".$model->event }}'><em class="fa fa-trash"></em> Delete </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
          </tbody>
        </table>
        {{ $models->onEachSide(1)->links() }}
    </div>
</div>
@include('bank.logs._delete')
@endsection