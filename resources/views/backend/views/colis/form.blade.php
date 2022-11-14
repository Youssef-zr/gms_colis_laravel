<div class="row">
    {{-- Expediteur --}}
    <div class="col-12 col-md-4 col-lg-3">
        <div class="form-group {{ $errors->has('id_Expediteur') ? 'has-error' : '' }}">
            {!! Form::label('id_Expediteur', 'Expéditeur', ['class' => 'form-label']) !!}
            {!! Form::select('id_Expediteur', $expediteurs, old('id_Expediteur'), [
                'class' => 'form-control',
                'placeholder' => 'Expéditeur',
            ]) !!}

            @if ($errors->has('id_Expediteur'))
                <span class="help-block">
                    <strong>{{ $errors->first('id_Expediteur') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Numero De Commande --}}
    <div class="col-12 col-md-4 col-lg-3">
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
    <div class="col-12 col-md-4 col-lg-3">
        <div class="form-group {{ $errors->has('numero_suvi') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('numero_suvi', 'Numéro suivi', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            {!! Form::text('numero_suvi', old('numero_suvi'), [
                'class' => 'form-control',
                'placeholder' => 'Numero suivi',
            ]) !!}

            @if ($errors->has('numero_suvi'))
                <span class="help-block">
                    <strong>{{ $errors->first('numero_suvi') }}</strong>
                </span>
            @endif
        </div>
    </div>

    {{-- Date --}}
    <div class="col-12 col-md-4 col-lg-3">
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
    <div class="col-12 col-md-4 col-lg-3">
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
    {{-- <div class="col-12 col-md-4 col-lg-3">
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
    </div> --}}

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
    <div class="col-12 col-md-4 col-lg-3">
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
    <div class="col-12 col-md-4 col-lg-3">
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
    <div class="col-12 col-md-4 col-lg-3">
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
    <div class="col-12 col-md-4 col-lg-3">
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

{{-- ------- sginature and recu ------- --}}
{{-- start row --}}
<div class="row">
    {{-- signature --}}
    <div class="col-12 col-md-4 col-lg-3">
        <div class="form-group mb-1 {{ $errors->has('signature') ? 'has-error' : '' }}">
            <div class="signature-container">
                {!! Form::label('signature', 'signature', ['class' => 'form-label']) !!}
                {!! Form::textarea('signature', null, ['style' => 'display: none', 'class' => 'form-control']) !!}
                <div id="sig"></div>

                @if ($errors->has('libelle'))
                    <span class="help-block">
                        <strong>{{ $errors->first('libelle') }}</strong>
                    </span>
                @endif
                <button id="clear" class="btn btn-danger btn-sm ml-1">
                    <i class="fa fa-times"></i>
                    Effacer
                </button>
            </div>
        </div>

        @if (isset($colis))
            @php
                $signature = 'assets/dist/storage/colis/signature/' . $colis->id_colis . '.png';
            @endphp
            @if (\File::exists(public_path($signature)))
                <img src="{{ url($signature) }}" alt="signature">
            @endif
        @endif
        <button class="btn btn-success btn-sm" id="update-sign"><i class="fa fa-edit"></i> signe</button>

    </div>

    {{-- recu --}}
    <div class="col-12 col-md-4 col-lg-5">
        <div class="form-group {{ $errors->has('recu') ? 'has-error' : '' }}">
            {!! Form::label('recu', 'reçu', ['class' => 'form-label']) !!}
            {!! Form::file('recu', [
                'name' => 'recu',
                'class' => 'form-control',
            ]) !!}
            <small id="emailHelp" class="form-text text-muted">
                image de recu doit etre de type (jpg,png,jpeg,gif,svg)
            </small>
            @if ($errors->has('recu'))
                <span class="help-block">
                    <strong>{{ $errors->first('recu') }}</strong>
                </span>
            @endif
        </div>

        @if (isset($colis) and $colis)
            @php
                $recu = 'assets/dist/storage/colis/recu/' . $colis->id_colis . '.png';
            @endphp
            @if (\File::exists(public_path($recu)))
                @if (isset($recu) and $recu != null)
                    <div class="img-recu">
                        <img src="{{ url($recu) }}" class="img-responsive" id="recu-id" alt="recu">
                    </div>
                @endif
            @else
                <img src="" id="recu-id" alt="" class="img-responsive">
            @endif
        @else
            <img src="" id="recu-id" alt="" class="img-responsive">
        @endif

    </div>
</div>
{{-- end row --}}

<div class="form-group mt-4">
    <button class="btn {{ isset($colis) ? 'bg-warning' : 'bg-primary' }}">
        <i class="fa fa-floppy-o float"></i>
        Enregistrer
    </button>
</div>
{{-- End row --}}

@push('js')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
    <script>
        $(() => {
            $.widget("ns.widget", {});
            var sig = $('#sig').signature({
                syncField: '#signature',
                syncFormat: 'PNG'
            });

            $('#clear').click(function(e) {
                e.preventDefault();
                sig.signature('clear');
                $("#signature64").val('');
                $('input[type="file"]').val('');
            });

            // ----------------------------------------------------------------
            // change image preview
            $('#receipt').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    $('.img-receipt').find('img').attr("src", URL.createObjectURL(file));
                }
            })

            // show signature form
            $('#update-sign').on('click', function(e) {
                e.preventDefault();
                $('.signature-container').slideDown(500);
                $(this).fadeOut();
            })

            // change recu image
            $('#recu').on('change', function() {
                let $input = $(this);
                let reader = new FileReader();
                reader.onload = function() {
                    $("#recu-id").attr("src", reader.result);
                }
                reader.readAsDataURL($input[0].files[0]);
            })
        })
    </script>
@endpush

@push('css')
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

    <style>
        .kbw-signature {
            width: 100%;
            height: 250px;
            border-color: #999;
            border-radius: 10px;
            overflow: hidden
        }

        .signature-container {
            display: none;
        }

        #recu-id{
            max-height: 350px
        }
    </style>
@endpush
