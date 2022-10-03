<div class="session-msg">
    @if (session()->has('msgSuccess'))
        <script>
            new Noty({
                "theme": 'metroui',
                "type":"success",
                "layout":'topRight',
                "text":"<span>{{session('msgSuccess')}} <i class='fa fa-smile-o'></i></span>",
                "timeout":2000,
                "killer":true,
                "progressBar": true,
            }).show();
        </script>
    
    @elseif (session()->has('msgDanger'))
        <script>
            new Noty({
                "theme": 'relax',
                "type":"error",
                "layout":'topRight',
                "text":"<span>{{session('msgDanger')}} <i class='fa fa-frown-o'></i></span>",
                "timeout":6000,
                "killer":true,
                "progressBar": true,
            }).show();
        </script>
    @elseif (session()->has('msgWarning'))
        <script>
            new Noty({
                "theme": 'relax',
                "type":"warning",
                "layout":'topRight',
                "text":"{{session('msgWarning')}}",
                "timeout":2000,
                "killer":true,
                "progressBar": true,
            }).show();
        </script>
    @endif
    
</div>
