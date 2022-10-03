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
    </style>
@endpush

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-lock"></i> les rôles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('/') }}"><i class="fa fa-dashboard"></i>
                                TABLEAU DE BORD
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-lock"></i> {{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')
    <div class="box text-capitalize px-3">

        @can('nouveau_rôle')
            <div class="box-header mb-3 text-right">
                <a href="{{ adminUrl('roles/create') }}" class="btn btn-primary btn-sm add"> 
                    <i class="fa fa-plus"></i> 
                    Nouveau
                </a>
            </div>
        @endcan
        <div class="box-body">
            <!-- row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-body">
                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="example" class="stripe row-border order-column w-100">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">nom de rôle</th>
                                                        <th class="text-right pr-4">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @php
                                                        $i = 1;
                                                    @endphp

                                                    @foreach ($roles as $role)
                                                        <tr>
                                                            <td class="text-center"> {{ $i }} </td>
                                                            <td class="text-center">
                                                                <span
                                                                    class="badge {{ $role->name == 'developpeur' ? 'bg-warning' : 'bg-success' }}">
                                                                    {{ $role->name }}
                                                                </span>
                                                            </td>
                                                            <td class="text-right pr-3">
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="btn btn-default btn-flat">Actions</button>
                                                                    <button type="button"
                                                                        class="btn btn-default btn-flat dropdown-toggle dropdown-icon"
                                                                        data-toggle="dropdown" aria-expanded="false">
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <div class="dropdown-menu" role="menu"
                                                                        style="">

                                                                        @can('afficher_rôle')
                                                                            <label class="dropdown-item">
                                                                                <a href="{{ adminurl('roles/' . $role->id) }}"
                                                                                    class="btn btn-primary btn-block btn-flat text-left"
                                                                                    title='Afficher Role'
                                                                                    data-toggle="tooltip"><i
                                                                                        class="fa fa-eye"></i> Afficher</a>
                                                                            </label>
                                                                        @endcan

                                                                        @can('editer_rôle')
                                                                            <label class="dropdown-item">
                                                                                <a href="{{ adminurl('roles/' . $role->id . '/edit') }}"
                                                                                    class="btn btn-warning btn-block btn-flat text-left"
                                                                                    title='Editer' data-toggle="tooltip"><i
                                                                                        class="fa fa-edit"></i> Editer</a>
                                                                            </label>
                                                                        @endcan

                                                                        @can('supprimer_rôle')
                                                                            @if ($role->id != 1)
                                                                                <label class="dropdown-item">
                                                                                    <a href="#"
                                                                                        class="btn btn-danger bg-maroon btn-block btn-flat text-left delete_role"
                                                                                        data-id="{{ $role->id }}"
                                                                                        title='Supprimer'
                                                                                        data-toggle="tooltip"><i
                                                                                            class="fa fa-trash"></i>
                                                                                        Supprimer</a>
                                                                                </label>
                                                                            @endif
                                                                        @endcan
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
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

    <!-- Modal Remove Role -->
    @can('supprimer_rôle')
        <div class="modal text-left" id="myModal" style="overflow: hidden">
            <div class="d-flex align-items-center justify-content-center h-100">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Supprimer ce rôle ?</h4>
                            <button type="button" class="close hide-modal"><i class="fa fa-times-circle"></i></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <h3 class="mb2 text-center" style="color:#f39c12"><i class="fa fa-exclamation-triangle fa-3x"></i>
                            </h3>
                            <p class="text-center">
                                Voulez-vous supprimer ce rôle des enregistrements ?
                            </p>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer" style="text-align: center !important">
                            <form action="" data-url="{{ adminUrl('roles') }}" method="post" style="display: none"
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
    @endcan
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                direction: "rtl",
                "order": [
                    [0, 'asc']
                ],
                "aLengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr-FR.json"
                },
                "columnDefs": [{
                        "width": "60px",
                        "targets": 0
                    },
                    {
                        "width": "160px",
                        "targets": $('table').find('thead th').length - 1
                    },
                ],
            });
            // hide modal
            $('.hide-modal').click(function() {
                $('#myModal').slideUp(500);
            })
            // delete record
            $('.delete_role').click(function(e) {
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
