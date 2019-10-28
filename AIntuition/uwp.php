<script>
    function format ( d ) 
    {
        console.log(d);
        var table="";
        table+="<table width='100%'>";
        table+="<tr><td width='50%'>Status</td><td width='50%'>Delegation</td></tr>";
        table+="<tr><td><div style='max-height: 200px;overflow-y: auto;'>"+d.message+"<div></td>";
        table+="<td><div style='max-height: 200px;overflow-y: auto;'>"+d.delegation+"</div></td></tr>";
        table+="</table>";
    
        return table;
    }
$(document).ready(function() {
	var uwp = $('#uwpTable').DataTable({
	    "ajax":{
	    		'type':'POST',
	    		'url' :'/AIntuition/ajax/uwp/uwp.php',
	    		"data": function ( d ) 
	    		{
                            d.action = 'get'
                        }
	    },
	    "columns": [
              {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
              },
	      { "data": "employeeName" },
	      { "data": "aintuitionCategory"},
	      { "data": "aintuitionSubcategory" },
              { "data": "messageType"},
              { "data": "reportCode"},
              { "data": "createdDate"},
              { "data": "createdTime"}
	    ],
	    "aoColumnDefs": [
	      { "bSortable": false, "aTargets": [-1] }
	    ],
	    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
	    "oLanguage": {
	      "oPaginate": {
	        "sFirst":       " ",
	        "sPrevious":    " ",
	        "sNext":        " ",
	        "sLast":        " ",
	      },
	      "sLengthMenu":    "Records per page: _MENU_",
	      "sInfo":          "Total of _TOTAL_ records (showing _START_ to _END_)",
	      "sInfoFiltered":  "(filtered from _MAX_ total records)"
	    }
	  });
          
          
    // Array to track the ids of the details displayed rows
    var detailRows = [];
 
    $('#uwpTable tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = uwp.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    uwp.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );
    
    
} );
</script>

<input type="button" onclick="backToMainMenu();" value="Back to main menu" style="float:right;"/><br /><br />
<fieldset><legend>Universal Parser</legend>
    <table id="uwpTable" class="tableRowColoring display"  style="width: 100%;     margin-top: 20px;" cellspacing="0" width="100%"> 
        <thead>
           <tr class="table_header">
                <th></th>
                <th>Employee Name</th>
                <th>Aintuition Category</th>
                <th>Aintuition Subcategory</th>
                <th>Message Type</th>
                <th>Report Code</th>
                <th>Created Date</th>
                <th>Created Time</th>
            </tr>
        </thead>
    </table>
</fieldset>