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
                    <h1><i class="fa fa-globe"></i> Parametres</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('/') }}">
                                <i class="fa fa-dashboard"></i>
                                TABLEAU DE BORD
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-cog"></i> paramètres</li>
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
                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card card-primary card-tabs">
                                            <div class="card-header p-0 pt-1">
                                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                    @can('liste_services')
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="custom-tabs-one-service-tab"
                                                                data-toggle="pill" href="#custom-tabs-one-service"
                                                                role="tab" aria-controls="custom-tabs-one-service"
                                                                aria-selected="true">
                                                                <i class="fa fa-american-sign-language-interpreting"></i>
                                                                Service
                                                            </a>
                                                        </li>
                                                    @endcan
                                                    @can('liste_priorités')
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-one-priorité-tab"
                                                                data-toggle="pill" href="#custom-tabs-one-priorité"
                                                                role="tab" aria-controls="custom-tabs-one-priorité"
                                                                aria-selected="false">
                                                                <i class="fa fa-sort-numeric-desc">

                                                                </i>
                                                                Priorité
                                                            </a>
                                                        </li>
                                                    @endcan
                                                    @can('liste_type_documents')
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-one-document-tab"
                                                                data-toggle="pill" href="#custom-tabs-one-document"
                                                                role="tab" aria-controls="custom-tabs-one-document"
                                                                aria-selected="false">
                                                                <i class="fa fa-file-o"></i>
                                                                Type Document
                                                            </a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                                    {{-- start service tab --}}
                                                    @can('liste_services')
                                                        <div class="tab-pane fade active show" id="custom-tabs-one-service"
                                                            role="tabpanel" aria-labelledby="custom-tabs-one-service-tab">
                                                            <div class="table-responsive">
                                                                @can('ajouter_service')
                                                                    <div class="add-new text-right">
                                                                        <a href="{{ route('services.create') }}"
                                                                            class="btn btn-primary">
                                                                            <i class="fa fa-plus-square"></i>
                                                                            Ajouter
                                                                        </a>
                                                                    </div>
                                                                @endcan
                                                                <table id="example1"
                                                                    class="table stripe row-border order-column"
                                                                    style="width:100%">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th> libelle </th>
                                                                            <th> adresse email </th>
                                                                            <th> actions </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($services as $service)
                                                                            <tr>
                                                                                <td>{{ $service->libelle }}</td>
                                                                                <td>{{ $service->email }}</td>
                                                                                <td>
                                                                                    <div class="btn-group">
                                                                                        <button type="button"
                                                                                            class="btn btn-default btn-flat">Actions</button>
                                                                                        <button type="button"
                                                                                            class="btn btn-default btn-flat dropdown-toggle dropdown-icon"
                                                                                            data-toggle="dropdown"
                                                                                            aria-expanded="false">
                                                                                            <span class="sr-only">Menu</span>
                                                                                        </button>
                                                                                        <div
                                                                                            class="dropdown-menu"role="menu"style="">
                                                                                            @can('editer_service')
                                                                                                <label class="dropdown-item">
                                                                                                    <a href="{{ adminUrl('services/' . $service->id) . '/edit' }}"
                                                                                                        class="btn bg-warning btn-block btn-flat text-left"
                                                                                                        title='Éditer'
                                                                                                        data-toggle="tooltip">
                                                                                                        <i class="fa fa-edit"></i>
                                                                                                        Éditer
                                                                                                    </a>
                                                                                                </label>
                                                                                            @endcan

                                                                                            @can('supprimer_service')
                                                                                                <label class="dropdown-item">
                                                                                                    <a href="#"
                                                                                                        class="btn btn-danger bg-maroon btn-block btn-flat text-left delete"
                                                                                                        data-id="{{ 'services/' . $service->id }}"
                                                                                                        title='Supprimer'
                                                                                                        data-toggle="tooltip">
                                                                                                        <i class="fa fa-trash"></i>
                                                                                                        Supprimer
                                                                                                    </a>
                                                                                                </label>
                                                                                            @endcan
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endcan

                                                    {{-- start priorité tab --}}
                                                    @can('liste_priorités')
                                                        <div class="tab-pane Priorité fade" id="custom-tabs-one-priorité"
                                                            role="tabpanel" aria-labelledby="custom-tabs-one-priorité-tab">
                                                            <div class="table-responsive">
                                                                @can('ajouter_priorité')
                                                                    <div class="add-new text-right">
                                                                        <a href="{{ route('priorites.create') }}"
                                                                            class="btn btn-primary">
                                                                            <i class="fa fa-plus-square"></i>
                                                                            Ajouter
                                                                        </a>
                                                                    </div>
                                                                @endcan
                                                                <table id="example2"
                                                                    class="table2 stripe row-border order-column"
                                                                    style="width:100%">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th> libelle </th>
                                                                            <th class="text-right pr-3"> actions </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($priorites as $priorite)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $priorite->libelle }}
                                                                                </td>
                                                                                <td class="text-right pr-3">
                                                                                    <div class="btn-group">
                                                                                        <button type="button"
                                                                                            class="btn btn-default btn-flat">Actions</button>
                                                                                        <button type="button"
                                                                                            class="btn btn-default btn-flat dropdown-toggle dropdown-icon"
                                                                                            data-toggle="dropdown"
                                                                                            aria-expanded="false">
                                                                                            <span class="sr-only">Menu</span>
                                                                                        </button>
                                                                                        <div class="dropdown-menu"
                                                                                            role="menu" style="">
                                                                                            @can('editer_priorité')
                                                                                                <label class="dropdown-item">
                                                                                                    <a href="{{ adminUrl('priorites/' . $priorite->id) . '/edit' }}"
                                                                                                        class="btn bg-warning btn-block btn-flat text-left"
                                                                                                        title='Éditer'
                                                                                                        data-toggle="tooltip">
                                                                                                        <i class="fa fa-edit"></i>
                                                                                                        Éditer
                                                                                                    </a>
                                                                                                </label>
                                                                                            @endcan

                                                                                            @can('supprimer_priorité')
                                                                                                <label class="dropdown-item">
                                                                                                    <a href="#"
                                                                                                        class="btn btn-danger bg-maroon btn-block btn-flat text-left delete"
                                                                                                        data-id="{{ 'priorites/' . $priorite->id }}"
                                                                                                        title='Supprimer'
                                                                                                        data-toggle="tooltip">
                                                                                                        <i class="fa fa-trash"></i>
                                                                                                        Supprimer
                                                                                                    </a>
                                                                                                </label>
                                                                                            @endcan
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endcan

                                                    {{-- start type document tab --}}
                                                    @can('liste_type_documents')
                                                        <div class="tab-pane fade" id="custom-tabs-one-document"
                                                            role="tabpanel" aria-labelledby="custom-tabs-one-document-tab">
                                                            @can('ajouter_type_document')
                                                                <div class="add-new text-right">
                                                                    <a href="{{ route('typeDocuments.create') }}"
                                                                        class="btn btn-primary"><i class="fa fa-plus-square"></i>
                                                                        Ajouter</a>
                                                                </div>
                                                            @endcan
                                                            <div class="table-responsive">
                                                                <table id="example3"
                                                                    class="table2 stripe row-border order-column"
                                                                    style="width:100%">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th> libelle </th>
                                                                            <th class="text-right pr-3"> actions </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($type_documents as $type_document)
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $type_document->libelle }}
                                                                                </td>
                                                                                <td class="text-right pr-3">
                                                                                    <div class="btn-group">
                                                                                        <button type="button"
                                                                                            class="btn btn-default btn-flat">Actions</button>
                                                                                        <button type="button"
                                                                                            class="btn btn-default btn-flat dropdown-toggle dropdown-icon"
                                                                                            data-toggle="dropdown"
                                                                                            aria-expanded="false">
                                                                                            <span class="sr-only">Menu</span>
                                                                                        </button>
                                                                                        <div class="dropdown-menu"
                                                                                            role="menu" style="">
                                                                                            @can('editer_type_document')
                                                                                                <label class="dropdown-item">
                                                                                                    <a href="{{ adminUrl('typeDocuments/' . $type_document->id) . '/edit' }}"
                                                                                                        class="btn bg-warning btn-block btn-flat text-left"
                                                                                                        title='Éditer'
                                                                                                        data-toggle="tooltip">
                                                                                                        <i class="fa fa-edit"></i>
                                                                                                        Éditer
                                                                                                    </a>
                                                                                                </label>
                                                                                            @endcan
                                                                                            @can('supprimer_type_document')
                                                                                                <label class="dropdown-item">
                                                                                                    <a href="#"
                                                                                                        class="btn btn-danger bg-maroon btn-block btn-flat text-left delete"
                                                                                                        data-id="{{ 'typeDocuments/' . $type_document->id }}"
                                                                                                        title='Supprimer'
                                                                                                        data-toggle="tooltip">
                                                                                                        <i class="fa fa-trash"></i>
                                                                                                        Supprimer
                                                                                                    </a>
                                                                                                </label>
                                                                                            @endcan
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endcan
                                                </div>
                                            </div>
                                            <!-- /.card -->
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
    <div class="modal text-right" id="myModal" style="overflow: hidden">
        <div class="d-flex align-items-center justify-content-center h-100">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">supprimer l'enregistrement ?</h4>
                        <button type="button" class="close hide-modal"><i class="fa fa-times-circle"></i></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <h3 class="mb2 text-center" style="color:#f39c12"><i
                                class="fa fa-exclamation-triangle fa-3x"></i></h3>
                        <p class="text-center">
                            êtes-vous sûr de supprimer cet enregistrement ?
                        </p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="text-align: center !important">
                        <form action="" data-url="{{ adminUrl('') }}" method="post" style="display: none"
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
@endsection


@push('js')
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#example1').DataTable({
                direction: "ltr",
                "order": [
                    [0, 'desc']
                ],
                "aLengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json"
                },
                "columnDefs": [{
                        "width": "180px",
                        "targets": 0
                    },
                    {
                        "width": "160px",
                        "targets": 2
                    },
                ],
            });

            $('.table2').DataTable({
                direction: "ltr",
                "order": [
                    [0, 'desc']
                ],
                "aLengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json"
                },
                "columnDefs": [{
                    "width": "80px",
                    "targets": 0
                }, ],
            });

            // hide modal
            $('.hide-modal').click(function() {
                $('#myModal').slideUp(500);
            })
            // delete record
            $('.delete').click(function(e) {
                e.preventDefault();
                $('#myModal').slideDown(500);
                let id = $(this).data('id'),
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
        });
    </script>
@endpush
