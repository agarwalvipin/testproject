<?php require_once("includes/functions.php"); ?>
<?php
	function createOrderBlotter()
	{
		$firstTenOrder_set = get_first_ten_orders();
		
		// $orderBlotterOut = "<table";
		// $orderBlotterOut .= "<caption>Order Blotter</caption>";
		// $orderBlotterOut .= "<tr>";
		// $orderBlotterOut .= 	"<th>OrderId</th>";
		// $orderBlotterOut .= 	"<th>CustomerId</th>";
		// $orderBlotterOut .= 	"<th>DealerId</th>";
		// $orderBlotterOut .= "</tr>";
		
		// $orderBlotterOut .=  "| OrderId |  CustomerId	|	DealerId	|<br/>";
		// while ($order = mysql_fetch_array($firstTenOrder_set))
		// {
			// //$orderBlotterOut .=  "|	{$order['OrderId']}	|	{$order['CustomerId']}	|	{$order['DealerId']} |<br/>";
			// $orderBlotterOut .= "<tr>";
			// $orderBlotterOut .= 	"<td>{$order['OrderId']}</td>";
			// $orderBlotterOut .= 	"<td>{$order['CustomerId']}</td>";
			// $orderBlotterOut .= 	"<td>{$order['DealerId']}</td>";
			// $orderBlotterOut .= "</tr>";
		// }
		// $orderBlotterOut = "</table>";
		
		// echo $orderBlotterOut;
		
		$orderBlotterOut = "<p class=\"OrderDetail\">";
		$orderBlotterOut .=  "| OrderId |  CustomerId	|	DealerId	|<br/>";
		while ($order = mysql_fetch_array($firstTenOrder_set))
		{
			$orderBlotterOut .=  "|	{$order['OrderId']}	|	{$order['CustomerId']}	|	{$order['DealerId']} |<br/>";
		}
		$orderBlotterOut .= "<br/>";
		$orderBlotterOut .= "<a href=\"previous.php\">previous</a>&nbsp&nbsp&nbsp<a href=\"next.php\">next</a>";
		
		$orderBlotterOut .= "</p>";					
		echo $orderBlotterOut;
	}
	
	function orderDetailsPage()
	{
		createOrderBlotter();
	}

?>