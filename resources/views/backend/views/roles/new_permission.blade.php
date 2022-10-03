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
              <h1><i class="fa fa-lock"></i> rôles</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{adminurl('/')}}"><i class="fa fa-dashboard"></i> tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{adminurl('roles')}}"><i class="fa fa-lock"></i> rôles</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-plus-circle"></i> nouveau</li>
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
                        <h3><i class="fa fa-plus-circle"></i> autorisation </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::open(['route'=>'permission.store','method'=>'POST']) !!}
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <div class="option">
                                            {!! Form::label("name", "nom", ["class"=>'form-label']) !!}
                                            <span class="star text-danger">*</span>
                                        </div>
                                        {!! Form::text('name', old('name'), ["class"=>'form-control',"placeholder"=>"Nom De L'autorisation"]) !!}

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary mt-3"><i class="fa fa-floppy-o float"></i> Enregistrer</button>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- row closed -->
        </div>
	<!-- Container closed -->
    </div>
</div>

@endsection
