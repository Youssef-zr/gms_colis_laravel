@extends('backend.layouts.master')

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-map-marker"></i> {{$title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('villes') }}">
                                <i class="fa fa-map"></i>
                                villes
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-pencil-square"></i> {{ $title }}</li>
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
                    <div class="card card-warning mg-b-20">
                        <div class="card-header">
                            <h3><i class="fa fa-pencil-square"></i> {{ $title }} </h3>
                        </div>
                        <div class="card-body">
                            {!! Form::model($ville, ['route' => ['villes.update', $ville->id_ville],"method"=>"patch"]) !!}
                            @include('backend.views.villes.form')
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
