<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	echo "<p>Inside create dealer</p>";
	$errors = array();
	
	// Form Validation
	$required_fields = array('MobileNum',
				 'FirstName',
				 'Gender',
				 'MobileNum',
				 'FirstName',
				 'Gender',
				 'StreetAddr',
				 'Landmark',
				 'City',
				 'State',
				 'Pincode',
				 'GPSCordinates');
	foreach($required_fields as $fieldname) {
		if (!isset($_GET[$fieldname]) || (empty($_GET[$fieldname]) && $_GET[$fieldname] != 0)) {
			$errors[] = $fieldname;
		}
	}
	
	$fields_with_lengths = array('EmailId'  => 64 ,
				'MobileNum'  => 11,
				'LandlineNum'  => 12,
				'FirstName'  => 16,
				'LastName'  => 16,
				'Gender'  => 8,
				'Age'  => 3,
				'StreetAddr'  => 64,
				'Landmark'  => 64,
				'City'  => 32,
				'State'  => 32,
				'Pincode'  => 8,
				'LocationId'  => 8,
				'GPSCordinates'  => 16,
				'ContractType'  => 16,
				'Rating'  => 2);
	foreach($fields_with_lengths as $fieldname => $maxlength ) {
		if (strlen(trim(mysql_prep($_GET[$fieldname]))) > $maxlength) { $errors[] = $fieldname; }
	}
	
	if (!empty($errors)) {
		var_dump($errors);
		//redirect_to("new_subject.php");
	}
?>
<?php
	//$DealerId= mysql_prep($_GET['DealerId']);
	$EmailId= mysql_prep($_GET['EmailId']);
	$MobileNum= mysql_prep($_GET['MobileNum']);
	$LandlineNum= mysql_prep($_GET['LandlineNum']);
	$FirstName= mysql_prep($_GET['FirstName']);
	$LastName= mysql_prep($_GET['LastName']);
	$Gender= mysql_prep($_GET['Gender']);
	$Age= mysql_prep($_GET['Age']);
	$StreetAddr= mysql_prep($_GET['StreetAddr']);
	$Landmark= mysql_prep($_GET['Landmark']);
	$City= mysql_prep($_GET['City']);
	$State= mysql_prep($_GET['State']);
	$Pincode= mysql_prep($_GET['Pincode']);
	$LocationId= mysql_prep($_GET['LocationId']);
	$AccountType= 'abc';
	$GPSCordinates= mysql_prep($_GET['GPSCordinates']);
	$ContractType= mysql_prep($_GET['ContractType']);
	$UpdatedBy= 1234;
	$LastUpdatedDate= date("Y-m-d H:i:s");
	$LastUpdatedTime= time();
	$Rating= mysql_prep($_GET['Rating']);
	$Note= mysql_prep($_GET['Note']);
	
?>
<?php
	$query = "INSERT INTO dealer (
				EmailId, MobileNum, LandlineNum, FirstName, LastName, Gender, Age, StreetAddr, Landmark, City, State, Pincode, LocationId, AccountType, GPSCordinates, ContractType, UpdatedBy, LastUpdatedDate, LastUpdatedTime, Rating, Note
			) VALUES (
				'{$EmailId}',{$MobileNum},{$LandlineNum},'{$FirstName}','{$LastName}','{$Gender}',{$Age},'{$StreetAddr}','{$Landmark}','{$City}','{$State}',{$Pincode},{$LocationId},'{$AccountType}','{$GPSCordinates}','{$ContractType}',{$UpdatedBy},'{$LastUpdatedDate}','{$LastUpdatedTime}',{$Rating},'{$Note}'
			)";
			
	echo "<p>" . $query . "</p>";
	$result = mysql_query($query, $connection);
	if ($result) {
		// Success!
		echo "<p>Dealer creation success.</p>";
		//redirect_to("content.php");
	} else {
		// Display error message.
		echo "<p>Dealer creation failed.</p>";
		echo "<p>" . mysql_error() . "</p>";
	}
?>

<?php mysql_close($connection); ?>