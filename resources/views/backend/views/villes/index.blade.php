@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" />
@endpush

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-map"></i> {{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('/') }}">
                                <i class="fa fa-dashboard"></i> TABLEAU DE BORD
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-map"></i> {{ $title }}</li>
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
                             <!-- btns action -->
                             <div class="btn p-0" id="actions">
                                {{-- @can('ajouter_ville') --}}
                                <div class="btn-group">
                                    <a href="{{ adminUrl('villes/create') }}" class="btn btn-primary add mr-2 rounded"
                                        data-toggle="tooltip" title="Nouvelle ville">
                                        <i class="fa fa-plus"></i>
                                        Nouveau
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-cogs"></i>
                                        Actions
                                    </button>
                                    <button type="button" class="btn btn-info border-left dropdown-toggle dropdown-icon"
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
                                                        <th> Ville </th>
                                                        <th> actions </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($villes as $ville)
                                                        <tr>
                                                            <td>{{ $ville->id_ville }}</td>
                                                            <td>{{ $ville->libelle }}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    {{-- @can('editer_ville') --}}
                                                                    <a href="{{ adminUrl('villes/' . $ville->id_ville . '/edit') }}"
                                                                        class="btn bg-warning text-left btn-sm"
                                                                        title='Éditer' data-toggle="tooltip">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    {{-- @endcan --}}

                                                                    {{-- @can('supprimer_ville') --}}
                                                                    <a href="#"
                                                                        class="btn btn-danger bg-maroon text-left btn-sm delete"
                                                                        data-id="{{ $ville->id_ville }}" title='supprimer'
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
    {{-- @can('supprimer_client') --}}
    <div class="modal text-right" id="myModal" style="overflow: hidden">
        <div class="d-flex align-items-center justify-content-center h-100">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">supprimer une ville ?</h4>
                        <button type="button" class="close hide-modal"><i class="fa fa-times-circle"></i></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <h3 class="mb2 text-center" style="color:#f39c12"><i class="fa fa-exclamation-triangle fa-3x"></i>
                        </h3>
                        <p class="text-center">
                            Voulez-vous supprimer cette ville des enregistrements ?
                        </p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="text-align: center !important">
                        <form action="" data-url="{{ adminUrl('villes') }}" method="post" style="display: none"
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
                    [10, 25, 50, "Tout"]
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json"
                },
                "columnDefs": [{
                        "width": "90px",
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
                            columns: [1]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [1]
                        }
                    }
                ],
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
                $('#example_filter').css({
                    marginRight: "15px"
                });

                // move actions btns to filter container
                $('#actions').appendTo(".dt-buttons");
                $('.buttons-pdf').appendTo("#excel")
                $('.buttons-excel').appendTo("#pdf")

            }, 500);


            // hide modal
            $('.hide-modal').click(function() {
                $('#myModal').slideUp(500);
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
        });
    </script>
@endpush

@push('css')
    <style>

    </style>
@endpush
