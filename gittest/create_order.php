<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	echo "<p>Inside create customer</p>";
	$errors = array();
	
	// Form Validation
	//$required_fields = array('CustomerId',
	//			'MobileNum',
	//			'FirstName',
	//			'Age',
	//			'StreetAddr',
	//			'Landmark',
	//			'City',
	//			'State',
	//			'Pincode',
	//			);
	//foreach($required_fields as $fieldname) {
	//	if (!isset($_GET[$fieldname]) || (empty($_GET[$fieldname]) && $_GET[$fieldname] != 0)) {
	//		$errors[] = $fieldname;
	//	}
	//}
	
	$fields_with_lengths = array(
				//'DealerId' =>11,
				//'StatusInt' =>11,
				//'AgentId' =>11,
				//'FieldAgentId' =>11,
				'ScrapId' =>11,
				'ScrapDescription' =>64,
				//'CustWeight' =>11,
				//'DealerWeight' =>11,
				//'CustAmount' =>11,
				//'DealerAmount' =>11,
				'AgentCustNote' =>128,
				//'AgentDlrNote' =>128,
				//'CustFeedbackNote' =>128,
				//'RatingDealer' =>11);
				);
	foreach($fields_with_lengths as $fieldname => $maxlength ) {
		if (strlen(trim(mysql_prep($_GET[$fieldname]))) > $maxlength) { $errors[] = $fieldname; }
	}
	
	if (!empty($errors)) {
		var_dump($errors);
		//redirect_to("new_subject.php");
	}
?>
<?php
	$CustPhoneNumber	= $_GET['CustPhoneNumber'];
	$CustRecord 	= getCustomerByPhoneNum($CustPhoneNumber);
	$CustomerId	= mysql_prep($CustRecord['CustomerId']);
	
	if(!$CustomerId)
	{
		echo "<p>Customer was not found, first create customer.</p>";
		return;
	}
	
	echo "<br><p>".$CustomerId."</p>";
	
	$OrderId	= NULL;
	$OrderDate	= date("Y-m-d H:i:s");
	$OrderTime	= time();
	//$PrefferedDate	= mysql_prep($_GET['PrefferedDate']);
	//$PrefferedTime	= mysql_prep($_GET['PrefferedTime']);
	$PrefferedDate	= date("Y-m-d H:i:s");
	$PrefferedTime	= time();
	
	//$CustomerId	= mysql_prep($_GET['CustomerId']);
	//$DealerId	= mysql_prep($_GET['DealerId']);
	$DealerId	= 1;
	$StatusInt	= STATUS_START;
	$AgentId	= NULL;
	$FieldAgentId	= NULL;
	$ScrapId	= mysql_prep($_GET['ScrapId']);
	$ScrapDescription	= mysql_prep($_GET['ScrapDescription']);
	$CustWeight	= NULL;
	$DealerWeight	= NULL;
	$CustAmount	= NULL;
	$DealerAmount	= NULL;
	$AgentCustNote	= mysql_prep($_GET['AgentCustNote']);
	$AgentDlrNote	= NULL;
	$CustFeedbackNote	= NULL;
	$RatingDealer	= NULL;
	$OrderSourceStr	= 'CC';
	$UpdatedBy	= 1234;
	$LastUpdatedDate	= date("Y-m-d H:i:s");
	$LastUpdatedTime	= time();
	$Note	= mysql_prep($_GET['Note']);
	
?>
<?php
	$query = "INSERT INTO  `order` (`OrderId` ,
					`OrderDate` ,
					`OrderTime` ,
					`PrefferedDate` ,
					`PrefferedTime` ,
					`CustomerId` ,
					`DealerId` ,
					`StatusInt` ,
					`AgentId` ,
					`FieldAgentId` ,
					`ScrapId` ,
					`ScrapDescription` ,
					`CustWeight` ,
					`DealerWeight` ,
					`CustAmount` ,
					`DealerAmount` ,
					`AgentCustNote` ,
					`AgentDlrNote` ,
					`CustFeedbackNote` ,
					`RatingDealer` ,
					`OrderSourceStr` ,
					`UpdatedBy` ,
					`LastUpdatedDate` ,
					`LastUpdatedTime` ,
					`Note`
					)
					VALUES (
					'{$OrderId}' ,'{$OrderDate}' ,'{$OrderTime}' ,'{$PrefferedDate}' ,'{$PrefferedTime}' ,'{$CustomerId}' ,'{$DealerId}' ,'{$StatusInt}' ,'{$AgentId}' ,'{$FieldAgentId}' ,'{$ScrapId}' ,'{$ScrapDescription}' ,'{$CustWeight}' ,'{$DealerWeight}' ,'{$CustAmount}' ,'{$DealerAmount}' ,'{$AgentCustNote}' ,'{$AgentDlrNote}' ,'{$CustFeedbackNote}' ,'{$RatingDealer}' ,'{$OrderSourceStr}' ,'{$UpdatedBy}' ,'{$LastUpdatedDate}' ,'{$LastUpdatedTime}' ,'{$Note}'
					)"	;
	//echo "<p>" . $query . "</p>";
	$result = mysql_query($query, $connection);
	if ($result) {
		// Success!
		echo "<p>Order creation success.</p>";
		//redirect_to("content.php");
	} else {
		// Display error message.
		echo "<p>Order creation failed.</p>";
		echo "<p>" . mysql_error() . "</p>";
	}
?>

<?php mysql_close($connection); ?>