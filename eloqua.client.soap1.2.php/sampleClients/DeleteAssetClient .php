<?php
include ('../EloquaSOAPClient.php');

	echo '<link rel="stylesheet" href="../bootstrap.css" type="text/css">';
	echo '<link rel="stylesheet" href="../style.css" type="text/css">';
	echo '<div class="container">';
	echo  ' <div align="Center">
		    <table class="bordered-table">
		    <tr>
		    <td><h3>Service Name : </h3></td> <td><h3> DeleteAsset </h3></td>
		    </tr>
		    <tr>
		    <td><h3>Service Description : </h3></td><td><h3>Sample is delete an Asset using the DeleteAsset Service Call.<h3></td>
		    </tr>
		    <tr>
		    <td><h3>PHP Client Code Snippet : <h3></td><td> 
			<b><br>$client = new EloquaSoapClient($wsdl, $userName, $password,$endPointURL); </br>
			<br>$assetType = new AssetType(0, \'ContactList\', \'ContactGroup\');</br>
			<br>$assetFields = new AssetFields(\'name\',$assetName);</br>
			<br>$dynamicAssetFields = new DynamicAssetFields($entityFields);</br>
			<br>$asset = new DynamicAsset($AssetType,$dynamicAssetFields,$id);</br>
			<br>$param = new UpdateAsset(array($asset));</br></b>
			</td>
			</tr>
			</table>
			</div>';
	session_start();
	if(isSet($_SESSION['userName']) && isset($_SESSION['password']) && isset($_SESSION['endPointURL']))
	{
		if(isSet($_GET['assetType']) &&  isSet($_GET['assetTypeName']) && isSet($_GET['id']))
		{
			try
			{
				chdir('../');
				$wsdl = getcwd().'/wsdl/EloquaServiceV1.2.wsdl';
				# Fetching Client Credentials from Request
				$userName= $_SESSION['userName'];
				$password = $_SESSION['password'];
				$endPointURL = $_SESSION['endPointURL'];
				# Instantiate a new instance of the Soap client
				$client = new EloquaSoapClient($wsdl, $userName, $password,$endPointURL);
				
				#Create Request Object for Creating Entity
				$assetTypeName = $_GET['assetTypeName'];
				$assetType = $_GET['assetType'];
				$id = $_GET['id'];
				$assetType = new AssetType(0, $assetTypeName, $assetType);
				$param = new DeleteAsset(array($assetType),array($id));

				# Invoke SOAP Request : UpdateAsset ()
				$response = $client->DeleteAsset($param);
				
				print_r($response);
				echo '<br>';
				echo '<form action="../index.php" method="GET"><div><button class="btn danger"  type="submit" value="Go to Example Page">Back</button></div></form>';
			}
			catch (Exception $e)
			{
				echo '<table><tr><td>Error Occured</td><td>Error Message : '.$e->getMessage().'</td></tr></table>';
				echo '<form action="../index.php" method="GET"><div><button class="btn danger"  type="submit" value="Go to Example Page">Back</button></div></form>';
			}
		}
		else
		{
		echo 	'<form action="DeleteAssetClient.php">';
		echo 	'<table class="bordered-table">';
		echo 	'<tr><td>Asset Type :</td>
				<td><input type ="Text" name="assetType"></input> e.g. ContactGroup</td></tr>
				<tr><td>Asset Type Name : </td><td> <input type ="Text" name="assetTypeName"></input>e.g. ContactList</td></tr>
				<tr><td>Asset ID : </td><td> <input type ="Text" name="id"></input></td></tr>
				</tr></table> 
				<div><button class="btn warning"  type="submit" value="e">Delete</button></div>
				</form>';
		echo 	'<form action="../index.php" method="GET"><div><button class="btn success"  type="submit">Back</button></div></form>';
		}	
	}	
	else
	{
	echo '<form action="../index.php" method="GET"><div><button class="btn danger"  type="submit" value="Go to Example Page">Back</button></div></form>';
	}
?>