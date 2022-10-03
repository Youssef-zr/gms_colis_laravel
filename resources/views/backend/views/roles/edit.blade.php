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
            width: 95%;
            margin: 0 auto;
        }
    </style>
@endpush

@section('braidcrump')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-lock"></i> rôles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('/') }}"><i class="fa fa-dashboard"></i>
                                TABLEAU DE BORD
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ adminurl('roles') }}"><i class="fa fa-lock"></i> rôles</a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-plus-circle"></i> editer</li>
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
                            <h3><i class="fa fa-plus-circle"></i> Editer Le Role - {{ $role->name }} </h3>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => ['roles.update', $role->id], 'method' => 'patch']) !!}
                            <div class="row">
                                {{-- User name field --}}
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <div class="option">
                                            {!! Form::label('name', 'nom du role', ['class' => 'form-label']) !!}
                                            <span class="star text-danger">*</span>
                                        </div>
                                        {!! Form::text('name', $role->name, [
                                            'class' => 'form-control',
                                            'placeholder' => 'le role d\'utilisateur dans l\'application',
                                            'disabled' => 'disabled',
                                        ]) !!}

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="select-all">
                                        <label class="custom-control custom-checkbox">
                                            {!! Form::checkbox('select_permissions', null, '', ['class' => 'custom-control-input']) !!}
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-label text-black">
                                                sélectionner tout
                                                <i class="fa fa-star text-danger ml-2" style="font-size: 13px"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{-- End row --}}

                            <div class="row">
                                @php
                                    $i = 0;
                                @endphp
                                {{-- User permission list --}}
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('permission') ? 'has-error' : '' }}">
                                        <ul id="treeview1" class="tree">
                                            <li class="branch"><a href="#">Autorisations</a>
                                                <ul class="mt-3">
                                                    @foreach ($permission as $perm)
                                                        <li>

                                                            <div class="form-group">
                                                                <div class="icheck-teal">
                                                                    {!! Form::checkbox('permission[]', $perm->name, in_array($perm->id, $rolePermissions), [
                                                                        'class' => 'form-checkbox',
                                                                        'id' => $i,
                                                                    ]) !!}
                                                                    <label for="{{ $i }}" class="permission">
                                                                        {{ $perm->name }}
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </li>

                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>

                                        @if ($errors->has('permission'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('permission') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- End row --}}

                            <div class="row justify-content-start mt-4">
                                <div class="form-group">
                                    <button class="btn bg-primary btn-block">
                                        <i class="fa fa-floppy-o float"></i>
                                        Enregistrer
                                    </button>
                                </div>
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

@push('css')
    <link rel="stylesheet" href="{{ url('adminLte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@push('js')
    <script>
        $(() => {

            Object.entries($('.form-checkbox')).forEach(element => {
                let $element = $($(element)[1]);
                if ($element.attr('checked') != undefined && $element.attr('checked') == "checked") {
                    $element.siblings('.main-toggle').addClass('on')
                    $element.siblings('.permission').addClass('text-success')

                } else {
                    $element.siblings('.permission').addClass('text-danger')
                }
            });

            $('.main-toggle').click(function() {
                let custom_checkbox = $(this);
                custom_checkbox.toggleClass('on');

                if (custom_checkbox.hasClass('on')) {
                    custom_checkbox.siblings('input[type="checkbox"]').attr('checked', "checked");
                    custom_checkbox.siblings('.permission').toggleClass('text-success text-danger')
                } else {
                    custom_checkbox.siblings('input[type="checkbox"]').removeAttr('checked');
                    custom_checkbox.siblings('.permission').toggleClass('text-danger text-success')
                }
            });

            // select unselect permissions
            $('.select-all').on("change", ".custom-control-input", function() {
                // select unselect permissions
                $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
            })
        })
    </script>
@endpush
