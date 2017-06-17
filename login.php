<html class="login-html">

<head>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/stylea.css" rel="stylesheet" type="text/css">
    <link href="css/hover-min.css" rel="stylesheet" type="text/css">
    <title>Login</title>
</head>

<body class="login-body">
    <div class="container-fluid">
        <div class="row login-bg login-outer scene_element scene_element--fadeinup">
            <center>
                <img class="login-pic hvr-wobble-horizontal" src="img/login.png" style="margin: 0px; margin-top: 10%">
                <form class="form-horizontal login-login " style="margin: 0px;">
                    <h1>Login</h1>
                    <p>Please enter your credentials.</p>
                    <div class="form-group has-feedback" data-toggle="validator">
                        <input type="text" class="form-control login-input has-feedback hvr-grow" name="inputUsername" placeholder="Username" required>
                        <input type="password" class="form-control login-input has-feedback hvr-grow" name="inputPassword" placeholder="Password" required>
                    </div>
                    <button type="submit" class="hvr-push btn btn-primary login-btn">Login</button>
                </form>
            </center>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/validator.min.js"></script>
</body>
</html>

<?php
if (isset($_GET['inputUsername']) && isset($_GET['inputPassword'])) {
    include_once 'connect.php';

    $username = htmlentities($_GET['inputUsername']);
    $password = htmlentities($_GET['inputPassword']);

    if ($result = mysqli_query($con, "SELECT * FROM account WHERE uname = '" . $username . "' and pword = '" . $password . "'")) {
        if (mysqli_num_rows($result) > 0) {
            session_start();
            $_SESSION['Username'] = $username;
            $_SESSION['Password'] = $password;

            if ($row = mysqli_fetch_assoc($result)) {
                if ($row['active'] == "1"){
                    $_SESSION['ID'] = $row['id'];
                    $_SESSION['pStudent'] = str_split($row['permitstudent']);
                    $_SESSION['pProgram'] = str_split($row['permitprogram']);
                    $_SESSION['pSubject'] = str_split($row['permitsubject']);
                    $_SESSION['pNationality'] = str_split($row['permitnationality']);
                    $_SESSION['pReligion'] = str_split($row['permitreligion']);
                    $_SESSION['pAccounts'] = str_split($row['permitaccounts']);
                    $_SESSION['pGrades'] = str_split($row['permitgrades']);

                    //For Student Table
                    $_SESSION['StudentTable_Order'] = "2";
                    $_SESSION['StudentTable_Type'] = "DESC";
                    $_SESSION['StudentTable_Page'] = "0";
                    $_SESSION['StudentGradeTable_Order'] = "2";
                    $_SESSION['StudentGradeTable_Type'] = "DESC";

                    //For Programs Table
                    $_SESSION['ProgramsTable_Order'] = "2";
                    $_SESSION['ProgramsTable_Type'] = "DESC";
                    $_SESSION['ProgramsProsTable_Order'] = "7";
                    $_SESSION['ProgramsProsTable_Type'] = "DESC";

                    //For Subjects Table
                    $_SESSION['SubjectsTable_Order'] = "2";
                    $_SESSION['SubjectsTable_Type'] = "DESC";

                    //For Grades Table
                    $_SESSION['GradesTable_Order'] = "2";
                    $_SESSION['GradesTable_Type'] = "DESC";
                    $_SESSION['GradesViewTable_Order'] = "2";
                    $_SESSION['GradesViewTable_Type'] = "DESC";
                    $_SESSION['GradesSchoolYear'] = "20000";
                    $_SESSION['GradesSem']="100";

                    //For Accounts Table
                    $_SESSION['AccountsTable_Order'] = "1";
                    $_SESSION['AccountsTable_Type'] = "DESC";

                    echo "<script type=\"text/javascript\">self.location='home.php';</script>";
                } else {
                    echo "<script type=\"text/javascript\">alert('The account is inactive');</script>";
                }
            }
            $result->free();
        } else {
            echo "<script type=\"text/javascript\">alert('Enter your correct credentials');</script>";
        }
    } else echo "<script type=\"text/javascript\">alert('Enter your correct credentials');</script>";
}
?>


