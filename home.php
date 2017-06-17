<?php
    include 'session.php';
?>


<html class="home-html">
<head>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="css/stylea.css" rel="stylesheet" type="text/css">
	<link href="css/hover-min.css" rel="stylesheet" type="text/css">
	<title>Home</title>
</head>

<body class="home-body">
<script>document.body.className += ' fade-out';</script>
	<div class="container-fluid">
		<div class="row text-center home-welcome scene_element scene_element--fadeindown">
			<h1> Welcome, <?php echo $_SESSION['Username']?>!</h1>
			<h5> Choose a page to get started.</h5>
			<button class="btn btn-primary home-logout hvr-push" onclick="Logout()">Logout</button>
		</div>

		<div class="row text-center scene_element scene_element--fadeinup" style="padding-left: 20%; padding-right: 20%;">
            <div class="col-md-3 <?php if($_SESSION['pStudent'][0] == '0') echo "hidden";?> ">
                <a href="student.php"><img class="home-icons hvr-bounce-in" src="img/studs.png"></a>
                <p>Students</p>
            </div>
			<div class="col-md-3 <?php if($_SESSION['pProgram'][0] == '0') echo "hidden";?> ">
				<a href="programs.php"><img class="home-icons hvr-bounce-in" src="img/prog.png"></a>
				<p>Programs</p>
			</div>
			<div class="col-md-3 <?php if($_SESSION['pSubject'][0] == '0') echo "hidden";?> ">
				<a href="subjects.php"><img class="home-icons hvr-bounce-in" src="img/subj.png"></a>
				<p>Subjects</p>
			</div>
			<div class="col-md-3 <?php if($_SESSION['pGrades'][0] == '0') echo "hidden";?> ">
				<a href="grades.php"><img class="home-icons hvr-bounce-in" src="img/grades.png"></a>
				<p>Grades</p>
			</div>
			<div class="col-md-3 <?php if($_SESSION['pNationality'][0] == '0') echo "hidden";?> ">
				<a href="nationality.php"><img class="home-icons hvr-bounce-in" src="img/nat.png"></a>
				<p>Nationalities</p>
			</div>
			<div class="col-md-3 <?php if($_SESSION['pReligion'][0] == '0') echo "hidden";?> ">
				<a href="religion.php"><img class="home-icons hvr-bounce-in" src="img/rel.png"></a>
				<p>Religions</p>
			</div>
            <div class="col-md-3 <?php if($_SESSION['pAccounts'][0] == '0') echo "hidden";?> ">
                <a href="accounts.php"><img class="home-icons hvr-bounce-in " src="img/Accounts.png"></a>
                <p>Accounts</p>
            </div>
		</div>

		<div class="row text-center home-footer scene_element scene_element--fadein">
			<div class="col-md-12">
				<p>(C) AJ Pasigado, School Database.</p>
			</div>

		</div>

	</div>


	<script src="js/jquery.min.js"></script>
	<script src="js/script.js"></script>
	<script type="text/javascript">
		function Logout(){
            self.location="home.php?logout=yes";
		}
	</script>
</body>

</html>