<?php
//$qry_calls = "SELECT * FROM ".$tblprefix."calls"; 
//$res_calls = $db->Execute($qry_calls);
//$totalcountCalls =  $res_calls->RecordCount();

?>

<div class="row">

<div class="col-sm-4">
 <ol class="breadcrumb bc-3">
  <li> <a href="index.html"><i class="entypo-home"></i>Dashboard</a> </li>
  <li> <a href="index.html">SEO</a> </li>
  <li class="active"> <strong>Keyword Positions</strong> </li>
</ol>
</div>

          <div class="fr custom-btn"> <a href="javascript:;" onClick="jQuery('#modal-4').modal('show', {backdrop: 'static'});" class="btn btn-blue fr">Request A Call Now</a> </div>


  <form>
    <div class="col-sm-4 fr">
      <div class="daterange daterange-inline add-ranges" data-format="MMMM D, YYYY" data-start-date="September 16, 2014" data-end-date="September 22, 2014"> <i class="entypo-calendar"></i> <span>September 16, 2014 - September 22, 2014</span> </div>
    </div>
  </form>

  
    <div class="clearfix"></div>

</div>

<script type="text/javascript">
var responsiveHelper;
var breakpointDefinition = {
tablet: 1024,
phone : 480
};
var tableContainer;

jQuery(document).ready(function($)
{
    tableContainer = $("#table-1");
    
    tableContainer.dataTable({
        "sPaginationType": "bootstrap",
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "bStateSave": true,
        

        // Responsive Settings
        bAutoWidth     : false,
        fnPreDrawCallback: function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper) {
                responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
            }
        },
        fnRowCallback  : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            responsiveHelper.createExpandIcon(nRow);
        },
        fnDrawCallback : function (oSettings) {
            responsiveHelper.respond();
        }
    });
    
    $(".dataTables_wrapper select").select2({
        minimumResultsForSearch: -1
    });
});
</script> 
<script type="text/javascript">
jQuery(window).load(function()
{
var $ = jQuery;

$("#table-2").dataTable({
    "sPaginationType": "bootstrap",
    "sDom": "t<'row'<'col-xs-6 col-left'i><'col-xs-6 col-right'p>>",
    "bStateSave": false,
    "iDisplayLength": 8,
    "aoColumns": [
        { "bSortable": false },
        null,
        null,
        null,
        null
    ]
});

$(".dataTables_wrapper select").select2({
    minimumResultsForSearch: -1
});

// Highlighted rows
$("#table-2 tbody input[type=checkbox]").each(function(i, el)
{
    var $this = $(el),
        $p = $this.closest('tr');
    
    $(el).on('change', function()
    {
        var is_checked = $this.is(':checked');
        
        $p[is_checked ? 'addClass' : 'removeClass']('highlight');
    });
});

// Replace Checboxes
$(".pagination a").click(function(ev)
{
    replaceCheckboxes();
});
});

// Sample Function to add new row
var giCount = 1;

function fnClickAddRow() 
{
$('#table-2').dataTable().fnAddData(['<div class="checkbox checkbox-replace"><input type="checkbox" /></div>', giCount+".2", giCount+".3", giCount+".4", giCount+".5" ]);

replaceCheckboxes(); // because there is checkbox, replace it

giCount++;
}
</script> 
<script type="text/javascript">
jQuery(document).ready(function($)
{
    var table = $("#table-3").dataTable({
        "sPaginationType": "bootstrap",
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "bStateSave": true
    });
    
    table.columnFilter({
        "sPlaceHolder" : "head:after"
    });
});
</script>
<h2>Keyword Positions</h2>
<br />
<table class="table table-bordered datatable" id="table-4">
  <thead>
    <tr>
      <th>Keyword No.</th>
      <th>Keyword</th>
      <th>Keyword Position</th>
      <th>Change</th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd gradeX">
      <td>01</td>
      <td>resort dubai</td>
      <td>2</td>
      <td class="green"><i class="fa fa-caret-up"></i> 3</td>
    </tr>
    <tr class="even gradeC">
      <td>02</td>
      <td>tourist resort dubai</td>
      <td>8</td>
      <td class="green"><i class="fa fa-caret-up"></i> 10</td>
    </tr>
    <tr class="odd gradeA">
      <td>03</td>
      <td>beach resort</td>
      <td>9</td>
      <td class="green"><i class="fa fa-caret-up"></i> 12</td>
    </tr>
    <tr class="even gradeA">
      <td>04</td>
      <td>dubai beach resort</td>
      <td>10</td>
      <td class="green"><i class="fa fa-caret-up"></i> 112</td>
    </tr>
    <tr class="odd gradeA">
      <td>05</td>
      <td>dubai beach resort 5*</td>
      <td>15</td>
      <td class="green"><i class="fa fa-caret-up"></i> 12</td>
    </tr>
    <tr class="even gradeA">
      <td>06</td>
      <td>5* resort</td>
      <td>19</td>
      <td class="green"><i class="fa fa-caret-up"></i> 25</td>
    </tr>
    <tr class="gradeA">
      <td>07</td>
      <td>best beach resort</td>
      <td>21</td>
      <td class="green"><i class="fa fa-caret-up"></i> 01</td>
    </tr>
    <tr class="gradeA">
      <td>08</td>
      <td>top beach resort</td>
      <td>22</td>
      <td class="blue">Stable</td>
    </tr>
    <tr class="gradeA">
      <td>09</td>
      <td>beach resort uae</td>
      <td>24</td>
      <td class="blue"><i class="fa fa-caret-down"></i> 01</td>
    </tr>
    <tr class="gradeA">
      <td>10</td>
      <td>beach resort near jumeirah</td>
      <td>26</td>
      <td class="green"><i class="fa fa-caret-up"></i> 02</td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <th>Keyword No.</th>
      <th>Keyword</th>
      <th>Keyword Position</th>
      <th>Change</th>
    </tr>
  </tfoot>
</table>
<script type="text/javascript">
jQuery(document).ready(function($)
{
    var table = $("#table-4").dataTable({
        "sPaginationType": "bootstrap",
        "sDom": "<'row'<'col-xs-6 col-left'l><'col-xs-6 col-right'<'export-data'T>f>r>t<'row'<'col-xs-6 col-left'i><'col-xs-6 col-right'p>>",
        "oTableTools": {
        },
        
    });
});
    
</script> 
<br />
<br />
<div class="row">
  <div class="col-sm-12">
    <div class="action-links"> <a href="organic.html">View Summary</a> <a href="visitors.html">View Website Visitors Details</a>
      <hr />
    </div>
  </div>
</div>
<br />
<br />
<div class="row">
  <div class="viral-links">

    <h1>We Are Sure That You’re Happy With Our Service</h1>

    <a href="javascript:;" onClick="jQuery('#modal-1').modal('show');" class="green-btn"><i class="fa fa-thumbs-up"></i>Recommend Us</a>
    <a href="javascript:;" onClick="jQuery('#modal-6').modal('show', {backdrop: 'static'});" class="blue-btn"><i class="fa fa-share-square"></i>Share This Report</a>


  </div>
</div>
<br />

<link rel="stylesheet" href="<?php echo SURL?>assets/js/datatables/responsive/css/datatables.responsive.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/select2/select2.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/selectboxit/jquery.selectBoxIt.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/icheck/skins/minimal/_all.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/icheck/skins/square/_all.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/icheck/skins/flat/_all.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/icheck/skins/futurico/futurico.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/icheck/skins/polaris/polaris.css">

<!-- Bottom Scripts --> 
<script src="<?php echo SURL?>assets/js/gsap/main-gsap.js"></script> 
<script src="<?php echo SURL?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script> 
<script src="<?php echo SURL?>assets/js/bootstrap.js"></script> 
<script src="<?php echo SURL?>assets/js/joinable.js"></script> 
<script src="<?php echo SURL?>assets/js/resizeable.js"></script> 
<script src="<?php echo SURL?>assets/js/neon-api.js"></script> 
<script src="<?php echo SURL?>assets/js/jquery.dataTables.min.js"></script> 
<script src="<?php echo SURL?>assets/js/datatables/TableTools.min.js"></script> 
<script src="<?php echo SURL?>assets/js/dataTables.bootstrap.js"></script> 
<script src="<?php echo SURL?>assets/js/datatables/jquery.dataTables.columnFilter.js"></script> 
<script src="<?php echo SURL?>assets/js/datatables/lodash.min.js"></script> 
<script src="<?php echo SURL?>assets/js/datatables/responsive/js/datatables.responsive.js"></script> 
<script src="<?php echo SURL?>assets/js/select2/select2.min.js"></script> 
<script src="<?php echo SURL?>assets/js/neon-chat.js"></script> 
<script src="<?php echo SURL?>assets/js/neon-custom.js"></script> 
<script src="<?php echo SURL?>assets/js/neon-demo.js"></script> 

<!-- Bottom Scripts --> 
<script src="<?php echo SURL?>assets/js/select2/select2.min.js"></script> 
<script src="<?php echo SURL?>assets/js/typeahead.min.js"></script> 
<script src="<?php echo SURL?>assets/js/selectboxit/jquery.selectBoxIt.min.js"></script> 
<script src="<?php echo SURL?>assets/js/bootstrap-datepicker.js"></script> 
<script src="<?php echo SURL?>assets/js/bootstrap-timepicker.min.js"></script> 
<script src="<?php echo SURL?>assets/js/bootstrap-colorpicker.min.js"></script> 
<script src="<?php echo SURL?>assets/js/daterangepicker/moment.min.js"></script> 
<script src="<?php echo SURL?>assets/js/daterangepicker/daterangepicker.js"></script> 
<script src="<?php echo SURL?>assets/js/jquery.multi-select.js"></script> 
<script src="<?php echo SURL?>assets/js/icheck/icheck.min.js"></script>