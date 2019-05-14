@if (session('status'))
    <div class="alert alert-{{ session('status') }}" role="alert">
        <strong>{{ session('head') }}</strong><br>
        {{ session('message') }}
    </div>
@endif