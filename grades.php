<?php
include 'session.php';
include 'connect.php';
    if (isset($_SESSION['pGrades'])){
        if($_SESSION['pGrades'][0] == "0"){
            echo "<script type=\"text/javascript\">self.location='redirect.php';</script>";
        }
    } else  echo "<script type=\"text/javascript\">self.location='login.php';</script>";

    if (isset($_GET['inputYear']) && isset($_GET['inputSem']) && isset($_GET['SubjID']) && ($_SESSION['pGrades'][1] == "1" || $_SESSION['pGrades'][2] == "1")){
        if ($_GET['inputID'] != "" && $_SESSION['pGrades'][2] == "1") {
            $query = "UPDATE Grade SET schoolyear ='" . $_GET['inputYear'] . "', semester ='" . $_GET['inputSem'] . "', grade ='" . $_GET['inputGrade'] . "' WHERE student_id='" . $_GET['StudentToEdit'] . "'";
            if ($con->query($query)) {
                echo "<script type=\"text/javascript\">self.location='grades.php?SubjID=".$_GET['SubjID']."';</script>";
            }
        } else {
            $query = "INSERT INTO Grade (student_id, subject_id, schoolyear, semester, grade) VALUES ('" . $_GET['studentID'] . "', '" . $_GET['SubjID'] . "', '" . $_GET['inputYear'] . "', '" . $_GET['inputSem'] . "', '" . $_GET['inputGrade'] . "')";
            if ($con->query($query)) {
                echo "<script type=\"text/javascript\">self.location='grades.php?SubjID=".$_GET['SubjID']."';</script>";
            }
        }
    }

    if (isset($_GET['delete']) && $_SESSION['pGrades'][2] == "1"){
        $query = "DELETE FROM Grade WHERE id = (".$_GET['delete'].")";
        if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='grades.php?SubjID=".$_GET['SubjID']."';</script>";}
    }

    if (isset($_GET['order']) && isset($_GET['SubjID'])){
        $_SESSION['GradesViewTable_Order'] = $_GET['order'];
        $_SESSION['GradesViewTable_Type'] = $_GET['type'];
    } else if (isset($_GET['order'])){
        $_SESSION['GradesTable_Order'] = $_GET['order'];
        $_SESSION['GradesTable_Type'] = $_GET['type'];
    }

    if (isset($_GET['Year'])){
        $_SESSION['GradesSchoolYear'] = $_GET['Year'];
    }

    if (isset($_GET['Sem'])) {
        $_SESSION['GradesSem'] = $_GET['Sem'];
    } else $_SESSION['GradesSem'] = "100";

    if (!isset($_GET['SubjID'])){
        $_SESSION['GradesSchoolYear'] = "20000";
        $_SESSION['GradesSem'] = "100";
    }

    $available = true;
?>

<html>

<head>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="css/stylea.css" rel="stylesheet" type="text/css">
    <link href="css/hover-min.css" rel="stylesheet" type="text/css">
	<title>Grades List</title>
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
			<div class="col-md-12 text-center scene_element scene_element--fadeindown">
			    <img class="student-logo hvr-push" src="img/prog.png">
				<p class="student-header-label">Grades Table</p>	
				<p>Pick a class to view grades</p>
			</div>
		</div>
		<div class="modal fade" id="myGrades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" role="document" style="width: 40%">
				<div class="modal-content">
					<div class="modal-header text-center" style="background-color: #337ab7; height: 130px">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="CloseGrades()"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title text-center" id="myModalLabel" style="color: white; margin-top: 20px; margin-bottom: auto">Viewing grades for</h3>
						<p id="programTitle">
                            <?php if (isset($_GET['SubjID'])){
                                $query = "SELECT title FROM Subject WHERE id='".$_GET['SubjID']."'";
                                if ($result = mysqli_query($con, $query)) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        print($row["title"]);
                                    }
                                }
                            }
                            ?>
                        </p>
					</div>
					<div class="modal-body student-modal-add">
                        <div class="col-md-6 text-center">
                            <div class="btn-group btn-group-sm">
                                <p> Available School Years</p>
                                <?php if (isset($_GET['SubjID'])) {
                                    $query = "SELECT DISTINCT schoolyear FROM Grade WHERE subject_id='" . $_GET['SubjID'] . "' ORDER BY schoolyear ASC";
                                    if ($result = mysqli_query($con, $query)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if ($_SESSION['GradesSchoolYear'] == "20000") {
                                                    $_SESSION['GradesSchoolYear'] = $row['schoolyear'];
                                                }
                                                if ($_SESSION['GradesSchoolYear'] == $row['schoolyear']) {
                                                    $class = "active";
                                                } else $class = "";

                                                print('
                                                <button type="button" class="btn btn-default ' . $class . '" onclick="Year(' . $row['schoolyear'] . ', ' . $_GET['SubjID'] . ')">' . $row['schoolyear'] . '</button>
                                                ');
                                            }
                                        } else {echo "<p>None</p>"; $available = false;};
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 text-center" style="margin-bottom: 30px;">
                            <div class="btn-group btn-group-sm">
                                <p> Available Semesters</p>
                                <?php if (isset($_GET['SubjID'])) {
                                    $query = "SELECT DISTINCT semester FROM Grade WHERE subject_id='" . $_GET['SubjID'] . "' AND schoolyear = '" . $_SESSION['GradesSchoolYear'] . "' ORDER BY semester ASC";
                                    if ($result = mysqli_query($con, $query)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if ($_SESSION['GradesSem'] == "100") {
                                                    $_SESSION['GradesSem'] = $row['semester'];
                                                }
                                                if ($_SESSION['GradesSem'] == $row['semester']) {
                                                    $class = "active";
                                                } else $class = "";

                                                if ($row['semester'] == "1") {
                                                    $name = "First";
                                                } else if ($row['semester'] == "2") {
                                                    $name = "Second";
                                                } else if ($row['semester'] == "3") {
                                                    $name = "Third";
                                                }

                                                print('
                                                <button type="button" class="btn btn-default ' . $class . '" onclick="Sem(' . $row['semester'] . ', ' . $_GET['SubjID'] . ', ' . $_SESSION['GradesSchoolYear'] . ')">' . $name . '</button>
                                                ');
                                            }
                                        } else echo "<p>None</p>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php if(!$available) echo "<h4 class='text-center text-danger'>Oops there are no grades in this class...</h4>"; ?>
						<table class="subjects-table table table-hover table-responsive <?php if(!$available) echo "hidden"; ?>" style="width: 100%;">
							<thead class="student-table-header">
								<th class="hidden">ID</th>
								<th class="hidden">STUDENT ID</th>
                                <?php if (isset($_GET['SubjID'])) {
                                    if (isset($_SESSION['GradesViewTable_Order'])) {
                                        $order = $_SESSION['GradesViewTable_Order'];
                                    } else $order = "2";
                                    if ($_SESSION['GradesViewTable_Type'] == "ASC") {
                                        $type = "DESC";
                                        $caret = "▼";
                                    } else {
                                        $type = "ASC";
                                        $caret = "▲";
                                    }

                                    if ($order == 3) $LN = $caret; else $LN = "";
                                    if ($order == 8) $GN = $caret; else $GN = "";
                                    print('
                                        <th><a href="grades.php?SubjID=' . $_GET['SubjID'] . '&order=3&type=' . $type . '">STUDENT ' . $LN . '</a></th>
								        <th><a href="grades.php?SubjID=' . $_GET['SubjID'] . '&order=8&type=' . $type . '">GRADE ' . $GN . '</a></th>
                                    ');
                                }
                                ?>
							</thead>
							<tbody id="Data">
                                <?php if (isset($_GET['SubjID'])) {
                                    if ($_SESSION['pGrades'][2] == '0') {
                                        $hideEdit = "hidden";
                                    } else {
                                        $hideEdit = "";
                                    }
                                    if ($_SESSION['pGrades'][2] == '0') {
                                        $hideDel = "hidden";
                                    } else {
                                        $hideDel = "";
                                    }

                                    $query = "SELECT Grade.id AS GID, student.id AS SID, lastname, firstname, middlename, schoolyear, semester, grade FROM Grade LEFT JOIN Student ON Grade.Student_id = Student.id WHERE subject_id='" . $_GET['SubjID'] . "' AND schoolyear = '" . $_SESSION['GradesSchoolYear'] . "' AND semester = '" . $_SESSION['GradesSem'] . "' ORDER BY " . $order . " " . $type;
                                    if ($result = mysqli_query($con, $query)) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row["semester"] == 1) {
                                                $sem = 'First';
                                            } else if ($row["semester"] == 2) {
                                                $sem = 'Second';
                                            } else $sem = 'Third';

                                            print('
                                                        <tr id="' . $row["GID"] . '">
                                                            <td class="hidden">' . $row["GID"] . '</td>
                                                            <td class="hidden">' . $row["SID"] . '</td>
                                                            <td>' . $row["lastname"] . ', ' . $row["firstname"] . ' ' . $row["middlename"] . '</td>
                                                            <td class="hidden">' . $row["schoolyear"] . '</td>
                                                            <td class="hidden">' . $sem . '</td>
                                                            <td>' . $row["grade"] . '</td>
                                                            <td><button type="button" class="btn btn-default hvr-push ' . $hideEdit . '" onclick="Edit(' . $row['GID'] . ')"  data-toggle="modal" data-target="#myModal"><img data-toggle="tooltip" data-placement="top" title="Edit Grade" class="student-table-icons" src="img/edit.png"/></button><button type="button" class="btn btn-danger hvr-push ' . $hideDel . '" onclick="Delete(' . $row['GID'] . ', ' . $_GET['SubjID'] . ')"><img data-toggle="tooltip" data-placement="top" title="Delete" class="student-table-icons" src="img/del.png"/></button></td>
                                                        </tr>
                                                    ');
                                        }
                                        $result->free();
                                    }
                                }
                                ?>
							</tbody>
						</table>
					</div>

					<div class="modal-footer">
						<button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-primary <?php if($_SESSION['pGrades'][1] == '0') echo "hidden";?>">Add</button>
						<button type="button" class="btn btn-default" data-dismiss="modal" onclick="CloseGrades()" id="CloseBTN">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #337ab7; height: 100px">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="View(<?php echo $_GET['SubjID']; ?>)">&times;</span></button>
						<h3 class="modal-title text-center" id="myModalLabelAdd" style="color: white; margin-top: 20px; margin-bottom: auto">Add a new grade</h3>
					</div>
					<div class="modal-body student-modal-add">
						<form class="form-horizontal form" data-toggle="validator">
							<div class="form-group" id="CodeGroup">
								<label for="inputCode" id="LabelStudent" class="col-sm-5 control-label">Student</label>
								<div class="col-sm-4">
                                    <select class="form-control" name="studentID" id="studentID">
                                        <?php if (isset($_GET['SubjID'])) {
                                            $query = "SELECT id, lastname, firstname, middlename FROM Student WHERE NOT EXISTS (SELECT * FROM Grade WHERE student.id = student_id) ORDER BY lastname ASC";
                                            if ($result = mysqli_query($con, $query)) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    print('
                                                        <option value="' . $row['id'] . '">' . $row["lastname"] . ', ' . $row["firstname"] . ' ' . $row["middlename"] . '</option>
                                                ');
                                                }
                                                $result->free();
                                            }
                                        }
                                        ?>
                                    </select>
								</div>
							</div>

							<div class="form-group has-feedback" id="YearGroup">
								<label for="inputYear" class="col-sm-5 control-label">Schoolyear</label>
								<div class="col-sm-4">
									<input type="number" class="form-control" id="inputYear" name="inputYear" min="1000" max="9999" required>
								</div>
							</div>

                            <div class="form-group has-feedback" id="SemesterGroup">
                                <label for="semester" class="col-sm-5 control-label">Semester</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="inputSem" id="inputSem">
                                        <option value="1">First</option>
                                        <option value="2">Second</option>
                                        <option value="3">Third</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="StudentToEdit" id="StudentToEdit">
                            <input type="hidden" name="inputID" id="inputID">
                            <input type="hidden" name="SubjID" id="SubjID">
							<div class="form-group has-feedback" id="GardeGroup">
								<label for="inputGrade" class="col-sm-5 control-label">Grade</label>
								<div class="col-sm-4">
									<input type="number" class="form-control" id="inputGrade" name="inputGrade" min="0" max="100" required>
								</div>
							</div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="AddBTN">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="View(<?php echo $_GET['SubjID']; ?>)" id="EditBTN">Cancel</button>
                            </div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row scene_element scene_element--fadeinup">
			<table class="table table-hover table-striped programs-table table-responsive" id="tableID">
				<thead>
				<tr class="student-table-header">
					<th class="hidden">ID</th>
                    <?php
                        if(isset($_SESSION['GradesTable_Order'])){$order = $_SESSION['GradesTable_Order'];} else $order = "2";
                        if ($_SESSION['GradesTable_Type'] == "ASC") { $type = "DESC"; $caret = "▼";} else {$type = "ASC"; $caret = "▲";}

                        if ($order == 2) $LN = $caret; else $LN = "";
                        if ($order == 3) $FN = $caret; else $FN = "";


                        print('
                                        <th><a href="grades.php?order=2&type='.$type.'">CODE '.$LN.'</a></th>
                                        <th><a href="grades.php?order=3&type='.$type.'">TITLE '.$FN.'</a></th>
                                    ');
                    ?>
					<th class="hidden">UNITS</th>
				</tr>
				</thead>
				<tbody class="table-striped table-hover">
                    <?php
                        $query = "SELECT * FROM Subject ORDER BY ".$order." ".$type;

                        if ($result = mysqli_query($con, $query)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                print('
                                        <tr id="'.$row['id'].'">
                                            <td class="hidden">'.$row["id"].'</td>
                                            <td>'.$row["code"].'</td>
                                            <td>'.$row["title"].'</td>
                                            <td class="hidden">'.$row["unit"].'</td>
                                            <td><button type="button" class="btn btn-default hvr-push" onclick="View('.$row['id'].')"><img data-toggle="tooltip" data-placement="top" title="View Grades" class="student-table-icons" src="img/viewgrades.png"/></button></td>
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
            document.getElementById('inputYear').value = currentTable.cells[3].innerHTML;
            document.getElementById('inputID').value = currentTable.cells[0].innerHTML;
            var Semester;
            if (currentTable.cells[4].innerHTML == "First"){
                Semester = 1;
            } else if (currentTable.cells[4].innerHTML == "Second"){
                Semester = 2;
            } else if (currentTable.cells[4].innerHTML == "Third"){
                Semester = 3;
            } else if (currentTable.cells[4].innerHTML == "Fourth"){
                Semester = 4;
            }
            document.getElementById('inputSem').value = Semester;

            document.getElementById('inputGrade').value = currentTable.cells[5].innerHTML;

            document.getElementById('StudentToEdit').value = currentTable.cells[1].innerHTML;

            document.getElementById('studentID').className += " hidden";
            document.getElementById('LabelStudent').className += " hidden";
			document.getElementById('AddBTN').innerHTML = "Save";
			document.getElementById('myModalLabelAdd').innerHTML = currentTable.cells[2].innerHTML;
		}
        function Year(yr, sid){
            self.location="grades.php?SubjID="+sid+"&Year="+yr;
        }
        function Sem(sem, sid, sy){
            self.location="grades.php?SubjID="+sid+"&Year="+sy+"&Sem="+sem;
        }
		function View(Subj){
            self.location="grades.php?SubjID="+Subj;
        }
        function CloseGrades(){
            self.location="grades.php";
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
        function Delete(num, del){
            self.location="grades.php?delete="+num+"&SubjID="+del;
        }
	</script>
</body>

</html>

<?php
if (isset($_GET['SubjID'])){
    echo "<script type=\"text/javascript\">$('#myGrades').modal('show'); document.getElementById('SubjID').value = ".$_GET['SubjID'].";</script>";
}
?>