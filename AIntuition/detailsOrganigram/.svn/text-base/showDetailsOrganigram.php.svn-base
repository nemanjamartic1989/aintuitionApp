
<?php include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");?>

<fieldset id="ShowDetailOrganigram"><legend>Show Details Organigram</legend>
	<div class="listOfChooseOrganigram_1">
		<table class="mightyTable tableHover tableRowColoring" style="display: table-row;" align="left" cellpadding="2" cellspacing="0">
		<thead>
		<tr class="mightyTableHeader" style="text-align:center">
        	 <th class="tableNewBorderWhite" width="250px" style="color:white;" align="center">Employee Name</th>
             <th class="tableNewBorderWhite" width="250px" style="color:white;" align="center">Role name</th>
             <th class="tableNewBorderWhite" width="200px" style="color:white;" align="center">Level Name</th>
             <th class="tableNewBorderWhite" width="200px" style="color:white;" align="center">Level Organigram</th>
             <th class="tableNewBorderWhite" width="70px" style="color:white;" align="center">Assign Category</th>
    	</tr>
    	</thead>
    	<tbody style="height: auto;overflow-y:scroll;min-height: 40px;max-height: 200px;">
		<?php 
		$query = "SELECT ho.orgLev, ho.empID, ho.holdingID, ho.roleName FROM tdbHoldingOrganigram ho ORDER BY ho.orgLev ASC";
		$resQuery = mysql_query($query); // Send a MySQL query.
		
		while($rowQuery = mysql_fetch_assoc($resQuery)){ // Fetch a result row as an associative array.
			
			$employeeID = $rowQuery['empID'];
			$employeeName = displayEmployeeName($rowQuery['empID']);
			$roleName = $rowQuery['roleName'];
			$holdingID = $rowQuery['holdingID'];
			$levelName = displayClient($rowQuery['holdingID']);
			$levelOrganigram = $rowQuery['orgLev'];
			
			echo"<tr>";	
				echo"<td class='tableNewBorder' width='250' align='center'>" . $employeeName . "</td>";
				echo"<td class='tableNewBorder' width='250' align='center'>" . $roleName . "</td>";
				echo"<td class='tableNewBorder' width='200' align='center'>" . $levelName . "</td>";
				echo"<td class='tableNewBorder' width='200' align='center'>" . $levelOrganigram . "</td>";
				echo"<td class='tableNewBorder' width='70' align='center'><img src='/images/ui/buttons/btn_plus_gray.png' style='cursor:pointer' onclick='showHoldingOrganigram($employeeID, $levelOrganigram);'></td>";
			echo"</tr>";
		}
		?>
		</tbody>
	</table>
	<input type="button" id="hide" value="Hide" onclick="hideDetailOrganigram();" style="margin: 50px 0 0 60px;"/>
	</div>
		
	</fieldset> 
	
	<div id="ChooseCategoryForThisAIntuition"></div>
	
</fieldset>