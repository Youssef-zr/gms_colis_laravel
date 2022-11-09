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
            height: 250px;
            border-color: #999;
            border-radius: 10px;
            overflow: hidden
        }

        .img-receipt {
            width: 300px;
            height: 300px;
            margin: auto
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
                                <i class="fa fa-shopping-basket"></i>
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
                            {!! Form::open(['route' => ['bundel.signature.update', 'bundel_id'], 'method' => 'patch', 'files' => true]) !!}
                            {!! Form::hidden('bundel_id', $bundel_id) !!}
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-3">
                                    <div class="form-group mb-1 {{ $errors->has('signed') ? 'has-error' : '' }}">
                                        {!! Form::label('signed', 'signature', ['class' => 'form-label']) !!}
                                        {!! Form::textarea('signed', null, ['style' => 'display: none', 'class' => 'form-control']) !!}
                                        <div id="sig"></div>

                                        @if ($errors->has('libelle'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('libelle') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if (isset($oldSignature) and $oldSignature != null)
                                    <div class="col-12 col-md-6 col-lg-5 text-center">
                                        <img src="{{ url($oldSignature) }}" alt="signature">
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-3">
                                    <div class="form-group {{ $errors->has('receipt') ? 'has-error' : '' }}">
                                        {!! Form::label('receipt', 'reçu', ['class' => 'form-label']) !!}
                                        {!! Form::file('receipt', [
                                            'name' => 'receipt',
                                            'class' => 'form-control',
                                        ]) !!}
                                        <small id="emailHelp" class="form-text text-muted">
                                            image de recu doit etre de type (jpg,png,jpeg,gif,svg)
                                        </small>
                                        @if ($errors->has('receipt'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('receipt') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="actions">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-send"></i>
                                            Valider
                                        </button>
                                        <button id="clear" class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                            Effacer
                                        </button>
                                    </div>
                                </div>
                                @if (isset($oldReceipt) and $oldReceipt != null)
                                    <div class="col-12 col-md-6 col-lg-5 text-center">
                                        <div class="img-receipt">
                                            <img src="{{ url($oldReceipt) }}" class="img-responsive" alt="signature">
                                        </div>
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
        $(() => {
            $.widget("ns.widget", {});
            var sig = $('#sig').signature({
                syncField: '#signed',
                syncFormat: 'PNG'
            });

            $('#clear').click(function(e) {
                e.preventDefault();
                sig.signature('clear');
                $("#signature64").val('');
                $('input[type="file"]').val('');
            });
        })
    </script>
@endpush
