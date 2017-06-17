<?php
        session_start();
        if (isset($_GET['logout']) || isset($_SESSION['Username'])==false){
            session_destroy();
            echo "<script type=\"text/javascript\">self.location='login.php';</script>";
        }

