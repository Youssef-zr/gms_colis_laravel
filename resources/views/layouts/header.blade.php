<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('assets/adminLte/plugins/fontawesome-free/css/all.min.css') }} ">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('assets/adminLte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/adminLte/dist/css/adminlte.min.css') }}"><!-- Theme style -->
    <style>
        body {
            background: #eee;
        }

        .card {
            border: 1px solid #007bff;
            border-left-width: 5px;
            border-right-width: 5px;
        }

        .card-head>h1 {
            color: #007bff;
            text-shadow: 2px 4px 3px rgba(0, 0, 0, .3);
            margin-bottom: 22px;
        }

        .form-relative {
            position: relative;
        }

        .form-group .icheck-primary {
            margin-left: 3px
        }

        .form-relative input {
            padding-left: 40px;
            padding-right: 35px;
        }

        .form-relative .icon {
            position: absolute;
            top: 4px;
            font-size: 21px;
            left: 8px;
            border-right: 1px solid #eee;
            padding-right: 5px
        }

        .form-card {
            position: relative;
            padding-top: 10px;
            background: #ffffffa3 !important
        }

        .form-card .card-avatar {
            position: absolute;
            top: -83px;
            left: 49%;
            transform: translateX(-54px);
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .form-card .show-password {
            position: absolute;
            right: 11px;
            top: 6px;
            cursor: pointer;
        }
    </style>
</head>

<body>
