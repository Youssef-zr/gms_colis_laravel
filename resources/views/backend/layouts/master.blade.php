@include('backend.layouts.header')
@include('backend.layouts.nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper px-2">
    @yield('braidcrump')
    @yield('content')
</div>
@include('backend.layouts.footer')
@include('_partial._messages')