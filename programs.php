<?php
    include 'session.php';
    include 'connect.php';
    if (isset($_SESSION['pProgram'])){
        if($_SESSION['pProgram'][0] == "0"){
            echo "<script type=\"text/javascript\">self.location='redirect.php';</script>";
        }
    } else  echo "<script type=\"text/javascript\">self.location='login.php';</script>";

    if (isset($_GET['delete']) && $_SESSION['pProgram'][2] == "1"){
        $query = "DELETE FROM Program WHERE id = (".$_GET['delete'].")";
        if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='programs.php';</script>";}
    }

    if (isset($_GET['DelCID']) && $_SESSION['pProgram'][5] == "1"){
        $query = "DELETE FROM Curriculum WHERE id = (".$_GET['DelCID'].")";
        if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='programs.php?ProgID=".$_GET['ProgID']."';</script>";}
    }

    if (isset($_GET['inputCode']) && isset($_GET['inputTitle']) && isset($_GET['inputYear']) && ($_SESSION['pProgram'][1] == "1" || $_SESSION['pProgram'][2] == "1")){
                if ($_GET['inputID'] != "" && $_SESSION['pProgram'][2] == "1") {
                    $query = "UPDATE Program SET code ='" . $_GET['inputCode'] . "', title ='" . $_GET['inputTitle'] . "', year ='" . $_GET['inputYear'] . "' WHERE id='" . $_GET['inputID'] . "'";
                    if ($con->query($query)) {
                        echo "<script type=\"text/javascript\">self.location='programs.php';</script>";
                    }
                } else {
                    if ($result = mysqli_query($con, "SELECT code, title FROM Program WHERE code = '".$_GET['inputCode']."' OR title = '".$_GET['inputTitle']."'")) {
                        if (mysqli_num_rows($result) == 0) {
                    $query = "INSERT INTO Program (code, title, year) VALUES ('" . $_GET['inputCode'] . "', '" . $_GET['inputTitle'] . "', '" . $_GET['inputYear'] . "')";
                    if ($con->query($query)) {
                        echo "<script type=\"text/javascript\">self.location='programs.php';</script>";
                    }
                }  else echo "<script type=\"text/javascript\">alert('Program with the same code or title already exists'); self.location='programs.php';</script>";
            }
        }
    }

    if (isset($_GET['order']) && isset($_GET['ProgID'])){
        $_SESSION['ProgramsProsTable_Order'] = $_GET['order'];
        $_SESSION['ProgramsProsTable_Type'] = $_GET['type'];
    } else if (isset($_GET['order'])){
        $_SESSION['ProgramsTable_Order'] = $_GET['order'];
        $_SESSION['ProgramsTable_Type'] = $_GET['type'];
    }

    if (isset($_GET['inputID']) && isset($_GET['subject']) && isset($_GET['yeartaken']) && isset($_GET['semester']) && ($_SESSION['pProgram'][5] == "1" || $_SESSION['pProgram'][4] == "1")) {
        if (isset($_GET['major'])) {
            $major = "1";
        } else $major = "0";
        if ($_GET['subjID'] == "" && $_SESSION['pProgram'][4] == "1") {
            $query = "INSERT INTO Curriculum (program_id, subject_id, ismajor, semester, yeartaken) VALUES ('" . $_GET['inputID'] . "', '" . $_GET['subject'] . "', '" . $major . "', '" . $_GET['semester'] . "', '" . $_GET['yeartaken'] . "')";
            if ($con->query($query)) {
                echo "<script type=\"text/javascript\">self.location='programs.php?ProgID=" . $_GET['inputID'] . "';</script>";
            }
        } else {
            $query = "UPDATE Curriculum SET ismajor = '".$major."', semester = '".$_GET['semester']."', yeartaken = '".$_GET['yeartaken']."' WHERE id =".$_GET['subjID'];
            if ($con->query($query)) {
                echo "<script type=\"text/javascript\">self.location='programs.php?ProgID=" . $_GET['inputID'] . "';</script>";
            }
        }
    }
?>

<html>

<head>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="css/stylea.css" rel="stylesheet" type="text/css">
    <link href="css/hover-min.css" rel="stylesheet" type="text/css">
	<title>Programs List</title>
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
			    <img class="student-logo hvr-push" src="img/prog.png">
				<p class="student-header-label">Programs Table</p>
			</div>
		</div>


		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #337ab7; height: 100px">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="Clear()">&times;</span></button>
						<h3 class="modal-title text-center" id="myModalLabelAdd" style="color: white; margin-top: 20px; margin-bottom: auto">Add a new curriculum</h3>
					</div>
					<div class="modal-body student-modal-add">
						<form class="form-horizontal form" data-toggle="validator">
							<div class="form-group has-feedback" id="CodeGroup">
								<label for="inputCode" class="col-sm-5 control-label">Code</label>
								<div class="col-sm-4">
                                    <input type="hidden" name="inputID" id="inputID">
									<input type="text" class="form-control" name="inputCode" id="inputCode" maxlength="60" required>
								</div>
							</div>

							<div class="form-group has-feedback" id="TitleGroup">
								<label for="inputTitle" class="col-sm-5 control-label">Title</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="inputTitle" id="inputTitle" maxlength="120" required>
								</div>
							</div>

							<div class="form-group has-feedback" id="YearGroup">
								<label for="inputYear" class="col-sm-5 control-label">Year</label>
								<div class="col-sm-4">
                                    <select class="form-control" name="inputYear" id="inputYear">
                                        <option value="1">First</option>
                                        <option value="2">Second</option>
                                        <option value="3">Third</option>
                                        <option value="4">Fourth</option>
                                        <option value="">Fifth</option>
                                    </select>

								</div>
							</div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" onclick="Add()" id="AddBTN">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="Clear()" id="EditBTN">Cancel</button>
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
                        if(isset($_SESSION['ProgramsTable_Order'])){$order = $_SESSION['ProgramsTable_Order'];} else $order = "2";
                        if ($_SESSION['ProgramsTable_Type'] == "ASC") { $type = "DESC"; $caret = "▼";} else {$type = "ASC"; $caret = "▲";}

                        if ($order == 2) $LN = $caret; else $LN = "";
                        if ($order == 3) $FN = $caret; else $FN = "";
                        if ($order == 4) $MN = $caret; else $MN = "";


                        print('
                                    <th><a href="programs.php?order=2&type='.$type.'">CODE '.$LN.'</a></th>
                                    <th><a href="programs.php?order=3&type='.$type.'">TITLE '.$FN.'</a></th>
                                    <th><a href="programs.php?order=4&type='.$type.'">YEAR '.$MN.'</a></th>
                                ');
                    ?>
				</tr>
				</thead>
				<tbody class="table-striped table-hover" id="Data">
                    <?php
                        if($_SESSION['pProgram'][2] == '0') {$hideEdit = "hidden";} else {$hideEdit = "";}
                        if($_SESSION['pProgram'][2] == '0') {$hideDel = "hidden";} else {$hideDel = "";}
                        if($_SESSION['pProgram'][3] == '0') {$hidePros = "hidden";} else {$hidePros = "";}

                            $query = "SELECT id, code, title, year FROM Program ORDER BY ".$order." ".$type;
                            if ($result = mysqli_query($con, $query)) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    print('
                                            <tr id="'.$row['id'].'">
                                                <td class="hidden">'.$row["id"].'</td>
                                                <td>'.$row["code"].'</td>
                                                <td>'.$row["title"].'</td>
                                                <td>'.$row["year"].'</td>
                                                <td><button type="button" class="btn btn-default hvr-push '.$hideEdit.'" onclick="Edit('.$row['id'].')"  data-toggle="modal" data-target="#myModal"><img data-toggle="tooltip" data-placement="top" title="Edit Details" class="student-table-icons" src="img/edit.png"/></button><button type="button" class="btn btn-default hvr-push '.$hidePros.'" onclick="ViewProspectus('.$row['id'].')"  data-toggle="modal" data-target="#myGrades"><img data-toggle="tooltip" data-placement="top" title="View Prospectus" class="student-table-icons" src="img/viewgrades.png"/></button><button type="button" class="btn btn-danger hvr-push '.$hideDel.'" onclick="Delete('.$row['id'].')"><img data-toggle="tooltip" data-placement="top" title="Delete"  class="student-table-icons" src="img/del.png"/></button></td>
                                            </tr>
                                        ');
                                }
                                $result->free();
                            }
                    ?>
				</tbody>
			</table>
		</div>
        <div id="myButton" class="button">
            <p id="about" onclick="openNav()">Menu <img class="student-back" src="img/back.png" style="width: 20px; margin-left: 10px;"/></p>
        </div>
        <div id="floating-button" data-toggle="modal" data-target="#myModal" class="hvr-grow-rotate scene_element scene_element--fadeinright <?php if($_SESSION['pProgram'][1] == '0') echo "hidden";?> ">
            <img  data-toggle="tooltip" data-placement="top" title="Add new program"  class="plus hvr-grow" src="img/add.png">
        </div>
		<div class="modal fade" id="myGrades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" role="document" style="width: 50%;">
				<div class="modal-content">
					<div class="modal-header text-center" style="background-color: #337ab7; height: 130px">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ClosePros()"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title text-center" id="myModalLabel" style="color: white; margin-top: 20px; margin-bottom: auto">Viewing curriculum for</h3>
						<p id="programTitle">
                            <?php
                                $query = "SELECT title FROM Program WHERE id='".$_GET['ProgID']."'";
                                if ($result = mysqli_query($con, $query)) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        print($row["title"]);
                                    }
                                    $result->free();
                                }
                            ?>
                        </p>
					</div>
					<div class="modal-body student-modal-add">
						<table class="student-table table table-hover table-responsive" style="margin-bottom: 0;">
							<tr class="student-table-header">
                                <th class="hidden">ID</th>
                                <th class="hidden">SUBJECT ID</th>
                                <?php
                                    if(isset($_SESSION['ProgramsProsTable_Order'])){$order = $_SESSION['ProgramsProsTable_Order'];} else $order = "2";
                                    if ($_SESSION['ProgramsProsTable_Type'] == "ASC") { $type = "DESC"; $caret = "▼";} else {$type = "ASC"; $caret = "▲";}

                                    if ($order == 3) $LN = $caret; else $LN = "";
                                    if ($order == 5) $FN = $caret; else $FN = "";
                                    if ($order == 6) $MN = $caret; else $MN = "";
                                    if ($order == 7) $GN = $caret; else $GN = "";

                                    print('
                                        <th><a href="programs.php?ProgID='.$_GET["ProgID"].'&order=3&type='.$type.'"> SUBJECT '.$LN.'</th>
                                        <th class="hidden">PROGRAM ID</th>
                                        <th><a href="programs.php?ProgID='.$_GET["ProgID"].'&order=5&type='.$type.'">MAJOR '.$FN.'</th>
                                        <th><a href="programs.php?ProgID='.$_GET["ProgID"].'&order=6&type='.$type.'">SEMESTER '.$MN.'</th>
                                        <th><a href="programs.php?ProgID='.$_GET["ProgID"].'&order=7&type='.$type.'">YEAR TAKEN '.$GN.'</th>
                                    ');
                                ?>
							</tr>
                            <?php
                                if($_SESSION['pProgram'][5] == '0') $hideEditPros = "hidden"; else $hideEditPros = "";

                                $query = "SELECT Curriculum.id AS CID, subject_id, title, program_id, ismajor, semester, yeartaken FROM Curriculum LEFT JOIN Subject ON curriculum.Subject_id = Subject.id WHERE program_id='".$_GET['ProgID']."' ORDER BY ".$_SESSION['ProgramsProsTable_Order']." ".$type.", semester ASC";
                                if ($result = mysqli_query($con, $query)) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if ($row["semester"] == 1){
                                            $sem = 'First';
                                        } else  if ($row["semester"] == 2){
                                            $sem = 'Second';
                                        } else $sem = 'Third';

                                        if ($row["ismajor"] == 1){
                                            $major = 'Yes';
                                        } else $major = 'No';

                                        print('
                                                    <tr id='.$row['CID'].'>
                                                        <td class="hidden">'.$row["CID"].'</td>
                                                        <td class="hidden">'.$row["subject_id"].'</td>
                                                        <td>'.$row["title"].'</td>
                                                        <td class="hidden">'.$row["program_id"].'</td>
                                                        <td>'.$major.'</td>
                                                        <td>'.$sem.'</td>
                                                        <td>'.$row["yeartaken"].'</td>
                                                        <td><button type="button" class="btn btn-default hvr-push '.$hideEditPros.'" onclick="EditSubject('.$row['CID'].')"  data-toggle="modal" data-target="#addSubject"><img data-toggle="tooltip" data-placement="top" title="Edit Details" class="student-table-icons" src="img/edit.png"/></button><button type="button" class="btn btn-danger hvr-push '.$hideEditPros.'" onclick="DeletePros('.$row['CID'].', '.$_GET['ProgID'].')"><img data-toggle="tooltip" data-placement="top" title="Remove Subject"  class="student-table-icons" src="img/del.png"/></button></td>
                                                     </tr>
                                                ');
                                    }
                                    $result->free();
                                }
                            ?>
						</table>
					</div>
					<div class="modal-footer">
                        <button type="button" data-toggle="modal" data-target="#addSubject" class="btn btn-primary <?php if($_SESSION['pProgram'][4] == '0') echo "hidden";?>">Add</button>
						<button type="button" class="btn btn-default" data-dismiss="modal" onclick="ClosePros()" id="CloseBTN">Close</button>
					</div>
				</div>
			</div>
		</div>

        <div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #337ab7; height: 100px">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="ViewProspectus(<?php echo $_GET['ProgID']; ?>)">&times;</span></button>
                        <h3 class="modal-title text-center" id="myModalLabelAddSubj" style="color: white; margin-top: 20px; margin-bottom: auto">Add a subject to prospectus</h3>
                    </div>
                    <div class="modal-body student-modal-add">
                        <form class="form-horizontal form" data-toggle="validator">
                            <input type="hidden" name="inputID" value="<?php echo $_GET['ProgID'];?>">
                            <div class="form-group has-feedback" id="SubjectGroup">
                                <label for=subject" class="col-sm-5 control-label" id ="SubjLabel">Pick a subject</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="subject" id="subject">
                                        <?php
                                            $query = "SELECT id, code, title FROM Subject WHERE NOT EXISTS (Select * from Curriculum WHERE subject.id = Subject_id) ORDER BY title ASC";
                                            if ($result = mysqli_query($con, $query)) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    print('
                                                        <option value="'.$row['id'].'">'.$row["code"].' '.$row["title"].'</option>
                                                ');
                                                }
                                                $result->free();
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback" id="YearTakenGroup">
                                <label for="yeartaken" class="col-sm-5 control-label">Year Taken</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="yeartaken" id="yeartaken">
                                        <option value="1">First</option>
                                        <option value="2">Second</option>
                                        <option value="3">Third</option>
                                        <option value="4">Fourth</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback" id="SemesterGroup">
                                <label for="semester" class="col-sm-5 control-label">Semester</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="semester" id="semester">
                                        <option value="1">First</option>
                                        <option value="2">Second</option>
                                        <option value="3">Third</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="subjID" id="subjID"/>
                            <div class="form-group has-feedback" id="regularGroup">
                                <label for="major" class="col-sm-5 control-label">Major?</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="form-control" name="major" id="major"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="AddSubjBTN">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="ViewProspectus(<?php echo $_GET['ProgID']; ?>)" id="EditBTN">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
            document.getElementById('inputID').value = currentTable.cells[0].innerHTML;
            document.getElementById('inputCode').value = currentTable.cells[1].innerHTML;
            document.getElementById('inputTitle').value = currentTable.cells[2].innerHTML;
            document.getElementById('inputYear').value = currentTable.cells[3].innerHTML;
			document.getElementById('AddBTN').innerHTML = "Save";
			document.getElementById('myModalLabelAdd').innerHTML = "Edit Details";
		}
        function Clear(){
            document.getElementById('inputID').value = "";
            document.getElementById('inputCode').value = "";
            document.getElementById('inputTitle').value = "";
            document.getElementById('inputYear').value = "";
            document.getElementById('AddBTN').innerHTML = "Add";
            document.getElementById('myModalLabelAdd').innerHTML = "Add new Program";
        }
        function EditSubject(num){
            var currentTable = document.getElementById(num);
            document.getElementById('subject').className += " hidden";
            document.getElementById('SubjLabel').className += " hidden";
            document.getElementById('yeartaken').value = currentTable.cells[6].innerHTML;
            document.getElementById('subjID').value = currentTable.cells[0].innerHTML;
            var Semester;
            if (currentTable.cells[5].innerHTML == "First"){
                Semester = 1;
            } else if (currentTable.cells[5].innerHTML == "Second"){
                Semester = 2;
            } else if (currentTable.cells[5].innerHTML == "Third"){
                Semester = 3;
            } else if (currentTable.cells[5].innerHTML == "Fourth"){
                Semester = 4;
            }
            var Major;
            if (currentTable.cells[4].innerHTML == "Yes"){
                document.getElementById('major').checked = true;
            } else if (currentTable.cells[4].innerHTML == "No"){
                document.getElementById('major').checked = false;
            }
            document.getElementById('semester').value = Semester;
            document.getElementById('AddSubjBTN').innerHTML = "Save";
            document.getElementById('myModalLabelAddSubj').innerHTML = currentTable.cells[2].innerHTML;

        }
        function ClosePros() {
            self.location="programs.php";
        }
        /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
        function openNav() {
            document.getElementById("mySidenav").style.width = "300px";
            document.getElementById("main").style.marginLeft = "300px";
        }

        /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
        function Logout(){
            self.location="home.php?logout=yes";
        }
        function ViewProspectus(ProgID){
            self.location="programs.php?ProgID="+ProgID;
        }
        function Delete(num){
            self.location="programs.php?delete="+num;
        }
        function DeletePros(CID, ProgID){
            self.location="programs.php?ProgID="+ProgID+"&DelCID="+CID;
        }
	</script>
</body>

</html>

<?php
if (isset($_GET['ProgID'])){
    echo "<script type=\"text/javascript\">$('#myGrades').modal('show');</script>";
}
?>