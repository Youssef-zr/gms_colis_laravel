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
              <h1><i class="fa fa-lock"></i> roles</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{adminurl('/')}}"><i class="fa fa-dashboard"></i> dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{adminurl('roles')}}"><i class="fa fa-lock"></i> roles</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-eye"></i> show</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
@endsection

@section('content')

<div class="box text-capitalize px-3">

    <div class="box-header mb-3 text-right">
    </div>
    <div class="box-body">
        <!-- row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-body">
                        <div class="row">
                            {{-- User name field --}}
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                    {!! Form::label('name', 'Role Name :', ['class'=>'form-label']) !!}
                                    <h6 class="bg-primary py-2 px-2 border-radius text-center text-capitalize">{{ $role->name }}</h6>
                                </div>
                            </div>
                        </div>
                        {{-- End row --}}
                        
                        <div class="row">
                            {{-- User permission list --}}
                            <div class="col-md-6">
                                <div class="form-group {{$errors->has('permission') ? 'has-error' : ''}}">
                                    <ul id="treeview1" class="tree">
                                        <li class="branch"><a href="#">permissions</a>
                                            <ul>
                                                @foreach ($rolePermissions as $permission)
                                                <li>
                                                    <label for="">{{$permission->name}}</label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                        
                                    @if ($errors->has('permission'))
                                    <span class="help-block">
                                        <strong>{{$errors->first('permission')}}</strong>
                                    </span>
                                    @endif
                                </div>
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