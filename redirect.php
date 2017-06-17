
<html>
<head>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/stylea.css" rel="stylesheet" type="text/css">
    <link href="css/hover-min.css" rel="stylesheet" type="text/css">
    <title> Redirect </title>
</head>
<body class="login-body">

    <div class="container-fluid">
        <div class="row scene_element scene_element--fadeinup">
            <center>
                <img class="login-pic hvr-wobble-horizontal" src="img/redirect.png" style="margin: 0px; margin-top: 10%">
                <form class="form-horizontal redirect " style="margin: 0px;">
                    <h1>Ooops!</h1>
                    <p>You are not allowed to view this page.</p>
                </form>
                <button type="button" class="btn btn-primary login-btn hvr-push" id="AddBTN" onclick="Home()">Go Home</button>
            </center>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script type="text/javascript">
        function Home(){
            self.location="home.php";
        }
    </script>

</body>


</html>