<?php
    include 'session.php';
    include 'connect.php';

    if (isset($_SESSION['pAccounts'])){
        if($_SESSION['pAccounts'][0] == "0"){
            echo "<script type=\"text/javascript\">self.location='redirect.php';</script>";
        }
    } else  echo "<script type=\"text/javascript\">self.location='login.php';</script>";

    if (isset($_GET['inputID']) && isset($_GET['inputUN']) && isset($_GET['inputPW']) && isset($_GET['inputDE']) && isset($_GET['active']) && ($_SESSION['pAccounts'][1] == "1" || $_SESSION['pAccounts'][2] == "1")){
        $Stu; $Pro; $Sub; $Nat; $Rel; $Acc; $Gra;
        if (isset($_GET['Stu_view'])) $Stu = "1"; else $Stu = "0";
        if (isset($_GET['Stu_add'])) $Stu = $Stu."1"; else $Stu = $Stu."0";
        if (isset($_GET['Stu_edit'])) $Stu = $Stu."1"; else $Stu = $Stu."0";
        if (isset($_GET['Stu_viewGrades'])) $Stu = $Stu."1"; else $Stu = $Stu."0";
        if (isset($_GET['Pro_view'])) $Pro = "1"; else $Pro = "0";
        if (isset($_GET['Pro_add'])) $Pro = $Pro."1"; else $Pro = $Pro."0";
        if (isset($_GET['Pro_edit'])) $Pro = $Pro."1"; else $Pro = $Pro."0";
        if (isset($_GET['Pros_view'])) $Pro = $Pro."1"; else $Pro = $Pro."0";
        if (isset($_GET['Pros_add'])) $Pro = $Pro."1"; else $Pro = $Pro."0";
        if (isset($_GET['Pros_edit'])) $Pro = $Pro."1"; else $Pro = $Pro."0";
        if (isset($_GET['Sub_view'])) $Sub = "1"; else $Sub = "0";
        if (isset($_GET['Sub_add'])) $Sub= $Sub."1"; else $Sub = $Sub."0";
        if (isset($_GET['Sub_edit'])) $Sub = $Sub."1"; else $Sub = $Sub."0";
        if (isset($_GET['Nat_view'])) $Nat = "1"; else $Nat= "0";
        if (isset($_GET['Nat_add'])) $Nat = $Nat."1"; else $Nat= $Nat."0";
        if (isset($_GET['Nat_edit'])) $Nat = $Nat."1"; else $Nat = $Nat."0";
        if (isset($_GET['Rel_view'])) $Rel = "1"; else $Rel = "0";
        if (isset($_GET['Rel_add'])) $Rel= $Rel."1"; else $Rel = $Rel."0";
        if (isset($_GET['Rel_edit'])) $Rel = $Rel."1"; else $Rel = $Rel."0";
        if (isset($_GET['Acc_view'])) $Acc = "1"; else $Acc = "0";
        if (isset($_GET['Acc_add'])) $Acc = $Acc."1"; else $Acc = $Acc."0";
        if (isset($_GET['Acc_edit'])) $Acc = $Acc."1"; else $Acc = $Acc."0";
        if (isset($_GET['Gra_view'])) $Gra = "1"; else $Gra = "0";
        if (isset($_GET['Gra_add'])) $Gra = $Gra."1"; else $Gra = $Gra."0";
        if (isset($_GET['Gra_edit'])) $Gra = $Gra."1"; else $Gra = $Gra."0";
        if ($_GET['inputID'] != "" && $_SESSION['pAccounts'][2] == "1"){
            $query = "UPDATE Account SET uname ='".$_GET['inputUN']."', pword ='".$_GET['inputPW']."', description ='".$_GET['inputDE']."', active ='".$_GET['active']."', permitstudent ='".$Stu."', permitprogram ='".$Pro."', permitsubject ='".$Sub."', permitnationality ='".$Nat."', permitreligion ='".$Rel."', permitaccounts ='".$Acc."', permitgrades ='".$Gra."', modifiedby_id = '".$_SESSION['ID']."', modifiedon = '".date('Y-m-d H:i:s')."' WHERE id='".$_GET['inputID']."'";
            if ($con->query($query)){
                if ($_GET['inputID'] == $_SESSION['ID']){
                    echo "<script type=\"text/javascript\">alert('You will be Logged out to apply changes in your account');</script>";
                    echo "<script type=\"text/javascript\">self.location='home.php?logout=yes';</script>";
                } else {
                    echo "<script type=\"text/javascript\">self.location='accounts.php';</script>";
                }
            }
        } else {
            $query = "INSERT INTO Account (uname, pword, description, active, permitstudent, permitprogram, permitsubject, permitnationality, permitreligion, permitaccounts, permitgrades, addedby_id, modifiedby_id, addedon, modifiedon) VALUES ('".$_GET['inputUN']."', '".$_GET['inputPW']."', '".$_GET['inputDE']."', '".$_GET['active']."', '".$Stu."', '".$Pro."', '".$Sub."', '".$Nat."', '".$Rel."', '".$Acc."', '".$Gra."', '".$_SESSION['ID']."', '".$_SESSION['ID']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
            if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='accounts.php';</script>";}
        }
    }

    if (isset($_GET['delete']) && $_SESSION['pAccounts'][2] == "1"){
        $query = "DELETE FROM Account WHERE id = ".$_GET['delete'];
        if ($con->query($query)){echo "<script type=\"text/javascript\">self.location='accounts.php';</script>";}
    }

    if (isset($_GET['order'])){
        $_SESSION['AccountsTable_Order'] = $_GET['order'];
        $_SESSION['AccountsTable_Type'] = $_GET['type'];
    }
?>

<html>

<head>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="css/stylea.css" rel="stylesheet" type="text/css">
    <link href="css/hover-min.css" rel="stylesheet" type="text/css">
	<title>Accounts List</title>
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
			    <img class="student-logo hvr-push" src="img/Accounts.png">
				<p class="student-header-label">Accounts Table</p>
			</div>
		</div>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" role="document" style="width: 40%">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #337ab7; height: 100px">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Clear()"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title text-center" id="myModalLabelAdd" style="color: white; margin-top: 20px; margin-bottom: auto">Add a new account</h3>
					</div>
					<div class="modal-body student-modal-add">
						<form class="form-horizontal form" data-toggle="validator">
							<div class="form-group has-feedback" id="UsernameGroup">
								<label for="inputUN" class="col-sm-5 control-label">Username</label>
								<div class="col-sm-4">
                                    <input type="hidden" name="inputID" id="inputID">
									<input type="text" class="form-control" id="inputUN" name="inputUN" maxlength="20" required>
								</div>
							</div>

							<div class="form-group has-feedback" id="PasswordGroup">
								<label for="inputPW" class="col-sm-5 control-label">Password</label>
								<div class="col-sm-4">
									<input type="password" class="form-control" id="inputPW" name="inputPW" maxlength="256" required>
								</div>
							</div>

                            <div class="form-group has-feedback" id="DescriptionGroup">
                                <label for="inputDE" class="col-sm-5 control-label">Description</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="inputDE" name="inputDE" maxlength="120" required>
                                </div>
                            </div>
							
							<div class="form-group" id="StatusGroup">
								<label for="GM" class="col-sm-5 control-label">Status</label>
								<div class="col-sm-4">
									<label class="radio-inline">
										<input type="radio" name="active" id="Active" value="1" checked> Active
									</label>
									<label class="radio-inline">
										<input type="radio" name="active" id="Inactive" value="0"> Inactive
									</label>
								</div>
							</div>

                            <hr>

                            <div class="row" id="StatusGroup">
                                <center>
                                    <h4 class="text-center">Permissions</h4>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-primary" onclick="CheckAll()">Check All</button>
                                        <button type="button" class="btn btn-primary" onclick="UncheckAll()">Uncheck All</button>
                                    </div>
                                </center>
                            </div>

                            <div class="form-group" id="StudentGroup" style="margin-top: 20px;">
                                <label for="GM" class="col-sm-5 control-label">Students Page</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Stu_view" id="Stu_view" value="1"> View
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Stu_add" id="Stu_add" value="0"> Add
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Stu_edit" id="Stu_edit" value="0"> Edit
                                    </label>
                                </div>
                                <label for="GM" class="col-sm-5 control-label">Grades</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Stu_viewGrades" id="Stu_viewGrades" value="0"> View Grades
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="ProgramsGroup">
                                <label for="GM" class="col-sm-5 control-label">Programs Page</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Pro_view" id="Pro_view" value="1"> View
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Pro_add" id="Pro_add" value="0"> Add
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Pro_edit" id="Pro_edit" value="0"> Edit
                                    </label>
                                </div>
                                <label for="GM" class="col-sm-5 control-label">Prospectus</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Pros_view" id="Pros_view" value="0"> View
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Pros_add" id="Pros_add" value="0"> Add
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Pros_edit" id="Pros_edit" value="0"> Edit
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="SubjectsGroup">
                                <label for="GM" class="col-sm-5 control-label">Subjects Page</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Sub_view" id="Sub_view" value="1"> View
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Sub_add" id="Sub_add" value="0"> Add
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Sub_edit" id="Sub_edit" value="0"> Edit
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="NationalityGroup">
                                <label for="GM" class="col-sm-5 control-label">Nationalities Page</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Nat_view" id="Nat_view" value="1"> View
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Nat_add" id="Nat_add" value="0"> Add
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Nat_edit" id="Nat_edit" value="0"> Edit
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="ReligionGroup">
                                <label for="GM" class="col-sm-5 control-label">Religions Page</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Rel_view" id="Rel_view" value="1"> View
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Rel_add" id="Rel_add" value="0"> Add
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Rel_edit" id="Rel_edit" value="0"> Edit
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="AccountsGroup">
                                <label for="GM" class="col-sm-5 control-label">Accounts Page</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Acc_view" id="Acc_view" value="1"> View
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Acc_add" id="Acc_add" value="0"> Add
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Acc_edit" id="Acc_edit" value="0"> Edit
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="GradesGroup">
                                <label for="GM" class="col-sm-5 control-label">Grades Page</label>
                                <div class="col-sm-6">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Gra_view" id="Gra_view" value="1"> View
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Gra_add" id="Gra_add" value="0"> Add
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="Gra_edit" id="Gra_edit" value="0"> Edit
                                    </label>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="AddBTN">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="Clear()" id="EditBTN">Cancel</button>
                            </div>
						</form>
					</div>


				</div>
			</div>
		</div>

		<div class="row scene_element scene_element--fadeinup">
			<table class="table table-hover table-striped accounts-table table-responsive" id="tableID">
				<thead>
				<tr class="student-table-header">
                    <th class="hidden">ID</th>
                    <?php
                        if(isset($_SESSION['AccountsTable_Order'])){$order = $_SESSION['AccountsTable_Order'];} else $order = "2";
                        if ($_SESSION['AccountsTable_Type'] == "ASC") { $type = "DESC"; $caret = "▼";} else {$type = "ASC"; $caret = "▲";}


                        if ($order == 1) $LN = $caret; else $LN = "";
                        if ($order == 3) $FN = $caret; else $FN = "";
                        if ($order == 4) $MN = $caret; else $MN = "";
                        if ($order == 12) $GEN = $caret; else $GEN = "";
                        if ($order == 13) $BD = $caret; else $BD = "";
                        if ($order == 14) $PRO = $caret; else $PRO = "";
                        if ($order == 15) $REL = $caret; else $REL = "";
                        print('
                            <th><a href="accounts.php?order=1&type='.$type.'">USERNAMES '.$LN.'</th>
                            <th class="hidden">PASSWORDS</th>
                            <th><a href="accounts.php?order=3&type='.$type.'">DESCRIPTION '.$FN.'</th>
                            <th><a href="accounts.php?order=4&type='.$type.'">STATUS '.$MN.'</th>
                            <th><a href="accounts.php?order=12&type='.$type.'">ADDED ON '.$GEN.'</th>
                            <th><a href="accounts.php?order=13&type='.$type.'">ADDED BY '.$BD.'</th>
                            <th><a href="accounts.php?order=14&type='.$type.'">MODIFIED ON '.$PRO.'</th>
                            <th><a href="accounts.php?order=15&type='.$type.'">MODIFIED BY '.$REL.'</th>
                            <th>ACTIONS</th>
                        ');
                    ?>
				</tr>
				</thead>
				<tbody class="table-striped table-hover" id="Data">
                    <?php
                    if($_SESSION['pAccounts'][2] == '0') {$hideEdit = "hidden";} else {$hideEdit = "";}
                    if($_SESSION['pAccounts'][2] == '0') {$hideDel = "hidden";} else {$hideDel = "";}


                        $query = "SELECT A.id AS aid, A.uname AS un, A.pword AS pw, A.description AS descr, A.active AS ac, A. permitstudent AS pst, A.permitprogram AS pp, A. permitsubject AS ps, A.permitnationality AS pn, A.permitreligion AS pr, A.permitaccounts AS pa, A.permitgrades AS pg, A.addedon AS ao, A.modifiedon AS mo, B.uname AS modifiedbyID, C.uname AS addedbyID FROM Account AS A LEFT JOIN Account AS B ON A.modifiedby_id = B.id LEFT JOIN Account AS C ON A.addedby_id = C.id ORDER BY ".$order." ".$type;

                        if ($result = mysqli_query($con, $query)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['aid'] == $_SESSION['ID']){$class = "hidden"; $classB = "";} else {$class=""; $classB = "hidden";}

                                if ($row['ac'] == "1"){
                                    $act = "Active";
                                } else $act = "Inactive";
                                print('
                                        <tr id="'.$row['aid'].'">
                                            <td class="hidden">'.$row["aid"].'</td>
                                            <td>'.$row["un"].'</td>
                                             <td class="hidden">'.$row["pw"].'</td>
                                            <td>'.$row["descr"].'</td>
                                            <td>'.$act.'</td>
                                            <td class="hidden">'.$row["pst"].'</td>
                                            <td class="hidden">'.$row["pp"].'</td>
                                            <td class="hidden">'.$row["ps"].'</td>
                                            <td class="hidden">'.$row["pn"].'</td>
                                            <td class="hidden">'.$row["pr"].'</td>
                                            <td class="hidden">'.$row["pa"].'</td>
                                            <td class="hidden">'.$row["pg"].'</td>
                                            <td>'.explode(" ", $row["ao"])[0].'</td>
                                            <td>'.$row["addedbyID"].'</td>
                                            <td>'.explode(" ", $row["mo"])[0].'</td>
                                            <td>'.$row["modifiedbyID"].'</td>
                                            <td class="'.$class.'"><button type="button" class="btn btn-default hvr-push '.$hideEdit.'" onclick="Edit('.$row['aid'].')"  data-toggle="modal" data-target="#myModal"><img data-toggle="tooltip" data-placement="top" title="Edit Details" class="student-table-icons" src="img/edit.png"/></button><button type="button" class="btn btn-danger hvr-push '.$hideDel.'" onclick="Delete('.$row['aid'].')"><img data-toggle="tooltip" data-placement="top" title="Delete" class="student-table-icons" src="img/del.png"/></button></td>
                                            <td class="'.$classB.'"> You cannot edit your <br> own account </td>
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
    <div id="floating-button" data-toggle="modal" data-placement="left" data-target="#myModal" class="hvr-grow-rotate scene_element scene_element--fadeinright <?php if($_SESSION['pAccounts'][1] == '0') echo "hidden";?> ">
        <img class="plus hvr-grow" src="img/add.png" data-toggle="tooltip" data-placement="top" title="Add new account">
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
            document.getElementById('inputID').value = currentTable.cells[0].innerHTML;
            document.getElementById('inputUN').value = currentTable.cells[1].innerHTML;
            document.getElementById('inputPW').value = currentTable.cells[2].innerHTML;
            document.getElementById('inputDE').value = currentTable.cells[3].innerHTML;
            if (currentTable.cells[4].innerHTML.localeCompare('Inactive')){
                document.getElementById('Active').checked = true;
			} else document.getElementById('Inactive').checked = true;
            var Stu = currentTable.cells[5].innerHTML.split("");
            var Pro = currentTable.cells[6].innerHTML.split("");
            var Sub = currentTable.cells[7].innerHTML.split("");
            var Nat = currentTable.cells[8].innerHTML.split("");
            var Rel = currentTable.cells[9].innerHTML.split("");
            var Acc = currentTable.cells[10].innerHTML.split("");
            var Gra = currentTable.cells[11].innerHTML.split("");
            if (Stu[0]=="1"){
                document.getElementById('Stu_view').checked = true;
            }
            if (Stu[1]=="1"){
                document.getElementById('Stu_add').checked = true;
            }
            if (Stu[2]=="1"){
                document.getElementById('Stu_edit').checked = true;
            }
            if (Stu[3]=="1"){
                document.getElementById('Stu_viewGrades').checked = true;
            }
            if (Pro[0]=="1"){
                document.getElementById('Pro_view').checked = true;
            }
            if (Pro[1]=="1"){
                document.getElementById('Pro_add').checked = true;
            }
            if (Pro[2]=="1"){
                document.getElementById('Pro_edit').checked = true;
            }
            if (Pro[3]=="1"){
                document.getElementById('Pros_view').checked = true;
            }
            if (Pro[4]=="1"){
                document.getElementById('Pros_add').checked = true;
            }
            if (Pro[5]=="1"){
                document.getElementById('Pros_edit').checked = true;
            }
            if (Sub[0]=="1"){
                document.getElementById('Sub_view').checked = true;
            }
            if (Sub[1]=="1"){
                document.getElementById('Sub_add').checked = true;
            }
            if (Sub[2]=="1"){
                document.getElementById('Sub_edit').checked = true;
            }
            if (Nat[0]=="1"){
                document.getElementById('Nat_view').checked = true;
            }
            if (Nat[1]=="1"){
                document.getElementById('Nat_add').checked = true;
            }
            if (Nat[2]=="1"){
                document.getElementById('Nat_edit').checked = true;
            }
            if (Rel[0]=="1"){
                document.getElementById('Rel_view').checked = true;
            }
            if (Rel[1]=="1"){
                document.getElementById('Rel_add').checked = true;
            }
            if (Rel[2]=="1"){
                document.getElementById('Rel_edit').checked = true;
            }
            if (Acc[0]=="1"){
                document.getElementById('Acc_view').checked = true;
            }
            if (Acc[1]=="1"){
                document.getElementById('Acc_add').checked = true;
            }
            if (Acc[2]=="1"){
                document.getElementById('Acc_edit').checked = true;
            }
            if (Gra[0]=="1"){
                document.getElementById('Gra_view').checked = true;
            }
            if (Gra[1]=="1"){
                document.getElementById('Gra_add').checked = true;
            }
            if (Gra[2]=="1"){
                document.getElementById('Gra_edit').checked = true;
            }
			document.getElementById('AddBTN').innerHTML = "Save";
			document.getElementById('myModalLabelAdd').innerHTML = "Edit Account Details";
		}
        function Clear(){
            document.getElementById('inputID').value = "";
            document.getElementById('inputUN').value = "";
            document.getElementById('inputPW').value = "";
            document.getElementById('inputDE').value = "";
            document.getElementById('Active').checked = true;
            UncheckAll();
            document.getElementById('AddBTN').innerHTML = "Add";
            document.getElementById('myModalLabelAdd').innerHTML = "Add new account";
        }
        function CheckAll(){
            document.getElementById('Stu_view').checked = true;
            document.getElementById('Stu_add').checked = true;
            document.getElementById('Stu_edit').checked = true;
            document.getElementById('Stu_viewGrades').checked = true;
            document.getElementById('Pro_view').checked = true;
            document.getElementById('Pro_add').checked = true;
            document.getElementById('Pro_edit').checked = true;
            document.getElementById('Pros_view').checked = true;
            document.getElementById('Pros_add').checked = true;
            document.getElementById('Pros_edit').checked = true;
            document.getElementById('Sub_view').checked = true;
            document.getElementById('Sub_add').checked = true;
            document.getElementById('Sub_edit').checked = true;
            document.getElementById('Nat_view').checked =true;
            document.getElementById('Nat_add').checked = true;
            document.getElementById('Nat_edit').checked = true;
            document.getElementById('Rel_view').checked =true;
            document.getElementById('Rel_add').checked = true;
            document.getElementById('Rel_edit').checked = true;
            document.getElementById('Acc_view').checked = true;
            document.getElementById('Acc_add').checked = true;
            document.getElementById('Acc_edit').checked = true;
            document.getElementById('Gra_view').checked = true;
            document.getElementById('Gra_add').checked = true;
            document.getElementById('Gra_edit').checked = true;
        }
        function UncheckAll(){
            document.getElementById('Stu_view').checked = false;
            document.getElementById('Stu_add').checked = false;
            document.getElementById('Stu_edit').checked = false;
            document.getElementById('Stu_viewGrades').checked = false;
            document.getElementById('Pro_view').checked = false;
            document.getElementById('Pro_add').checked = false;
            document.getElementById('Pro_edit').checked = false;
            document.getElementById('Pros_view').checked = false;
            document.getElementById('Pros_add').checked = false;
            document.getElementById('Pros_edit').checked = false;
            document.getElementById('Sub_view').checked = false;
            document.getElementById('Sub_add').checked = false;
            document.getElementById('Sub_edit').checked = false;
            document.getElementById('Nat_view').checked = false;
            document.getElementById('Nat_add').checked = false;
            document.getElementById('Nat_edit').checked = false;
            document.getElementById('Rel_view').checked = false;
            document.getElementById('Rel_add').checked = false;
            document.getElementById('Rel_edit').checked = false;
            document.getElementById('Acc_view').checked = false;
            document.getElementById('Acc_add').checked = false;
            document.getElementById('Acc_edit').checked = false;
            document.getElementById('Gra_view').checked = false;
            document.getElementById('Gra_add').checked = false;
            document.getElementById('Gra_edit').checked = false;
        }
        function Delete(num){
            self.location="accounts.php?delete="+num;
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