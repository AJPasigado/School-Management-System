<?php
    include 'session.php';
    include 'connect.php';
    if (isset($_SESSION['pNationality'])){
        if($_SESSION['pNationality'][0] == "0"){
            echo "<script type=\"text/javascript\">self.location='redirect.php';</script>";
        }
    } else  echo "<script type=\"text/javascript\">self.location='login.php';</script>";

    if (isset($_GET['inputID']) && isset($_GET['inputNat']) && ($_SESSION['pNationality'][1] == "1" || $_SESSION['pNationality'][2] == "1")){
        if ($result = mysqli_query($con, "SELECT name FROM Nationality WHERE name = '".$_GET['inputNat']."'")){
            if (mysqli_num_rows($result) == 0) {
                if ($_GET['inputID'] != "" && $_SESSION['pNationality'][2] == "1"){
                    $query = "UPDATE Nationality SET name ='".$_GET['inputNat']."' WHERE id='".$_GET['inputID']."'";
                    if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='nationality.php';</script>";}
                } else {
                    $query = "INSERT INTO Nationality (name) VALUES ('".$_GET['inputNat']."')";
                    if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='nationality.php';</script>";}
                }
            } else {
                echo "<script type=\"text/javascript\">alert('Nationality with the same name already exists'); self.location='nationality.php';</script>";
            }
        }
    }

    if (isset($_GET['delete']) && $_SESSION['pNationality'][2] == "1"){
        $query = "DELETE FROM Nationality WHERE id = (".$_GET['delete'].")";
        if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='nationality.php';</script>";}
    }
?>

<html>

<head>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="css/stylea.css" rel="stylesheet" type="text/css">
    <link href="css/hover-min.css" rel="stylesheet" type="text/css">
	<title>Nationalities</title>
</head>

<body class="student-body">
    <!-- The overlay -->
    <div id="mySidenav" class="sidenav scene_element scene_element--fadeinleft">
        <a href="javascript:void(0)" class="closebtn hvr-backward" onclick="closeNav()">&times;</a>
        <div class="overlay-content">

            <center>
                <img src="img/profile.jpg" class="img-circle hvr-push" style="width: 100px; margin-top: 40px;">
                <h3> Hi, <?php echo $_SESSION['Username']?> </h3>
                <button class="btn btn-info hvr-push" onclick="Logout()" style="margin-bottom: 50px; font-size: 12px;">Logout</button>
            </center>

            <a href="home.php" class="hvr-backward"><img src="img/login.png" class="sidenavicons"/>Home</a>
            <a href="student.php" class="hvr-backward"><img src="img/studs.png" class="sidenavicons"/>Students</a>
            <a href="programs.php" class="hvr-backward"><img src="img/prog.png" class="sidenavicons"/>Programs</a>
            <a href="subjects.php" class="hvr-backward"><img src="img/subj.png" class="sidenavicons"/>Subjects</a>
            <a href="grades.php" class="hvr-backward"><img src="img/grades.png" class="sidenavicons"/>Grades</a>
            <a href="nationality.php" class="hvr-backward"><img src="img/nat.png" class="sidenavicons"/>Nationalities</a>
            <a href="religion.php" class="hvr-backward"><img src="img/rel.png" class="sidenavicons"/>Religions</a>
            <a href="accounts.php" class="hvr-backward"><img src="img/Accounts.png" class="sidenavicons"/>Accounts</a>

            <center>
                <p style="bottom: 0px; position: absolute; margin-left: 100px;"> (C) AJ Pasigado </p>
            </center>
        </div>
    </div>


	<div class="container-fluid" id="main">
		<div class="row student-header">
			<div class="col-md-12 text-center scene_element scene_element--fadeindown" >
			    <img class="student-logo hvr-push" src="img/nat.png">
				<p class="student-header-label">Nationalities Table</p>
			</div>
		</div>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #337ab7; height: 100px">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Clear()"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title text-center" id="myModalLabelAdd" style="color: white; margin-top: 20px; margin-bottom: auto">Add a new nationality</h3>
					</div>
					<div class="modal-body student-modal-add">
						<form class="form-horizontal form" data-toggle="validator">
							<div class="form-group has-feedback" id="UsernameGroup">
								<label for="inputNat" class="col-sm-5 control-label">Name</label>
								<div class="col-sm-4">
                                    <input type="hidden" name="inputID" id="inputID">
									<input type="text" class="form-control" id="inputNat" name="inputNat" maxlength="60" required>
								</div>
							</div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="AddBTN">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="Clear()">Cancel</button>
                            </div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row scene_element scene_element--fadeinup">
			<table class="table table-hover table-striped religion-table table-responsive" id="tableID">
				<thead>
				<tr class="student-table-header">
					<th class="hidden">ID</th>
                    <?php
                        if(isset($_GET['type'])){
                            if ($_GET['type'] == "ASC") $type = "DESC";
                            else $type = "ASC";
                        } else $type = "ASC";

                        if ($type == "ASC") $caret = "▲"; else $caret = "▼";
                        print('
                                <th><a href="nationality.php?type='.$type.'">NAME '.$caret.'</a></th>
                            ');
                    ?>
				</tr>
				</thead>
				<tbody class="table-striped table-hover" id="Data">
                    <?php
                    if($_SESSION['pNationality'][2] == '0') {$hideEdit = "hidden";} else {$hideEdit = "";}
                    if($_SESSION['pNationality'][2] == '0') {$hideDel = "hidden";} else {$hideDel = "";}

                        $query = "SELECT * FROM Nationality ORDER BY 1 ".$type;

                        if ($result = mysqli_query($con, $query)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                print('
                                                <tr id="'.$row['id'].'">
                                                    <td class="hidden">'.$row["id"].'</td>
                                                    <td>'.$row["name"].'</td>
                                                    <td><button type="button" class="btn btn-default hvr-push '.$hideEdit.'" onclick="Edit('.$row['id'].')"  data-toggle="modal" data-target="#myModal"><img data-toggle="tooltip" data-placement="top" title="Edit Details" class="student-table-icons" src="img/edit.png"/></button><button type="button" class="btn btn-danger hvr-push '.$hideDel.'" onclick="Delete('.$row['id'].')"><img data-toggle="tooltip" data-placement="top" title="Delete" class="student-table-icons" src="img/del.png"/></button></td>
                                                </tr>
                                            ');
                            }
                            $result->free();
                        }
                    ?>
				</tbody>
			</table>
		</div>
	</div>
    <div id="floating-button" data-toggle="modal" data-placement="left" data-target="#myModal" class="hvr-grow-rotate scene_element scene_element--fadeinright <?php if($_SESSION['pNationality'][1] == '0') echo "hidden";?> ">
        <img class="plus hvr-grow" src="img/add.png" data-toggle="tooltip" data-placement="top" title="Add new nationality">
    </div>

    <div id="myButton" class="button">
        <p id="about" onclick="openNav()">Menu <img class="student-back" src="img/back.png" style="width: 20px; margin-left: 10px;"/></p>
    </div>


	<script src="js/jquery.min.js"></script>
	<script src="js/script.js"></script>
    <script src="js/validator.min.js"></script>
	<script type="text/javascript">
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
		function Edit(StudNum){
			var currentTable = document.getElementById(StudNum);
            document.getElementById('inputNat').value = currentTable.cells[1].innerHTML;
            document.getElementById('inputID').value = currentTable.cells[0].innerHTML;
			document.getElementById('AddBTN').innerHTML = "Save";
			document.getElementById('myModalLabelAdd').innerHTML = "Edit Details";
		}
        function Clear(){
            document.getElementById('inputNat').value = "";
            document.getElementById('inputID').value = "";
            document.getElementById('AddBTN').innerHTML = "Add";
            document.getElementById('myModalLabelAdd').innerHTML = "Add New Nationality";
        }
        function Delete(num){
            self.location="nationality.php?delete="+num;
        }
        function openNav() {
            document.getElementById("mySidenav").style.width = "300px";
            document.getElementById("main").style.marginLeft = "300px";
        }
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
        function Logout(){
            self.location="home.php?logout=yes";
        }
	</script>
</body>

</html>