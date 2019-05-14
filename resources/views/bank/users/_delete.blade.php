{!! Form::open([
    'method'=>'DELETE', 
    'url' => route('bank.users.destroy', ['id'=>'']),
    'style' => 'display:none', 
    'id'    => 'delete-form']) !!}
{!! Form::close() !!}

@section('css')
    @parent
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
@show

@section('scripts')
    @parent
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.btn-delete').click(function () {
                const btn = $(this);
                swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover {{ $modelName }} '"+btn.data('title')+"'!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel this!",
                    closeOnConfirm: false,
                    closeOnCancel: false 
                }, function (isConfirm) {
                    if (isConfirm) {
                        $('.confirm').prop('disabled', true);
                        const fdelete = $('#delete-form');
                        fdelete.attr('action', fdelete.attr('action')+"/"+btn.data('id')).submit();
                    } else {
                        swal("Cancelled", "{{ $modelName }} data is safe :)", "error");
                    }
                });
            });
        });
    </script>
@show