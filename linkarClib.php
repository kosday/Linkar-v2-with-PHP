<!DOCTYPE html>
<html>
<body>

<h3>Test LinkarClientLibC</h3>

<?php

function DisplayDbErrors($lkString)
{
	$lstErrors = LkGetErrorsFromLkString($lkString);
	$numErr = count($lstErrors);
	if($numErr > 0)
	{
		for($i = 0; $i < $numErr; $i++)
		{
			$j = $i + 1;
			echo "<tr>";
			if($i > 0)
				echo "<td><td/>";
			echo "<td colspan=\"3\">Error({$j}):</td>";
			echo utf8_encode("<td colspan=\"6\">{$lstErrors[$i]}</td>");
			echo "</tr>";
		}
	}

	return $numErr;
}

try
{
	$IO_FORMAT_MV = 1;
	$IO_FORMAT_XML = 2;
	$IO_FORMAT_JSON = 3;
	$IO_FORMAT_TABLE = 4;
	$DBMV_Mark_AM = chr(254);
	$DBMV_Mark_VM = chr(253);
	$LK_MARK_RS = chr(30);
	$ROWHEADERSTYPE_MAINLABEL = 1;
	$ROWHEADERSTYPE_SHORTLABEL = 2;
	$ROWHEADERSTYPE_NONE = 3;
	
	//LOGIN
	$host = "127.0.0.1";		// Replace 127.0.0.1 by your real IP
	$entrypoint = "EP_NAME";	// Replace EP_NAME by your real EntryPoint name
	$port = 11300;				// Replace 11300 by your real port
	$username = "user";			// Replace user, by your real username
	$password = "password";		// Replace password, by your real password
	$freeText = "Test from PHP";
	$customVars = "";
	$crdOpt = LkCreateCredentialOptions($host, $entrypoint, $port, $username, $password, $customVars, $freeText);
	$receiveTimeout = -1;
	$loginResult = LkLogin($crdOpt, $hasError, $customVars, $receiveTimeout);
	if (!$hasError)
	{
		$connectionInfo = $loginResult;
		echo "<table border=\"2\" style=\"width: 100%;\">";
		echo "<tr>";
		echo "<td><b>Session Id</b></td>";
		$sessionId = LkGetDataFromConnectionInfo($connectionInfo, 1);
		echo "<td colspan=\"9\">{$sessionId}</td>";
		echo "</tr>";

		echo "<tr><td><br/></td></tr>";
		//NEW
		$fileName = "LK.CUSTOMERS";
		$strNewId = "A99";
		$strNewRecord = "CUSTOMER 99{$DBMV_Mark_AM}ADDRESS 99{$DBMV_Mark_AM}999 - 999 - 99";
		echo "<tr><td><b>LkNew</b> {$fileName} {$strNewId}</td>";

		$nop_newItemIdTypeNone = LkCreateNewRecordIdTypeNone();
		$nop_readAfter = 1; // BOOL 0:FALSE 1:TRUE
		$nop_calculated = 0; // BOOL 0:FALSE 1:TRUE
		$nop_conversion = 0; // BOOL 0:FALSE 1:TRUE
		$nop_formatSpec = 0; // BOOL 0:FALSE 1:TRUE
		$nop_originalRecords = 0; // BOOL 0:FALSE 1:TRUE
		$newOptions = LkCreateNewOptions($nop_newItemIdTypeNone, $nop_readAfter, $nop_calculated, $nop_conversion, $nop_formatSpec, $nop_originalRecords);
		$lkStringNew = LkNew($connectionInfo, $hasError, $fileName, $strNewId, $strNewRecord, $newOptions, $IO_FORMAT_MV, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringNew}</td></tr>");
		}
		else
		{
			echo "</tr>";
			
			$numErr = DisplayDbErrors($lkStringNew);
			//if($numErr > 0)
			//	echo "<td></td>";
			
			

			$lstRecordIds = LkGetRecordIdsFromLkString($lkStringNew);
			$lstRecords = LkGetRecordsFromLkString($lkStringNew);
			for($i = 0; $i < count($lstRecordIds); $i++)
			{
				$j = $i + 1;
				echo "<tr>";
				if($i > 0)
					echo "<td></td>";
				echo utf8_encode("<td colspan=\"2\">Record({$j}):</td>");
				echo utf8_encode("<td colspan=\"1\">Id: {$lstRecordIds[$i]}</td>");
				echo utf8_encode("<td colspan=\"4\">Data: {$lstRecords[$i]}</td>");
				echo "</tr>";
			}
		}

		$strRecordId = $lstRecordIds[0];
		$strRecord = $lstRecords[0];

		echo "<tr><td><br/></td></tr>";
		//LKEXTRACT
		$mvresult = LkExtract($strRecord, 1, 0, 0);
		echo "<tr>";
		echo "<td><b>LkExtract</b></td>";
		echo utf8_encode("<td colspan=\"5\">{$mvresult}</td>");
		echo "</tr>";

		//LKREPLACE
		$replaceVal = "UPDATED CUSTOMER";
		$strRecord = LkReplace($strRecord, $replaceVal, 1, 0, 0);
		echo "<tr>";
		echo "<td><b>LkReplace</b></td>";
		echo utf8_encode("<td colspan=\"5\">{$strRecord}</td>");
		echo "</tr>";

		//LKCHANGE
		$strRecord = LkChange($strRecord, "9", "8", -1, -1);
		echo "<tr>";
		echo "<td><b>LkChange</b></td>";
		echo utf8_encode("<td colspan=\"5\">{$strRecord}</td>");
		echo "</tr>";

		//LKCOUNT
		$mvresult = LkCount($strRecord, ord($DBMV_Mark_AM));
		echo "<tr>";
		echo "<td><b>LkCount</b></td>";
		echo utf8_encode("<td colspan=\"5\">{$mvresult}</td>");
		echo "</tr>";

		//LKDCOUNT
		$mvresult = LkDCount($strRecord, ord($DBMV_Mark_AM));
		echo "<tr>";
		echo "<td><b>LkDCount</b></td>";
		echo utf8_encode("<td colspan=\"5\">{$mvresult}</td>");
		echo "</tr>";

		echo "<tr><td><br/></td></tr>";
		//UPDATE
		echo "<tr><td><b>LkUpdate</b></td>";
		$uop_optimisticLock = 0; // BOOL 0:FALSE 1:TRUE
		$uop_readAfter = 1; // BOOL 0:FALSE 1:TRUE
		$uop_calculated = 0; // BOOL 0:FALSE 1:TRUE
		$uop_conversion = 0; // BOOL 0:FALSE 1:TRUE
		$uop_formatSpec = 0; // BOOL 0:FALSE 1:TRUE
		$uop_originalRecords = 0; // BOOL 0:FALSE 1:TRUE
		$updateOptions = LkCreateUpdateOptions($uop_optimisticLock, $uop_readAfter, $uop_calculated, $uop_conversion, $uop_formatSpec, $uop_originalRecords);

		$originalRecords = "";

		$lkStringUpdate = LkUpdate($connectionInfo, $hasError, $fileName, $strRecordId, $strRecord, $originalRecords, $updateOptions, $IO_FORMAT_MV, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringUpdate}</td></tr>");
		}
		else
		{
			echo "</tr>";
			
			$numErr = DisplayDbErrors($lkStringUpdate);
			//if($numErr > 0)
			//	echo "<td></td>";
			

			$lstRecordIds = LkGetRecordIdsFromLkString($lkStringUpdate);
			$lstRecords = LkGetRecordsFromLkString($lkStringUpdate);
			for($i = 0; $i < count($lstRecordIds); $i++)
			{
				$j = $i + 1;
				echo "<tr>";
				if($i > 0)
					echo "<td></td>";
				echo utf8_encode("<td colspan=\"2\">Record({$j}):</td>");
				echo utf8_encode("<td colspan=\"1\">Id: {$lstRecordIds[$i]}</td>");
				echo utf8_encode("<td colspan=\"4\">Data: {$lstRecords[$i]}</td>");
				echo "</tr>";
			}
		}

		//READ
		// Uncomment for see how to read more than one record
		//$strNewId .= $LK_MARK_RS . "1" . $LK_MARK_RS . "2" . $LK_MARK_RS . "555" . $LK_MARK_RS . "3";
		echo "<tr><td><b>LkRead</b> only address {$strNewId}</td>";
		$rop_calculated = 1; // BOOL 0:FALSE 1:TRUE
		$rop_conversion = 0; // BOOL 0:FALSE 1:TRUE
		$rop_formatSpec = 0; // BOOL 0:FALSE 1:TRUE
		$rop_originalRecords = 0; // BOOL 0:FALSE 1:TRUE
		$readOptions = LkCreateReadOptions($rop_calculated, $rop_conversion, $rop_formatSpec, $rop_originalRecords);

		$dictionaries = "ADDR";
		$lkStringRead = LkRead($connectionInfo, $hasError, $fileName, $strNewId, $dictionaries, $readOptions, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringRead}</td></tr>");
		}
		else
		{
			echo "</tr>";
			
			$numErr = DisplayDbErrors($lkStringRead);
			//if($numErr > 0)
			//	echo "<td></td>";			

			// DB result
			$lstRecordIds = LkGetRecordIdsFromLkString($lkStringRead);
			$lstRecords = LkGetRecordsFromLkString($lkStringRead);
			for($i = 0; $i < count($lstRecordIds); $i++)
			{
				$j = $i + 1;
				echo "<tr>";
				if($i > 0)
					echo "<td></td>";
				echo utf8_encode("<td colspan=\"2\">Record({$j}):</td>");
				echo utf8_encode("<td colspan=\"1\">Id: {$lstRecordIds[$i]}</td>");
				echo utf8_encode("<td colspan=\"4\">Data: {$lstRecords[$i]}</td>");
				echo "</tr>";
			}
		}

		//DELETE
		echo "<tr><td><b>LkDelete</b> {$fileName} {$strRecordId}</td>";
		$dop_optimisticLock = 0; // BOOL 0:FALSE 1:TRUE
		$dop_recoverIdType = LkCreateRecoverRecordIdTypeNone();
		$deleteOptions = LkCreateDeleteOptions($dop_optimisticLock, $dop_recoverIdType);
		$originalRecords = "";
		$lkStringDelete= LkDelete($connectionInfo, $hasError, $fileName, $strRecordId, $originalRecords, $deleteOptions, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringDelete}</td></tr>");
		}
		else
		{
			echo "</tr>";
			
			$numErr = DisplayDbErrors($lkStringDelete);
			//if($numErr > 0)
			//	echo "<td></td>";					

			$lstRecordIds = LkGetRecordIdsFromLkString($lkStringDelete);
			for($i = 0; $i < count($lstRecordIds); $i++)
			{
				$j = $i + 1;
				//if($i == 0)
				//	echo "</td>";
				//else
					echo "<tr><td></td>";
				echo utf8_encode("<td colspan=\"3\">Record({$j}):</td>");
				echo utf8_encode("<td colspan=\"3\">Id: {$lstRecordIds[$i]}</td>");
				echo "</tr>";
			}
		}

		echo "<tr><td><br/></td></tr>";
		//SUBROUTINE
		$subroutineName = "SUB.DEMOLINKAR";
		$strArgs = LkAddArgumentSubroutine("0", "qwerty");
		$strArgs = LkAddArgumentSubroutine($strArgs, "");
		echo "<tr><td><b>LkSubroutine</b> {$subroutineName}</td>";

		$lkStringSubroutine = LkSubRoutine($connectionInfo, $hasError, $subroutineName, 3, $strArgs, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"6\">{$lkStringSubroutine}</td></tr>");
		}
		else
		{
			echo "</tr>";
			
			$numErr = DisplayDbErrors($lkStringSubroutine);
			if($numErr == 0)
			{
				echo "<tr><td colspan=\"5\">Input Args: {$strArgs}</td></tr>";
				$strOutArgs = LkGetArgumentsFromLkString($lkStringSubroutine);
				echo "<tr><td></td><td colspan=\"5\">Output Args: {$strOutArgs}</td></tr>";
			}
		}

		//CONVERSION
		$code = "D2-";
		$expresion = "13320";
		$conversionType = ord("O");
		echo "<tr>";
		echo "<td><b>LkConversion</b> OCONV {$expresion} {$code}</td>";
		$lkStringConversion = LkConversion($connectionInfo, $hasError, $code, $expresion, $conversionType, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringConversion}</td></tr>");
		}
		else
		{
			echo "</tr>";
			$numErr = DisplayDbErrors($lkStringConversion);
			if($numErr == 0)
			{
				$conversionResult = LkGetConversionFromLkString($lkStringConversion);
				echo utf8_encode("<tr><td colspan=\"4\">{$conversionResult}</td></tr>");
			}
		}

		//FORMAT
		$formatSpec = "R%10";
		$expresion = "HELLO";
		echo "<tr>";
		echo "<td><b>Format</b> {$expresion} {$formatSpec}</td>";
		$lkStringFormat = LkFormat($connectionInfo, $hasError, $formatSpec, $expresion, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringFormat}</td></tr>");
		}
		else
		{
			echo "</tr>";
			$numErr = DisplayDbErrors($lkStringFormat);
			if($numErr == 0)
			{
				$formatResult = LkGetFormatFromLkString($lkStringFormat);
				echo utf8_encode("<tr><td colspan=\"4\">{$formatResult}</td></tr>");
			}
		}

		//EXECUTE
		$statement = "WHO";
		echo "<tr>";
		echo "<td><b>LkExecute</b> {$statement}</td>";
		$lkStringExecute = LkExecute($connectionInfo, $hasError, $statement, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringExecute}</td></tr>");
		}
		else
		{
			echo "</tr>";
			$numErr = DisplayDbErrors($lkStringExecute);
			if($numErr == 0)
			{
				$executeReturning = LkGetReturningFromLkString($lkStringExecute);
				echo "<tr><td colspan=\"1\">RETURNING:  {$executeReturning}</td>";
				$executeCapturing = LkGetCapturingFromLkString($lkStringExecute);
				echo utf8_encode("<td colspan=\"2\">CAPTURING: {$executeCapturing}</td></tr>");
			}

		}

		echo "<tr><td><br/></td></tr>";
		//DICTIONARIES
		echo "<tr><td><b>LkDictionaries</b> {$fileName}</td>";
		$lkStringDictionaries = LkDictionaries($connectionInfo, $hasError, $fileName, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringDictionaries}</td></tr>");
		}
		else
		{
			echo "</tr>";
			$numErr = DisplayDbErrors($lkStringDictionaries);
			if($numErr == 0)
			{
				$dictionariesResult = LkGetDictionariesFromLkString($lkStringDictionaries);
				$dictionaryIdsResult = LkGetDictionaryIdsFromLkString($lkStringDictionaries);
				$numDictionaries = count($dictionariesResult);
				if($numDictionaries > 0)
				{
					for($i = 0; $i < $numDictionaries; $i++)
					{
						echo "<tr>";
						$k = $i + 1;
						echo "<td colspan=\"1\">Dictionary({$k}) {$dictionaryIdsResult[$i]}:</td>";

						$columns = explode ($DBMV_Mark_AM, $dictionariesResult[$i]); 
						echo "<td>";
						for ($j = 0; $j < count($columns); $j++) 
						{
							echo utf8_encode("{$columns[$j]} ");
						}
						echo "</td></tr>";
					}
				}
			}

		}

		echo "<tr><td><br/></td></tr>";

		//SELECT
		echo "<tr><td><b>LkSelect</b> {$fileName}</td>";

		$sop_onlyRecordId = 0; // BOOL 0:FALSE 1:TRUE
		$sop_pagination = 0; // BOOL 0:FALSE 1:TRUE
		$sop_regPage = 0;
		$sop_numPage = 0;
		$sop_calculated = 1; // BOOL 0:FALSE 1:TRUE
		$sop_conversion = 0; // BOOL 0:FALSE 1:TRUE
		$sop_formatSpec = 0; // BOOL 0:FALSE 1:TRUE
		$sop_originalRecords = 0; // BOOL 0:FALSE 1:TRUE
		$selectOptions = LkCreateSelectOptions($sop_onlyRecordId, $sop_pagination, $sop_regPage, $sop_numPage,
											   $sop_calculated, $sop_conversion, $sop_formatSpec, $sop_originalRecords);

		$selectClause = "";
		$sortClause = "BY CODE";
		$dictClause = "";
		$preSelectClause = "";
		$lkStringSelect = LkSelect($connectionInfo, $hasError, $fileName, $selectClause, $sortClause, $dictClause, $preSelectClause, $selectOptions, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringSelect}</td></tr>");
		}
		else
		{
			echo "</tr>";
			$numErr = DisplayDbErrors($lkStringSelect);
			if($numErr == 0)
			{
				echo "<tr>";
				$recordIdDict = LkGetRecordsIdDictsFromLkString($lkStringSelect);
				echo "<td>{$recordIdDict[0]}</td>";
				$recordDicts = LkGetRecordsDictionariesFromLkString($lkStringSelect);
				for ($i = 0; $i < count($recordDicts); $i++)
				{
					echo utf8_encode("<td>{$recordDicts[$i]}</td>");
				}
				echo "</tr>";
				$records = LkGetRecordsFromLkString($lkStringSelect);
				$recordIds = LkGetRecordIdsFromLkString($lkStringSelect);
				for ($i = 0; $i < count($records); $i++)
				{
					echo "<tr>";
					echo utf8_encode("<td>{$recordIds[$i]}</td>");
					$columns = explode ($DBMV_Mark_AM, $records[$i]);
					for ($j = 0; $j < count($columns); $j++)
					{
						echo utf8_encode("<td>{$columns[$j]}</td>");
					}
					echo "</tr>";
				}
			}
		}
				
		echo "<tr><td><br/></td></tr>";
		
		//LKSCHEMAS
	
		echo "<tr><td><b>LkSchemas</b> {$fileName}</td>";

		$schop_rowHeadersType = $ROWHEADERSTYPE_MAINLABEL;
		$schop_rowProperties = 0; // BOOL 0:FALSE 1:TRUE
		$schop_onlyVisibles = 0; // BOOL 0:FALSE 1:TRUE
		$schop_pagination = 0; // BOOL 0:FALSE 1:TRUE
		$schop_regPage = 0;
		$schop_numPage = 0;
		$lkSchemasOptions = LkCreateSchOptionsTypeLKSCHEMAS($schop_rowHeadersType, $schop_rowProperties, $schop_onlyVisibles, $schop_pagination, $schop_regPage,
                                                        $schop_numPage);

		$lkStringSchemas = LkSchemas($connectionInfo, $hasError, $lkSchemasOptions, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringSchemas}</td></tr>");
		}
		else
		{
			echo "</tr>";
			$numErr = DisplayDbErrors($lkStringSchemas);
			if($numErr == 0)
			{
				echo "<tr>";
				//$recordIdDict = LkGetRecordsIdDictsFromLkString($lkStringSchemas);
				//echo "<td>{$recordIdDict[0]}</td>";
				$rowHeaders = LkGetRowHeadersFromLkString($lkStringSchemas);
				for ($i = 0; $i < count($rowHeaders); $i++)
				{
					echo utf8_encode("<td>{$rowHeaders[$i]}</td>");
				}
				echo "</tr>";
				$records = LkGetRecordsFromLkString($lkStringSchemas);
				$recordIds = LkGetRecordIdsFromLkString($lkStringSchemas);
				for ($i = 0; $i < count($records); $i++)
				{
					echo "<tr>";
					//echo "<td></td>";
					echo utf8_encode("<td>{$recordIds[$i]}</td>");
					$columns = explode ($DBMV_Mark_AM, $records[$i]);
					for ($j = 0; $j < count($columns); $j++)
					{
						echo utf8_encode("<td>{$columns[$j]}</td>");
					}
					echo "</tr>";
				}
			}
		}
	
		echo "<tr><td><br/></td></tr>";
		
		//LKPROPERTIES
		
		$fileName = "LK.ORDERS";
		echo "<tr><td><b>LkProperties</b> {$fileName}</td>";

		$propop_rowHeadersType = $ROWHEADERSTYPE_MAINLABEL;
		$propop_rowProperties = 0; // BOOL 0:FALSE 1:TRUE
		$propop_onlyVisibles = 0; // BOOL 0:FALSE 1:TRUE
		$propop_usePropertyNames = 0; // BOOL 0:FALSE 1:TRUE
		$propop_pagination = 0; // BOOL 0:FALSE 1:TRUE
		$propop_regPage = 0;
		$propop_numPage = 0;
		$lkPropertiesOptions = LkCreatePropOptionsTypeLKSCHEMAS($propop_rowHeadersType, $propop_rowProperties, $propop_onlyVisibles, $propop_usePropertyNames, 
																$propop_pagination, $propop_regPage, $propop_numPage);

		$lkStringProperties = LkProperties($connectionInfo, $hasError, $fileName, $lkPropertiesOptions, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringProperties}</td></tr>");
		}
		else
		{
			echo "</tr>";
			$numErr = DisplayDbErrors($lkStringProperties);
			if($numErr == 0)
			{
				echo "<tr>";
				$recordIdDict = LkGetRecordsIdDictsFromLkString($lkStringProperties);
				echo "<td>{$recordIdDict[0]}</td>";
				$recordDicts = LkGetRecordsDictionariesFromLkString($lkStringProperties);
				for ($i = 0; $i < count($recordDicts); $i++)
				{
					echo utf8_encode("<td>{$recordDicts[$i]}</td>");
				}
				echo "</tr>";
				$records = LkGetRecordsFromLkString($lkStringProperties);
				$recordIds = LkGetRecordIdsFromLkString($lkStringProperties);
				for ($i = 0; $i < count($records); $i++)
				{
					echo "<tr>";
					echo "<td></td>";
					echo utf8_encode("<td>{$recordIds[$i]}</td>");
					$columns = explode ($DBMV_Mark_AM, $records[$i]);
					for ($j = 0; $j < count($columns); $j++)
					{
						echo utf8_encode("<td>{$columns[$j]}</td>");
					}
					echo "</tr>";
				}
			}
		}
		
		echo "<tr><td><br/></td></tr>";

		//LKGETTABLE
		
		$fileName = "LK.ORDERS";
		echo "<tr><td><b>LkGetTable</b> {$fileName}</td>";
		echo "<tr><td colspan=\"6\">OPTIONS: ApplyConversion = TRUE ApplyFormat = TRUE Calculated = TRUE Pagination = TRUE (50 reg per page / Page 1)</td>";

		$gtop_rowHeadersType = $ROWHEADERSTYPE_MAINLABEL;
		$gtop_rowProperties = 0; // BOOL 0:FALSE 1:TRUE
		$gtop_onlyVisibles = 0; // BOOL 0:FALSE 1:TRUE
		$gtop_usePropertyNames = 0; // BOOL 0:FALSE 1:TRUE
		$gtop_repeatValues = 0; // BOOL 0:FALSE 1:TRUE
		$gtop_applyConversion = 1; // BOOL 0:FALSE 1:TRUE
		$gtop_applyFormat = 1; // BOOL 0:FALSE 1:TRUE
		$gtop_calculated = 1; // BOOL 0:FALSE 1:TRUE
		$gtop_pagination = 1; // BOOL 0:FALSE 1:TRUE
		$gtop_regPage = 50;
		$gtop_numPage = 1;
		$selectOptions = LkCreateTableOptionsTypeLKSCHEMAS($gtop_rowHeadersType, $gtop_rowProperties, $gtop_onlyVisibles, $gtop_usePropertyNames,
                                                           $gtop_repeatValues, $gtop_applyConversion, $gtop_applyFormat, $gtop_calculated,
														   $gtop_pagination, $gtop_regPage, $gtop_numPage);

		$selectClause = "";
		$sortClause = "BY CODE";
		$dictClause = "";
		$lkStringGetTable = LkGetTable($connectionInfo, $hasError, $fileName, $selectClause, $sortClause, $dictClause, $selectOptions, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringGetTable}</td></tr>");
		}
		else
		{			
			echo "</tr>";
			
			$rows = explode (chr(11), $lkStringGetTable);
			for($i =0; $i < count($rows); $i++)
			{
				echo "<tr>";
				$columns = explode("\t", $rows[$i]);
				for($j = 0; $j < count($columns); $j++)
				{
					echo "<td>";
					echo utf8_encode($columns[$j]);
					echo "</td>";
				}
				echo "</tr>";
			}
		}
		
		echo "<tr><td><br/></td></tr>";
		
		//LKRESETCOMMONBLOCKS
		
		echo "<tr>";
		echo "<td><b>LkResetCommonBlocks</b></td>";
		$lkStringResetCommonBlocks = LkResetCommonBlocks($connectionInfo, $hasError, $IO_FORMAT_MV, $customVars, $receiveTimeout);
		if($hasError)
		{
			// Internal Errors: LinkarClient & LinkarServer
			echo utf8_encode("<td colspan=\"9\">{$lkStringResetCommonBlocks}</td></tr>");
		}
		else
		{
			echo "</tr>";
			$numErr = DisplayDbErrors($lkStringResetCommonBlocks);
			if($numErr == 0)
			{				
				$executeReturning = LkGetReturningFromLkString($lkStringResetCommonBlocks);
				echo "<tr><td colspan=\"1\">RETURNING:  {$executeReturning}</td>";
				$executeCapturing = LkGetCapturingFromLkString($lkStringResetCommonBlocks);
				echo utf8_encode("<td colspan=\"2\">CAPTURING: {$executeCapturing}</td></tr>");
			}
		}
		
		echo "</table>";

		//LOGOUT
		$lkStringLogout = LkLogout($connectionInfo, $hasError, $customVars, $receiveTimeout);
	}
	else
	{
		echo "LOGIN ERROR: {$loginResult}<br/>";
	}
}
catch (Exception $e)
{
    echo "Exception: {$e->getMessage()}<br/>";
}

?>

</body>
</html>
