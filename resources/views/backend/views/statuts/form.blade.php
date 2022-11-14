<div class="row">
    <!-- libelle field -->
    <div class="col-12 col-md-4 col-lg-3">
        <div class="form-group {{ $errors->has('libelle') ? 'has-error' : '' }}">
            <div class="option">
                {!! Form::label('libelle', 'libelle', ['class' => 'form-label']) !!}
                <span class="star text-danger">*</span>
            </div>
            {!! Form::text('libelle', old('libelle'), [
                'class' => 'form-control',
                'placeholder' => 'libelle',
            ]) !!}
            @if ($errors->has('libelle'))
                <span class="help-block">
                    <strong>{{ $errors->first('libelle') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <!-- color field -->
    <div class="col-6 d-flex align-items-center">
        <div class="form-group {{ $errors->has('color') ? 'has-error' : '' }}" style="width:100px">
            {!! Form::label('color', 'color', ['class' => 'form-label']) !!}
            <input type="color" name="color" id="color" class="form-control">
            @if ($errors->has('color'))
                <span class="help-block">
                    <strong>{{ $errors->first('color') }}</strong>
                </span>
            @endif
        </div>
        @if (isset($statut) and $statut->color != '')
            <span class="color-preview rounded" style="background:{{ $statut->color }}"></span>
        @endif
    </div>
</div>
<!-- end row -->

<div class="form-group">
    <button class="btn {{ isset($statut) ? 'bg-warning' : 'bg-primary' }}">
        <i class="fa fa-floppy-o float"></i>
        Enregistrer
    </button>
</div>
{{-- End row --}}

@push('js')
    <script>
        $(() => {
            $('input[type="color"]').on('change',function(){
                $('.color-preview').css('background',$(this).val())
            })
        })
    </script>
@endpush

@push('css')
    <style>
        .color-preview {
            display: inline-block;
            margin-top: 10px;
            margin-left: 10px;
            width: 100px;
            height: 25px;
        }
    </style>
@endpush
