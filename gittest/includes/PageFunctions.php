<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php
	function showSearchResult($SearchId)
	{
		if((!is_null($SearchId)) && $SearchId !=0)
		{
			$order 		= getOrderByPhoneNum($SearchId);
			$customer	= getCustomerByPhoneNum($SearchId);
			$searchResultOut = "<div id=\"showSearchResult\">";
			$searchResultOut .= "<p>";
			$searchResultOut .= "OrderId :[".$order['OrderId']."]";
			$searchResultOut .= "&nbsp Full Name :[".$customer['FirstName']." ".$customer['LastName']."]";
			$searchResultOut .= "</p></div>";
			echo $searchResultOut;
		}
		else
		{//this is a default portion to show the first latest order details
			$order 		= getFirstOrder();
			$customer	= get_customer_by_id($order['CustomerId']);
			$searchResultOut = "<div id=\"showSearchResult\">";
			$searchResultOut .= "<p>";
			$searchResultOut .= "OrderId :[".$order['OrderId']."]";
			$searchResultOut .= "&nbsp OrderDate :[".$order['OrderDate']."]";
			$searchResultOut .= "&nbsp OrderTime :[".$order['OrderTime']."]";
			$searchResultOut .= "</br>";
			$searchResultOut .= "CustomeId :[".$customer['CustomerId']."]";
			$searchResultOut .= "&nbsp Full Name :[".$customer['FirstName']." ".$customer['LastName']."]";
			$searchResultOut .= "&nbsp Mobile :[".$customer['MobileNum']."]";
			$searchResultOut .= "</br>";
			$searchResultOut .= "DealerId :[".$customer['CustomerId']."]";
			$searchResultOut .= "&nbsp Dealer Name :[".$customer['FirstName']." ".$customer['LastName']."]";
			$searchResultOut .= "&nbsp Mobile :[".$customer['MobileNum']."]";
			$searchResultOut .= "</p></div>";
			echo $searchResultOut;
		}
	}
	function createSearchForm($SearchBy, $SearchId)
	{	
		$searchFormOut = "<div id=\"SearchForm\">";
		$searchFormOut .= "<p>";
		$searchFormOut .= "<form action=\"content.php\" method=\"get\">";
		//if($SearchBy == URL_PHN_NUM_TAG)
		//{	$searchFormOut .= "Order<input type=\"radio\" name=\"page\" value=\"7\" checked>";	}//order	contants-TBC
		//else
		//{	$searchFormOut .= "Order<input type=\"radio\" name=\"page\" value=\"7\">";	}//order	contants-TBC
		//
		//if($SearchBy == URL_PHN_NUM_TAG)
		//{	$searchFormOut .= "&nbsp Customer<input type=\"radio\" name=\"page\" value=\"2\" checked>";}//customer	contants-TBC
		//else
		//{	$searchFormOut .= "&nbsp Customer<input type=\"radio\" name=\"page\" value=\"2\">";}
		//
		//if($SearchBy == URL_PHN_NUM_TAG)
		//{	$searchFormOut .= "&nbsp Dealer<input type=\"radio\" name=\"page\" value=\"3\" checked><br>";}//dealer	contants-TBC
		//else
		//{	$searchFormOut .= "&nbsp Dealer<input type=\"radio\" name=\"page\" value=\"3\"><br>";}//dealer	contants-TBC
		//
		
		$searchFormOut .= "Search: &nbsp &nbsp &nbsp Order<input type=\"radio\" name=\"page\" value=\"7\" checked>";	//order	contants-TBC
		$searchFormOut .= "&nbsp Customer<input type=\"radio\" name=\"page\" value=\"2\">";
		$searchFormOut .= "&nbsp Dealer<input type=\"radio\" name=\"page\" value=\"3\"><br>";	//dealer	contants-TBC
		$searchFormOut .= "Order Number: <input type =\"text\" name=\"OrdId\" >";
		if(is_null($SearchId) || ($SearchId == 0)) 
		{
			$searchFormOut .= "&nbsp Phone: <input type =\"text\" name=\"PhnNum\" >"; 
		}
		else 
		{	
			$searchFormOut .= "&nbsp Phone: <input type =\"text\" value=".$SearchId." name=\"PhnNum\" >";
		}
		
		$searchFormOut .= "<input type=\"submit\" value=\"Search\" />";
		$searchFormOut .= "</form>";
		
		$searchFormOut .= "</p></div>";
		
		echo $searchFormOut;
	}
	
	function createOrderBlotter()
	{
		$firstTenOrder_set = get_first_ten_orders();
		
		$orderBlotterOut = "<div id=\"OrderBlotter\">";
		$orderBlotterOut .= "<p>";
		$orderBlotterOut .= "<table border=\"1\">";
		$orderBlotterOut .= "<caption>Order Blotter</caption>";
		$orderBlotterOut .= "<tr>";
		$orderBlotterOut .= 	"<th>Date</th>";
		$orderBlotterOut .= 	"<th>Time</th>";
		$orderBlotterOut .= 	"<th>OrderId</th>";
		$orderBlotterOut .= 	"<th>CustomerId</th>";
		$orderBlotterOut .= 	"<th>DealerId</th>";
		$orderBlotterOut .= "</tr>";
		
		while ($order = mysql_fetch_array($firstTenOrder_set))
		{
			 $orderBlotterOut .= "<tr>";
			 $orderBlotterOut .= 	"<td>{$order['OrderDate']}</td>";
			 $orderBlotterOut .= 	"<td>{$order['OrderTime']}</td>";
			 $orderBlotterOut .= 	"<td>{$order['OrderId']}</td>";
			 $orderBlotterOut .= 	"<td>{$order['CustomerId']}</td>";
			 $orderBlotterOut .= 	"<td>{$order['DealerId']}</td>";
			 $orderBlotterOut .= "</tr>";
		}
		$orderBlotterOut .= "</table>";
		$orderBlotterOut .= "<br/>";
		$orderBlotterOut .= "<a href=\"content.php?page=1&offset=0\">previous</a>&nbsp&nbsp&nbsp<a href=\"content.php?page=1&offset=2\">next</a>";
		
		$orderBlotterOut .= "</p></div>";
		
		echo $orderBlotterOut;

	}
	
	function showorderDetails($SearchBy, $SearchId)
	{
		if($SearchBy == "PhnNum")
		{
			$order = getOrderByPhoneNum($SearchId);
			if(!is_null($order))
				$cust  = get_customer_by_id($order['CustomerId']);
		}
		elseif($SearchBy == "OrdId")
		{
			$order = get_order_by_id($SearchId);
		}
	
		if(!is_null($order))
		{
			$cust  = get_customer_by_id($order['CustomerId']);
			$orderDetail = "<div id=\"OrderBlotter\">";
			$orderDetail .= "<p>";
			$orderDetail .= "<table border=\"1\">";
			$orderDetail .= "<caption>Order Details</caption>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<th>Detail</th>";
			$orderDetail .= 	"<th>Value</th>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>OrderId</td>";
			$orderDetail .= 	"<td>{$order['OrderId']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>CustomerId</td>";
			$orderDetail .= 	"<td>{$order['CustomerId']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>DealerId</td>";
			$orderDetail .= 	"<td>{$order['DealerId']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>OrderSourceStr</td>";
			$orderDetail .= 	"<td>{$order['OrderSourceStr']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>Order Date</td>";
			$orderDetail .= 	"<td>{$order['Date']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>Order Time</td>";
			$orderDetail .= 	"<td>{$order['Time']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>ScrapDescription</td>";
			$orderDetail .= 	"<td>{$order['ScrapDescription']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>CustWeight</td>";
			$orderDetail .= 	"<td>{$order['CustWeight']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>DealerWeight</td>";
			$orderDetail .= 	"<td>{$order['DealerWeight']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>CustAmount</td>";
			$orderDetail .= 	"<td>{$order['CustAmount']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>DealerAmount</td>";
			$orderDetail .= 	"<td>{$order['DealerAmount']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>AgentCustNote</td>";
			$orderDetail .= 	"<td>{$order['AgentCustNote']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>AgentDlrNote</td>";
			$orderDetail .= 	"<td>{$order['AgentDlrNote']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "<tr>";
			$orderDetail .= 	"<td>CustFeedbackNote</td>";
			$orderDetail .= 	"<td>{$order['CustFeedbackNote']}</td>";
			$orderDetail .= "</tr>";
			$orderDetail .= "</table>";
			$orderDetail .= "</p></div>";
			echo $orderDetail;
		}
		else
		{
			echo "<p>Could not search order. Please modify your search criteria</p>";
			//createSearchForm($SearchBy, $SearchId);
		}
	}
	
	function showDealerDetails($SearchBy, $SearchId)
	{
		if($SearchBy == "PhnNum")
		{
			$dealer = getDealerByPhoneNum($SearchId);
			//if(!is_null($order))
			//	$cust  = get_customer_by_id($order['CustomerId']);
		}
		elseif($SearchBy == "OrdId")
		{
			$dealer = getDealerByOrderId($SearchId);
		}
	
		if(!is_null($dealer))
		{
			$dealerDetail = "<div id=\"OrderBlotter\">";
			$dealerDetail .= "<p>";
			$dealerDetail .= "<table border=\"1\">";
			$dealerDetail .= "<caption>Order Details</caption>";
			$dealerDetail .= "<tr><th>Detail</th><th>Value</th></tr>";
			$dealerDetail .= "<tr><td>DealerId</td><td>{$dealer['DealerId']}</td></tr>";
			$dealerDetail .= "<tr><td>EmailId</td><td>{$dealer['EmailId']}</td></tr>";
			$dealerDetail .= "<tr><td>MobileNum</td><td>{$dealer['MobileNum']}</td></tr>";
			$dealerDetail .= "<tr><td>LandlineNum</td><td>{$dealer['LandlineNum']}</td></tr>";
			$dealerDetail .= "<tr><td>FirstName</td><td>{$dealer['FirstName']}</td></tr>";
			$dealerDetail .= "<tr><td>LastName</td><td>{$dealer['LastName']}</td></tr>";
			$dealerDetail .= "<tr><td>Gender</td><td>{$dealer['Gender']}</td></tr>";
			$dealerDetail .= "<tr><td>Age</td><td>{$dealer['Age']}</td></tr>";
			$dealerDetail .= "<tr><td>StreetAddr</td><td>{$dealer['StreetAddr']}</td></tr>";
			$dealerDetail .= "<tr><td>Landmark</td><td>{$dealer['Landmark']}</td></tr>";
			$dealerDetail .= "<tr><td>City</td><td>{$dealer['City']}</td></tr>";
			$dealerDetail .= "<tr><td>State</td><td>{$dealer['State']}</td></tr>";
			$dealerDetail .= "<tr><td>Pincode</td><td>{$dealer['Pincode']}</td></tr>";
			$dealerDetail .= "<tr><td>LocationId</td><td>{$dealer['LocationId']}</td></tr>";
			$dealerDetail .= "<tr><td>AccountType</td><td>{$dealer['AccountType']}</td></tr>";
			$dealerDetail .= "<tr><td>GPSCordinates</td><td>{$dealer['GPSCordinates']}</td></tr>";
			$dealerDetail .= "<tr><td>ContractType</td><td>{$dealer['ContractType']}</td></tr>";
			$dealerDetail .= "<tr><td>UpdatedBy</td><td>{$dealer['UpdatedBy']}</td></tr>";
			$dealerDetail .= "<tr><td>LastUpdatedDate</td><td>{$dealer['LastUpdatedDate']}</td></tr>";
			$dealerDetail .= "<tr><td>LastUpdatedTime</td><td>{$dealer['LastUpdatedTime']}</td></tr>";
			$dealerDetail .= "<tr><td>Rating</td><td>{$dealer['Rating']}</td></tr>";
			$dealerDetail .= "<tr><td>Note</td><td>{$dealer['Note']}</td></tr>";
			$dealerDetail .= "</table>";
			$dealerDetail .= "</p></div>";
			echo $dealerDetail;
		}
		else
		{
			echo "<p>Could not search Dealer. Please modify your search criteria</p>";
			//createSearchForm($SearchBy, $SearchId);
		}
	}
	
	function showCustDetails($SearchBy, $SearchId)
	{
		if($SearchBy == "PhnNum")
		{
			$customer = getCustomerByPhoneNum($SearchId);
			//if(!is_null($cust))
			//	$cust  = get_customer_by_id($cust['CustomerId']);
		}
		elseif($SearchBy == "OrdId")
		{
			$customer = getCustomerByOrderId($SearchId);
		}
	
		if(!is_null($customer))
		{
			$customerDetail = "<div id=\"OrderBlotter\">";
			$customerDetail .= "<p>";
			$customerDetail .= "<table border=\"1\">";
			$customerDetail .= "<caption>Customer Details</caption>";
			$customerDetail .= "<tr><th>Detail</th><th>Value</th></tr>";
			$customerDetail .= "<tr><td>CustomerId</td><td>{$customer['CustomerId']}</td></tr>";
			$customerDetail .= "<tr><td>EmailId</td><td>{$customer['EmailId']}</td></tr>";
			$customerDetail .= "<tr><td>MobileNum</td><td>{$customer['MobileNum']}</td></tr>";
			$customerDetail .= "<tr><td>LandlineNum</td><td>{$customer['LandlineNum']}</td></tr>";
			$customerDetail .= "<tr><td>FirstName</td><td>{$customer['FirstName']}</td></tr>";
			$customerDetail .= "<tr><td>LastName</td><td>{$customer['LastName']}</td></tr>";
			$customerDetail .= "<tr><td>Gender</td><td>{$customer['Gender']}</td></tr>";
			$customerDetail .= "<tr><td>Age</td><td>{$customer['Age']}</td></tr>";
			$customerDetail .= "<tr><td>StreetAddr</td><td>{$customer['StreetAddr']}</td></tr>";
			$customerDetail .= "<tr><td>Landmark</td><td>{$customer['Landmark']}</td></tr>";
			$customerDetail .= "<tr><td>City</td><td>{$customer['City']}</td></tr>";
			$customerDetail .= "<tr><td>State</td><td>{$customer['State']}</td></tr>";
			$customerDetail .= "<tr><td>Pincode</td><td>{$customer['Pincode']}</td></tr>";
			$customerDetail .= "<tr><td>LocationId</td><td>{$customer['LocationId']}</td></tr>";
			$customerDetail .= "<tr><td>UpdateSource</td><td>{$customer['UpdateSource']}</td></tr>";
			$customerDetail .= "<tr><td>UpdatedBy</td><td>{$customer['UpdatedBy']}</td></tr>";
			$customerDetail .= "<tr><td>LastUpdatedDate</td><td>{$customer['LastUpdatedDate']}</td></tr>";
			$customerDetail .= "<tr><td>LastUpdatedTime</td><td>{$customer['LastUpdatedTime']}</td></tr>";
			$customerDetail .= "<tr><td>Note</td><td>{$customer['Note']}</td></tr>";
			echo $customerDetail;
		}
		else
		{
			echo "<p>Could not search Customer. Please modify your search criteria</p>";
			//createSearchForm($SearchBy, $SearchId);
		}
	}
	
	function dashboardDetailsPage($SearchBy, $SearchId)
	{
		showSearchResult($SearchId);
		createSearchForm($SearchBy, $SearchId);
		createOrderBlotter();
	}
	
	function orderDetailsPage($SearchBy, $SearchId)
	{
		createSearchForm($SearchBy, $SearchId);
		if(!is_null($SearchId))
		{
			showorderDetails($SearchBy, $SearchId);				
		}
	}
	
	function custDetailsPage($SearchBy, $SearchId)
	{
		createSearchForm($SearchBy, $SearchId);
		if(!is_null($SearchId))
		{
			showCustDetails($SearchBy, $SearchId);				
		}
	}
	
	function dealerDetailsPage($SearchBy, $SearchId)
	{
		createSearchForm($SearchBy, $SearchId);
		if(!is_null($SearchId))
		{
			showDealerDetails($SearchBy, $SearchId);				
		}
	}
	
	function createNewOrder()
	{
		$ordFormOut = "<div id=\"addDealer\">";
		$ordFormOut .= "<p>";
		$ordFormOut .= "<form action=\"create_order.php\" method=\"get\">";
		//$ordFormOut .= "OrderDate: <input type=\"text\" name=\"OrderDate\"><br>";
		//$ordFormOut .= "OrderTime: <input type=\"text\" name=\"OrderTime\"><br>";
		$ordFormOut .= "Customer Phone Number: <input type=\"text\" name=\"CustPhoneNumber\"><br>";
		$ordFormOut .= "Preffered Date: <input type=\"text\" name=\"PrefferedDate\"><br>";
		$ordFormOut .= "Preffered Time: <input type=\"text\" name=\"PrefferedTime\"><br>";
		//$ordFormOut .= "DealerId: <input type=\"text\" name=\"DealerId\"><br>";
		//$ordFormOut .= "StatusInt: <input type=\"text\" name=\"StatusInt\"><br>";
		//$ordFormOut .= "AgentId: <input type=\"text\" name=\"AgentId\"><br>";
		//$ordFormOut .= "FieldAgentId: <input type=\"text\" name=\"FieldAgentId\"><br>";
		$ordFormOut .= "ScrapId: <input type=\"text\" name=\"ScrapId\"><br>";
		//$ordFormOut .= "ScrapDescription: <input type=\"text\" name=\"ScrapDescription\"><br>";
		$ordFormOut .= "<label>ScrapDescription: <textarea name=\"ScrapDescription\" cols=\"20\" rows=\"5\"></textarea></label><br>";
		//$ordFormOut .= "CustWeight: <input type=\"text\" name=\"CustWeight\"><br>";
		//$ordFormOut .= "DealerWeight: <input type=\"text\" name=\"DealerWeight\"><br>";
		//$ordFormOut .= "CustAmount: <input type=\"text\" name=\"CustAmount\"><br>";
		//$ordFormOut .= "DealerAmount: <input type=\"text\" name=\"DealerAmount\"><br>";
		//$ordFormOut .= "AgentCustNote: <input type=\"text\" name=\"AgentCustNote\"><br>";
		$ordFormOut .= "<label>AgentCustNote: <textarea name=\"AgentCustNote\" cols=\"20\" rows=\"5\"></textarea></label><br>";

		//$ordFormOut .= "AgentDlrNote: <input type=\"text\" name=\"AgentDlrNote\"><br>";
		//$ordFormOut .= "CustFeedbackNote: <input type=\"text\" name=\"CustFeedbackNote\"><br>";
		//$ordFormOut .= "RatingDealer: <input type=\"text\" name=\"RatingDealer\"><br>";
		//$ordFormOut .= "OrderSourceStr: <input type=\"text\" name=\"OrderSourceStr\"><br>";
		//$ordFormOut .= "Updatedby: <input type=\"text\" name=\"Updatedby\"><br>";
		//$ordFormOut .= "LastUpdatedDate: <input type=\"text\" name=\"LastUpdatedDate\"><br>";
		//$ordFormOut .= "LastUpdatedTime: <input type=\"text\" name=\"LastUpdatedTime\"><br>";
		//$ordFormOut .= "Note: <input type=\"text\" name=\"Note\"><br>";
		$ordFormOut .= "<label>Note: <textarea name=\"Note\" cols=\"20\" rows=\"5\"></textarea></label><br>";
		
		$ordFormOut .= "<input type=\"submit\" value=\"Submit\" />";
		$ordFormOut .= "</form>";
		$ordFormOut .= "</p></div>";
		echo $ordFormOut;	}
	
	function addDealer()
	{
		$stateList = getStatesList();
		$dlrFormOut = "<div id=\"addDealer\">";
		$dlrFormOut .= "<p>";
		$dlrFormOut .= "<form action=\"create_dealer.php\" method=\"get\">";
		$dlrFormOut .= "Email: <input type=\"text\" name=\"EmailId\"><br>";
		$dlrFormOut .= "Mobile: <input type=\"text\" name=\"MobileNum\"><br>";
		$dlrFormOut .= "Landline: <input type=\"text\" name=\"LandlineNum\"><br>";
		$dlrFormOut .= "First name: <input type=\"text\" name=\"FirstName\"><br>";
		$dlrFormOut .= "Last name: <input type=\"text\" name=\"LastName\"><br>";
		$dlrFormOut .= "Gender: M<input type=\"radio\" name=\"Gender\" value=\"Male\" checked> F<input type=\"radio\" name=\"Gender\" value=\"Female\"><br>";
		$dlrFormOut .= "Age: <input type=\"text\" name=\"Age\"><br>";
		$dlrFormOut .= "Street Address: <input type=\"text\" name=\"StreetAddr\"><br>";
		$dlrFormOut .= "Landmark: <input type=\"text\" name=\"Landmark\"><br>";
		$dlrFormOut .= "City: <input type=\"text\" name=\"City\"><br>";
		#$dlrFormOut .= "State: <input type=\"text\" name=\"State\"><br>";
		$dlrFormOut .= "State:".$stateList."<br>";
		$dlrFormOut .= "Pincode: <input type=\"text\" name=\"Pincode\"><br>";
		$dlrFormOut .= "LocationId: <input type=\"text\" name=\"LocationId\"><br>";
		$dlrFormOut .= "GPSCordinates: <input type=\"text\" name=\"GPSCordinates\"><br>";
		$dlrFormOut .= "ContractType: <input type=\"text\" name=\"ContractType\"><br>";
		$dlrFormOut .= "Rating: <input type=\"text\" name=\"Rating\"><br>";
		//$dlrFormOut .= "Note: <input type=\"text\" name=\"Note\"><br>";
		$ordFormOut .= "<label>Note: <textarea name=\"Note\" cols=\"20\" rows=\"5\"></textarea></label><br>";
		
		$dlrFormOut .= "<input type=\"submit\" value=\"Submit\" />";
		$dlrFormOut .= "</form>";
		$dlrFormOut .= "</p></div>";
		echo $dlrFormOut;
	}
	
	function addCustomer()
	{
		$stateList = getStatesList();
		$custFormOut = "<div id=\"addCustomer\">";
		$custFormOut .= "<p>";
		$custFormOut .= "<form action=\"create_customer.php\" method=\"get\">";
		$custFormOut .= "Email: <input type=\"text\" name=\"EmailId\"><br>";
		$custFormOut .= "Mobile: <input type=\"text\" name=\"MobileNum\" size=\"10\" maxlength=\"10\"><br>";
		$custFormOut .= "Landline: <input type=\"text\" name=\"LandlineNum\" size=\"12\" maxlength=\"12\"><br>";
		$custFormOut .= "First name: <input type=\"text\" name=\"FirstName\" maxlength=\"32\"><br>";
		$custFormOut .= "Last name: <input type=\"text\" name=\"LastName\" maxlength=\"32\"><br>";
		$custFormOut .= "Gender: M<input type=\"radio\" name=\"Gender\" value=\"Male\" checked> F<input type=\"radio\" name=\"Gender\" value=\"Female\"><br>";
		$custFormOut .= "Age: <input type=\"text\" name=\"Age\" size=\"3\" maxlength=\"3\"><br>";
		$custFormOut .= "Street Address: <input type=\"text\" name=\"StreetAddr\" size=\"64\" maxlength=\"64\"><br>";
		$custFormOut .= "Landmark: <input type=\"text\" name=\"Landmark\" size=\"64\" maxlength=\"64\"><br>";
		$custFormOut .= "City: <input type=\"text\" name=\"City\" size=\"32\" maxlength=\"32\"><br>";
		#$custFormOut .= "State: <input type=\"text\" name=\"State\"><br>";
		$custFormOut .= "State:".$stateList."<br>";
		$custFormOut .= "Pincode: <input type=\"text\" name=\"Pincode\" size=\"8\" maxlength=\"8\"><br>";
		$custFormOut .= "LocationId: <input type=\"text\" name=\"LocationId\" size=\"8\" maxlength=\"8\"><br>";
		//$custFormOut .= "Note: <input type=\"text\" name=\"Note\" size=\"160\" maxlength=\"160\"><br>";
		$custFormOut .= "<label>Note: <textarea name=\"Note\" cols=\"20\" rows=\"5\"></textarea></label><br>";
		
		$custFormOut .= "<input type=\"submit\" value=\"Submit\" />";
		$custFormOut .= "</form>";
		$custFormOut .= "</p></div>";
		echo $custFormOut;
	}
	
	function createSMS()
	{
		$smsForm = "<div id=\"addCustomer\">";
		$smsForm .= "<p>";
		$smsForm .= "<form action=\"http://192.168.1.5:9090/sendsms\" method=\"get\">";
		$smsForm .= "Mobile: <input type=\"text\" name=\"phone\"><br>";
		//$smsForm .= "Message: <input type=\"text\" name=\"text\" size=\"50\" maxlength=\"160\"><br>";
		$smsForm .= "<label>Message: <textarea name=\"text\" cols=\"20\" rows=\"5\" maxlength=\"160\"></textarea></label><br>";
		
		$smsForm .= "<input type=\"submit\" value=\"Send\" />";
		$smsForm .= "</form>";
		$smsForm .= "</p></div>";
		echo $smsForm;
	}

?>