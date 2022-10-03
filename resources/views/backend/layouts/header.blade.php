<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>
    {{ config('app.name') }} 
    @if (isset($title))
        - {{ $title }}
    @endif
  </title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ url('assets/adminLte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('assets/adminLte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('assets/adminLte/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  {{-- noty source --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" ></script>
  {{-- select2 --}}
  <link rel="stylesheet" href="{{ url('assets/adminLte/plugins/select2/css/select2.min.css') }}">
  {{-- treeview --}}
  <link rel="stylesheet" href="{{ url('assets/adminLte/plugins/treeview/treeview.css') }}">
  {{-- treeview --}}
  <link rel="stylesheet" href="{{ url('assets/adminLte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  {{-- custom style --}}
  <link rel="stylesheet" href="{{url('assets/dist/css/dashboard.css')}}">
  
  @stack('css')
  
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
      @include('backend.layouts.sidebar')
