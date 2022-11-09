@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" />
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

        .select2 {
            width: 100% !important;
        }

        [class*="icheck-"]>input:first-child+input[type="hidden"]+label::before,
        [class*="icheck-"]>input:first-child+label::before {
            border-color: #007bff
        }

        @media (min-width: 576px) {
            .modal-dialog {
                width: 500px;
            }
        }

        .dt-buttons {
            margin-bottom: 10px
        }
    </style>
@endpush

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1><i class="fa fa-credit-card-alt"></i> {{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('/') }}">
                                <i class="fa fa-dashboard"></i> TABLEAU DE BORD
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-credit-card-alt"></i> {{ $title }}</li>
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
                        <div class="card-body">
                            {{-- -------- btns action --}}
                            <div class="btn p-0" id="actions">
                                {{-- @can('ajouter_paiment') --}}
                                <div class="btn-group">
                                    <a href="{{ route('paiements.create') }}" class="btn btn-primary add mr-2 rounded"
                                        data-toggle="tooltip" title="Nouvelle paiement">
                                        <i class="fa fa-plus"></i>
                                        Nouveau
                                    </a>
                                    {{-- @can('rechercher_paiement') --}}
                                    <button type="button" class="btn btn-warning btn-sm mr-1 rounded" id="search-paiement">
                                        <i class="fa fa-search"></i> Rechercher
                                    </button>
                                    {{-- @endcan --}}
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-cogs"></i>
                                        Actions
                                    </button>
                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Menu</span>
                                    </button>

                                    <div class="dropdown-menu" role="menu">
                                        <label class="dropdown-item mb-0" id="excel">

                                        </label>
                                        <label class="dropdown-item mb-0" id="pdf">

                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="example" class="stripe row-border order-column" style="width:100%">
                                                <thead>
                                                    <tr role="row">
                                                        <th> # </th>
                                                        <th> Date </th>
                                                        <th> livreur </th>
                                                        <th> Expéditeur </th>
                                                        <th> Montant </th>
                                                        <th> actions </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($paiements as $paiement)
                                                        <tr>
                                                            <td>{{ $paiement->id }}</td>
                                                            <td>{{ $paiement->date ? date('d-m-Y', strtotime($paiement->date)) : '---' }}
                                                            </td>
                                                            <td>{{ $paiement->livreur->name }}</td>
                                                            <td>{{ $paiement->expediteur->nom }}</td>
                                                            <td>{{ $paiement->montant }}DH</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    {{-- @can('editer_paiment') --}}
                                                                    <a href="{{ adminUrl('paiements/' . $paiement->id . '/edit') }}"
                                                                        class="btn bg-warning btn-sm text-left"
                                                                        title='Éditer' data-toggle="tooltip">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    {{-- @endcan --}}

                                                                    {{-- @can('supprimer_paiment') --}}
                                                                    <a href="#"
                                                                        class="btn btn-danger bg-maroon btn-sm text-left delete"
                                                                        data-id="{{ $paiement->id }}" title='supprimer'
                                                                        data-toggle="tooltip">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                    {{-- @endcan --}}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- {!! Form::close() !!} --}}
                                        </div>
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
    {{-- modal delete record --}}

    <!-- The Modal Remove Castumer -->
    {{-- @can('supprimer_paiement') --}}
    <div class="modal text-right" id="myModal" style="overflow: hidden">
        <div class="d-flex align-items-center justify-content-center h-100">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">supprimer paiment ?</h4>
                        <button type="button" class="close hide-modal"><i class="fa fa-times-circle"></i></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <h3 class="mb2 text-center" style="color:#f39c12"><i
                                class="fa fa-exclamation-triangle fa-3x"></i>
                        </h3>
                        <p class="text-center">
                            Voulez-vous supprimer ce paiment des enregistrements ?
                        </p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="text-align: center !important">
                        <form action="" data-url="{{ adminUrl('paiements') }}" method="post"
                            style="display: none" id="form-delete">
                            @csrf
                            @method('delete')
                        </form>
                        <button type="button" class="btn btn-success btn-confirm btn-sm">
                            <i class="fa fa-send"></i>
                            Confirmer
                        </button>
                        <button type="button" class="btn btn-danger bg-maroon hide-modal btn-sm">
                            <i class="fa fa-times"></i>
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @endcan --}}

    {{-- search colis modal --}}
    <div class="modal" id="searchPaiementModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-search"></i> Rechercher Colis</h4>
                    <button type="button" class="btn btn-danger btn-sm hide-modal"><i class="fa fa-times"></i></button>
                </div>

                <!-- Modal body -->
                {!! Form::open(['route' => 'paiements.search', 'method' => 'GET']) !!}
                <div class="modal-body">
                    {{-- start row --}}
                    <div class="row">
                        {{-- list (expediteurs) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="form-label">Expediteurs</label>
                                {!! Form::select('expediteur', $expediteurs, request()->input('username', old('expediteur')), [
                                    'class' => 'form-control w-100',
                                    'placeholder' => 'Expediteurs',
                                ]) !!}
                            </div>
                        </div>
                        {{-- list (livreurs) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="form-label">Livreurs</label>
                                {!! Form::select('deliveryMan', $livreurs, request()->input('deliveryMan', old('deliveryMan')), [
                                    'class' => 'form-control w-100',
                                    'placeholder' => 'livreurs',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    {{-- end row --}}

                    {{-- start row --}}
                    <div class="row">
                        {{-- date field --}}
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                <label for="" class="form-label">Date</label>
                                {!! Form::date('date', request()->input('date', old('date')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Date Paiement',
                                ]) !!}
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{-- montant field --}}
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('montant') ? 'has-error' : '' }}">
                                <label for="" class="form-label">Montant</label>
                                {!! Form::text('montant', request()->input('montant', old('montant')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Montant Paiement',
                                ]) !!}
                                @if ($errors->has('montant'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('montant') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- end row --}}
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm" id="submit-search-form">
                        <i class="fa fa-search"></i>
                        Rechercher
                    </button>
                    <button type="button" class="btn btn-danger hide-modal btn-sm">
                        <i class="fa fa-times"></i>
                        Fermer
                    </button>
                </div>

                {!! Form::close() !!}
                {{-- end form --}}

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-2.1.1/b-html5-2.1.1/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/numeric-comma.js"></script>
    <script>
        $(document).ready(function() {

            $table = $('#example').DataTable({
                direction: "ltr",
                "order": [
                    [0, 'desc']
                ],
                "aLengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "touts"]
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json"
                },
                "columnDefs": [{
                        "width": "60px",
                        "targets": 0,
                        "type": "numeric-comma",
                    },
                    {
                        "width": "160px",
                        "targets": $('#example').find('thead th').length - 1
                    },
                ],
                "buttons": [{
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [1, 2, 3,4]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [1, 2, 3,4]
                        }
                    },
                    'colvis'
                ],
                // "searching": false,

            });

            setTimeout(() => {
                $table.buttons().container().insertBefore('#example_filter');
                $('.buttons-excel').toggleClass('btn-secondary btn-success btn-block btn-sm').html(
                    '<i class="fa fa-file-excel-o"></i> Excel');
                $('.buttons-pdf').toggleClass('btn-secondary btn-warning btn-block btn-sm').html(
                    '<i class="fa fa-file-pdf-o"></i> Pdf');
                $('#example_length').css({
                    'display': 'block',
                    'margin-right': "20px"
                })
                $('#example_filter').empty();

                // move actions btns to filter container
                $('#actions').appendTo(".dt-buttons");
                $('.buttons-pdf').appendTo("#excel")
                $('.buttons-excel').appendTo("#pdf")

            }, 500);

            // hide modal
            $('.hide-modal').click(function() {
                $('.modal').fadeOut();
            })
            // delete record
            $('.delete').click(function(e) {
                e.preventDefault();
                $('#myModal').slideDown(500);
                let id = parseInt($(this).data('id')),
                    form = $('#form-delete');
                form.attr('action', form.data('url') + '/' + id);

            });
            // close modal cliking in overlay only
            $('#myModal').on('click', function(e) {
                e.target.id == "myModal" ? $('#myModal').slideUp(500) : 'break';
            });
            // confirm btn submit form 
            $('.btn-confirm').click(function() {
                $('#form-delete').submit();
            })
            
            // search paiement modal ---------------------------------------------
            $('#search-paiement').on('click', function() {
                $('#searchPaiementModal').fadeIn();
            })

        });
    </script>
@endpush
