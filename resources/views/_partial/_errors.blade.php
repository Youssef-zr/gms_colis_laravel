<div class="col-md-4 col-md-offset-4 errors">
    @if(!empty($errors->any()))
    <div class="alert well well-sm alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="right:20px !important;text-decoration:none">&times;</a>
        @foreach ($errors->all() as $err)
            <b>| ! {{ trans('validation.Warning') }} | </b> {{$err}} <br>
        @endforeach
    </div>
    @endif
</div>
<div class="clearfix"></div>