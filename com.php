<!DOCTYPE html>
<html>
<body>

<h3>COM</h3>

<?php

try 
{
	//LOGIN
	$crd = new COM("LinkarCommon.CredentialsOptions");

	// Change your own credentials: LinkarHost, EntryPoint, Port, LinkarUser, Password, Language, Free Text
	$crd -> InitializeProperties("127.0.0.1","EntryPoint1",11300,"admin","admin","","From PHP");
	$lkClt = new COM("LinkarClient.LinkarClt");
	$error = $lkClt -> Login($crd);
	
	if (strlen($error) == 0)
	{
		echo "<table border=\"0\" style=\"width: 100%;\">";
		echo "<tr>";
		echo "<td>Session Id</td>";
		echo "<td colspan=\"9\">{$lkClt->SessionId}</td>";
		echo "</tr>";
		
		//AUX OBJECTS
	
		$mvchars = new COM("LinkarCommon.DBMV_MarkCOM");
		$chars = new COM("LinkarCommon.ASCII_CharsCOM");
		$mvFunc = new COM("LinkarCommon.MvFunctions");
		
		$mvstr = "CUSTOMER 1{$mvchars->AM_str}ADDRESS 1{$mvchars->VM_str}ADDRESS 2{$mvchars->VM_str}ADDRESS 3{$mvchars->AM_str}111 - 111 - 111";
		$strNewId = "A99";
		$fileName = "LK.CUSTOMERS";
		
		$mylkdata = new COM("LinkarCommon.LkData");
		$mylkstring = "";
		
		//NEW
		
		$strNewRecord = "CUSTOMER 99{$mvchars->AM_str}ADDRESS 99{$mvchars->AM_str}999 - 999 - 99";
		
		$nop = new COM("LinkarCommon.NewOptions");
		$nrit = new COM("LinkarCommon.RecordIdType");
		$nop -> InitializeProperties($nrit, true, false, false, false, false);
		
		$mylkdata = $lkClt -> New($fileName, $strNewId, $strNewRecord, $nop);
		
		echo "<tr>";
		echo "<td>New</td>";	
		if ($mylkdata -> HasError())
		{
			echo utf8_encode("<td colspan=\"9\">ERROR: {$mylkdata -> GetFormatedError()}</td>");
		}
		else
		{			
			echo utf8_encode("<td colspan=\"3\">{$mylkdata -> recordsIds}</td>");
			echo utf8_encode("<td colspan=\"6\">{$mylkdata -> records}</td>");
		}
		echo "</tr>";
		
		$strRecord = $mylkdata -> records;
		
		//LKEXTRACT		
		
		$mvresult = $mvFunc -> LkExtract($strRecord, 1);
		
		echo "<tr>";
		echo "<td>LkExtract</td>";
		echo "<td colspan=\"3\"></td>";
		echo utf8_encode("<td colspan=\"6\">{$mvresult}</td>");
		echo "</tr>";
			
		//LKREPLACE
		
		$replaceVal = "UPDATED CUSTOMER";
		$mvresult = $mvFunc -> LkReplace($strRecord, $replaceVal, 1);
		
		echo "<tr>";
		echo "<td>LkReplace</td>";
		echo "<td colspan=\"3\"></td>";
		echo utf8_encode("<td colspan=\"6\">{$mvresult}</td>");
		echo "</tr>";
		
		//LKCHANGE

		$strRecord = $mvFunc -> LkChange($strRecord, "9", "8");
		
		echo "<tr>";
		echo "<td>LkChange</td>";
		echo "<td colspan=\"3\"></td>";
		echo utf8_encode("<td colspan=\"6\">{$strRecord}</td>");
		echo "</tr>";
			
		//LKCOUNT

		$mvresult = $mvFunc -> LkCount($strRecord, $mvchars->AM_str);
		
		echo "<tr>";
		echo "<td>LkCount</td>";
		echo "<td colspan=\"3\"></td>";
		echo utf8_encode("<td colspan=\"6\">{$mvresult}</td>");
		echo "</tr>";
			
		//LKDCOUNT

		$mvresult = $mvFunc -> LkDCount($strRecord, $mvchars->AM_str);
		
		echo "<tr>";
		echo "<td>LkDCount</td>";
		echo "<td colspan=\"3\"></td>";
		echo utf8_encode("<td colspan=\"6\">{$mvresult}</td>");
		echo "</tr>";
		
		//UPDATE
	
		$uop = new COM("LinkarCommon.UpdateOptions");
		$uop -> InitializeProperties(false, true, false, false, false, false);
		
		$mylkdata= $lkClt -> Update($fileName, $strNewId, $strRecord, $uop);
		
		echo "<tr>";
		echo "<td>Update</td>";	
		if ($mylkdata -> HasError())
		{
			echo utf8_encode("<td colspan=\"9\">{$mylkdata -> GetFormatedError()}</td>");
		}
		else
		{			
			echo utf8_encode("<td colspan=\"3\">{$mylkdata -> recordsIds}</td>");
			echo utf8_encode("<td colspan=\"6\">{$mylkdata -> records}</td>");
		}	
		echo "</tr>";		
		
		//READ
		
		$rop = new COM("LinkarCommon.ReadOptions");
		$rop -> InitializeProperties(false, false, false, false);			
		
		$mylkdata = $lkClt -> Read($fileName, $strNewId, "ADDR", $rop);
		
		echo "<tr>";
		echo "<td>Read only address</td>";	
		if ($mylkdata -> HasError())
		{
			echo utf8_encode("<td colspan=\"9\">{$mylkdata -> GetFormatedError()}</td>");
		}
		else
		{			
			echo utf8_encode("<td colspan=\"3\">{$mylkdata -> recordsIds}</td>");
			echo utf8_encode("<td colspan=\"6\">{$mylkdata -> records}</td>");
		}
		echo "</tr>";
			
		//DELETE
		
		$dop = new COM("LinkarCommon.DeleteOptions");
		$rritl = new COM("LinkarCommon.RecoverIdType");	
		$dop -> InitializeProperties(false,$rritl);
		
		$mylkdata = $lkClt -> Delete($fileName, $strNewId, $dop);
		
		echo "<tr>";
		echo "<td>Delete</td>";	
		if ($mylkdata -> HasError())
		{
			echo utf8_encode("<td colspan=\"9\">{$mylkdata -> GetFormatedError()}</td>");
		}
		else
		{			
			echo utf8_encode("<td colspan=\"3\">{$mylkdata -> recordsIds}</td>");
			echo utf8_encode("<td colspan=\"6\">{$mylkdata -> records}</td>");
		}
		echo "</tr>";			
		
		//SUBROUTINE
		echo "<br />";
		
		$strargs = "1{$chars->DC4_str}aw{$chars->DC4_str}";			
		
		$mylkdata = $lkClt -> RunSubroutine("SUB.DEMOLINKAR", 3, $strargs);
		
		echo "<tr>";
		echo "<td>RunSubroutine</td>";
		if ($mylkdata -> HasError())
		{
			echo utf8_encode("<td colspan=\"9\">{$mylkdata -> GetFormatedError()}</td>");
		}
		else
		{			
			echo utf8_encode("<td colspan=\"3\">{$mylkdata -> Arguments[1]}</td>");
			echo utf8_encode("<td colspan=\"6\">{$mylkdata -> Arguments[2]}</td>");
		}	
		echo "</tr>";	
			
		//CONVERSION	
			
		$mylkdata = $lkClt -> Conversion(0, "13320", "D2-");
		
		echo "<tr>";
		echo "<td>Conversion</td>";
		if ($mylkdata -> HasError())
		{
			echo utf8_encode("<td colspan=\"9\">{$mylkdata -> GetFormatedError()}</td>");
		}
		else
		{	
			echo "<td colspan=\"3\">Date 18258</td>";	
			echo utf8_encode("<td colspan=\"6\">{$mylkdata -> Conversion}</td>");
		}
		echo "</tr>";
			
			
		//FORMAT	
			
		$mylkdata = $lkClt -> Format("HELLO", "R%10");
		
		echo "<tr>";
		echo "<td>Format</td>";
		if ($mylkdata -> HasError())
		{
			echo utf8_encode("<td colspan=\"9\">{$mylkdata -> GetFormatedError()}</td>");
		}
		else
		{			
			echo "<td colspan=\"3\">HELLO</td>";	
			echo utf8_encode("<td colspan=\"6\">{$mylkdata -> Format}</td>");
		}
		echo "</tr>";
		
		//EXECUTE	
			
		$mylkdata = $lkClt -> Execute("who");
		
		echo "<tr>";
		echo "<td>Execute</td>";
		if ($mylkdata -> HasError())
		{
			echo utf8_encode("<td colspan=\"9\">{$mylkdata -> GetFormatedError()}</td>");
		}
		else
		{	
			echo "<td colspan=\"3\">WHO</td>";	
			echo utf8_encode("<td colspan=\"6\">Capturing {$mylkdata -> Capturing} Returning {$mylkdata -> Returning}</td>");
		}
		echo "</tr>";
			
		//DICTIONARIES
		echo "<tr><td><br /></td></tr>";
			
		$mylkdata = $lkClt -> Dictionaries($fileName);
		
		
		if ($mylkdata -> HasError())
		{
			echo "<tr>";
			echo "<td>Dictionaries</td>";
			echo utf8_encode("<td colspan=\"9\">{$mylkdata -> GetFormatedError()}</td>");
			echo "</tr>";
		}
		else
		{	
			$rows = explode ($chars -> RS_str, $mylkdata -> Dictionaries); 
			$recordIds = explode ($chars -> RS_str, $mylkdata -> DictionariesId); 
			for ($i = 0; $i < count($rows); $i++) 
			{
				echo "<tr>";
				if ($i == 0)
				{
					echo "<td>Dictionaries</td>";
				}
				else
				{
					echo "<td></td>";
				}
				$columns = explode ($mvchars -> AM_str, $rows[$i]); 				
				for ($j = 0; $j < count($columns); $j++) 
				{
					echo utf8_encode("<td>{$columns[$j]}</td>");
				}
				echo "</tr>";
			}	
		}
									
		//SELECT
		echo "<tr><td><br /></td></tr>";
		
		$sop = new COM("LinkarCommon.SelectOptions");
		$sop -> InitializeProperties(false, true, 20, 1, true, false, false, false);			
		
		$mylkdata = $lkClt -> Select($fileName, "", "BY CODE", "", "", $sop);
		
		if ($mylkdata -> HasError())
		{
			echo "<tr>";
			echo "<td>Select</td>";
			echo utf8_encode("<td colspan=\"9\">{$mylkdata -> GetFormatedError()}</td>");
			echo "</tr>";
		}
		else
		{	
			$recordDicts = explode ($mvchars -> AM_str, $mylkdata -> RecordsDicts);
			echo "<tr>";
			echo "<td>Select</td>";
			echo "<td></td>";
			for ($i = 0; $i < count($recordDicts); $i++) 
			{
				echo utf8_encode("<td>{$recordDicts[$i]}</td>");
			}	
			echo "</tr>";			
			$rows = explode ($chars -> RS_str, $mylkdata -> Records); 
			$recordIds = explode ($chars -> RS_str, $mylkdata -> RecordsIds); 
			for ($i = 0; $i < count($rows); $i++) 
			{
				echo "<tr>";
				echo "<td></td>";
				echo utf8_encode("<td>{$recordIds[$i]}</td>");
				$columns = explode ($mvchars -> AM_str, $rows[$i]); 				
				for ($j = 0; $j < count($columns); $j++) 
				{
					echo utf8_encode("<td>{$columns[$j]}</td>");
				}
				echo "</tr>";
			}	
		}	

		//GETTABLE
		echo "<tr><td><br /></td></tr>";
		
		$gtop = new COM("LinkarCommon.TableOptions");
		$gtop -> InitializePropertiesLkSchemas(1, False, False, False, True, True, False, True, False, 10, 1);			
		$errorGetTable = "";
		$mylkstring = $lkClt -> GetTable_Text($errorGetTable, $fileName, "", "", "BY CODE", $gtop);
		
		if($errorGetTable == "")
		{
			if (strpos($mylkstring, $mvchars -> AM_str) !== false)
			{
				echo "<tr>";
				echo "<td>GetTable</td>";
				echo "<td></td>";
				echo "</tr>";			
				$rows = explode ($mvchars -> AM_str, $mylkstring); 
				for ($i = 0; $i < count($rows); $i++) 
				{
					echo "<tr>";
					echo "<td></td>";
					$columns = explode (chr(9), $rows[$i]); 				
					for ($j = 0; $j < count($columns); $j++) 
					{
						echo utf8_encode("<td>{$columns[$j]}</td>");
					}
					echo "</tr>";
				}
			}
			else
			{	
				echo "<tr>";
				echo "<td>GetTable</td>";
				echo utf8_encode("<td colspan=\"9\">{$mylkstring}</td>");
				echo "</tr>";
			}		
		}
		else
		{
			echo "<tr>";
			echo "<td>GetTable ERROR</td>";
			echo utf8_encode("<td colspan=\"9\">{$errorGetTable}</td>");
			echo "</tr>";			
		}
		
		//LOGOUT
	
		$lkClt -> Logout();				
	}
	else
	{
		echo "LOGIN ERROR: {$error}<br />";
	}	
} 
catch (Exception $e) 
{
    echo "Exception: {$e->getMessage()}<br />";
}

?>

</body>
</html>