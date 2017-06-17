<?php
    include 'session.php';
    include 'connect.php';

    if (isset($_SESSION['pStudent'][0])){
        if($_SESSION['pStudent'][0] == "0"){
            echo "<script type=\"text/javascript\">self.location='redirect.php';</script>";
        }
    } else  echo "<script type=\"text/javascript\">self.location='login.php';</script>";

    if (isset($_GET['inputID']) && isset($_GET['inputFN']) && isset($_GET['inputMN']) && isset($_GET['inputLN']) && isset($_GET['gender']) && isset($_GET['bday']) && isset($_GET['program']) && isset($_GET['religion']) && isset($_GET['nationality']) && isset($_GET['yearstatus']) && ($_SESSION['pStudent'][1] == "1" || $_SESSION['pStudent'][2] == "1")){
        if ($_GET['inputID'] != ""){
            if (isset($_GET['regular']) && $_SESSION['pStudent'][2] == "1"){
                $query = "UPDATE Student SET firstname ='".$_GET['inputFN']."', middlename ='".$_GET['inputMN']."', lastname ='".$_GET['inputLN']."', gender ='".$_GET['gender']."', birthdate ='".$_GET['bday']." 00:00:00', program_id ='".$_GET['program']."', religion_id ='".$_GET['religion']."', nationality_id ='".$_GET['nationality']."', yearstatus ='".$_GET['yearstatus']. "', regular = '1' WHERE id='".$_GET['inputID']."'";
                if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='student.php';</script>";}
            } else {
                $query = "UPDATE Student SET firstname ='".$_GET['inputFN']."', middlename ='".$_GET['inputMN']."', lastname ='".$_GET['inputLN']."', gender ='".$_GET['gender']."', birthdate ='".$_GET['bday']." 00:00:00', program_id ='".$_GET['program']."', religion_id ='".$_GET['religion']."', nationality_id ='".$_GET['nationality']."', yearstatus='".$_GET['yearstatus']."', regular = '0' WHERE id='".$_GET['inputID']."'";
                if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='student.php';</script>";}
            }
        } else {
            if (isset($_GET['regular'])) {
                if ($_GET['regular'] == "on") {
                    $query = "INSERT INTO Student (firstname, middlename, lastname, gender, birthdate, program_id, religion_id, nationality_id, yearstatus, regular) VALUES ('" . $_GET['inputFN'] . "', '" . $_GET['inputMN'] . "', '" . $_GET['inputLN'] . "',  '" . $_GET['gender'] . "', '" . $_GET['bday'] . " 00:00:00', '" . $_GET['program'] . "', '" . $_GET['religion'] . "', '" . $_GET['nationality'] . "', '" . $_GET['yearstatus'] . "', '1')";
                    if ($con->query($query)) {
                        echo "<script type=\"text/javascript\">self.location='student.php';</script>";
                    }
                }
            } else {
                $query = "INSERT INTO Student (firstname, middlename, lastname, gender, birthdate, program_id, religion_id, nationality_id, yearstatus, regular) VALUES ('" . $_GET['inputFN'] . "', '" . $_GET['inputMN'] . "', '" . $_GET['inputLN'] . "', '" . $_GET['gender'] . "', '" . $_GET['bday'] . " 00:00:00', '" . $_GET['program'] . "', '" . $_GET['religion'] . "', '" . $_GET['nationality'] . "', '" . $_GET['yearstatus'] . "', '0')";
                if ($con->query($query)) {
                    echo "<script type=\"text/javascript\">self.location='student.php';</script>";
                }
            }
        }
    }

    if (isset($_GET['delete']) && $_SESSION['pStudent'][2] == "1"){
        $query = "DELETE FROM Student WHERE id = (".$_GET['delete'].")";
        if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='student.php';</script>";}
    }

    if (isset($_GET['order']) && isset($_GET['StudID'])){
        $_SESSION['StudentGradeTable_Order'] = $_GET['order'];
        $_SESSION['StudentGradeTable_Type'] = $_GET['type'];
    } else if (isset($_GET['order'])){
        $_SESSION['StudentTable_Order'] = $_GET['order'];
        $_SESSION['StudentTable_Type'] = $_GET['type'];
        $_SESSION['StudentTable_Page'] = "0";
    }


    if (isset($_GET['page'])){
        $_SESSION['StudentTable_Page'] = $_GET['page'];
    }


?>

<html>

<head>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="css/stylea.css" rel="stylesheet" type="text/css">
    <link href="css/hover-min.css" rel="stylesheet" type="text/css">
	<title>Students List</title>
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
			    <img class="student-logo hvr-push" src="img/studs.png">
				<p class="student-header-label">Students Table</p>
			</div>
		</div>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" role="document" style="width:40%">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #337ab7; height: 100px">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Clear()"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title text-center" id="myModalLabelAdd" style="color: white; margin-top: 20px; margin-bottom: auto">Add a new student</h3>
					</div>
					<div class="modal-body student-modal-add">
						<form class="form-horizontal form" data-toggle="validator">
							<div class="form-group has-feedback" id="FirstnameGroup">
								<label for="inputFN" class="col-sm-5 control-label">Firstname</label>
								<div class="col-sm-4">
                                    <input type="hidden" name="inputID" id="inputID">
									<input type="text" class="form-control" name="inputFN" id="inputFN" maxlength="60" required>
								</div>
							</div>

							<div class="form-group has-feedback" id="MiddlenameGroup">
								<label for="inputLN" class="col-sm-5 control-label">Middlename</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="inputMN" id="inputMN" maxlength="60" required>
								</div>
							</div>

							<div class="form-group has-feedback" id="LastnameGroup">
								<label for="inputLN" class="col-sm-5 control-label">Lastname</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="inputLN" id="inputLN"  maxlength="60" required>
								</div>
							</div>

							<div class="form-group has-feedback" id="GenderGroup">
								<label for="GM" class="col-sm-5 control-label">Gender</label>
								<div class="col-sm-4">
									<label class="radio-inline">
										<input type="radio" name="gender" id="GM" value="1" checked> Male
									</label>
									<label class="radio-inline">
										<input type="radio" name="gender" id="GF" value="0"> Female
									</label>
								</div>
							</div>

							<div class="form-group has-feedback" id="BDayGroup">
								<label for="GM" class="col-sm-5 control-label">Birthdate</label>
								<div class='col-sm-4'>
									<input type='date' class="form-control" name='bday' id='bday' required>
								</div>
							</div>

							<div class="form-group has-feedback" id="ProgramGroup">
								<label for="program" class="col-sm-5 control-label">Program</label>
								<div class="col-sm-4">
									<select class="form-control" name="program" id="program">
                                        <?php
                                        $query = "SELECT title, id FROM Program ORDER BY title ASC";
                                        if ($result = mysqli_query($con, $query)) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                print('
                                                    <option value="'.$row['id'].'">'.$row["title"].'</option>
                                            ');
                                            }
                                            $result->free();
                                        }
                                        ?>
									</select>
								</div>
							</div>

							<div class="form-group has-feedback" id="ReligionGroup">
								<label for="religion" class="col-sm-5 control-label">Religion</label>
								<div class="col-sm-4">
									<select class="form-control" name="religion" id="religion">
                                        <?php
                                        $query = "SELECT name, id FROM Religion ORDER BY name ASC";
                                        if ($result = mysqli_query($con, $query)) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                print('
                                                    <option value="'.$row['id'].'">'.$row["name"].'</option>
                                            ');
                                            }
                                            $result->free();
                                        }
                                        ?>
									</select>
								</div>
							</div>

							<div class="form-group has-feedback" id="NationalityGroup">
								<label for="nationality" class="col-sm-5 control-label">Nationality</label>
								<div class="col-sm-4">
									<select class="form-control" name="nationality" id="nationality">
                                        <?php
                                        $query = "SELECT name, id FROM Nationality ORDER BY name ASC";
                                        if ($result = mysqli_query($con, $query)) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                print('
                                                    <option value="'.$row['id'].'">'.$row["name"].'</option>
                                            ');
                                            }
                                            $result->free();
                                        }
                                        ?>
									</select>
								</div>
							</div>

							<div class="form-group has-feedback" id="regularGroup">
								<label for="regular" class="col-sm-5 control-label">Regular</label>
								<div class="col-sm-1">
									<input type="checkbox" class="form-control" name="regular" id="regular"/>
								</div>
							</div>

							<div class="form-group has-feedback" id="YearStatusGroup">
								<label for="yearstatus" class="col-sm-5 control-label">Year Status</label>
								<div class="col-sm-4">
									<select class="form-control" name="yearstatus" id="yearstatus">
										<option value="1">First</option>
										<option value="2">Second</option>
										<option value="3">Third</option>
										<option value="4">Fourth</option>
									</select>
								</div>
							</div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="AddBTN">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick = "Clear()" id="EditBTN">Cancel</button>
                            </div>
						</form>
                      </div>
                </div>
			</div>
		</div>

		<div class="row scene_element scene_element--fadeinup">
			<table class="table table-hover table-striped student-table table-responsive" id="tableID">
				<thead>
				<tr class="student-table-header">
                    <th class="hidden">ID</th>
                    <?php
                        if ($_SESSION['StudentTable_Type'] == "ASC") { $type = "DESC"; $caret = "▼";} else {$type = "ASC"; $caret = "▲";}

                        if (isset($_SESSION['StudentTable_Order'])){
                            if ($_SESSION['StudentTable_Order'] == 2) $LN = $caret; else $LN = "";
                            if ($_SESSION['StudentTable_Order'] == 3) $FN = $caret; else $FN = "";
                            if ($_SESSION['StudentTable_Order'] == 4) $MN = $caret; else $MN = "";
                            if ($_SESSION['StudentTable_Order'] == 5) $GEN = $caret; else $GEN = "";
                            if ($_SESSION['StudentTable_Order'] == 6) $BD = $caret; else $BD = "";
                            if ($_SESSION['StudentTable_Order'] == 7) $PRO = $caret; else $PRO = "";
                            if ($_SESSION['StudentTable_Order'] == 8) $REL = $caret; else $REL = "";
                            if ($_SESSION['StudentTable_Order'] == 12) $NAT = $caret; else $NAT = "";
                            if ($_SESSION['StudentTable_Order'] == 13) $REG = $caret; else $REG = "";
                            if ($_SESSION['StudentTable_Order'] == 14) $YR = $caret; else $YR = "";
                        }
                    print('
                        <th><a href="student.php?order=2&type='.$type.'">LASTNAME '.$LN.'</a></th>
                        <th><a href="student.php?order=3&type='.$type.'">FIRSTNAME '.$FN.'</a></th>
                        <th><a href="student.php?order=4&type='.$type.'">MIDDLENAME '.$MN.'</a></th>
                        <th><a href="student.php?order=5&type='.$type.'">GENDER '.$GEN.'</a></th>
                        <th><a href="student.php?order=6&type='.$type.'">BIRTHDATE '.$BD.'</a></th>
                        <th><a href="student.php?order=7&type='.$type.'">PROGRAM '.$PRO.'</a></th>
                        <th><a href="student.php?order=8&type='.$type.'">RELIGION '.$REL.'</a></th>
                        <th><a href="student.php?order=12&type='.$type.'">NATIONALITY '.$NAT.'</a></th>
                        <th><a href="student.php?order=13&type='.$type.'">REGULAR '.$REG.'</a></th>
                        <th><a href="student.php?order=14&type='.$type.'">YEAR '.$YR.'</a></th>
                        <th class="hidden">PROG ID</th>
                        <th class="hidden">REL ID</th>
                        <th class="hidden">NAT ID</th>
                    ');
                    ?>
				</tr>
				</thead>
				<tbody class="table-striped table-hover" id="Data">
                    <?php

                        if($_SESSION['pStudent'][2] == '0') {$hideEdit = "hidden";} else {$hideEdit = "";}
                        if($_SESSION['pStudent'][2] == '0') {$hideDel = "hidden";} else {$hideDel = "";}
                        if($_SESSION['pStudent'][3] == '0') {$hideGrades = "hidden";} else {$hideGrades = "";}

                        $query = "SELECT student.id, lastname, firstname, middlename, gender, birthdate, program.title, religion.name AS rel, student.program_id AS progid, student.religion_id AS relid, student.nationality_id AS natid, nationality.name AS nat, regular, yearstatus FROM Student LEFT JOIN Nationality ON Student.nationality_id = Nationality.id LEFT JOIN Religion ON Student.religion_id = Religion.id LEFT JOIN Program ON program_id = program.id ORDER BY ".$_SESSION['StudentTable_Order']." ".$type." LIMIT ".($_SESSION['StudentTable_Page']*50).", 50";

                        if ($result = mysqli_query($con, $query)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row["gender"] == 0){
                                    $gender = 'Female';
                                } else $gender = 'Male';

                                if ($row["regular"]==1){
                                    $reg = 'Yes';
                                } else $reg = 'No';

                                $bday = explode(" ", $row['birthdate']);
                                print('
                                        <tr id="'.$row['id'].'">
                                            <td class="hidden">'.$row["id"].'</td>
                                            <td>'.$row["lastname"].'</td>
                                            <td>'.$row["firstname"].'</td>
                                            <td>'.$row["middlename"].'</td>
                                            <td>'.$gender.'</td>
                                            <td>'.$bday[0].'</td>
                                            <td>'.$row["title"].'</td>
                                            <td>'.$row["rel"].'</td>
                                            <td>'.$row["nat"].'</td>
                                            <td>'.$reg.'</td>
                                            <td>'.$row['yearstatus'].'</td>
                                            <td class="hidden">'.$row['progid'].'</td>
                                            <td class="hidden">'.$row['relid'].'</td>
                                            <td class="hidden">'.$row['natid'].'</td>
                                            <td><button type="button" class="btn btn-default hvr-push '.$hideEdit.'" onclick="Edit('.$row['id'].')"  data-toggle="modal" data-target="#myModal"><img data-toggle="tooltip" data-placement="top" title="Edit Details" class="student-table-icons" src="img/edit.png"/></button><button type="button" class="btn btn-default hvr-push '.$hideGrades.'" onclick="Grades('.$row['id'].')"><img data-toggle="tooltip" data-placement="top" title="View Grades" class="student-table-icons" src="img/viewgrades.png"/></button><button type="button" class="btn btn-danger hvr-push '.$hideDel.'" onclick="Delete('.$row['id'].')"><img data-toggle="tooltip" data-placement="top" title="Delete" class="student-table-icons" src="img/del.png"/></button></td>
                                        </tr>
                                    ');
                            }
                            $result->free();
                        }
                    ?>
				</tbody>
			</table>
		</div>
		
		<div class="modal fade" id="myGrades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" role="document" style="width:50%">
				<div class="modal-content">
					<div class="modal-header text-center" style="background-color: #337ab7; height: 130px">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="CloseGrades()"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title text-center" id="myModalLabel" style="color: white; margin-top: 20px; margin-bottom: auto">Report Card for</h3>
						<h4 id="NameForGrades">
                            <?php
                            $query = "SELECT lastname, firstname, middlename FROM Student WHERE id='".$_GET['StudID']."'";
                            if ($result = mysqli_query($con, $query)) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    print($row["lastname"].', '.$row["firstname"].' '.$row["middlename"]);
                                }
                                $result->free();
                            }
                            ?>
                        </h4>
					</div>
					<div class="modal-body student-modal-add">

                            <?php
                            $available = true;
                            $query = "SELECT id FROM Grade WHERE student_id='".$_GET['StudID']."'";
                            if ($result = mysqli_query($con, $query)) {
                                if (mysqli_num_rows($result) <= 0) {$available = false;}
                            }
                            ?>

						<table class="student-table table table-hover table-responsive <?php if (!$available)  echo "hidden";?>" style="margin-bottom: 0;" >
							<tr class="student-table-header">
                                <th class="hidden">ID</th>
                                <?php
                                    $query = "SELECT id FROM Grade WHERE student_id='".$_GET['StudID']."'";
                                    if ($result = mysqli_query($con, $query)) {
                                        if (mysqli_num_rows($result) <= 0) $available = false;
                                        if ($_SESSION['StudentGradeTable_Type'] == "ASC") {
                                            $type = "DESC";
                                            $caret = "▼";
                                        } else {
                                            $type = "ASC";
                                            $caret = "▲";
                                        }

                                        if (isset($_SESSION['StudentGradeTable_Order'])) {
                                            if ($_SESSION['StudentGradeTable_Order'] == 2) $LN = $caret; else $LN = "";
                                            if ($_SESSION['StudentGradeTable_Order'] == 3) $FN = $caret; else $FN = "";
                                            if ($_SESSION['StudentGradeTable_Order'] == 4) $MN = $caret; else $MN = "";
                                            if ($_SESSION['StudentGradeTable_Order'] == 5) $GEN = $caret; else $GEN = "";
                                        }

                                        print('
                                        <th><a href="student.php?StudID=' . $_GET["StudID"] . '&order=2&type=' . $type . '">SUBJECT ' . $LN . '</a></th>
                                        <th><a href="student.php?StudID=' . $_GET["StudID"] . '&order=3&type=' . $type . '">SCHOOL YEAR ' . $FN . '</a></th>
                                        <th><a href="student.php?StudID=' . $_GET["StudID"] . '&order=4&type=' . $type . '">SEMESTER ' . $MN . '</a></th>
                                        <th><a href="student.php?StudID=' . $_GET["StudID"] . '&order=5&type=' . $type . '">GRADE ' . $GEN . '</a></th>
                                    ');
                                    }
                                ?>
							</tr>
                                <?php
                                    if(isset($_GET['StudID'])){
                                        $query = "SELECT Grade.id, title, schoolyear, semester, grade FROM Grade LEFT JOIN Subject ON Grade.Subject_id = Subject.id WHERE student_id='".$_GET['StudID']."' ORDER BY ".$_SESSION['StudentGradeTable_Order']." ".$type;
                                        if ($result = mysqli_query($con, $query)) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if ($row["semester"] == 1){
                                                    $sem = 'First';
                                                } else  if ($row["semester"] == 2){
                                                    $sem = 'Second';
                                                } else $sem = 'Third';

                                                print('
                                                    <tr>
                                                        <td class="hidden">'.$row["id"].'</td>
                                                        <td>'.$row["title"].'</td>
                                                        <td>'.$row["schoolyear"].'</td>
                                                        <td>'.$sem.'</td>
                                                        <td>'.$row["grade"].'</td></tr>
                                                ');
                                            }
                                            $result->free();
                                        }
                                    }
                                ?>
						</table>
                        <?php if (!$available)  echo "<h4 class='text-danger text-center'>Ooops! There are no grades available for this student...</h4>";?>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" onclick="CloseGrades()" id="CloseBTN">Close</button>
					</div>
				</div>
			</div>
		</div>

        <div class="row text-center">
            <ul class="pagination paginationBar">
                <?php
                $query = "SELECT * FROM Student";
                if ($result = mysqli_query($con, $query)) {
                    $rows = mysqli_num_rows($result)/50;
                    for ($i = 0; $i<$rows; $i++){
                        if ($_SESSION['StudentTable_Page'] == $i) {$class = "active";} else $class = "";
                        print('
                            <li class="'.$class.'"><a href="student.php?page='.$i.'">'.($i+1).'</a></li>
                        ');
                    }

                    $result->free();
                }
                ?>
            </ul>
        </div>
	</div>

    <div id="floating-button" data-toggle="modal" data-placement="left" data-target="#myModal" class="hvr-grow-rotate scene_element scene_element--fadeinright <?php if($_SESSION['pStudent'][1] == '0') echo "hidden";?> ">
        <img class="plus hvr-grow" src="img/add.png" data-toggle="tooltip" data-placement="top" title="Add new student">
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
        function openNav() {
            document.getElementById("mySidenav").style.width = "300px";
            document.getElementById("main").style.marginLeft = "300px";
        }
        function Grades(num){
            self.location="student.php?StudID="+num;
        }
        function CloseGrades(){
            self.location="student.php";
        }
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
        function Delete(num){
            self.location="student.php?delete="+num;
        }
        function Edit(StudNum){
            var currentTable = document.getElementById(StudNum);
            document.getElementById('inputID').value = currentTable.cells[0].innerHTML;
            document.getElementById('inputFN').value = currentTable.cells[2].innerHTML;
            document.getElementById('inputMN').value = currentTable.cells[3].innerHTML;
            document.getElementById('inputLN').value = currentTable.cells[1].innerHTML;
            if (currentTable.cells[4].innerHTML.localeCompare('Male')){
                document.getElementById('GF').checked = true;
            } else document.getElementById('GM').checked = true;
            document.getElementById('bday').value = currentTable.cells[5].innerHTML;
            document.getElementById('program').value = currentTable.cells[11].innerHTML;
            document.getElementById('religion').value = currentTable.cells[12].innerHTML;
            document.getElementById('nationality').value = currentTable.cells[13].innerHTML;
            if (currentTable.cells[9].innerHTML.localeCompare('Yes')){
                document.getElementById('regular').checked = false;
            } else document.getElementById('regular').checked = true;
            document.getElementById('yearstatus').value = currentTable.cells[10].innerHTML;
            document.getElementById('AddBTN').innerHTML = "Save";
            document.getElementById('myModalLabelAdd').innerHTML = "Edit Student Details";
        }
        function Clear(){
            document.getElementById('inputID').value = "";
            document.getElementById('inputFN').value = "";
            document.getElementById('inputMN').value = "";
            document.getElementById('inputLN').value = "";
            document.getElementById('regular').checked = false;
            document.getElementById('AddBTN').innerHTML = "Add";
            document.getElementById('myModalLabelAdd').innerHTML = "Add New Student";
        }4
        function Logout(){
            self.location="home.php?logout=yes";
        }
	</script>
</body>
</html>

<?php
    if (isset($_GET['StudID'])){
        echo "<script type=\"text/javascript\">$('#myGrades').modal('show');</script>";
    }
?>