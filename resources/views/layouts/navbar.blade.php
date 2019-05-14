<ul class="navbar-nav mr-auto">
    @php
        $menu = [
            'Bank Lists',
            'Bank Users',
            'Bank Accounts',
            'Bank Logs'
        ];

        $segments = str_replace(config('app.url'), '', Request::url());
    @endphp
    @foreach ($menu as $item)
        <li class="nav-item">
            <a class="nav-link @if (substr_count($segments, str_replace(' ', '/', strtolower($item))) > 0) active @endif" href="{{ route(str_replace(' ', '.', strtolower($item)).'.index') }}">{{ $item }}</a>
        </li>
    @endforeach
</ul>