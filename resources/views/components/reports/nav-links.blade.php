<!-- resources/views/components/nav-links.blade.php -->

@props(['routeName', 'icon', 'title'])

<li class="nav-item">
    <a class="nav-link{{ (request()->routeIs($routeName)) ? ' active' : '' }}" href="{{ route($routeName, withLang()) }}">
        <i class="{{ $icon }}" style="padding-right: 5px"></i> {{ __($title) }}
    </a>
</li>
