<!DOCTYPE html>
<html>
@include('scripts.common.head')
<body>
    <div id="top">
        @include('scripts.common.header')
        @include('scripts.common.menu')
    </div>
    <main>
        @yield('content')
    </main>

    @include('scripts.common.footer')
</div>
</body>
</html>