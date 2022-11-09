<div class="row">
    <div class="col-12">
        <div class="row">
            {{-- Date --}}
            <div class="col-12 col-md-3">
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

            @if (!isset($payment))
                {{-- Expediteur --}}
                <div class="col-12 col-md-3">
                    <div class="form-group {{ $errors->has('id_expediteur') ? 'has-error' : '' }}">
                        {!! Form::label('id_expediteur', 'Expéditeur', ['class' => 'form-label']) !!}
                        {!! Form::select('id_expediteur', $expediteurs, old('id_expediteur'), [
                            'class' => 'form-control',
                            'placeholder' => 'Expéditeur',
                            isset($paiement) ? 'disabled' : '',
                        ]) !!}

                        @if ($errors->has('id_expediteur'))
                            <span class="help-block">
                                <strong>{{ $errors->first('id_expediteur') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Livreurs --}}
                <div class="col-12 col-md-3">
                    <div class="form-group {{ $errors->has('id_livreur') ? 'has-error' : '' }}">
                        {!! Form::label('id_livreur', 'Livreur', ['class' => 'form-label']) !!}
                        {!! Form::select('id_livreur', $livreurs, old('id_livreur'), [
                            'class' => 'form-control',
                            'placeholder' => 'Livreur',
                            isset($paiement) ? 'disabled' : '',
                        ]) !!}

                        @if ($errors->has('id_livreur'))
                            <span class="help-block">
                                <strong>{{ $errors->first('id_livreur') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            @else
                {!! Form::hidden('id_livreur', old('id_livreur'), ['id' => 'id_livreur']) !!}
                {!! Form::hidden('id_expediteur', old('id_expediteur'), ['id' => 'id_expediteur']) !!}
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
                {{ isset($paiement) ? $paiement->montant : '0' }} DH
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
                                        <input type="checkbox" id="{{ $colis['id'] }}"
                                            data-montant="{{ $colis['montant'] }}" class="colis_montant" name='colis[]'
                                            value="{{ $colis['id'] }}" checked>
                                        <label for="{{ $colis['id'] }}"></label>
                                    </div>
                                </td>
                                <td>{{ $colis['numero_suivi'] }}</td>
                                <td>{{ $colis['montant'] }}DH</td>
                                <td>{{ $colis['date'] }}</td>
                                <td>{{ $colis['numero_commande'] }}</td>
                                <td>{{ $colis['code_destinataire'] }}</td>
                                <td>{{ $colis['ville']['libelle'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- end row --}}

{{-- receipt --}}
<div class="col-12" id="recu_paiment_container">
    <div class="row">
        <div class="col-12">
            {{-- Expediteur --}}
            <div class="receipt-container rounded">
                <div class="row mb-4">
                    @if (isset($payment) and $payment->recu_paiment != '')
                        <div class="col-md-4 col-lg-3">
                            <img class="img-responsive" src="{{ $payment->recu_paiment }}" alt="">
                        </div>
                    @endif
                </div>
                {{-- end row --}}

                <div class="row">
                    <div class="col-md-6 col-lg-5">
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
                {{-- end row --}}
            </div>
        </div>
    </div>
</div>

<div class="form-group d-none" id="submit_form">
    <button class="btn {{ isset($colis) ? 'bg-warning' : 'bg-primary' }}">
        <i class="fa fa-floppy-o float"></i>
        Enregistrer
    </button>
</div>
{{-- End row --}}

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
                    expediteur: parseInt($('#id_expediteur').val()),
                    livreur: parseInt($('#id_livreur').val())
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
                                                        <input type="checkbox" id="${element["id"]}" name='colis[]' value="${element["id"]}"
                                                         data-montant="${element["montant"]}" class="colis_montant">
                                                        <label for="${element["id"]}"></label>
                                                    </div>
                                                </td>
                                                <td>${ element['numero_suivi'] }</td>
                                                <td>${ element['montant'] }DH</td>
                                                <td>${ element['date'] }</td>
                                                <td>${ element['numero_commande'] }</td>
                                                <td>${ element['code_destinataire'] }</td>
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
            $('#id_expediteur,#id_livreur').on('change', function() {
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
            $totalAmount = total.mony;

            $('tbody').on('change', ".colis_montant", function() {
                $colisMontant = $(this).data('montant');
                if ($(this).is(':checked')) {
                    $totalAmount += $colisMontant;
                } else {
                    $totalAmount -= $colisMontant;
                }

                totalMony.text(`${$totalAmount} DH`);
            })
        })
    </script>
@endpush

@push('css')
    <style>
        #recu_paiment_container {
            position: relative;
            transition: linear .8s all
        }

        #recu_paiment_container:hover .old-receipt-image {
            display: block;
        }

        .old-receipt-image {
            position: absolute;
            z-index: 55;
            right: 0;
            top: 0;
            display: none;
            transition: linear .8s all
        }


        .table-responsive {
            max-height: 50vh;
        }
    </style>
@endpush
