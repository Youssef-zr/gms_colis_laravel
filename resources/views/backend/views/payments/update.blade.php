@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

    <style>
        div.dataTables_wrapper {
            direction: ltr;
        }

        /* Ensure that the demo table scrolls */
        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            margin: 15px auto 0;
        }

        .hidden {
            display: none
        }
    </style>
@endpush

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa fa-credit-card-alt"></i> {{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('payments') }}">
                                <i class="fa fa fa-credit-card-alt"></i>
                                list colis
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-pencil"></i> {{ $title }}</li>
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
                            <h3><i class="fa fa-pencil"></i> {{ $title }} </h3>
                        </div>
                        <div class="card-body">
                            {!! Form::model($payment, ['route' => ['payments.update', $payment->id], 'method' => 'patch', 'files' => true]) !!}
                            @include('backend.views.payments.form')
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
