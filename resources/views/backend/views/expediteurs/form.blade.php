<div class="row">
    {{-- name field --}}
    <div class="col-12 col-md-6">
        <div class="form-group {{ $errors->has('Nom') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('Nom', 'Nom', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>

            {!! Form::text('Nom', old('Nom'), [
                'class' => 'form-control',
                'placeholder' => 'Nom d\'expediteur',
            ]) !!}
            @if ($errors->has('Nom'))
                <span class="help-block">
                    <strong>{{ $errors->first('Nom') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- phone field --}}
    <div class="col-12 col-md-6">
        <div class="form-group {{ $errors->has('tel') ? 'has-error' : '' }}">
            {!! Form::label('tel', 'Téléphone', ['class' => 'form-label']) !!}

            {!! Form::text('tel', old('tel'), [
                'class' => 'form-control',
                'placeholder' => 'Téléphone d\'expediteur',
            ]) !!}
            @if ($errors->has('tel'))
                <span class="help-block">
                    <strong>{{ $errors->first('tel') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
{{-- end row --}}

<div class="row">
    {{-- adresse field --}}
    <div class="col-12 col-md-6">
        <div class="form-group {{ $errors->has('adresse') ? 'has-error' : '' }}">
            {!! Form::label('adresse', 'Adresse', ['class' => 'form-label']) !!}

            {!! Form::text('adresse', old('adresse'), [
                'class' => 'form-control',
                'placeholder' => 'Adresse d\'expediteur',
            ]) !!}
            @if ($errors->has('adresse'))
                <span class="help-block">
                    <strong>{{ $errors->first('adresse') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- mail field --}}
    <div class="col-12 col-md-6">
        <div class="form-group {{ $errors->has('mail') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('mail', 'e-mail', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            
            {!! Form::text('mail', old('mail'), [
                'class' => 'form-control',
                'placeholder' => 'E-mail d\'expediteur',
            ]) !!}
            @if ($errors->has('mail'))
                <span class="help-block">
                    <strong>{{ $errors->first('mail') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
{{-- end row --}}

<div class="form-group">
    <button class="btn {{ isset($expediteur) ? 'bg-warning' : 'bg-primary' }}">
        <i class="fa fa-floppy-o float"></i>
        Enregistrer
    </button>
</div>
{{-- End row --}}

@push('js')
    <script>
        $(() => {

        })
    </script>
@endpush

@push('css')
    <style>

    </style>
@endpush
