<?php 
session_start();

//variables 
$username = 'admin';
$password = 'admin';
$random1 = 'secret_key1';
$random2 = 'secret_key2';

$hash = md5($random1 . $password . $random2);
$self = $_SERVER['REQUEST_URI'];

//logout
if(isset($_GET['logout']))
{
	unset($_SESSION['login']);
}

//logged in
if (isset($_SESSION['login']) && $_SESSION['login'] == $hash)
{
	logged_in_msg($username);
}

//submitted form
else if (isset($_POST['submit']))
{
	if ($_POST['username'] == $username && $_POST['password'] == $password)
	{
		//IF USERNAME AND PASSWORD ARE CORRECT SET THE LOGIN SESSION
		$_SESSION["login"] = $hash;
		header("Location: $_SERVER[PHP_SELF]");
	}
	else
	{
		// DISPLAY FORM WITH ERROR
		display_login_form();
		display_error_msg();
	}
}

//show log in form
else
{
	display_login_form();
}

function display_login_form()
{
	echo '<form action="index.php" method="post">' .
			 '<label for="username">Username:   </label>' .
			 '<input type="text" name="username" id="username" placeholder="password == admin">' .
			 '<br><br>' .
			 '<label for="password">Password:   </label>' .
			 '<input type="password" name="password" id="password" placeholder="password == admin">' .
			 '<br><br>' .
			 '<input type="submit" name="submit" value="Submit">' .
		 '</form>';
}

function logged_in_msg($username)
{
	echo '<p>Hello ' . $username . ', you have successfully logged in!</p>' .
		 '<a href="?logout=true">Logout?</a>';
}

function display_error_msg()
{
	echo '<p>Username or password is invalid</p>';
}

?>
