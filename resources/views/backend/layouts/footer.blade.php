  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="http://assets/adminLte.io">{{ config('app.name') }}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 0.1
    </div>
  </footer>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap -->
<script src="{{ url('assets/adminLte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ url('assets/adminLte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- assets/adminLte App -->
<script src="{{ url('assets/adminLte/dist/js/adminlte.js') }}"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="{{ url('assets/adminLte/dist/js/demo.js') }}"></script>
{{-- select2 --}}
<script src="{{ url('assets/adminLte/plugins/select2/js/select2.min.js') }}"></script>
{{-- treview --}}
<script src="{{ url('assets/adminLte/plugins/treeview/treeview.js') }}"></script>
<!-- PAGE SCRIPTS -->
<script src="{{ url('assets/adminLte/dist/js/pages/dashboard.js') }}"></script>
{{-- my dashboard script --}}
<script src="{{ url('assets/dist/js/dashboard.js') }}"></script>

@stack('js')

<script>
  $(()=>{
    $('[data-toggle="tooltip"]').tooltip();
    $('select').select2();

    // open treeview in load of page
    $('.branch').find('ul li').css({
      'display':'block'
    })
  })
</script>
</body>
</html>
