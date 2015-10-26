<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "heroyaguza228", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
<?PHP
	if(isset($_POST['submit'])){
		$password = trim($_POST['password']);
		$newpassword = trim($_POST['newpassword']);
		$confirmnewpassword = trim($_POST['confirmnewpassword']);
		$id = $_SESSION['ID'];
		if($newpassword == $confirmnewpassword){
		$query = "SELECT * FROM TABLE1 WHERE ID = '$id' and password='$password'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if(($row)&($password != $newpassword)){
			$query1 = "UPDATE TABLE1 SET Password = '$newpassword' where ID = '$id'";
			$parseRequest1 = oci_parse($conn, $query1);
			oci_execute($parseRequest1);
			echo '<script>window.location = "MemberPage.php";</script>';
		}else{
			echo "Old Password was wrong";
		}
		}else{
			echo "New password not match";
		}
	};
?>


<?PHP
	if(isset($_POST['back'])){
		echo '<script>window.location = "MemberPage.php";</script>';
	};
?>

<form action='password_changing.php' method='post'>
	Old Password <br>
	<input name='password' type='password'><br>
	New Password<br>
	<input name='newpassword' type='password'><br>
    Comfirm New Password <br>
	<input name='confirmnewpassword' type='password'><br><br>
	<input name='submit' type='submit' value='Submit'>
    <input name='back' type='submit' value='Back'>
	</form>