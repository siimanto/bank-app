@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">{{ $modelName }}</div>

    <div class="card-body">
        @include('layouts.flash-session')

        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
                <th class="">RTGS Code</th>
                <th class="">Code</th>
                <th class="">Full Code</th>
                <th class="">Name / Register Date</th>
                <th class="text-center">Status</th>
                <th class="text-center">Updated</th>
                <th class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
                @if ($models->count() == 0)
                    <tr>
                        <td colspan="3">No available {{ $title }}</td>
                    </tr>    
                @else
                    @foreach ($models as $model)
                    <tr>
                        <td>
                            <a href="{{ route('bank.lists.show', $model->getKey()) }}">{{ $model->rtgs_code }}</a>
                        </td>
                        <td>
                            {{ $model->full_code }}
                        </td>
                        <td>
                            {{ $model->code }}
                        </td>
                        <td>
                            <a href="{{ route('bank.lists.show', $model->getKey()) }}">{{ $model->name }}</a>
                            <br/>
                            <small>Register at {{ $model->created_at->format('D, d-m-Y h:i') }}</small>
                        </td>
                        <td class="project-title text-center">
                            {{ $model->statusName }}
                        </td>
                        <td class="project-title text-center">
                            <a href="#">{{ $model->updated_at->diffForHumans() }}</a>
                        </td>
                        <td class="project-actions">
                            <a href="{{route('bank.lists.show', $model->getKey())}}" class="btn btn-primary btn-sm"><em class="fa fa-folder"></em> View </a>
                            <a href="{{route('bank.lists.edit', $model->getKey())}}" class="btn btn-warning btn-sm"><em class="fa fa-pencil"></em> Edit </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
          </tbody>
        </table>
        {{ $models->onEachSide(1)->links() }}
    </div>
</div>
@endsection