@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
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

        .bundel-info-list li {
            margin-bottom: 10px;

        }

        .bundel-info-list li .label {
            text-transform: capitalize;
        }

    </style>
@endpush

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1><i class="fa fa-shopping-basket"></i> {{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('/') }}">
                                <i class="fa fa-dashboard"></i> TABLEAU DE BORD
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-shopping-basket"></i> {{ $title }}</li>
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

                            {{-- btn length --}}
                            <div class="datatables-length">
                                @php
                                    $dtLimit = [25 => 25, 50 => 50, 100 => 100, 500 => 500];
                                    $currentPage = request()->page ? request()->page : 1;
                                @endphp
                                {!! Form::open(['url' => adminUrl('colis'), 'method' => 'get', 'id' => 'change-limit']) !!}
                                {!! Form::hidden('page', 1,['data-total'=>$colisData->total()]) !!}
                                <div class="d-flex align-items-center">
                                    Afficher {!! Form::select('limit', $dtLimit, request()->input('limit', old('limit')), ['class' => 'custom-select']) !!} entrées
                                </div>
                                {!! Form::close() !!}
                            </div>

                            {{-- -------- btns action --}}                            
                            <div class="btn p-0" id="actions">
                                {{-- @can('ajouter_colis') --}}
                                <div class="btn-group">
                                    <a href="{{ route('colis.create') }}" class="btn btn-primary add mr-2 rounded"
                                        data-toggle="tooltip" title="Nouvelle colis">
                                        <i class="fa fa-plus"></i>
                                        Nouveau
                                    </a>
                                    {{-- @can('rechercher_colis') --}}
                                    <button type="button" class="btn btn-warning btn-sm mr-1 rounded" id="search-colis">
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
                                        {{-- @can('mise_en_masse') --}}
                                        <label class="dropdown-item mb-0">
                                            <button type="button" class="btn btn-success btn-sm btn-block"
                                                id="update-colis">
                                                <i class="fa fa-history"></i> Mise en masse
                                            </button>
                                        </label>
                                        {{-- @endcan --}}

                                        <label class="dropdown-item mb-0">
                                            <button class="btn btn-danger btn-sm" id="checkall">
                                                <i class="fa fa-check"></i> Sélectionner tous
                                            </button>
                                        </label>
                                        <label class="dropdown-item mb-0" id="excel">

                                        </label>
                                        <label class="dropdown-item mb-0" id="pdf">

                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- start form --}}
                            {!! Form::open(['route' => 'staff.updateDelivery', 'method' => 'patch', 'id' => 'deliveryForm']) !!}
                            <div class="modal" id="modal-default" style="overflow: hidden">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Mettre à jour </h4>
                                                <button type="button" class="close hide-modal"><i
                                                        class="fa fa-times-circle"></i></button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="date" class="form-label">date</label>
                                                    {!! Form::date('date', old('date'), ['class' => 'form-control']) !!}
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_livreur" class="form-label">livreur</label>
                                                    {!! Form::select('id_livreur', $livreurs, old('id_livreur'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => 'livreurs',
                                                    ]) !!}
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_statut" class="form-label">date</label>
                                                    {!! Form::select('id_statut', $statuts, old('id_statut'), [
                                                        'class' => 'form-control',
                                                        'placeholder' => 'statuts',
                                                    ]) !!}
                                                </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer" style="text-align: center !important">
                                                <button type="submit" class="btn btn-success btn-sm updateDeliveryMan">
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
                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="example" class="stripe row-border order-column" style="width:100%">
                                                <thead>
                                                    <tr role="row">
                                                        <th> </th>
                                                        <th> Date </th>
                                                        <th> Numéro de suivi </th>
                                                        <th> Expéditeur </th>
                                                        <th> Destinataire </th>
                                                        <th> Montant </th>
                                                        <th> N°Commande </th>
                                                        <th> Livreur </th>
                                                        <th> Ville </th>
                                                        <th> Statut </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($colisData as $colis)
                                                        <tr class="bundel-tr" data-id="{{ $colis->id }}">
                                                            <td>
                                                                <div class="icheck-blue ml-2">
                                                                    <input type="checkbox" name="colis[]"
                                                                        value="{{ $colis->id }}"
                                                                        id="checkbox-{{ $colis->id }}">
                                                                    <label for="checkbox-{{ $colis->id }}">
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>{{ $colis->date ? date('d-m-Y', strtotime($colis->date)) : "---" }}</td>
                                                            <td class="colis-get-info text-primary pointer">{{ $colis->numero_suivi }}</td>
                                                            <td>
                                                                @if ($colis->expediteur->nom != null)
                                                                    {{ $colis->expediteur->nom }}
                                                                @else
                                                                    --
                                                                @endif
                                                            </td>
                                                            <td>{{ $colis->nom_destinataire }}</td>
                                                            <td>{{ $colis->montant }}DH</td>
                                                            <td>{{ $colis->numero_commande }}</td>
                                                            <td>
                                                                @if (isset($colis->livreur->name))
                                                                    {{ $colis->livreur->name }}
                                                                @else
                                                                    --
                                                                @endif
                                                            </td>
                                                            <td>{{ $colis->ville->libelle }}</td>
                                                            <td>
                                                                @php
                                                                    $status = \Str::lower($colis->statut->libelle);
                                                                @endphp
                                                                {{ $status }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            {{-- pagination --}}
                                            <div class="paginatiopn-container mt-2 d-inline-block mx-auto">
                                                @php
                                                    $page = isset(request()->page) ? request()->page : 1;
                                                    $previous = $page > 1 ? $page - 1 : 1;
                                                    $next = $page >= 1 ? $page + 1 : 1;
                                                    
                                                    $limit = request('limit') ?? 25;
                                                @endphp

                                                @if ($page > 1)
                                                    <a href="{{ adminUrl("colis?page=$previous&limit=$limit") }}"
                                                        class="btn btn-primary btn-sm mr-2"><i class="fa fa-arrow-left"></i>
                                                        Précédent
                                                    </a>
                                                @endif

                                                @if ($page >= 1 and $page < $colisData->lastPage())
                                                    <a href="{{ adminUrl("colis?page=$next&limit=$limit") }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-arrow-right"></i>
                                                        Suivant
                                                    </a>
                                                @endif
                                            </div>

                                            {{-- total colis --}}
                                            <div class="total-colis">
                                                <ul class="list-unstyled mb-0 d-flex float-right p-0">
                                                    <li>
                                                        <p class="p-0 m-0">Affichage de {{ $colisData->perPage() * $page }}
                                                            à {{ $colisData->total() + 1 }} </p>
                                                    </li>
                                                    <li>
                                                        <p class="p-0 m-0 pl-1"> sur {{ $colisData->total() + 1 }} entrées
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            {{-- end form --}}
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
    {{-- @can('supprimer_colis') --}}
    <div class="modal text-right" id="myModal" style="overflow: hidden">
        <div class="d-flex align-items-center justify-content-center h-100">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">supprimer une colis ?</h4>
                        <button type="button" class="close hide-modal"><i class="fa fa-times-circle"></i></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <h3 class="mb2 text-center" style="color:#f39c12"><i
                                class="fa fa-exclamation-triangle fa-3x"></i>
                        </h3>
                        <p class="text-center">
                            Voulez-vous supprimer cette colis des enregistrements ?
                        </p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="text-align: center !important">
                        <form action="" data-url="{{ adminUrl('colis') }}" method="post" style="display: none"
                            id="form-delete">
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

    {{-- colis information modal --}}
    <div class="modal" id="showColisInfo">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-file-o"></i> Colis information</h4>
                    <button type="button" class="btn btn-danger btn-sm hide-modal"><i class="fa fa-times"></i></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        {{-- colis information --}}
                        <div class="col-md-6 col-lg-7">
                            <ul class="list-unstyled bundel-info-list">
                                <li><b class="label">date: </b> <span id="date"></span></li>
                                <li><b class="label">numero suivi: </b> <span id="numero_suivi"></span></li>
                                <li><b class="label">nom destinataire: </b> <span id="nom_destinataire"></span></li>
                                <li><b class="label">numero commande: </b> <span id="numero_commande"></span></li>
                                <li><b class="label">adresse destinataire: </b> <span id="adresse_destinataire"></span>
                                </li>
                                <li><b class="label">tel: </b> <span id="tel"></span></li>
                                <li><b class="label">montant: </b> <span id="montant"></span></li>
                                <li><b class="label">paye: </b> <span id="paye"></span></li>
                                <li><b class="label">expediteur: </b> <span id="expediteur"></span></li>
                                <li><b class="label">ville: </b> <span id="ville"></span></li>
                                <li><b class="label">statut: </b> <span id="statut"></span></li>
                                <li><b class="label">remarques: </b> <span id="remarques"></span></li>
                            </ul>
                            {{-- colis signature and recu --}}
                            <div id="signature" class="d-none">
                                <div class="form-group">
                                    <label for="signature" class="form-label d-block text-underline">Signature</label>
                                    <img src="" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-5">
                            <div id="recu" class="d-none">
                                <div class="form-group">
                                    <label for="recu" class="form-label d-block text-underline">Recu</label>
                                    <img src="" alt="" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    {{-- @can('editer_colis') --}}
                    <a href="" data-url="{{ adminUrl('colis/') }}" class="btn bg-warning text-left"
                        id="edit-bundel" title='Éditer' data-toggle="tooltip">
                        <i class="fa fa-edit"></i>
                        Éditer
                    </a>
                    {{-- @endcan --}}
                    <button type="button" class="btn btn-danger hide-modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    {{-- search colis modal --}}
    <div class="modal" id="searchColisModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-search"></i> Rechercher Colis</h4>
                    <button type="button" class="btn btn-danger btn-sm hide-modal"><i class="fa fa-times"></i></button>
                </div>

                <!-- Modal body -->
                {!! Form::open(['route' => 'colis.search', 'method' => 'GET']) !!}
                <div class="modal-body">
                    {{-- start row --}}
                    <div class="row">
                        {{-- list status (statuts) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label">Statuts</label>
                                {!! Form::select('status', $statuts, request()->input('status', old('status')), [
                                    'class' => 'form-control w-100',
                                    'placeholder' => 'statuts',
                                ]) !!}
                            </div>
                        </div>
                        {{-- list (expediteurs) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label">Expediteurs</label>
                                {!! Form::select('expediteur', $expediteurs, request()->input('username', old('expediteur')), [
                                    'class' => 'form-control w-100',
                                    'placeholder' => 'Expediteurs',
                                ]) !!}
                            </div>
                        </div>
                        {{-- list (livreurs) --}}
                        <div class="col-md-4">
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
                        {{-- start date --}}
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                                <label for="" class="form-label">Date du</label>
                                {!! Form::date('start_date', request()->input('start_date', old('start_date')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'date du',
                                ]) !!}
                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- end date --}}
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
                                <label for="" class="form-label">Date au</label>
                                {!! Form::date('end_date', request()->input('end_date', old('end_date')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'date au',
                                ]) !!}
                                @if ($errors->has('end_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- tracking number (numero suivi) --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label">Numéro de suivi</label>
                                {!! Form::text('tracking_number', request()->input('tracking_number', old('tracking_number')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Numéro de suivi',
                                ]) !!}
                            </div>
                        </div>

                        {{-- order number (numero de commande) --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label">Numéro de commande</label>
                                {!! Form::text('order_number', request()->input('order_number', old('order_number')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Numéro de commande',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    {{-- end row --}}

                    {{-- start row --}}
                    <div class="row">
                        {{-- recipient name (nom de destinatair) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label">Nom</label>
                                {!! Form::text('name', request()->input('name', old('name')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Nom de destinataire',
                                ]) !!}
                            </div>
                        </div>

                        {{-- recipient adress (adresse de destinatair) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label">Adresse</label>
                                {!! Form::text('adress', request()->input('adress', old('adress')), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Adresse de destinataire',
                                ]) !!}
                            </div>
                        </div>

                        {{-- recipient city (ville de destinatair) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label">Ville</label>
                                {!! Form::select('city', $villes, request()->input('city', old('city')), [
                                    'class' => 'form-control w-100',
                                    'placeholder' => 'ville de destinataire',
                                ]) !!}
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

            let $table = $('#example').DataTable({
                direction: "ltr",
                "order": [
                    [1, 'desc']
                ],
                "aLengthMenu": [
                    [-1],
                    ["touts"]
                ],

                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json"
                },
                "columnDefs": [{
                        "width": "40px",
                        "targets": 0,
                    },
                    {
                        "width": "60px",
                        "targets": 1,
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
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    'colvis'
                ],
                // "searching": false,
                "bInfo": false,
                "lengthChange": false
            });
            // change style of buttons excel and pdf
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

            // check all checkboxes
            let $status = false;
            $('#checkall').on('click', function(e) {
                e.preventDefault();

                $("tbody input[type='checkbox']").prop("checked", !$status)
                $status = !$status;
            });

            // open modal update bundels delivery status
            $('#update-colis').on("click", function() {
                $('#modal-default').fadeIn();
            });

            // check colis selected to affected delivery man
            $('.updateDeliveryMan').on('click', function(e) {
                e.preventDefault();
                let $checkboxColis = $('input[name="colis[]"]:checked');
                if ($checkboxColis.length > 0) {
                    $('#deliveryForm').submit();
                } else {
                    alert('veuillez sélectionner les colis avant les avoir soumis');
                }
            });

            // get bundel ajax information
            $('.colis-get-info').on('click', function() {

                $('#showColisInfo').fadeIn();

                $bundel_id = $(this).parent().data('id');
                let btnEdit = $('#edit-bundel');
                btnEdit.attr("href", btnEdit.data('url') + "/" + $bundel_id + "/edit");

                $.get({
                    url: `/admin/colis/${$bundel_id}`,
                    type: 'GET',
                    success: function(res) {
                        let bundel = res[0];
                        $('span#date').text(bundel.date);
                        $('span#numero_suivi').text(bundel.numero_suivi);
                        $('span#nom_destinataire').text(bundel.nom_destinataire);
                        $('span#numero_commande').text(bundel.numero_commande);
                        $('span#adresse_destinataire').text(bundel.adresse_destinataire);
                        $('span#tel').text(bundel.tel);
                        $('span#montant').text(bundel.montant + "DH");
                        $('span#paye').text(bundel.paye == 0 ? "oui" : "non");
                        $('span#expediteur').text(bundel.expediteur.nom ?? "--");
                        $('span#ville').text(bundel.ville.libelle ?? "--");
                        $('span#statut').text(bundel.statut.libelle ?? "--");
                        $('span#remarques').text(bundel.remarque.libelle ?? "--");

                        const url = '{{ url('') }}';

                        const recu = $("#recu");
                        if (bundel.recu != null) {
                            recu.removeClass('d-none');
                            recu.find("img").attr('src', url + "/" + bundel.recu)
                        } else {
                            recu.addClass('d-none');
                        }

                        const signature = $("#signature");
                        if (bundel.signature != null) {
                            signature.removeClass('d-none');
                            signature.find("img").attr('src', url + "/" + bundel.signature)
                        } else {
                            signature.addClass('d-none');
                        }

                    },
                    error: function() {
                        alert("error");
                    }
                });
            });

            // disbled default pagination and replace by laravel pagination ---
            setTimeout(() => {
                $('#example_paginate').empty();
                $('.total-colis').appendTo('#example_paginate');
                $('.datatables-length').appendTo('#example_filter');
            }, 500);


            // search colis modal ---------------------------------------------
            $('#search-colis').on('click', function() {
                $('#searchColisModal').fadeIn();
            })

            // change table limit
            $('select[name="limit"]').on('change', function() {
                $('#change-limit').submit()
            })

        });
    </script>

    @if ($errors->any())
        <script>
            $(() => {
                $('#searchColisModal').fadeIn();
            })
        </script>
    @endif
@endpush
