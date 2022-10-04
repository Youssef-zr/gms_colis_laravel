@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

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

        .kbw-signature {
            width: 100%;
            height: 200px;
        }
    </style>
@endpush

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-file-signature"></i> {{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('bundels') }}">
                                <i class="fas fa-file-signature"></i>
                                list colis
                            </a>
                        </li>
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
                            <h3><i class="fas fa-file-signature"></i> {{ $title }} </h3>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => ['bundel.signature.update', 'bundel_id'], 'method' => 'patch']) !!}
                            {!! Form::hidden('bundel_id', $bundel_id) !!}
                            <div class="row align-items-md-center">
                                <div class="col-md-12 col-lg-5">
                                    <div class="form-group mb-1">
                                        {!! Form::label('signature', 'Signature', ['class' => 'form-label']) !!}
                                        {!! Form::textarea('signature', null, [
                                            'name' => 'signed',
                                            'style' => 'display: none',
                                            'class' => 'form-control',
                                        ]) !!}
                                        <div id="sig"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-send"></i>
                                        Valider
                                    </button>
                                    <button id="clear" class="btn btn-danger">
                                        <i class="fa fa-times"></i>
                                        Effacer
                                    </button>
                                </div>
                                @if ($oldSignature != null)
                                    <div class="col-12 col-md-6 col-lg-7">
                                        <img src="{{ url($oldSignature) }}" alt="signature">
                                    </div>
                                @endif
                            </div>
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

@push('js')
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
    <script>
        $.widget("ns.widget", {});
        var sig = $('#sig').signature({
            syncField: '#signature',
            syncFormat: 'PNG'
        });

        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
        $(() => {})
    </script>
@endpush
