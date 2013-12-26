<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/PageFunctions.php"); ?>
<?php find_selected_page(); ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($sel_subject, $sel_page); ?>
			<br />
			<a href="new_subject.php">+ Add a new subject</a>
		</td>
		<td id="page">
		<?php if (!is_null($sel_subject)) { // subject selected ?>
			<h2><?php echo $sel_subject['menu_name']; ?></h2>
		<?php } elseif (!is_null($sel_page)) { // page selected ?>
			<h2><?php echo $sel_page['menu_name']; ?></h2>
			<div class="page-content">
				<?php if($sel_page['menu_name'] == DASHBOARD)
				{
					$srchPh = 0;
					dashboardDetailsPage(URL_DEFAULT_TAG, $srchPh);
				}
				elseif($sel_page['menu_name'] == ORDER_DETAIL)
				{
					$srchPh = NULL;
					$OrdId	 = NULL;
					if (isset($_GET['OrdId']) && is_numeric($_GET['OrdId'])) {
						$OrdId = $_GET['OrdId'];
						orderDetailsPage("OrdId", $OrdId);	//TBC
					}
					else if (isset($_GET[URL_PHN_NUM_TAG]) && is_numeric($_GET['PhnNum']))
					{
						$srchPh = $_GET['PhnNum'];
						orderDetailsPage("PhnNum", $srchPh);	//TBC
					}
					else
					{
						orderDetailsPage(NULL,$srchPh);
					}
					//
				}
				elseif($sel_page['menu_name'] == CUST_DETAIL)
				{
					$srchPh = NULL;
					$OrdId	 = NULL;
					if (isset($_GET['OrdId']) && is_numeric($_GET['OrdId'])) {
						$OrdId = $_GET['OrdId'];
						custDetailsPage("OrdId", $OrdId);	//TBC
					}
					else if (isset($_GET[URL_PHN_NUM_TAG]) && is_numeric($_GET['PhnNum']))
					{
						$srchPh = $_GET['PhnNum'];
						custDetailsPage("PhnNum", $srchPh);	//TBC
					}
					else
					{
						custDetailsPage(NULL,$srchPh);
					}
				}
				elseif($sel_page['menu_name'] == DLR_DETAIL)
				{
					$srchPh = NULL;
					$OrdId	 = NULL;
					if (isset($_GET['OrdId']) && is_numeric($_GET['OrdId'])) {
						$OrdId = $_GET['OrdId'];
						dealerDetailsPage("OrdId", $OrdId);	//TBC
					}
					else if (isset($_GET[URL_PHN_NUM_TAG]) && is_numeric($_GET['PhnNum']))
					{
						$srchPh = $_GET['PhnNum'];
						dealerDetailsPage("PhnNum", $srchPh);	//TBC
					}
					else
					{
						dealerDetailsPage(NULL,$srchPh);
					}
				}
				elseif($sel_page['menu_name'] == NEW_ORDER)
				{
					createNewOrder();
				}
				elseif($sel_page['menu_name'] == PAGE_SMS)
				{
					createSMS();
				}
				elseif($sel_page['menu_name'] == PAGE_ADD_CC_USER)
				{
				}
				elseif($sel_page['menu_name'] == PAGE_ADD_DEALER)
				{
					//redirect_to("create_dealer.php");
					addDealer();
				}
				elseif($sel_page['menu_name'] == PAGE_NEW_CUSTOMER)
				{
					//redirect_to("create_dealer.php");
					addCustomer();
				}
				?>
			</div>
			<br />

		<?php } ?>
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>
