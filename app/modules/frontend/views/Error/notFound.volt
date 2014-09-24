<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ app_name }} | 404</title>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="/themes/adminlte/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- font Awesome -->
    <link href="/themes/adminlte/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="/themes/adminlte/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="/themes/adminlte/css/AdminLTE.css" rel="stylesheet" type="text/css"/>

    <style>
        @import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin-ext);
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue">

<section class="content">

    <div class="error-page">
        <h2 class="headline text-info">404</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Strona nie została znaleziona.</h3>

            <p>
                Nie mogliśmy znaleźć poszukiwanej przez Ciebie strony.
                Póki co, możesz <a href='/'>wrócić na stronę główną</a> lub spróbować wyszukać strony przy pomocy formularza.
            </p>

            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="{{ 'common.search'|trans }}"/>

                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-primary disabled"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>

<!-- jQuery 2.0.2 -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/themes/adminlte/js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="/themes/adminlte/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="/themes/adminlte/js/AdminLTE/demo.js" type="text/javascript"></script>
</body>
</html>
