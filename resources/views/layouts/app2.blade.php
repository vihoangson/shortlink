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
    </head>

    <body>
        <div class="container">
            @yield('BodyContent')
        </div>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/init/jquery-3.5.1.slim.min.js"></script>
        <script src="/init/popper.min.js"></script>
        <script src="/init/bootstrap.min.js" ></script>
        @yield('FooterContent')
        <div class="loading-page"></div>
    </body>
</html>
