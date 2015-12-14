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
		;(function($, window, undefined)
{
	"use strict";
	
	$(document).ready(function()
	{
		
		// Rickshaw Graphs
		if(typeof Rickshaw != 'undefined')
		{
			// Graph 1
			var graph = new Rickshaw.Graph( {
					element: document.querySelector("#chart1"),
					renderer: 'area',
					stroke: true,
					height: 120,
					series: [ {
							data: [ { x: 0, y: 40 }, { x: 1, y: 49 }, {x: 2, y: 33}, {x: 3, y: 57}, {x: 4, y: 68} ],
							color: 'steelblue'
					}, {	
							data: [ { x: 0, y: 40 }, { x: 1, y: 49 }, {x: 2, y: 6}, {x: 3, y: 13}, {x: 4, y: 19} ],
							color: 'lightblue'
					} ]					 
			} );
				 
			graph.render();
		
		
			// Graph 2		
			var seriesData = [ [], [], [], [], [], [], [], [], [] ];
			var random = new Rickshaw.Fixtures.RandomData(150);
			
			for (var i = 0; i < 100; i++) {
				random.addData(seriesData);
			}
			
			var palette = new Rickshaw.Color.Palette( { scheme: 'classic9' } );
			
			
			var graph = new Rickshaw.Graph( {
				element: document.getElementById("chart2"),
				height: 120,
				renderer: 'area',
				stroke: true,
				preserve: true,
				series: [
					{
						color: palette.color(),
						data: seriesData[0],
						name: 'Moscow'
					}, {
						color: palette.color(),
						data: seriesData[1],
						name: 'Shanghai'
					}, {
						color: palette.color(),
						data: seriesData[2],
						name: 'Amsterdam'
					}, {
						color: palette.color(),
						data: seriesData[3],
						name: 'Paris'
					}, {
						color: palette.color(),
						data: seriesData[4],
						name: 'Tokyo'
					}, {
						color: palette.color(),
						data: seriesData[5],
						name: 'London'
					}, {
						color: palette.color(),
						data: seriesData[6],
						name: 'New York'
					}
				]
			} );
			
			graph.render();
		}
		
	
		// Morris.js Graphs
		if(typeof Morris != 'undefined')
		{
			// Bar Charts
			Morris.Bar({
				element: 'chart3',
				axes: true,
				data: [
					{x: '2013 Q1', y: getRandomInt(1,10), z: getRandomInt(1,10), a: getRandomInt(1,10)},
					{x: '2013 Q2', y: getRandomInt(1,10), z: getRandomInt(1,10), a: getRandomInt(1,10)},
					{x: '2013 Q3', y: getRandomInt(1,10), z: getRandomInt(1,10), a: getRandomInt(1,10)},
					{x: '2013 Q4', y: getRandomInt(1,10), z: getRandomInt(1,10), a: getRandomInt(1,10)}
				],
				xkey: 'x',
				ykeys: ['y', 'z', 'a'],
				labels: ['Facebook', 'LinkedIn', 'Google+'],
				barColors: ['#707f9b', '#455064', '#242d3c']
			});
			
			// Stacked Bar Charts
			Morris.Bar({
				element: 'chart4',
				data: [
					{x: '2013 Q1', y: getRandomInt(1,10), z: getRandomInt(1,20), a: getRandomInt(1,20)},
					{x: '2013 Q2', y: getRandomInt(1,11), z: getRandomInt(1,10), a: getRandomInt(1,14)},
					{x: '2013 Q3', y: getRandomInt(1,20), z: getRandomInt(1,20), a: getRandomInt(1,19)},
					{x: '2013 Q4', y: getRandomInt(1,15), z: getRandomInt(1,15), a: getRandomInt(1,11)}
				],
				xkey: 'x',
				ykeys: ['y', 'z', 'a'],
				labels: ['Facebook', 'LinkedIn', 'Google+'],
				stacked: true,
				barColors: ['#ffaaab', '#ff6264', '#d13c3e']
			});
			
			// Donut
			Morris.Donut({
				element: 'chart5',
				data: [
					{label: "Download Sales", value: getRandomInt(10,50)},
					{label: "In-Store Sales", value: getRandomInt(10,50)},
					{label: "Mail-Order Sales", value: getRandomInt(10,50)}
				],
				colors: ['#707f9b', '#455064', '#242d3c']
			});
			
			// Donut Colors
			Morris.Donut({
				element: 'chart6',
				data: [
					{label: "Games", value: getRandomInt(10,50)},
					{label: "Photos", value: getRandomInt(10,50)},
					{label: "Apps", value: getRandomInt(10,50)},
					{label: "Other", value: getRandomInt(10,50)},
				],
				labelColor: '#303641',
				colors: ['#f26c4f', '#00a651', '#00bff3', '#0072bc']
			});
			
			// Donut Formatting
			Morris.Donut({
				element: 'chart7',
				data: [
					{value: 70, label: 'foo', formatted: 'at least 70%' },
					{value: 15, label: 'bar', formatted: 'approx. 15%' },
					{value: 10, label: 'baz', formatted: 'approx. 10%' },
					{value: 5, label: 'A really really long label', formatted: 'at most 5%' }
				],
				formatter: function (x, data) { return data.formatted; },
				colors: ['#b92527', '#d13c3e', '#ff6264', '#ffaaab']
			});
			
			
			// Line Chart
			/*var day_data = [
				{"elapsed": "Saturday", "value": 10},
				{"elapsed": "Sunday", "value": 16},
				{"elapsed": "Monday", "value": 24},
				{"elapsed": "Tuesday", "value": 32},
				{"elapsed": "Wednesday", "value": 26},
				{"elapsed": "Thursday", "value": 22},
				{"elapsed": "Friday", "value": 25}
			];
			*/
			Morris.Line({
				element: 'chart8',
				data: day_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Calls'],
				parseTime: false,
				lineColors: ['#242d3c']
			});
			
			
			
			// Goals
			var decimal_data = [];
			
			for (var x = 0; x <= 360; x += 10) {
				decimal_data.push({
				x: x,
				y: Math.sin(Math.PI * x / 180).toFixed(4)
				});
			}
			
			Morris.Line({
				element: 'chart9',
				data: decimal_data,
				xkey: 'x',
				ykeys: ['y'],
				labels: ['sin(x)'],
				parseTime: false,
				goals: [-1, 0, 1],
				lineColors: ['#d13c3e']
			});
		
			
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
		}
		
		
		// Peity Graphs
		if($.isFunction($.fn.peity))
		{
			$("span.pie").peity("pie", {colours: ['#0e8bcb', '#57b400'], width: 150, height: 25});
			$(".panel span.line").peity("line", {width: 150});
			$("span.bar").peity("bar", {width: 150});
			
			var updatingChart = $(".updating-chart").peity("line", { width: 150 })

			setInterval(function() 
			{
				var random = Math.round(Math.random() * 10);
				var values = updatingChart.text().split(",");
				
				values.shift()
				values.push(random);
				
				updatingChart.text(values.join(",")).change();
				$("#peity-right-now").text(random + ' user' + (random != 1 ? 's' : ''));
				
			}, 1000)
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
              <div id="chart10" style="height: 300px"></div></td>
            <td style="display:none;"><strong>Line Chart</strong> <br />
              <div id="chart8" style="height: 300px"></div></td>
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
