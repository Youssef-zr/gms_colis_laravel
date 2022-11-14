<div class="row">
    <div class="col-12">
        <div class="row">
            {{-- Date --}}
            <div class="col-12 col-md-3">
                <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                    {!! Form::label('date', 'Date', ['class' => 'form-label']) !!}
                    {!! Form::date('date', old('date', isset($paiement->date) ? date('Y-m-d', strtotime($paiement->date)) : ''), [
                        'class' => 'form-control',
                    ]) !!}

                    @if ($errors->has('date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- Heure --}}
            <div class="col-12 col-md-3">
                <div class="form-group {{ $errors->has('heure') ? 'has-error' : '' }}">
                    {!! Form::label('heure', 'heure', ['class' => 'form-label']) !!}
                    {!! Form::time('heure', old('heure'), ['class' => 'form-control']) !!}

                    @if ($errors->has('heure'))
                        <span class="help-block">
                            <strong>{{ $errors->first('heure') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            @if (!isset($paiement))
                {{-- Expediteur --}}
                <div class="col-12 col-md-3">
                    <div class="form-group {{ $errors->has('id_Expediteur') ? 'has-error' : '' }}">
                        {!! Form::label('id_Expediteur', 'Expéditeur', ['class' => 'form-label']) !!}
                        {!! Form::select('id_Expediteur', $expediteurs, old('id_Expediteur'), [
                            'class' => 'form-control',
                            'placeholder' => 'Expéditeur',
                            isset($paiement) ? 'disabled' : '',
                        ]) !!}

                        @if ($errors->has('id_Expediteur'))
                            <span class="help-block">
                                <strong>{{ $errors->first('id_Expediteur') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Livreurs --}}
                <div class="col-12 col-md-3">
                    <div class="form-group {{ $errors->has('id_utilisateur') ? 'has-error' : '' }}">
                        {!! Form::label('id_utilisateur', 'Livreur', ['class' => 'form-label']) !!}
                        {!! Form::select('id_utilisateur', $livreurs, old('id_utilisateur'), [
                            'class' => 'form-control',
                            'placeholder' => 'Livreur',
                            isset($paiement) ? 'disabled' : '',
                        ]) !!}

                        @if ($errors->has('id_utilisateur'))
                            <span class="help-block">
                                <strong>{{ $errors->first('id_utilisateur') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            @else
                {!! Form::hidden('id_utilisateur', old('id_utilisateur'), ['id' => 'id_utilisateur']) !!}
                {!! Form::hidden('id_Expediteur', old('id_Expediteur'), ['id' => 'id_Expediteur']) !!}
            @endif

            {{-- load bundels not payed --}}
            <div class="col-12">
                <div class="load-payments">
                    <button class="btn btn-primary" id="load-payments" data-toggle="tooltip"
                        data-title="afficher list des colis">
                        <i class="fa fa-refresh"></i>
                        afficher
                    </button>
                    <button class="btn btn-warning" id="save-payment" data-toggle="tooltip"
                        data-title="Payer colis sélectionnés">
                        <i class="fa fa-send"></i>
                        enregistrer
                    </button>

                    <div class="btn-group">
                        <button type="button" class="btn btn-info" data-toggle="dropdown" data-placement="bottom"><i
                                class="fa fa-cog"></i> Actions</button>
                        <button type="button" class="btn btn-info border-left dropdown-toggle dropdown-icon"
                            data-toggle="dropdown" data-placement="bottom">
                            <span class="sr-only">Menu</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            {{-- <label class="dropdown-item mb-0" title="" data-toggle="tooltip" data-placement="top"
                                data-original-title="Afficher">
                                <button id="select-all" class="btn btn-primary btn-sm btn-block"><i
                                        class="fa fa-check"></i> Sélectionner Tout</button>
                            </label> --}}
                            <label class="dropdown-item mb-0" title="" data-toggle="tooltip" data-placement="top"
                                data-original-title="Afficher">
                                <a href="#" id="export-pdf" class="btn btn-success btn-sm btn-block">
                                    <i class="fa fa-file-excel-o"></i>
                                    excel
                                </a>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3" id="error-field" style="display: none">
                <p class="alert alert-warning mb-0">veuillez sélectionner le livreur et l'expediteur</p>
            </div>
        </div>
        {{-- end row --}}
    </div>
</div>
{{-- end row --}}

<div class="row mt-3">
    <div class="col-12">
        <p class="mb-1">
            <strong>Montant total : </strong> <span id="total-mony">
                {{ (isset($paiement) and $paiement->montant != 0) ? $paiement->montant : '0' }} DH
            </span>
            <span id="total-bundels" class="ml-3 d-inline-block">
                <strong>Total : </strong>
                <span> {{ isset($paiement) ? $paiementColis->count() : '0' }} </span>
                colis
            </span>
        </p>
        <div class="table-responsive">
            <table class="table table-stripped table-hover" id="table">
                <thead>
                    <tr>
                        <th> paye </th>
                        <th> N suivi </th>
                        <th> montant </th>
                        <th> date </th>
                        <th> N Commande </th>
                        <th> code destinataire </th>
                        <th> ville </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- this get bundels in edit mode only --}}
                    @if (isset($paiement))
                        @foreach ($paiementColis as $colis)
                            <tr>
                                <td>
                                    <div class="icheck-blue d-inline">
                                        <input type="checkbox" id="{{ $colis['id_colis'] }}"
                                            data-montant="{{ $colis['montant'] }}" class="colis_montant" name='colis[]'
                                            value="{{ $colis['id_colis'] }}" checked>
                                        <label class="icheck-colis" data-id="{{ $colis['id_colis'] }}"></label>
                                    </div>
                                </td>
                                <td>{{ $colis['numero_suvi'] ?? '---' }}</td>
                                <td>{{ $colis['montant'] != 0 ? $colis['montant'] : 0 }}DH</td>
                                <td>{{ $colis['date'] ?? '---' }}</td>
                                <td>{{ $colis['numero_commande'] ?? '---' }}</td>
                                <td>{{ $colis['code_destinataire'] ?? '---' }}</td>
                                <td>{{ $colis['ville']['libelle'] ?? '---' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- end row --}}

{{-- recu --}}
<div class="row mt-4">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('recu_paiment') ? 'has-error' : '' }}">
            {!! Form::label('recu_paiment', 'recu paiment', ['class' => 'form-label']) !!}
            {!! Form::file('recu_paiment', ['class' => 'form-control']) !!}
            @if ($errors->has('recu_paiment'))
                <span class="help-block">
                    <strong>{{ $errors->first('recu_paiment') }}</strong>
                </span>
            @endif
            <small id="emailHelp" class="form-text">
                image de recu doit etre de type (jpg,png,jpeg,gif,svg)
            </small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 border">
        @php
            $path = '';
            if (isset($paiement)) {
                $recu = 'assets/dist/storage/paiement/' . $paiement->ID_paiement . '.png';
                if (\File::exists(public_path($recu))) {
                    $path = url($recu);
                }
            }
        @endphp
        <img src="{{ $path }}" class="recu-preview" id="img-preview">
    </div>
</div>
{{-- end row --}}

@push('js')
    <script>
        $(() => {
            // load payment not payed for selected fields
            let $loadPayments = $('#load-payments');
            let $table = $('#table tbody');
            let oldLivreurIds = [];
            let count = 0;
            let totalMony = $('#total-mony'),
                totalBundels = $('#total-bundels span');
            let total = {
                'mony': parseInt(totalMony.text()),
                'bundels': parseInt(totalBundels.text()),
            };

            let $errorField = $('#error-field');

            $loadPayments.on('click', function(e) {
                e.preventDefault();

                // inputs data 
                let $form = {
                    expediteur: parseInt($('#id_Expediteur').val()),
                    livreur: parseInt($('#id_utilisateur').val())
                };

                if (isNaN($form.expediteur) || isNaN($form.livreur)) {
                    $errorField.fadeIn(500);
                    $errorField.find('p').text("veuillez sélectionner le livreur et l'expediteur")
                } else {
                    $errorField.fadeOut(500);

                    $existing = `${$form.livreur}${$form.expediteur}`;
                    if (oldLivreurIds.includes($existing) == false || count == 0) {

                        // start spin icon
                        $(this).find('i').addClass('fa-spin');

                        $.ajax({
                            method: "GET",
                            url: "{{ route('payments.colis_not_paid') }}",
                            contentType: "application/json",
                            dataType: "json",
                            data: {
                                expediteur: $form.expediteur,
                                livreur: $form.livreur
                            },
                            success(res) {
                                let $bundels = res;

                                // if had ajaw data
                                if ($bundels.length > 0) {
                                    // push existing search livreur and expediteur
                                    if (oldLivreurIds.includes($existing) == false) {
                                        oldLivreurIds.push($existing);
                                        count++;
                                    }
                                } else {
                                    // no data returned from request ajax
                                    $errorField.fadeIn(500);
                                    $errorField.find('p').text("pas de nouvelles données")
                                }


                                for (let i = 0; i < $bundels.length; i++) {
                                    let element = $bundels[i];

                                    // increase mony and count of bundels
                                    total.mony += (element.id_statut == 9) ? parseInt(element[
                                        "montant"]) : 0;
                                    total.bundels++;

                                    let $tr = `
                                            <tr>
                                                <td>
                                                    <div class="icheck-blue d-inline">
                                                        <input type="checkbox" id="${element["id_colis"]}" name='colis[]' value="${element["id_colis"]}"
                                                         data-montant="${element["montant"]}" class="colis_montant">
                                                         <label class="icheck-colis" data-id="${element['id_colis']}"></span>
                                                    </div>
                                                </td>
                                                <td>${ element['numero_suvi'] }</td>
                                                <td>${ element['montant']!=0 ?element['montant'] : 0 }DH</td>
                                                <td>${ element['date'] }</td>
                                                <td>${ element['numero_commande'] }</td>
                                                <td>${ element['code_destinataire'] ?? '---' }</td>
                                                <td>${ element['ville']["libelle"] }</td>
                                            </tr>
                                        `;
                                    // append table row
                                    $table.append($tr);
                                }

                                // change total mony of bundels and count of bundels
                                totalMony.text(`${total.mony} DH`);
                                totalBundels.text(`${total.bundels}`);
                            },
                            error(err) {
                                console.log(err.message);
                            }
                        })
                    } else {
                        $errorField.fadeIn(500);
                        $errorField.find('p').text("données existantes")
                    }
                    // stoped spin icon
                    setTimeout(() => {
                        $(this).find('i').removeClass('fa-spin');
                    }, 300);
                }
            });

            // remove data in table
            $('#id_Expediteur,#id_utilisateur').on('change', function() {
                $table.empty();
                oldLivreurIds = [];
                total.bundels = 0;
                total.mony = 0;
                totalMony.text(`${total.mony} DH`);
                totalBundels.text(`${total.bundels}`);
            })

            // save payment
            $('#save-payment').on("click", function(e) {
                e.preventDefault();

                $('form').submit();
                // if ($('input[name="colis[]"]:checked').length > 0) {
                // } else {
                //     $errorField.fadeIn(500);
                //     $errorField.find("p").text('veuillez sélectionner des colis');
                // }
            })

            // select all bundels
            let $status = false;
            $initAmount = total.mony;

            $('#select-all').on('click', function(e) {
                e.preventDefault();

                $('input[type="checkbox"]').prop('checked', !$status);
                $status = !$status;

                if ($status) {
                    totalMony.text(`${$initAmount} DH`);

                } else {
                    totalMony.text(`${0} DH`);
                }
            })

            // recalculate total amount
            $totalAmount = parseInt(total.mony);

            $('tbody').on('change', ".colis_montant", function(e) {
                $colisMontant = parseInt($(this).data('montant'));
                if (!isNaN($colisMontant)) {

                    if ($(this).is(':checked')) {
                        $totalAmount += parseInt($colisMontant);
                    } else {
                        $totalAmount -= parseInt($colisMontant);
                    }
                }
                totalMony.text(`${$totalAmount} DH`);
            })

            $('tbody').on("click", ".icheck-colis", function(e) {
                $for = $("#" + $(this).data('id'));

                if ($for.is(':checked') == true) {
                    $for.removeAttr('checked');
                } else {
                    $for.attr('checked', "checked");
                }
                $for.change();
            })

            // preview image
            function filePreview(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#img-preview').fadeIn().attr("src", e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            if ($('.recu-preview').attr('src') == "") {
                $('.recu-preview').fadeOut();
            }
            $('#recu_paiment').on('change', function() {
                filePreview(this);
            });

        })
    </script>
@endpush

@push('css')
    <style>
        .old-receipt-image {
            position: absolute;
            z-index: 55;
            right: 0;
            top: 0;
            display: none;
            transition: linear .8s all
        }

        .table-responsive {
            max-height: 500px;
            overflow-y: scroll
        }
    </style>
@endpush
