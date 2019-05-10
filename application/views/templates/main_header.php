<!DOCTYPE html>
<html lang="en" class="h-100">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/mecin.css" rel="stylesheet">

    <link rel="icon" href="<?= base_url('assets/img/logo/')?>fav.png" sizes="any" type="image/png">
    
</head>

<body class="d-flex flex-column h-100">

    <header>

        <?php ## NAVBAR ## ?>
        <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-gradient-primary">
            <div class="container px-1">
                <a class="navbar-brand d-none d-md-block" href="<?= base_url(); ?>">
                    <img src="<?= base_url('assets/img/logo/'); ?>logo-wide-white.svg" class="d-inline-block align-middle" alt=""  style="width: 100%;">
                </a>
                <a class="navbar-brand d-md-none" href="<?= base_url(); ?>" style="width: 20%;">
                    <img src="<?= base_url('assets/img/logo/'); ?>logo-white.svg" class="d-inline-block align-middle" alt="" >
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">F.A.Q.</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </li> -->
                    </ul>
                    <!-- <form class="form-inline mt-2 mt-md-0">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                        <button class="btn btn-light my-2 my-sm-0 font-primary" type="submit">Search</button>
                    </form> -->
                </div>
            </div>
        </nav>
        <?php ## END OF NAVBAR ## ?>

    </header>