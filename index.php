<?php
//logout
if (isset($_GET['logout'])) {
	session_start();
	session_unset();
	session_destroy();
	session_write_close();
	setcookie(session_name(),'',0,'/');
	session_regenerate_id(true);
	header('location: ./');
  }

//date
$today = date("d/m/Y");
echo $today;

'<br>';

//show path
print('<h2>GIT HUB directory contents: ' . str_replace('?BIT_PHP_TR=/', ' ', $_SERVER['REQUEST_URI'] . '</h2>'));
print("<br>");

//create
$pre_file_name = $_POST['name'];
switch ($extn) {
	case "png" : $extn = "PNG Image"; break;
	case "jpg" : $extn = "JPEG Image"; break;
	case "svg" : $extn = "SVG Image"; break;
	case "gif" : $extn = "GIF Image"; break;
	case "ico" : $extn = "Windows Icon"; break;
	
	case "txt" : $extn = "Text File"; break;
	case "log" : $extn = "Log File"; break;
	case "htm" : $extn = "HTML File"; break;
	case "php" : $extn = "PHP Script"; break;
	case "js" : $extn = "Javascript"; break;
	case "css" : $extn = "Stylesheet"; break;
	case "pdf" : $extn = "PDF Document"; break;

	case "zip" : $extn = "ZIP Archive"; break;
	case "bak" : $extn = "Backup File"; break;

	default : $extn = strtoupper($extn); break;
}
$filename = $pre_file_name . $extn;
fopen($filename, 'w');


//upload
if (isset($_POST['upload'])) {
	$file_name = $_FILES['file']['name'];
	$file_type = $_FILES['file']['type'];
	$file_size - $_FILES['file']['size'];
	$file_tem_loc = $_FILES['file']['tmp_name'];
	$file_store = "." . $file_name;

	if (move_uploaded_file($file_tem_loc, $file_store)); {
		print "";
	}
}

//delete
// $dfile = $_GET['name'];
// unlink($file);
// echo "File deleted";
if (isset($_POST['delete'])) {
	$deleteObj = './' . $_GET["path"] . $_POST['delete'];
	$del_obj = str_replace("&nbsp;", " ", htmlentities($deleteObj, null, 'utf-8'));
	if (is_file($del_obj)) {
		if (file_exists($del_obj)) {
			unlink($del_obj);
		}
	}
}

//download
if (isset($_POST['download'])) {
	$file = './' . $_POST['download'];
	$fileToDownload = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
	header('Content-Description: File Transfer');
	header('Content-Type: application/txt');
	header('Content-Disposition: attachment; filename=' . basename($fileToDownload));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($fileToDownload));
	flush();
	readfile($fileToDownload);
	exit;
}

$full_path = './' . $_GET["full_path"];
$files_and_dirs = scandir($full_path);

// List all files and directories
print('<table><th>Type</th><th>Name</th><th>Actions</th>');
foreach ($files_and_dirs as $fnd) {
	if ($fnd != ".." and $fnd != ".") {
		print('<tr>');
		// ./.git/logs
		print('<td>' . (is_dir($full_path . $fnd) ? "Directory" : "File") . '</td>');
		print('<td>' . (is_dir($full_path . $fnd)
			? '<a href="' . (isset($_GET['full_path'])
				? $_SERVER['REQUEST_URI'] . $fnd . '/'
				: $_SERVER['REQUEST_URI'] . '?full_path=' . $fnd . '/') . '">' . $fnd . '</a>'
			: $fnd)
			. '</td>');
		print('<td>'
			. (is_dir($full_path . $fnd)
				? ''
				: '<form style="display: inline-block" action="" method="post">
                                <input type="hidden" name="delete" value=' . str_replace(' ', '&nbsp;', $fnd) . '>
                                <input type="submit" value="Delete">
                               </form>
                               <form style="display: inline-block" action="" method="post">
                                <input type="hidden" name="download" value=' . str_replace(' ', '&nbsp;', $fnd) . '>
                                <input type="submit" value="Download">
                               </form>')
			. "</form></td>");
		print('</tr>');
	}
}
print("</table>");
?>

<html>
	<br><br><br>
<form action="index.php" method="POST">
	Example: FileName.pdf, FileName.jpg, FileName.txt, etc.
	<br><br>
	File name: <input type="text" name="name">
	<input type="submit" value="Create File">		
</form>

<br><br>
<form action="?" method="POST" enctype="multipart/form-data">
	Upload file: 
	<input type="file" name="file">
	<input type="submit" name="upload" value="Upload file">
</form>
<br><br>
<button type="submit" name="submit" value="Logout">
	<a href = "login.php?action=logout"> LOGOUT.</button>


</html>
