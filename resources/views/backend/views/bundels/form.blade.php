<div class="row">
    {{-- Expediteur --}}
    <div class="col-12 col-md-6">
        <div class="form-group {{ $errors->has('id_expediteur') ? 'has-error' : '' }}">
            {!! Form::label('id_expediteur', 'Expéditeur', ['class' => 'form-label']) !!}
            {!! Form::select('id_expediteur', $expediteurs, old('id_expediteur'), [
                'class' => 'form-control',
                'placeholder' => 'Expéditeur',
            ]) !!}

            @if ($errors->has('id_expediteur'))
                <span class="help-block">
                    <strong>{{ $errors->first('id_expediteur') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Numero De Commande --}}
    <div class="col-12 col-md-6">
        <div class="form-group {{ $errors->has('numero_commande') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('numero_commande', 'N° Commande', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            {!! Form::text('numero_commande', old('numero_commande'), [
                'class' => 'form-control',
                'placeholder' => 'Numero commande',
            ]) !!}

            @if ($errors->has('numero_commande'))
                <span class="help-block">
                    <strong>{{ $errors->first('numero_commande') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Numéro suivi --}}
    <div class="col-12 col-md-4">
        <div class="form-group {{ $errors->has('numero_suivi') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('numero_suivi', 'Numéro suivi', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            {!! Form::text('numero_suivi', old('numero_suivi'), [
                'class' => 'form-control',
                'placeholder' => 'Numero suivi',
            ]) !!}

            @if ($errors->has('numero_suivi'))
                <span class="help-block">
                    <strong>{{ $errors->first('numero_suivi') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Date --}}
    <div class="col-12 col-md-4">
        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
            {!! Form::label('date', 'Date', ['class' => 'form-label']) !!}
            {!! Form::date('date', old('date'), ['class' => 'form-control']) !!}

            @if ($errors->has('date'))
                <span class="help-block">
                    <strong>{{ $errors->first('date') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Statut --}}
    <div class="col-12 col-md-4">
        <div class="form-group {{ $errors->has('id_statut') ? 'has-error' : '' }}">
            {!! Form::label('id_statut', 'Statut', ['class' => 'form-label']) !!}
            {!! Form::select('id_statut', $statuts, old('id_statut'), [
                'class' => 'form-control',
                'placeholder' => 'status',
            ]) !!}

            @if ($errors->has('id_statut'))
                <span class="help-block">
                    <strong>{{ $errors->first('id_statut') }}</strong>
                </span>
            @endif
        </div>
    </div>
 {{-- Code Destinataire --}}
 <div class="col-12 col-md-4 col-lg-3">
    <div class="form-group {{ $errors->has('code_destinataire') ? 'has-error' : '' }}">
        <div class="option">
            {!! Form::label('code_destinataire', 'Code Destinataire', ['class' => 'form-label']) !!}
            <span class="star text-danger">*</span>
        </div>
        {!! Form::text('code_destinataire', old('code_destinataire'), [
            'class' => 'form-control',
            'placeholder' => 'Code destinataire',
        ]) !!}

        @if ($errors->has('code_destinataire'))
            <span class="help-block">
                <strong>{{ $errors->first('code_destinataire') }}</strong>
            </span>
        @endif
    </div>
</div>
    {{-- Nom --}}
    <div class="col-12 col-md-4 col-lg-3">
        <div class="form-group {{ $errors->has('nom_destinataire') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('nom_destinataire', 'Nom destinataire', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            {!! Form::text('nom_destinataire', old('nom_destinataire'), [
                'class' => 'form-control',
                'placeholder' => 'Nom destinataire',
            ]) !!}

            @if ($errors->has('nom_destinataire'))
                <span class="help-block">
                    <strong>{{ $errors->first('nom_destinataire') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Adresse Destinataire --}}
    <div class="col-12 col-md-4 col-lg-3">
        <div class="form-group {{ $errors->has('adresse_destinataire') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('adresse_destinataire', 'Adresse destinataire', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            {!! Form::text('adresse_destinataire', old('adresse_destinataire'), [
                'class' => 'form-control',
                'placeholder' => 'Adresse destinataire',
            ]) !!}

            @if ($errors->has('adresse_destinataire'))
                <span class="help-block">
                    <strong>{{ $errors->first('adresse_destinataire') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Tel  --}}
    <div class="col-12 col-md-4 col-lg-3">
        <div class="form-group {{ $errors->has('tel') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('tel', 'Tél destinataire', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            {!! Form::text('tel', old('tel'), ['class' => 'form-control', 'placeholder' => 'Télephone destinataire']) !!}

            @if ($errors->has('tel'))
                <span class="help-block">
                    <strong>{{ $errors->first('tel') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Ville --}}
    <div class="col-12 col-md-4">
        <div class="form-group {{ $errors->has('id_ville') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('id_ville', 'Ville', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            {!! Form::select('id_ville', $villes, old('id_ville'), [
                'class' => 'form-control',
                'placeholder' => 'Ville',
            ]) !!}

            @if ($errors->has('id_ville'))
                <span class="help-block">
                    <strong>{{ $errors->first('id_ville') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Remarques --}}
    <div class="col-12 col-md-4">
        <div class="form-group {{ $errors->has('id_remarques') ? 'has-error' : '' }}">
            {!! Form::label('id_remarques', 'Remarques', ['class' => 'form-label']) !!}
            {!! Form::select('id_remarques', $remarques, old('id_remarques'), [
                'class' => 'form-control',
                'placeholder' => 'Remarques',
            ]) !!}

            @if ($errors->has('id_remarques'))
                <span class="help-block">
                    <strong>{{ $errors->first('id_remarques') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- montant --}}
    <div class="col-12 col-md-4">
        <div class="form-group {{ $errors->has('montant') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('montant', 'Montant', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            {!! Form::number('montant', old('montant'), [
                'class' => 'form-control',
                'placeholder' => 'Montant',
            ]) !!}

            @if ($errors->has('montant'))
                <span class="help-block">
                    <strong>{{ $errors->first('montant') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Type de paiement --}}
    <div class="col-12 col-md-4">
        <div class="form-group {{ $errors->has('type_paiement') ? 'has-error' : '' }}">
            {!! Form::label('type_paiement', 'Type paiement', ['class' => 'form-label']) !!}
            {!! Form::select('type_paiement', type_paiment(), old('type_paiement'), [
                'class' => 'form-control',
                'placeholder' => 'Type paiement',
            ]) !!}

            @if ($errors->has('type_paiement'))
                <span class="help-block">
                    <strong>{{ $errors->first('type_paiement') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
{{-- end row --}}

<div class="form-group">
    <button class="btn {{ isset($bundel) ? 'bg-warning' : 'bg-primary' }}">
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
