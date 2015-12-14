<?php 
include('../../adodb/adodb.inc.php');
include('../../include/siteconfig.inc.php');
include('../../include/sitefunction.php');
include('../script_include.php');
$db = ADONewConnection('mysql');
$db->Connect(DBHOST,DBUSER,DBPASS,DBNAME) or die("Database not found! please install your application properly");
	
if(isset($_GET['act'])){
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//****************************************************************** Calls Section ****************************************************//
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////
	//*********Calls Listing*********//
	//////////////////////////////////
	
	if($_GET['act']=='doSelectedSort'){
	
		$sortVal = $_GET['sortVal'];
		$where = '';
		if($sortVal=='today'){
			
			$calls_date = date('Y-m-d');
			$where.= " call_start LIKE '%".$calls_date."%'";
			
		}elseif($sortVal=='yesterday'){
			
			$calls_date = date('Y-m-d',strtotime("-1 days"));
			$where.= " call_start LIKE '%".$calls_date."%'";
			
		}elseif($sortVal=='last_7_days'){
			
			$calls_date_from = date('Y-m-d',strtotime("-7 days"));
			$calls_date_to = date('Y-m-d');
			$where.= " call_start > '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
			
		}elseif($sortVal=='last_30_days'){
			
			$calls_date_from = date('Y-m-d',strtotime("-30 days"));
			$calls_date_to = date('Y-m-d');
			$where.= " call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
			
		}elseif($sortVal=='this_month'){
			
			$calls_date_from = date('Y-m-01'); // hard-coded '01' for first day
			$calls_date_to  = date('Y-m-t');
			$where.= " call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
			
		}elseif($sortVal=='last_month'){
			
			$calls_date_from = date("Y-n-j", strtotime("first day of previous month"));
			$calls_date_to  = date("Y-n-j", strtotime("last day of previous month"));
			$where.= " call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
			
		}elseif($sortVal=='lifetime'){
			
			$where.= "lifetimecalls";
			
		}else{
			
			$sort_arr = explode("#",$sortVal);
			$timestamp_from = strtotime($sort_arr[0]);
			$calls_date_from = date("Y-m-d", $timestamp_from);	
			$timestamp_to = strtotime($sort_arr[1]);
			$calls_date_to = date("Y-m-d", $timestamp_to);
			
			$where.= " call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
		}
		
		if($where =='lifetimecalls'){
			$qry_calls = "SELECT * FROM calls"; 
			$res_calls = $db->Execute($qry_calls);
		}else{
			$qry_calls = "SELECT * FROM calls WHERE ".$where; 
			$res_calls = $db->Execute($qry_calls);	
		}
		$totalcountCalls =  $res_calls->RecordCount();
		
		?>

            <table class="table table-bordered datatable" id="table-4">
              <thead>
                <tr>
                  <th>Sr.</th>
                  <th>Numbers</th>
                  <th>Time</th>
                  <th>Duration</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
 
			  <?php
              if($totalcountCalls>0){
                  $i=0;
                  $totalDuration=0;
                  while(!$res_calls->EOF){
                    $i++;
                    
                    $call_start = new DateTime($res_calls->fields['call_start']);
                    $call_end = new DateTime($res_calls->fields['call_end']);
                    $totalDuration+= date_diff($call_start,$call_end);
                    
              ?>
                    <tr class="even gradeA">
                      <td><?php echo $i;?></td>
                      <td><?php echo $res_calls->fields['callerid'];?></td>
                      <td><?php echo timeInAmPm($res_calls->fields['call_start']);?></td>
                      <td><?php echo timeDifferance($res_calls->fields['call_start'],$res_calls->fields['call_end']);?></td>
                      <td><?php echo userdate($res_calls->fields['call_start']);?></td>
                    </tr>
                
                <?php
                    $res_calls->MoveNext();
                  }
              }
                ?>

          </tbody>
          <tfoot>
            <tr>
              <th>Sr.</th>
              <th>Numbers</th>
              <th>Time</th>
              <th>Duration</th>
              <th>Date</th>
            </tr>
            
          </tfoot>
        </table>

        <?php
		
	}
	
	
	////////////////////////////////////
	//******Custom range Calls*******//
	//////////////////////////////////
	
	if($_GET['act']=='prepareCallsGraph'){
	
		$sortVal = $_GET['sortVal'];
		$where = '';
			
		$sort_arr = explode("#",$sortVal);
		$timestamp_from = strtotime($sort_arr[0]);
		$calls_date_from = date("Y-m-d", $timestamp_from);	
		$timestamp_to = strtotime($sort_arr[1]);
		$calls_date_to = date("Y-m-d", $timestamp_to);
			
		$where.= " call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
		
		$qry_calls = "SELECT * FROM calls WHERE ".$where; 
		$res_calls = $db->Execute($qry_calls);
		$totalcountCalls =  $res_calls->RecordCount();
		
		?>
<script type="text/javascript">
$.noConflict();
            (function($, window, undefined)
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
			];*/
			
			Morris.Line({
				element: 'chart_custom_range',
				data: custom_range_data,
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
					{ y: '2006', a: getRandomInt(10,100), b: getRandomInt(10,100) },
					{ y: '2007', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2008', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2009', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2010', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2011', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2012', a: getRandomInt(10,100), b: getRandomInt(10,100) }
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Series A', 'Series B']
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


var custom_range_data = [
	<?php 
		$arr_calls = createDateRangeArray($calls_date_from,$calls_date_to);
		$i=0;
		foreach($arr_calls as $arr_call){
			$i++;
			$qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%".$arr_call."%'"; 
			$res_calls_month = $db->Execute($qry_calls_month);
	?>
	
				{"elapsed": "<?php echo userdate($arr_call);?>", "value": <?php echo $res_calls_month->fields['month_calls_total'];?>} <?php if($i<count($arr_calls)){ echo ",";}?>
				
	<?php }?>
			];
			
</script>
<div id="chart_custom_range"></div>
        <?php
		
	}
	
	
	////////////////////////////////////
	//********Lifetime Calls*********//
	//////////////////////////////////
	
	if($_GET['act']=='prepareLifeTimeCallsGraph'){
	
		$qry_calls_graph = "SELECT * FROM calls order by id asc limit 1";
		$res_calls_graph = $db->Execute($qry_calls_graph);
		$totalcountCallsGraph =  $res_calls_graph->RecordCount();
		
		?>
<script type="text/javascript">
$.noConflict();
            (function($, window, undefined)
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
			];*/
			
			Morris.Line({
				element: 'chart_life_time',
				data: life_time_data,
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
					{ y: '2006', a: getRandomInt(10,100), b: getRandomInt(10,100) },
					{ y: '2007', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2008', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2009', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2010', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2011', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2012', a: getRandomInt(10,100), b: getRandomInt(10,100) }
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Series A', 'Series B']
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


var life_time_data = [
	<?php 
		$calls_date_from = $res_calls_graph->fields['call_start'];
		$calls_date_to = date('Y-m-d');
		$arr_calls = createDateRangeArray($calls_date_from,$calls_date_to);
		$i=0;
		foreach($arr_calls as $arr_call){
			$i++;
			$qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%".$arr_call."%'"; 
			$res_calls_month = $db->Execute($qry_calls_month);
	?>
	
				{"elapsed": "<?php echo userdate($arr_call);?>", "value": <?php echo $res_calls_month->fields['month_calls_total'];?>} <?php if($i<count($arr_calls)){ echo ",";}?>
				
	<?php }?>
			];
			
			
</script>
<div id="chart_life_time"></div>
        <?php
		
	}
	
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//****************************************************************** Emails Section ***************************************************//
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	////////////////////////////////////
	//*********Emails Listing********//
	//////////////////////////////////
	
	if($_GET['act']=='doSelectedSortEmail'){
	
		$sortVal = $_GET['sortVal'];
		$where = '';
		if($sortVal=='today'){
			
			$emails_date = date('Y-m-d');
			$where.= " email_date LIKE '%".$emails_date."%'";
			
		}elseif($sortVal=='yesterday'){
			
			$emails_date = date('Y-m-d',strtotime("-1 days"));
			$where.= " email_date LIKE '%".$emails_date."%'";
			
		}elseif($sortVal=='last_7_days'){
			
			$emails_date_from = date('Y-m-d',strtotime("-7 days"));
			$emails_date_to = date('Y-m-d');
			$where.= " email_date > '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
			
		}elseif($sortVal=='last_30_days'){
			
			$emails_date_from = date('Y-m-d',strtotime("-30 days"));
			$emails_date_to = date('Y-m-d');
			$where.= " email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
			
		}elseif($sortVal=='this_month'){
			
			$emails_date_from = date('Y-m-01'); // hard-coded '01' for first day
			$emails_date_to  = date('Y-m-t');
			$where.= " email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
			
		}elseif($sortVal=='last_month'){
			
			$emails_date_from = date("Y-n-j", strtotime("first day of previous month"));
			$emails_date_to  = date("Y-n-j", strtotime("last day of previous month"));
			$where.= " email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
			
		}elseif($sortVal=='lifetime'){
			
			$where.= "lifetimeemails";
			
		}else{
			
			$sort_arr = explode("#",$sortVal);
			$timestamp_from = strtotime($sort_arr[0]);
			$emails_date_from = date("Y-m-d", $timestamp_from);	
			$timestamp_to = strtotime($sort_arr[1]);
			$emails_date_to = date("Y-m-d", $timestamp_to);
			
			$where.= " email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
		}
		if($where =='lifetimeemails'){
			$qry_emails = "SELECT * FROM emails"; 
			$res_emails = $db->Execute($qry_emails);
		}else{
			$qry_emails = "SELECT * FROM emails WHERE ".$where; 
			$res_emails = $db->Execute($qry_emails);
		}
		$totalCountEmails =  $res_emails->RecordCount();
		
		?>

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

        <?php
		
	}
	
	
	////////////////////////////////////
	//*****Custom range Emails*******//
	//////////////////////////////////
	
	if($_GET['act']=='prepareEmailsGraph'){
	
		$sortVal = $_GET['sortVal'];
		$where = '';
			
		$sort_arr = explode("#",$sortVal);
		$timestamp_from = strtotime($sort_arr[0]);
		$emails_date_from = date("Y-m-d", $timestamp_from);	
		$timestamp_to = strtotime($sort_arr[1]);
		$emails_date_to = date("Y-m-d", $timestamp_to);
			
		$where.= " email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
		
		$qry_emails = "SELECT * FROM emails WHERE ".$where; 
		$res_emails = $db->Execute($qry_emails);
		$totalcountEmails =  $res_emails->RecordCount();
		
		?>
<script type="text/javascript">
var $ = jQuery.noConflict();
            (function($, window, undefined)
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
			];*/
			
			Morris.Line({
				element: 'chart_custom_range',
				data: custom_range_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Emails'],
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
					{ y: '2006', a: getRandomInt(10,100), b: getRandomInt(10,100) },
					{ y: '2007', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2008', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2009', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2010', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2011', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2012', a: getRandomInt(10,100), b: getRandomInt(10,100) }
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Series A', 'Series B']
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


var custom_range_data = [
	<?php 
		$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
		$i=0;
		foreach($arr_emails as $arr_email){
			$i++;
			$qry_emails_month = "SELECT count(*) as month_emails_total FROM emails WHERE email_date LIKE '%".$arr_email."%'"; 
			$res_emails_month = $db->Execute($qry_emails_month);
	?>
	
				{"elapsed": "<?php echo userdate($arr_email);?>", "value": <?php echo $res_emails_month->fields['month_emails_total'];?>} <?php if($i<count($arr_emails)){ echo ",";}?>
				
	<?php }?>
			];
			
</script>
<div id="chart_custom_range"></div>
        <?php
		
	}
	
	
	////////////////////////////////////
	//*******Life time Emails********//
	//////////////////////////////////
	
	if($_GET['act']=='prepareLifeTimeEmailsGraph'){
	
		$qry_emails_graph = "SELECT * FROM emails order by id asc limit 1";
		$res_emails_graph = $db->Execute($qry_emails_graph);
		$totalcountEmailsGraph =  $res_emails_graph->RecordCount();
		
		?>
<script type="text/javascript">
var $ = jQuery.noConflict();
            (function($, window, undefined)
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
			];*/
			
			Morris.Line({
				element: 'chart_life_time',
				data: life_time_data,
				xkey: 'elapsed',
				ykeys: ['value'],
				labels: ['Emails'],
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
					{ y: '2006', a: getRandomInt(10,100), b: getRandomInt(10,100) },
					{ y: '2007', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2008', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2009', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2010', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2011', a: getRandomInt(10,100),  b: getRandomInt(10,100) },
					{ y: '2012', a: getRandomInt(10,100), b: getRandomInt(10,100) }
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Series A', 'Series B']
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


var life_time_data = [
	<?php 
		$emails_date_from = $res_emails_graph->fields['email_date'];
		$emails_date_to = date('Y-m-d');
		$arr_emails = createDateRangeArray($emails_date_from,$emails_date_to);
		$i=0;
		foreach($arr_emails as $arr_email){
			$i++;
			$qry_emails_month = "SELECT count(*) as month_emails_total FROM emails WHERE email_date LIKE '%".$arr_email."%'"; 
			$res_emails_month = $db->Execute($qry_emails_month);
	?>
	
				{"elapsed": "<?php echo userdate($arr_email);?>", "value": <?php echo $res_emails_month->fields['month_emails_total'];?>} <?php if($i<count($arr_emails)){ echo ",";}?>
				
	<?php }?>
			];
			
			
</script>
<div id="chart_life_time"></div>
        <?php
		
	}
	
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//****************************************************************** ROI Section ******************************************************//
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////
	//*******Custome range ROI*******//
	//////////////////////////////////
	
	
	if($_GET['act']=='prepareRoiGraph'){
	
		$sortVal = $_GET['sortVal'];
		$where = '';
			
		$sort_arr = explode("#",$sortVal);
		$timestamp_from = strtotime($sort_arr[0]);
		$roi_date_from = date("Y-m-d", $timestamp_from);	
		$timestamp_to = strtotime($sort_arr[1]);
		$roi_date_to = date("Y-m-d", $timestamp_to);
			
		$where.= " roi_date >= '".$roi_date_from."' AND roi_date <= '".$roi_date_to."'";
		
		$qry_roi = "SELECT * FROM roi WHERE ".$where; 
		$res_roi = $db->Execute($qry_roi);
		$totalcountRoi =  $res_roi->RecordCount();
		
		?>
<script type="text/javascript">
var $ = jQuery.noConflict();
            (function($, window, undefined)
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
			];*/
			
			
			
			
			
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
		
			
			Morris.Area({
				element: 'chart_custom_range',
				data: [
				
				<?php 
					$arr_rois = createDateRangeArray($roi_date_from,$roi_date_to);
					$i=0;
					foreach($arr_rois as $arr_roi){
						$i++;
			
						$qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$arr_roi."%'"; 
						$res_roi_month = $db->Execute($qry_roi_month);
						$roi_total = $res_roi_month->fields['total_lifetime'];
						if($roi_total==''){
							$roi_total=0;
						}
					?>
					{ y: '<?php echo $arr_roi;?>', a: <?php echo $roi_total;?>}<?php if($i<count($arr_rois)){ echo ",";}?>
				
					<?php }?>
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
<div id="chart_custom_range"></div>
        <?php
		
	}
	
	
	////////////////////////////////////
	//*********Life time ROI*********//
	//////////////////////////////////
	
	if($_GET['act']=='prepareLifeTimeRoiGraph'){
	
		$qry_roi_graph = "SELECT * FROM roi order by id asc limit 1";
		$res_roi_graph = $db->Execute($qry_roi_graph);
		$totalcountRoiGraph =  $res_roi_graph->RecordCount();
		
		?>
<script type="text/javascript">
var $ = jQuery.noConflict();
            (function($, window, undefined)
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
			];*/
			
			
			
			
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
				element: 'chart_life_time',
				data: [
					<?php 
					$roi_date_from = $res_roi_graph->fields['roi_date'];
					$roi_date_to = date('Y-m-d');
					$arr_rois = createDateRangeArray($roi_date_from,$roi_date_to);
					$i=0;
					foreach($arr_rois as $arr_roi){
						$i++;
			
						$qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$arr_roi."%'"; 
						$res_roi_month = $db->Execute($qry_roi_month);
						$roi_total = $res_roi_month->fields['total_lifetime'];
						if($roi_total==''){
							$roi_total=0;
						}
					?>
					{ y: '<?php echo $arr_roi;?>', a: <?php echo $roi_total;?>}<?php if($i<count($arr_rois)){ echo ",";}?>
				
					<?php }?>
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
<div id="chart_life_time"></div>
        <?php
		
	}
	
}

?>