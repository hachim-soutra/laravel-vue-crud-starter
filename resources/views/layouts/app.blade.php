<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    <body>
        <div id="app">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
        @extends('layouts.script')
    </body>
</html>
