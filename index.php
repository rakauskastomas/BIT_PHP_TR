<?php
//  directory creation logic
if (isset($_GET["create_dir"])) {
	if ($_GET["create_dir"] != "") {
		$dir_to_create = './' . $_GET["path"] . $_GET["create_dir"];
		if (!is_dir($dir_to_create)) mkdir($dir_to_create, 0777, true);
	}
	$url = preg_replace("/(&?|\??)create_dir=(.+)?/", "", $_SERVER["REQUEST_URI"]);
	header('Location: ' . urldecode($url));
}

// directory deletion logic
if (isset($_POST['delete'])) {
	$objToDelete = './' . $_GET["path"] . $_POST['delete'];
	$objToDeleteEscaped = str_replace("&nbsp;", " ", htmlentities($objToDelete, null, 'utf-8'));
	if (is_file($objToDeleteEscaped)) {
		if (file_exists($objToDeleteEscaped)) {
			unlink($objToDeleteEscaped);
		}
	}
}

//delete
if(isset($_POST['delete'])){
	$objToDelete = './' . $_GET["path"] . $_POST['delete']; 
	$objToDeleteEscaped = str_replace("&nbsp;", " ", htmlentities($objToDelete, null, 'utf-8'));
	if(is_file($objToDeleteEscaped)){
		if (file_exists($objToDeleteEscaped)) {
			unlink($objToDeleteEscaped);
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>
	<!-- login FORM  -->
	<div class="container">
		<h1>LOGIN</h1>
		<form method="post" action="">
			<div class="login-body">
				<?php
				if (isset($error)) {
					echo "<div class='errormsg'>$error</div>";
				}
				?>
				<div class="form-row">
					<label for="emailaddress">Username:</label>
					<input type="text" name="username" id="username" placeholder="username" maxlength="100">
				</div>
				<div class="form-row">
					<label for="pass">Password:</label>
					<input type="password" name="pass" id="pass" placeholder="Password" maxlength="100">
				</div>

				<div class="login-button-row">
					<input type="submit" name="login-submit" id="login-submit" value="Login" title="Login now">
				</div>
			</div>
		</form>
		Click here to <a href="index.php?action=logout">Logout</a>
	</div>
	<form action="/BIT_PHP_TR" method="get">
                <input type="hidden" name="path" value="<?php print($_GET['path']) ?>" /> 
                <input placeholder="Name of new directory" type="text" id="create_dir" name="create_dir">
                <button type="submit">Submit</button>
            </form>
	<?php

	session_start();

	//login
	if (isset($_POST['submit'])) {
		if ((isset($_POST['username']) && $_POST['username'] != '') && (isset($_POST['password']) && $_POST['password'] != '')) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);


			if (password_verify($password, $row['password'])) {
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['user_name'] = $row['first_name'];
				exit;
			} else {
				$errorMsg =  "Wrong Username Or Password";
			}
		} else {
			$errorMsg =  "No User Found";
		}
	}
	?>
	<?php

	// Directory path 
	print('<h2>GIT HUB directory contents: ' . str_replace('?BIT_PHP_TR=/', ' ', $_SERVER['REQUEST_URI'] . '</h2>'));
	print("<br><br>");


	$dir = "../BIT_PHP_TR/";
	$file = glob($dir . "*.txt");

	// Open a directory, and read its contents

	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				print filetype($file) . "  -->  " . $file . "  -->  " . 
				'<form style="display: inline-block" action="" method="post">
				<input type="hidden" name="delete" value=' . str_replace(' ', '&nbsp;', $file) . '>
				<input type="submit" value="Delete">
			   </form>' . "<br>";
			}
			closedir($dh);
		}
	}

	// Cookies
	if (!isset($_COOKIE["Aplanyta_kartu"])) {
		$kartai = 1;
	} else {
		$kartai = $_COOKIE[$kartai] + 1;
	}
	setcookie("Aplankyta_kartu", $kartai, time() + 60);
	?>

</body>

</html>