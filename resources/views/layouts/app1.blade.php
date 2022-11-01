<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Peaceful Place</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/init/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
    @yield('HeaderContent')

</head>

<body>

<div class="progress" style=' height:3px;'>
    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
         aria-valuemax="100"></div>
</div>

<!-- page-header -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-caption">
                    <h1 class="page-title">Peaceful Place</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.page-header-->
<!-- news -->
<div class="card-section">
    <div class="container">
        <div class="card-block bg-white mb30">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- section-title -->
                    <div class="section-title mb-0">
                        @yield('BodyContent')

                    </div>
                    <!-- /.section-title -->
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">Created for <a href="/"
                                                                                                   target="_blank">Peaceful
                    Place </a>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/init/jquery-3.5.1.slim.min.js"></script>
<script src="/init/popper.min.js"></script>
<script src="/init/bootstrap.min.js"></script>
<script src="/js/lib.js"></script>
@yield('FooterContent')

<div class="loading-page"></div>
</body>
</html>
