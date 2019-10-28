<?php 
	// Include need file(s):
	include_once($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	
	$id = $_POST['id'];
?>
<div id="displayStatus">
<fieldset id="statusAIntuition"><legend>Check status of this AIntuition</legend>
	<select name="AIntuitionParametersSetup" id="AIntuitionParametersSetup<?php echo $id;?>">
		<option>---</option>
		<option value="Decrease">Decrease</option>
		<option value="Increase">Increase</option>
		<option value="Static">Static</option>
	</select>
</fieldset>

<fieldset><legend>AIntuition Handling Types</legend>
	
		<input type="radio" name="privates<?php echo $id;?>" id="privates1<?php echo $id;?>" value="Private"/>Private
		<input type="radio" name="privates<?php echo $id;?>" id="privates2<?php echo $id;?>" value="Duty"/>Duty
	
	<br />	
		
</fieldset>

<fieldset><legend>AIntuition Frequency</legend>
	<label>Per:</label>
	
		<input type="radio" name="frequency<?php echo $id;?>" id="frequency1<?php echo $id;?>" onclick = "frequencyHour(1, <?php echo $id;?>);" value="Hour"/>Hourly
		<input type="radio" name="frequency<?php echo $id;?>" id="frequency2<?php echo $id;?>" onclick = "frequencyDay(2, <?php echo $id;?>);" value="Day"/>Daily
		<input type="radio" name="frequency<?php echo $id;?>" id="frequency3<?php echo $id;?>" onclick = "frequencyMonth(3, <?php echo $id;?>);" value="Month"/>Monthly
		
		<div id="showFrequency<?php echo $id;?>"></div>

</fieldset>

<fieldset><legend>AIntuition Expiration Date</legend>
		
		<table> 
            <tr>
                <td>Date: </td>
                <td><input type="text" id="AIntuitionExpirationDate<?php echo $id;?>" name="AIntuitionExpirationDate" style="width: 130px; margin-right: 7px;" placeholder="--" value="<?php echo $date; ?>" readonly/></td>
               
            </tr> 
        </table>
		
</fieldset>
</div>   
<script>

	// DATAPICKER - BEGIN
	
   $(function(){
            var dateToday = new Date(); 
	        var dateFormat = "dd/mm/yy", 
	        from = $("#AIntuitionExpirationDate<?php echo $id;?>").datepicker({
	                      dateFormat : "dd/mm/yy",
	                      defaultDate: "+1w",
	                      changeMonth: true,
	                      changeYear: true,
					      beforeShow: function (textbox, instance) {
							  var txtBoxOffset = $(this).offset();
							  var top = txtBoxOffset.top;
							  var left = txtBoxOffset.left;
							  var textBoxWidth = $(this).outerWidth();
							  setTimeout(function () {
								  instance.dpDiv.css({
								  top: top-190, 
								  left: left + textBoxWidth + 30
								  });
							  }, 10);
					      },
	                      minDate: 0,
                          maxDate: '+1Y',
	                      showOn: 'button',
	                      buttonImage: '/images/calendarImages/cal.gif',
	                      buttonImageOnly: true,
	                      buttonText: "Select date"
	        });
   

	});
	
	// DATAPICKER - END

</script>