<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - Page Non Trouve</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
        body{
            background:#fff;
            padding:0;
            margin:0
        }
        .error-image{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-image img{
            width: 100%;
        }

        @media (min-width:768px){
            .image{
                width:550px
            }
        }

    </style>
</head>
<body>
    <div class="error-image">
        <div class="image text-center">
            <img src="{{ url('assets/dist/images/errors/404.png') }}" alt="404">
            <a href="{{ adminUrl('') }}" class="btn btn-warning mt-4"><i class="fa fa-history"></i> Retour à la page principale</a>
        </div>
    </div>
</body>
</html>