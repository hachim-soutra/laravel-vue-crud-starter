<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body>
    <div id="app" style="width: 80%;margin: 0 0 0 5%;
    height: 80vh;
    min-height: 70vh;
    overflow-y: scroll;
">
        @include('layouts.aside')
        @include('layouts.content')

        <router-view></router-view>

        <vue-progress-bar></vue-progress-bar>

    </div>
    @include('layouts.script')
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>
