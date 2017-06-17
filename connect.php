<?php
    $CON_Username = "encoder";
    $CON_Password = "encoder";
    $CON_Database = "school";
    $CON_Location = "localhost";

    $con = mysqli_connect($CON_Location,$CON_Username,$CON_Password,$CON_Database);
    if (mysqli_connect_errno()) {
        echo "<script type=\"text/javascript\">alert('MySQL Connection Error');</script>" ;
        mysqli_close($con);
    }