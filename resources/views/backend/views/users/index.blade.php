@extends('backend.layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

    <style>
        table tbody tr td {
            position: relative;
            padding: 10px 0 !important
        }

        .user-photo {
            width: 50px;
            height: 50px;
            position: absolute;
            top: 3px;
            left: 20px;
            border-radius: 50%
        }
    </style>
@endpush

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-users"></i> {{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('/') }}"><i class="fa fa-dashboard"></i>
                                TABLEAU DE BORD
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-users"></i> {{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')
    <div class="box text-capitalize px-3">

        {{-- @can('nouveau_utilisateur') --}}
        <div class="box-header mb-3 text-right">
            <a href="{{ adminUrl('users/create') }}" class="btn btn-primary btn-sm add">
                <i class="fa fa-plus"></i>
                nouveau
            </a>
        </div>
        {{-- @endcan --}}
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
                                            <table id="example" class="stripe row-border order-column text-capitalize"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>photo</th>
                                                        <th>nom</th>
                                                        <th>email</th>
                                                        <th>statut</th>
                                                        <th>derni??re connexion</th>
                                                        <th>r??le d'utilisateur</th>
                                                        <th>Expediteur</th>
                                                        <th>actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp

                                                    @foreach ($users as $user)
                                                        <tr>
                                                            <td> {{ $i }} </td>
                                                            <td> <img src="{{ url($user->path) }}" alt="{{ $user->path }}"
                                                                    class="user-photo"> </td>
                                                            <td> {{ $user->name }} </td>
                                                            <td> {{ $user->email }} </td>
                                                            <td>
                                                                @if ($user->status == 'activ??')
                                                                    <span class="badge badge-pill badge-success"
                                                                        style="position: relative;">
                                                                        <span class="pulse" style="right:-15px"></span>
                                                                        {{ $user->status }}
                                                                    </span>
                                                                @else
                                                                    <span class="badge badge-pill badge-danger"
                                                                        style="position: relative;">
                                                                        <span class="pulse-danger"
                                                                            style="right:-15px"></span>
                                                                        {{ $user->status }}
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($user->lastLogin() != 'pas encore connect??')
                                                                    <span
                                                                        class="text-lowercase badge badge-primary">{{ $user->lastLogin() }}</span>
                                                                @else
                                                                    <span
                                                                        class="text-lowercase badge badge-danger">{{ $user->lastLogin() }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ user_profile()[$user->roles_name] }}
                                                            </td>
                                                            <td>
                                                                @if ($user->expediteur !=null)
                                                                    {{ $user->expediteur->nom }}
                                                                @else
                                                                    ---
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="{{ adminurl('users/' . $user->id . '/edit') }}"
                                                                        class="btn btn-warning btn-sm text-left"
                                                                        title='editer' data-toggle="tooltip">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-danger bg-maroon btn-sm text-left delete"
                                                                        data-id="{{ $user->id }}" title='supprimer'
                                                                        data-toggle="tooltip">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
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

    <!-- Modal Remove User-->
    <div class="modal text-left" id="myModal" style="overflow: hidden">
        <div class="d-flex align-items-center justify-content-center h-100">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">supprimer l'utilisateur ?</h4>
                        <button type="button" class="close hide-modal"><i class="fa fa-times-circle"></i></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <h3 class="mb2 text-center" style="color:#f39c12"><i class="fa fa-exclamation-triangle fa-3x"></i>
                        </h3>
                        <p class="text-center">
                            Voulez-vous supprimer cet utilisateur des enregistrements ?
                        </p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="text-align: center !important">
                        <form action="" data-url="{{ adminUrl('users') }}" method="post" style="display: none"
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
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/numeric-comma.js"></script>

    <script>
        $(document).ready(function() {

            $('#example').DataTable({
                direction: "rtl",
                "order": [
                    [0, 'desc']
                ],
                "aLengthMenu": [
                    [25, 50, -1],
                    [25, 50, "Tout"]
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
                        "width": "180px",
                        "targets": 3
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
