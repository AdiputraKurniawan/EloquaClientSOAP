<?php
# Sample Client
include ('../EloquaSOAPClient.php');
echo    '<link rel="stylesheet" href="../bootstrap.css" type="text/css">';
echo    '<link rel="stylesheet" href="../style.css" type="text/css">';
echo    '<div class="container">';
echo    '<div align="Center">
		<table class="bordered-table">
		<tr>
		<td><h3>Service Name : </h3></td> <td><h3> DescribeAssetType </h3></td>
		</tr>
		<tr>
		<td><h3>Service Description : </h3></td><td></td>
		</tr>
		<tr>
		<td><h3>PHP Client Code Snippet : <h3></td><td> 
		<b><br>$client = new EloquaSoapClient($wsdl, $userName, $password,$endPointURL); </br>
		<br>$param = new DescribeAssetType(type); 
		<br>$describeAssetTypeResponse = $client->DescribeAssetType($param);</br>
		</b>
		</td>
		</tr>
		</table>
		</div>';

session_start(); 
if(isSet($_SESSION['userName']) && isset($_SESSION['password']) && isset($_SESSION['endPointURL']))
{
	if(isSet($_GET['type']))
	{
	try
	{
	chdir('../');
	$wsdl = getcwd().'/wsdl/EloquaServiceV1.2.wsdl';
	# Client Credentials
	$userName= $_SESSION['userName'];
	$password = $_SESSION['password'];
	$endPointURL = $_SESSION['endPointURL'];
	
	# Instantiate a new instance of the Soap client
	$client = new EloquaSoapClient($wsdl, $userName, $password,$endPointURL);
	$type = $_GET["type"];
	$globalAssetType = $type;
	$param = new DescribeAssetType($globalAssetType);
	echo '<ul class="breadcrumb"> <li><a href="ListAssetTypesClient.php">List Asset Type</a> <span class="divider">/</span></li><li class="active">'.$type.'</li>';
	echo '<br>';
	echo '<br>';
	
	# Invoke SOAP Request : DescribeEntityType()
	$describeAssetTypeResponse = $client->DescribeAssetType($param);
	if($describeAssetTypeResponse !=null)
	{
		$describeAssetTypesResult = $describeAssetTypeResponse->DescribeAssetTypeResult;
		$assetTypes = $describeAssetTypesResult->AssetTypes;
		echo '<table class="bordered-table">';
		echo '<tr> <td>Counter</td><td>ID</td><td>Name</td></tr>';
			foreach ($assetTypes as $key => $assetType)
			{
				foreach ($assetType as $key =>$value)
				{
				echo '<tr>';
				echo '<td>'.($key+1).'</td>';
				echo '<td>'.$value->ID.'</td>';
				echo '<td><ul class="pills"><a href ="DescribeAssetClient.php?assetType='.$type.'&asset='.$value->Name.'">'.$value->Name.'</a></td>';
				echo '</tr>';	
				}
			}
		echo '</table>';
		echo '<br>';
		echo '<br>';
		echo '<br>';
		echo '<form action="../index.php" method="GET"><div><button class="btn success"  type="submit" value="e">Back</button></div></form>';
		echo '</div>';
		echo '</div>';
	}
	}
	catch (Exception $e)
	{
	echo '<table><tr><td>Error Occured</td><td>Error Message : '.$e->getMessage().'</td></tr></table>';
	echo '<form action="../index.php" method="GET"><div><button class="btn danger"  type="submit" value="Go to Example Page">Back</button></div></form>';
	}
	}
	else
	{
				echo '<form action="DescribeAssetTypeClient.php">';
				echo '<table class="bordered-table">';
				echo '<tr><td>Type : </td>
				<td><input type ="Text" name="type"></input>e.g. ContactGroup</td>
				</tr>
				</table>
				<div><button class="btn warning"  type="submit" value="e">Describe</button></div>
				</form>';
				echo '<br>';
				echo '<form action="../index.php" method="GET"><div><button class="btn success"  type="submit">Back</button></div></form>';
	}
}
else
{
echo '<h2>Login Credentials not available. Please Press the Back Button to set login Credentials.<h2>'; 
echo '<form action="../index.php" method="GET"><div><button class="btn danger"  type="submit" value="Go to Example Page">Back</button></div></form>';
}
?>