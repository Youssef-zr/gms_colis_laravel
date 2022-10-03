@extends('backend.layouts.master')

@section('braidcrump')
 <!-- Content Header (Page header) -->
 <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><i class="fa fa-dashboard"></i> tableau de bord</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><i class="fa fa-user-o"></i> Bienvenue</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
@endsection

@section('content')
<!-- Default box -->
<div class="card bg-primary mx-2">
  <div class="card-header">
    <h3 class="card-title"><i class="fa fa-chart-line"></i> BIENVENUE SUR LE TABLEAU DE BORD</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
      <h1 class="text-center text-capitalize">
        Rebonjour <span class="badge badge-pill bg-white"> {{auth()->user()->name }}</span>
      </h1>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
<!-- /.content-wrapper -->
@endsection
