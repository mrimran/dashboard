<?php
$qry_roi = "SELECT * FROM roi"; 
$res_roi = $db->Execute($qry_roi);
$totalCountRoi =  $res_roi->RecordCount();

// Projected ROI
$qry_roi_proj = "SELECT avg_sale_revenue FROM roi LIMIT 0,10"; 
$res_roi_proj = $db->Execute($qry_roi_proj);

$total_avg_sale_revenue='';
 while(!$res_roi_proj->EOF){
	$total_avg_sale_revenue+=$res_roi_proj->fields['avg_sale_revenue'];
 $res_roi_proj->MoveNext();
 }
// Lifetime ROI
$qry_roi_lifetime = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi"; 
$res_roi_lifetime = $db->Execute($qry_roi_lifetime);

//Graph
$currentYear = date('Y');
$firstYear = $currentYear-1;
$secondYear = $currentYear-2;
$thirdYear = $currentYear-3;
$fourthYear = $currentYear-4;
$fifthYear = $currentYear-5;
$sixthYear = $currentYear-6;

// Current Year ROI
$qry_currentYear_roi = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$currentYear."%'"; 
$res_currentYear_roi = $db->Execute($qry_currentYear_roi);
$totalcountcurrentYearRoi =  $res_currentYear_roi->fields['total_lifetime'];

// First Year Calls
$qry_firstYear_roi = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$firstYear."%'"; 
$res_firstYear_roi = $db->Execute($qry_firstYear_roi);
$totalcountfirstYearRoi =  $res_firstYear_roi->fields['total_lifetime'];

// Second Year Calls
$qry_secondYear_roi = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$secondYear."%'"; 
$res_secondYear_roi = $db->Execute($qry_secondYear_roi);
$totalcountsecondYearRoi =  $res_secondYear_roi->fields['total_lifetime'];

// Third Year Calls
$qry_thirdYear_roi = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$thirdYear."%'"; 
$res_thirdYear_roi = $db->Execute($qry_thirdYear_roi);
$totalcountthirdYearRoi =  $res_thirdYear_roi->fields['total_lifetime'];

// Fourth Year Calls
$qry_fourthYear_roi = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$fourthYear."%'"; 
$res_fourthYear_roi = $db->Execute($qry_fourthYear_roi);
$totalcountfourthYearRoi =  $res_fourthYear_roi->fields['total_lifetime'];

// Fifth Year Calls
$qry_fifthYear_roi = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$fifthYear."%'"; 
$res_fifthYear_roi = $db->Execute($qry_fifthYear_roi);
$totalcountfifthYearRoi =  $res_fifthYear_roi->fields['total_lifetime'];

// Sixth Year Calls
$qry_sixthYear_roi = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$sixthYear."%'"; 
$res_sixthYear_roi = $db->Execute($qry_sixthYear_roi);
$totalcountsixthYearRoi =  $res_sixthYear_roi->fields['total_lifetime'];
?>


<script type="text/javascript">
var noconf = jQuery.noConflict();

	function setSortVal(val){
		
		if(val=='Today'){
			
			noconf("#chart10").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_thirty_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").show();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
				
		}else if(val=='Yesterday'){
			
			noconf("#chart10").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_thirty_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_yesreday_data").show();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
				
		}else if(val=='Last 7 Days'){
			
			noconf("#chart10").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").show();
			noconf("#chart_thirty_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
				
		}else if(val=='Last 30 Days'){
			
			noconf("#chart10").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_thirty_data").show();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
			
		}else if(val=='This Month'){
			
			noconf("#chart10").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_thirty_data").hide();
			noconf("#chart18").show();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
				
		}else if(val=='Last Month'){	
			
			noconf("#chart10").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_thirty_data").hide();
			noconf("#chart_last_month").show();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
			
		}else if(val=='Lifetime'){
			
			sortCriterean = 'lifetime';
			
			noconf("#chart10").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_thirty_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").show();
			
			noconf.ajax({	
		  		url: "<?php echo SURL?>ajaxresponse/ajax.php",
		  		type: "GET",
		  		catche:"false",
		  		data:{act:"prepareLifeTimeRoiGraph",sortVal:sortCriterean},
		  		success: function (data) {
					noconf("#chart_life_time").html(data);	
		  		}
			});	
			
		}else{
			var first = document.getElementById("daterangepicker_start").value;
			var secon = document.getElementById("daterangepicker_end").value;
			sortCriterean = first+'#'+secon;
			
			noconf("#chart10").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_thirty_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_life_time").hide();
			noconf("#chart_custom_range").show();
			
			noconf.ajax({	
		  		url: "<?php echo SURL?>ajaxresponse/ajax.php",
		  		type: "GET",
		  		catche:"false",
		  		data:{act:"prepareRoiGraph",sortVal:sortCriterean},
		  		success: function (data) {
					noconf("#chart_custom_range").html(data);	
					
		  		}
			});	
			
		}
				
	}
</script>



<script type="text/javascript">
		;(function($, window, undefined)
{
	"use strict";
	
	$(document).ready(function()
	{	
	
		// Morris.js Graphs
		if(typeof Morris != 'undefined')
		{	
			// Area Chart
			Morris.Area({
				element: 'chart10',
				data: [
					{ y: '<?php echo $firstYear?>', a: <?php echo $totalcountfirstYearRoi?>},
					{ y: '<?php echo $secondYear?>', a: <?php echo $totalcountsecondYearRoi?> },
					{ y: '<?php echo $thirdYear?>', a: <?php echo $totalcountthirdYearRoi?> },
					{ y: '<?php echo $fourthYear?>', a: <?php echo $totalcountfourthYearRoi?> },
					{ y: '<?php echo $fifthYear?>', a: <?php echo $totalcountfifthYearRoi?> },
					{ y: '<?php echo $sixthYear?>', a: <?php echo $totalcountsixthYearRoi?> },
					{ y: '<?php echo $currentYear?>', a: <?php echo $totalcountcurrentYearRoi?> }
				],
				xkey: 'y',
				ykeys: ['a'],
				labels: ['ROI']
			});
			
			
			Morris.Area({
				element: 'chart18',
				data: [
				
				<?php 
					$maxDays=date('t');
					$roi_total=0;
					for($i=1;$i<=$maxDays;$i++){ $dayName = date('Y-m-'.$i);
			
						$qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$dayName."%'"; 
						$res_roi_month = $db->Execute($qry_roi_month);
						$roi_total = $res_roi_month->fields['total_lifetime'];
						if($roi_total==''){
							$roi_total=0;
						}
					?>
					{ y: '<?php echo $dayName;?>', a: <?php echo $roi_total;?>}<?php if($i<$maxDays){ echo ",";}?>
				
					<?php }?>
				],
				xkey: 'y',
				ykeys: ['a'],
				labels: ['ROI']
			});
			
			
			
			Morris.Area({
				element: 'chart_last_month',
				data: [
				
				<?php 
					$maxDaysInLastMonth = date("t", mktime(0,0,0, date("n") - 1));
					$lastMonth = date("n") - 1;
					for($i=1;$i<=$maxDaysInLastMonth;$i++){ $dayName = date('Y-'.$lastMonth.'-'.$i);
			
						$qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$dayName."%'"; 
						$res_roi_month = $db->Execute($qry_roi_month);
						$roi_total = $res_roi_month->fields['total_lifetime'];
						if($roi_total==''){
							$roi_total=0;
						}
					?>
					{ y: '<?php echo $dayName;?>', a: <?php echo $roi_total;?>}<?php if($i<$maxDaysInLastMonth){ echo ",";}?>
				
					<?php }?>
				],
				xkey: 'y',
				ykeys: ['a'],
				labels: ['ROI']
			});
			
			Morris.Area({
				element: 'chart_thirty_data',
				data: [
				
				<?php 
					$emails_date_from = date('Y-m-d',strtotime("-30 days"));
					$emails_date_to = date('Y-m-d');
					$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
					$i=0;
					foreach($arr_emails as $arr_email){
						$i++;
			
						$qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$arr_email."%'"; 
						$res_roi_month = $db->Execute($qry_roi_month);
						$roi_total = $res_roi_month->fields['total_lifetime'];
						if($roi_total==''){
							$roi_total=0;
						}
					?>
					{ y: '<?php echo $arr_email;?>', a: <?php echo $roi_total;?>}<?php if($i<count($arr_emails)){ echo ",";}?>
				
					<?php }?>
				],
				xkey: 'y',
				ykeys: ['a'],
				labels: ['ROI']
			});
			
			
			Morris.Area({
				element: 'chart_seven_data',
				data: [
				
				<?php 
					$emails_date_from = date('Y-m-d',strtotime("-06 days"));
					$emails_date_to = date('Y-m-d');
					$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
					$i=0;
					foreach($arr_emails as $arr_email){
						$i++;
			
						$qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$arr_email."%'"; 
						$res_roi_month = $db->Execute($qry_roi_month);
						$roi_total = $res_roi_month->fields['total_lifetime'];
						if($roi_total==''){
							$roi_total=0;
						}
					?>
					{ y: '<?php echo $arr_email;?>', a: <?php echo $roi_total;?>}<?php if($i<count($arr_emails)){ echo ",";}?>
				
					<?php }?>
				],
				xkey: 'y',
				ykeys: ['a'],
				labels: ['ROI']
			});
			
			Morris.Area({
				element: 'chart_yesreday_data',
				data: [
				
				<?php 
					$emails_date_from = date('Y-m-d',strtotime("-01 days"));
					$emails_date_to = date('Y-m-d');
					$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
					$i=0;
					foreach($arr_emails as $arr_email){
						$i++;
			
						$qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$arr_email."%'"; 
						$res_roi_month = $db->Execute($qry_roi_month);
						$roi_total = $res_roi_month->fields['total_lifetime'];
						if($roi_total==''){
							$roi_total=0;
						}
					?>
					{ y: '<?php echo $arr_email;?>', a: <?php echo $roi_total;?>}<?php if($i<count($arr_emails)){ echo ",";}?>
				
					<?php }?>
				],
				xkey: 'y',
				ykeys: ['a'],
				labels: ['ROI']
			});
			
			Morris.Area({
				element: 'chart_today_data',
				data: [
				
				<?php 
					$emails_date_from = date('Y-m-d');
					$emails_date_to = date('Y-m-d');
					$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
					$i=0;
					foreach($arr_emails as $arr_email){
						$i++;
			
						$qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$arr_email."%'"; 
						$res_roi_month = $db->Execute($qry_roi_month);
						$roi_total = $res_roi_month->fields['total_lifetime'];
						if($roi_total==''){
							$roi_total=0;
						}
					?>
					{ y: '<?php echo $arr_email;?>', a: <?php echo $roi_total;?>}<?php if($i<count($arr_emails)){ echo ",";}?>
				
					<?php }?>
				],
				xkey: 'y',
				ykeys: ['a'],
				labels: ['ROI']
			});
			
		}
		
	});
	
})(jQuery, window);

			
function data(offset) {
	var ret = [];
	for (var x = 0; x <= 360; x += 10) {
		var v = (offset + x) % 360;
		ret.push({
			x: x,
			y: Math.sin(Math.PI * v / 180).toFixed(4),
			z: Math.cos(Math.PI * v / 180).toFixed(4),
		});
	}
	return ret;
}
 
 
function getRandomInt(min, max) 
{
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
</script>
<div class="row">
  <div class="col-sm-4">
    <ol class="breadcrumb bc-3">
      <li> <a href="admin.php?act=manageroi"><i class="entypo-home"></i>Dashboard</a> </li>
      <li> <a href="#">Leads</a> </li>
      <li class="active"> <strong>ROI</strong> </li>
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
<div class="row">
  <div class="col-sm-6">
    <div class="tile-stats tile-green">
      <div class="icon"><i class="entypo-suitcase"></i></div>
      <h3>PROJECTD ROI</h3>
      <div class="num"><?php echo number_format($total_avg_sale_revenue,2);?> <small style="font-size:18px;">AED</small></div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="tile-stats tile-aqua">
      <div class="icon"><i class="entypo-suitcase"></i></div>
      <h3>LIFETIME</h3>
      <div class="num"><?php echo number_format($res_roi_lifetime->fields['total_lifetime'],2);?> <small style="font-size:18px;">AED</small></div>
    </div>
  </div>
</div>
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
		
		
		
		var day_data = [
				{"elapsed": "Saturday", "value": 10},
				{"elapsed": "Sunday", "value": 16},
				{"elapsed": "Monday", "value": 24},
				{"elapsed": "Tuesday", "value": 32},
				{"elapsed": "Wednesday", "value": 26},
				{"elapsed": "Thursday", "value": 22},
				{"elapsed": "Friday", "value": 25}
			];
		
		

</script>
<br />
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td><strong>Projected ROI Breakup</strong> <br />
              <div id="chart10" style="height: 300px"></div>
              <div id="chart18" style="height: 300px;"></div>
              <div id="chart_last_month" style="height: 300px;"></div>
              <div id="chart_thirty_data" style="height: 300px;"></div>
              <div id="chart_seven_data" style="height: 300px;"></div>
              <div id="chart_yesreday_data" style="height: 300px;"></div>
              <div id="chart_today_data" style="height: 300px;"></div>
              <div id="chart_custom_range" style="height: 300px;"></div>
              <div id="chart_life_time" style="height: 300px;"></div>
              </td>
            <td style="display:none;"><strong>Line Chart</strong> <br />
              <div id="chart8" style="height: 300px"></div>
              
              </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered" style="display:none;">
        <tbody>
          <tr>
            <td width="50%"><strong>Bar Charts</strong> <br />
              <div id="chart3" style="height: 250px"></div></td>
            <td><strong>Bars Stacked</strong> <br />
              <div id="chart4" style="height: 250px"></div></td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered" style="display:none;">
        <tbody>
          <tr>
            <td width="33%"><strong>Donut Charts</strong> <br />
              <div id="chart5" style="height: 250px"></div></td>
            <td width="33%"><strong>Colored</strong> <br />
              <div id="chart6" style="height: 250px"></div></td>
            <td width="33%"><strong>Formatted</strong> <br />
              <div id="chart7" style="height: 250px"></div></td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered" style="display:none;">
        <tbody>
          <tr>
            <td><strong>Line Chart</strong> <br />
              <div id="chart9" style="height: 300px"></div></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<br />
<hr />
<br />
<div class="row">
  <div class="viral-links">
    <h1>We Are Sure That You're Happy With Our Service</h1>
    <a href="javascript:;" onClick="jQuery('#modal-1').modal('show');" class="green-btn"><i class="fa fa-thumbs-up"></i>Recommend Us</a> <a href="javascript:;" onClick="jQuery('#modal-6').modal('show', {backdrop: 'static'});" class="blue-btn"><i class="fa fa-share-square"></i>Share This Report</a> </div>
</div>
<br />

<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$("#chart18").hide();
		$("#chart_last_month").hide();
		$("#chart_thirty_data").hide();
		$("#chart_seven_data").hide();
		$("#chart_yesreday_data").hide();
		$("#chart_today_data").hide();
		$("#chart_custom_range").hide();
		$("#chart_life_time").hide();
		
	});
</script>
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
<script src="<?php echo SURL?>assets/js/raphael-min.js"></script>
<script src="<?php echo SURL?>assets/js/morris.min.js"></script>
<script src="<?php echo SURL?>assets/js/jquery.peity.min.js"></script>
<script src="<?php echo SURL?>assets/js/neon-charts.js"></script>
<script src="<?php echo SURL?>assets/js/jquery.sparkline.min.js"></script>
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
