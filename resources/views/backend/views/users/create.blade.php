@extends('backend.layouts.master')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

<style>
	div.dataTables_wrapper {
        direction: ltr;
    }
 
    /* Ensure that the demo table scrolls */
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 95%;
        margin: 0 auto;
    }
</style>
@endpush

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1><i class="fa fa-users"></i> utilisateurs</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{adminurl('users')}}"><i class="fa fa-users"></i> utilisateurs</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-plus-circle"></i> Nouveau</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
@endsection

@section('content')

<div class="box text-capitalize px-3">
    <div class="box-body">
        <!-- row -->
        <div class="row">
            <div class="col-xl-12">
              <div class="card card-primary mg-b-20">
                <div class="card-header">
                    <h3><i class="fa fa-plus-circle"></i> Nouveau Utilisateur </h3>
                </div>
                <div class="card-body">
                    {!! Form::open(['route'=>'users.store','method'=>'POST']) !!}
                        @include('backend.views.users.form')
                    {!! Form::close() !!}
                </div>
              </div>
            </div>
        <!-- row closed -->
        </div>
	<!-- Container closed -->
    </div>
</div>

@endsection
