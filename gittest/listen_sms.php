<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	//$timeStamp  = NULL;
	$device = mysql_prep($_GET['device']);
	$phone	= mysql_prep($_GET['phone']);
	$text	= mysql_prep($_GET['text']);
	$smscenter	= mysql_prep($_GET['smscenter']);
?>
<?php
	$query = "INSERT INTO SMS_MSG (
				device, phone, text, smscenter
			) VALUES (
				'{$device}', '{$phone}', '{$text}', '{$smscenter}'
			)";
			
	echo "<p>" . $query . "</p>";
	$result = mysql_query($query, $connection);
	if ($result) {
		// Success!
		echo "<p>Customer creation success.</p>";
	} else {
		// Display error message.
		echo "<p>Customer creation failed.</p>";
		echo "<p>" . mysql_error() . "</p>";
	}
?>

<?php mysql_close($connection); ?>