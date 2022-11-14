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
                    <h1><i class="fa fa-user"></i> {{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ adminurl('/') }}"><i class="fa fa-dashboard"></i>
                                TABLEAU DE BORD
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><i class="fa fa-user"></i> {{ $title }}</li>
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
                    <div class="row">
                        <div class="col-md-4">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body pb-2 box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="{{ url($user->path) }}"
                                            alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                                    <p class="text-muted text-center">{{ $user->roles_name }}</p>

                                    <ul class="list-group list-group-unbordered mb-2">
                                        <li class="list-group-item">
                                            <b><i class="fa fa-user-o mr-1"></i> email</b> <a
                                                class="float-right">{{ $user->email }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b><i class="fa fa-phone mr-1"></i> tél</b> <a
                                                class="float-right">{{ $user->phone }}</a>
                                        </li>
                                        <li class="list-group-item" style="border-bottom: none">
                                            <b><i class="fa fa-calendar mr-1"></i> Dernière connexion</b>
                                            <a class="float-right text-lowercase">{{ auth()->user()->lastLogin() }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#settings" data-toggle="tab">
                                                <i class="fa fa-list"></i> Information
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#password-tab" data-toggle="tab">
                                                <i class="fa fa-lock"></i> mot de passe
                                            </a>
                                        </li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body pb-2">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="settings">
                                            {!! Form::open([
                                                'route' => ['user.update_profile', $user->id],
                                                'method' => 'patch',
                                                'files' => 'true',
                                            ]) !!}

                                            <div class="row">
                                                {{-- name field --}}
                                                <div class="col-12 col-md-8">
                                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                                        <div class="option">
                                                            <label for="name">
                                                                <i class="fa fa-user-o form-label"></i>
                                                                Nom
                                                            </label>
                                                            <span class="star text-danger">*</span>
                                                        </div>

                                                        {!! Form::text('name', old('name') ?? $user->name, [
                                                            'class' => 'form-control',
                                                            'placeholder' => 'votre nom',
                                                        ]) !!}

                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- phone field --}}
                                                <div class="col-12 col-md-8">
                                                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                                        <div class="option">
                                                            <label for="phone">
                                                                <i class="fa fa-phone form-label mr-1"></i>
                                                                Tél
                                                            </label>
                                                            <span class="star text-danger">*</span>
                                                        </div>

                                                        {!! Form::text('phone', old('phone') ?? $user->phone, [
                                                            'class' => 'form-control',
                                                            'placeholder' => '06xxxxxxxx',
                                                        ]) !!}

                                                        @if ($errors->has('phone'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('phone') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- email field --}}
                                                <div class="col-12 col-md-8">
                                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                                        <div class="option">
                                                            <label for="email">
                                                                <i class="fa fa-envelope-o mr-1"></i>
                                                                Email
                                                            </label>
                                                            <span class="star text-danger">*</span>
                                                        </div>

                                                        {!! Form::text('email', old('email') ?? $user->email, [
                                                            'class' => 'form-control',
                                                            'placeholder' => '06xxxxxxxx',
                                                        ]) !!}

                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- photo field --}}
                                                <div class="col-12 col-md-8">
                                                    <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                                                        <div class="option">
                                                            <label for="photo">
                                                                <i class="fa fa-image mr-1"></i>
                                                                photo
                                                            </label>
                                                            <span class="star text-danger">*</span>
                                                        </div>

                                                        {!! Form::file('photo', [
                                                            'class' => 'form-control',
                                                            'placeholder' => '06xxxxxxxx',
                                                        ]) !!}
                                                        <small id="status_block" class="form-text text-muted">Le fichier
                                                            doit être de type : jpg,png,jpeg,gif,svg | dimensions: min=60x60 , max=300x300 | max taille: 150kb
                                                        </small>

                                                        @if ($errors->has('photo'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('photo') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                    Modifier
                                                </button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="password-tab">

                                            {!! Form::open([
                                                'route' => ['user.change_password', $user->id],
                                                'method' => 'patch',
                                            ]) !!}
                                            <div class="row form-card">
                                                {{-- User password field --}}
                                                <div class="col-md-8">
                                                    <div
                                                        class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                                        {!! Form::label('password', 'Mot de passe', ['class' => 'form-label']) !!}
                                                        <div class="form-relative">
                                                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Mot de passe', 'id' => 'password']) !!}
                                                            <div class="icon"><i class="fa fa-lock"></i></div>
                                                            <div class="show-password" title="afficher mot de passe"
                                                                data-toggle="tooltip"><i class="fa fa-eye"></i></div>
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        @if ($errors->has('password'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- User confirm-password field --}}
                                                <div class="col-md-8">
                                                    <div class="form-group {{ $errors->has('confirm-password') ? 'has-error' : '' }}">
                                                        {!! Form::label('confirm-password', 'confirmation', ['class' => 'form-label']) !!}
                                                        <div class="form-relative">
                                                            {!! Form::password('confirm-password', [
                                                                'class' => 'form-control',
                                                                'placeholder' => 'Confirmez le mot de passe',
                                                            ]) !!}
                                                            <div class="icon"><i class="fa fa-lock"></i></div>
                                                            <div class="show-password" title="afficher mot de passe"
                                                                data-toggle="tooltip"><i class="fa fa-eye"></i>
                                                            </div>
                                                            @error('confirm-password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        @if ($errors->has('confirm-password'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('confirm-password') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end row --}}
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                    Modifier
                                                </button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- row closed -->
            </div>
            <!-- Container closed -->
        </div>
    </div>
    {{-- modal delete record --}}
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#btnEdit').on('click', function() {
                $('input').removeAttr('disabled');
                $('button[type="submit"]').removeClass('d-none');
            })

        });
    </script>

    @if ($errors->has('password'))
        <script>
            $('a[href="#settings"]').removeClass('active');
            $('a[href="#password-tab"]').addClass('active');
            $('#settings').removeClass('active');
            $('#password-tab').addClass('active');
        </script>
    @endif
@endpush
