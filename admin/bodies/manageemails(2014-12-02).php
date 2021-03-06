<?php
$client_id = $_SESSION['lm_auth']['tbl_id'];

$qry_emails = "SELECT * FROM emails WHERE client_id='".$client_id."'"; 
$res_emails = $db->Execute($qry_emails);
$totalCountEmails =  $res_emails->RecordCount();

// Calculate graph
$saturday = strtotime("last saturday");
$saturday = date('w', $saturday)==date('w') ? $saturday+7*86400 : $saturday;
 
$friday = strtotime(date("Y-m-d",$saturday)." +6 days");
$this_week_sd = date("Y-m-d",$saturday);
$this_week_ed = date("Y-m-d",$friday);

$sql = "SELECT DAYNAME(atr.email_date) as dayname, count(*) as total
														FROM week_days wd
  														LEFT JOIN (
      														SELECT * FROM emails
      														WHERE
        													email_date >= '".$this_week_sd."' AND 
															email_date <= '".$this_week_ed."' AND
															client_id   = '".$client_id."'
    													) atr
    													ON wd.week_day_num = DAYOFWEEK(atr.email_date)
														GROUP BY
  														DAYOFWEEK(atr.email_date)";

$this_week_rec = $db->Execute($sql);
//echo "<pre>";
//print_r($this_week_rec);
$saturday = 0;
$sunday = 0;
$monday = 0;
$tuesday = 0;
$wednesday = 0;
$thursday = 0;
$friday = 0;

while(!$this_week_rec->EOF){

	$daynames = $this_week_rec->fields['dayname'];
	$totalemails = $this_week_rec->fields['total'];
	
	if($daynames=='Saturday'){
		$saturday = 	$this_week_rec->fields['total'];
	}
	if($daynames=='Sunday'){
		$sunday = 	$this_week_rec->fields['total'];
	}
	if($daynames=='Monday'){
		$monday = 	$this_week_rec->fields['total'];
	}
	if($daynames=='Tuesday'){
		$tuesday = 	$this_week_rec->fields['total'];
	}
	if($daynames=='Wednesday'){
		$wednesday = 	$this_week_rec->fields['total'];
	}
	if($daynames=='Thursday'){
		$thursday = 	$this_week_rec->fields['total'];
	}
	if($daynames=='Friday'){
		$friday = 	$this_week_rec->fields['total'];
	}
	
$this_week_rec->MoveNext();
}


// Average Emails per month
$sql_avg_month = "select monthname(email_date) email_date,count(*) as total_sum 
																		FROM emails WHERE client_id='".$client_id."'
																		GROUP BY monthname(email_date)";
$res_avg_month = $db->Execute($sql_avg_month);
$avg_total = $res_avg_month->recordCount();
$total_sum = 0;
while(!$res_avg_month->EOF){
	
	$total_sum+=$res_avg_month->fields['total_sum'];
$res_avg_month->MoveNext();
}
$total_avg_per_month = $total_sum/$avg_total;

$arr = array('Saturday'=>$saturday,
			 'Sunday'=>$sunday,
			 'Monday'=>$monday,
			 'Tuesday'=>$tuesday,
			 'Wednesday'=>$wednesday,
			 'Thursday'=>$thursday,
			 'Friday'=>$friday
			 );

$maxs = array_keys($arr, max($arr));


//Peak time
$sql_peak = "SELECT extract(hour from email_time) as hr,count(*)
														FROM emails WHERE client_id = '".$client_id."'
														GROUP BY extract(hour from email_time)
														ORDER BY count(*) DESC
														LIMIT 1";
$res_peak = $db->Execute($sql_peak);
$peak_time_f = $res_peak->fields['hr'];
$peak_time_t = $peak_time_f+1;
$peak_time_from =  timeInAmPmShort($peak_time_f);
$peak_time_to =  timeInAmPmShort($peak_time_t);

?>

<script type="text/javascript">
var noconf = jQuery.noConflict();
	function setSortVal(val){
		var sortCriterean = '';
		if(val=='Today'){
			sortCriterean = 'today';
			
			noconf("#chart8").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_thirty_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").show();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
				
		}else if(val=='Yesterday'){
			sortCriterean = 'yesterday';
			
			noconf("#chart8").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_thirty_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_yesreday_data").show();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
				
		}else if(val=='Last 7 Days'){
			sortCriterean = 'last_7_days';
			
			noconf("#chart8").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").show();
			noconf("#chart_thirty_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
				
		}else if(val=='Last 30 Days'){
			sortCriterean = 'last_30_days';	
			
			noconf("#chart8").hide();
			noconf("#chart18").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_thirty_data").show();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
			
		}else if(val=='This Month'){
			sortCriterean = 'this_month';
			
			noconf("#chart8").hide();
			noconf("#chart_seven_data").hide();
			noconf("#chart_last_month").hide();
			noconf("#chart_thirty_data").hide();
			noconf("#chart18").show();
			noconf("#chart_yesreday_data").hide();
			noconf("#chart_today_data").hide();
			noconf("#chart_custom_range").hide();
			noconf("#chart_life_time").hide();
				
		}else if(val=='Last Month'){
			sortCriterean = 'last_month';	
			
			noconf("#chart8").hide();
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
			
			noconf("#chart8").hide();
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
		  		data:{act:"prepareLifeTimeEmailsGraph",sortVal:sortCriterean},
		  		success: function (data) {
					noconf("#chart_life_time").html(data);	
		  		}
			});	
			
		}else{
			var first = document.getElementById("daterangepicker_start").value;
			var secon = document.getElementById("daterangepicker_end").value;
			sortCriterean = first+'#'+secon;
			
			noconf("#chart8").hide();
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
		  		data:{act:"prepareEmailsGraph",sortVal:sortCriterean},
		  		success: function (data) {
					noconf("#chart_custom_range").html(data);	
					
		  		}
			});	
			
		}
		
		noconf.ajax({	
		  url: "<?php echo SURL?>ajaxresponse/ajax.php",
		  type: "GET",
		  catche:"false",
		  data:{act:"doSelectedSortEmail",sortVal:sortCriterean},
		  success: function (data) {
			noconf("#sortResult").html(data);	
			
						
			var table = noconf("#table-4").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-6 col-left'l><'col-xs-6 col-right'<'export-data'T>f>r>t<'row'<'col-xs-6 col-left'i><'col-xs-6 col-right'p>>"
			
		});	 
			tableContainer = noconf("#table-1");
		
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
		
			noconf(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
			});
			
		  }
		});		
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
			Morris.Line({
				element: 'chart8',
				data: day_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Emails'],
				parseTime: false,
				lineColors: ['#242d3c']
			});
			
			
			Morris.Line({
				element: 'chart18',
				data: month_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Emails'],
				parseTime: false,
				lineColors: ['#242d3c']
			});
			
			
			Morris.Line({
				element: 'chart_last_month',
				data: last_month_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Emails'],
				parseTime: false,
				lineColors: ['#242d3c']
			});
			
			
			Morris.Line({
				element: 'chart_thirty_data',
				data: last_thirty_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Emails'],
				parseTime: false,
				lineColors: ['#242d3c']
			});
			
			Morris.Line({
				element: 'chart_seven_data',
				data: last_seven_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Emails'],
				parseTime: false,
				lineColors: ['#242d3c']
			});
			Morris.Line({
				element: 'chart_yesreday_data',
				data: last_yesterday_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Emails'],
				parseTime: false,
				lineColors: ['#242d3c']
			});
			
			Morris.Line({
				element: 'chart_today_data',
				data: today_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Emails'],
				parseTime: false,
				lineColors: ['#242d3c']
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
      <li> <a href="admin.php?act=manageemails"><i class="entypo-home"></i>Dashboard</a> </li>
      <li> <a href="#">Leads</a> </li>
      <li class="active"> <strong>Emails</strong> </li>
    </ol>
  </div>
  <div class="fr custom-btn"> <a href="javascript:;" onClick="jQuery('#modal-4').modal('show', {backdrop: 'static'});" class="btn btn-blue fr">Request A Call Now</a> </div>
  <form>
    <div class="col-sm-4 fr">
      <div class="daterange daterange-inline add-ranges" data-format="MMMM D, YYYY" data-start-date="September 16, 2014" data-end-date="September 22, 2014"> <i class="entypo-calendar"></i> <span>September 22, 2014 - <?php echo date('F d, Y', strtotime(date('Y-m-d')));?></span> </div>
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

<h2>Recent Emails</h2>
<br />
<div id="sortResult">
<table class="table table-bordered datatable" id="table-4">
  <thead>
    <tr>
      <th>Email No.</th>
      <th>From</th>
      <th>Time</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
  <?php
  if($totalCountEmails>0){
	  $i=0;
	  while(!$res_emails->EOF){
		$i++;
  ?>  
    <tr class="gradeA">
      <td><?php echo $i;?></td>
      <td><?php echo $res_emails->fields['from_email']?></td>
      <td><?php echo timeInAmPm($res_emails->fields['email_time']);?></td>
      <td><?php echo userdate($res_emails->fields['email_date']);?></td>
    </tr>
  <?php
  		$res_emails->MoveNext();
	  }
  }
  ?>
  </tbody>
  <tfoot>
    <tr>
      <th>Email No.</th>
      <th>From</th>
      <th>Time</th>
      <th>Date</th>
    </tr>
  </tfoot>
</table>
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
				{"elapsed": "Saturday", "value": <?php echo $saturday;?>},
				{"elapsed": "Sunday", "value": <?php echo $sunday;?>},
				{"elapsed": "Monday", "value": <?php echo $monday;?>},
				{"elapsed": "Tuesday", "value": <?php echo $tuesday;?>},
				{"elapsed": "Wednesday", "value": <?php echo $wednesday;?>},
				{"elapsed": "Thursday", "value": <?php echo $thursday;?>},
				{"elapsed": "Friday", "value": <?php echo $friday;?>}
			];
			
			
			
	var month_data = [
	<?php 
	$maxDays=date('t');
		for($i=1;$i<=$maxDays;$i++){ $dayName = date('Y-m-'.$i);
			
			$qry_emails_month = "SELECT count(*) as month_emails_total FROM emails WHERE email_date LIKE '%".$dayName."%' AND client_id='".$client_id."'"; 
			$res_emails_month = $db->Execute($qry_emails_month);
	?>
	
				{"elapsed": "<?php echo userdate($dayName);?>", "value": <?php echo $res_emails_month->fields['month_emails_total'];?>} <?php if($i<$maxDays){ echo ",";}?>
				
	<?php }?>
			];
			
	
	
	
	
	var last_month_data = [
	<?php 
		$maxDaysInLastMonth = date("t", mktime(0,0,0, date("n") - 1));
		$lastMonth = date("n") - 1;
		for($i=1;$i<=$maxDaysInLastMonth;$i++){ $dayName = date('Y-'.$lastMonth.'-'.$i);
			
			$qry_emails_month = "SELECT count(*) as month_emails_total FROM emails WHERE email_date LIKE '%".$dayName."%' AND client_id='".$client_id."'"; 
			$res_emails_month = $db->Execute($qry_emails_month);
	?>
	
				{"elapsed": "<?php echo userdate($dayName);?>", "value": <?php echo $res_emails_month->fields['month_emails_total'];?>} <?php if($i<$maxDaysInLastMonth){ echo ",";}?>
				
	<?php }?>
			];
			
			

var last_thirty_data = [
	<?php 
		$emails_date_from = date('Y-m-d',strtotime("-30 days"));
		$emails_date_to = date('Y-m-d');
		$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
		$i=0;
		foreach($arr_emails as $arr_email){
			$i++;
			$qry_emails_month = "SELECT count(*) as month_emails_total FROM emails WHERE email_date LIKE '%".$arr_email."%' AND client_id='".$client_id."'"; 
			$res_emails_month = $db->Execute($qry_emails_month);
	?>
	
				{"elapsed": "<?php echo userdate($arr_email);?>", "value": <?php echo $res_emails_month->fields['month_emails_total'];?>} <?php if($i<count($arr_emails)){ echo ",";}?>
				
	<?php }?>
			];
			
//console.log(last_thirty_data);
var last_seven_data = [
	<?php 
		$emails_date_from = date('Y-m-d',strtotime("-06 days"));
		$emails_date_to = date('Y-m-d');
		$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
		$i=0;
		foreach($arr_emails as $arr_email){
			$i++;
			$qry_emails_month = "SELECT count(*) as month_emails_total FROM emails WHERE email_date LIKE '%".$arr_email."%' AND client_id='".$client_id."'"; 
			$res_emails_month = $db->Execute($qry_emails_month);
	?>
	
				{"elapsed": "<?php echo userdate($arr_email);?>", "value": <?php echo $res_emails_month->fields['month_emails_total'];?>} <?php if($i<count($arr_emails)){ echo ",";}?>
				
	<?php }?>
			];
			
			
var last_yesterday_data = [
	<?php 
		$emails_date_from = date('Y-m-d',strtotime("-01 days"));
		$emails_date_to = date('Y-m-d');
		$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
		$i=0;
		foreach($arr_emails as $arr_email){
			$i++;
			$qry_emails_month = "SELECT count(*) as month_emails_total FROM emails WHERE email_date LIKE '%".$arr_email."%' AND client_id='".$client_id."'"; 
			$res_emails_month = $db->Execute($qry_emails_month);
	?>
	
				{"elapsed": "<?php echo userdate($arr_email);?>", "value": <?php echo $res_emails_month->fields['month_emails_total'];?>} <?php if($i<count($arr_emails)){ echo ",";}?>
				
	<?php }?>
			];
			
			
var today_data = [
	<?php 
		$emails_date_from = date('Y-m-d');
		$emails_date_to = date('Y-m-d');
		$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
		$i=0;
		foreach($arr_emails as $arr_email){
			$i++;
			$qry_emails_month = "SELECT count(*) as month_emails_total FROM emails WHERE email_date LIKE '%".$arr_email."%' AND client_id='".$client_id."'"; 
			$res_emails_month = $db->Execute($qry_emails_month);
	?>
	
				{"elapsed": "<?php echo userdate($arr_email);?>", "value": <?php echo $res_emails_month->fields['month_emails_total'];?>} <?php if($i<count($arr_emails)){ echo ",";}?>
				
	<?php }?>
			];	
			
</script>
<br />
<div class="row">
  <div class="col-lg-12">
    <h2 class="fl" style="margin-top:0px;">Email Stats</h2>
    <!--<div class="btn-group fr">
      <button type="button" class="btn btn-default">Day</button>
      <button type="button" class="btn btn-default active">Week</button>
      <button type="button" class="btn btn-default">Month</button>
    </div>-->
    <div class="btn-group fr">
    <button type="button" class="btn btn-default" id="dayBtn" onClick="showChart('daily')">Day</button>
    <button type="button" class="btn btn-default active " id="weekBtn" onClick="showChart('weekly')">Week</button>
    <button type="button" class="btn btn-default" id="monthBtn" onClick="showChart('monthly')">Month</button>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<br />
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td><strong>Line Chart</strong> <br />
              <div id="chart8" style="height: 300px"></div>
              <div id="chart18" style="height: 300px;"></div>
              <div id="chart_last_month" style="height: 300px;"></div>
              <div id="chart_thirty_data" style="height: 300px;"></div>
              <div id="chart_seven_data" style="height: 300px;"></div>
              <div id="chart_yesreday_data" style="height: 300px;"></div>
              <div id="chart_today_data" style="height: 300px;"></div>
              <div id="chart_custom_range" style="height: 300px;"></div>
              <div id="chart_life_time" style="height: 300px;"></div>
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
<div class="row">
  <div class="col-sm-4">
    <div class="tile-stats tile-aqua">
      <div class="icon"><i class="entypo-mail"></i></div>
      <div class="num"><?php echo ceil($total_avg_per_month);?> EMAILS</div>
      <h3>AVERAGE PER MONTH</h3>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="tile-stats tile-green">
      <div class="icon"><i class="entypo-calendar"></i></div>
      <div class="num"><?php echo strtoupper($maxs[0]);?></div>
      <h3>MOST ACTIVE DAY</h3>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="tile-stats tile-red">
      <div class="icon"><i class="entypo-clock"></i></div>
      <div class="num"><?php echo $peak_time_from." - ".$peak_time_to;?></div>
      <h3>PEAK TIME</h3>
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
		/*$("#chart18").hide();
		$("#chart_last_month").hide();
		$("#chart_thirty_data").hide();
		$("#chart_seven_data").hide();
		$("#chart_yesreday_data").hide();
		$("#chart_today_data").hide();
		$("#chart_custom_range").hide();
		$("#chart_life_time").hide();*/
		sortCriterean = 'lifetime';
			
			noconf("#chart8").hide();
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
		  		data:{act:"prepareLifeTimeEmailsGraph",sortVal:sortCriterean},
		  		success: function (data) {
					noconf("#chart_life_time").html(data);	
		  		}
			});	
		
	});
	
	function showChart(opt){
		var opt = opt
		if(opt=='daily'){
			$('.active').removeClass('active');
			$("#dayBtn").addClass("active");
			$("#chart18").hide();
			$("#chart_seven_data").hide();
			$("#chart_thirty_data").hide();
			$("#chart_last_month").hide();
			$("#chart_yesreday_data").hide();
			$("#chart_today_data").hide();
			$("#chart_custom_range").hide();
			$("#chart_life_time").hide();
			$("#chart8").show();
			$("#ch_title").html('Daily Calls Breakup');
		}
		if(opt=='weekly'){
		
			$('.active').removeClass('active');
			$("#weekBtn").addClass("active");
			$("#chart18").hide();
			$("#chart_thirty_data").hide();
			$("#chart_last_month").hide();
			$("#chart_yesreday_data").hide();
			$("#chart_today_data").hide();
			$("#chart_custom_range").hide();
			$("#chart_life_time").hide();
			$("#chart8").show();
			$("#ch_title").html('Weekly Calls Breakup');
		}
		if(opt=='monthly'){
		
			$('.active').removeClass('active');
			$("#monthBtn").addClass("active");
			$("#chart8").hide();
			$("#chart_seven_data").hide();
			$("#chart_thirty_data").hide();
			$("#chart_last_month").hide();
			$("#chart_yesreday_data").hide();
			$("#chart_today_data").hide();
			$("#chart_custom_range").hide();
			$("#chart_life_time").hide();
			$("#chart18").show();
			$("#ch_title").html('Monthly Calls Breakup');
		}
	}
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
