<?php
$client_id = $_SESSION['lm_auth']['tbl_id'];

$client_id_temp = $_SESSION['lm_auth']['client_id'];
$client_id_arr = explode("#",$client_id_temp);
foreach($client_id_arr as $client_id_single){
	$client_ids.=$client_id_single.',';	
}
$client_id_calls = rtrim($client_ids,',');

//Lifetime Calls
$qry_calls = "SELECT * FROM calls WHERE gsm_number IN( ".$client_id_calls." )"; 
$res_calls = $db->Execute($qry_calls);
$totalcountCalls =  $res_calls->RecordCount();

// New Calls
$qry_new_calls = "SELECT * FROM calls WHERE call_start LIKE '%".date('Y-m-d')."%' AND gsm_number IN( ".$client_id_calls." )"; 
$res_new_calls = $db->Execute($qry_new_calls);
$totalcountNewCalls =  $res_new_calls->RecordCount();

//Lifetime Emails

$qry_emails = "SELECT * FROM emails WHERE client_id='".$client_id."'"; 
$res_emails = $db->Execute($qry_emails);
$totalcountEmails =  $res_emails->RecordCount();

// New Emails
$qry_new_emails = "SELECT * FROM emails WHERE email_date LIKE '%".date('Y-m-d')."%' AND client_id='".$client_id."'"; 
$res_new_emails = $db->Execute($qry_new_emails);
$totalcountNewEmails =  $res_new_emails->RecordCount();

//Graph
$currentYear = date('Y');
$firstYear = $currentYear-1;
$secondYear = $currentYear-2;
$thirdYear = $currentYear-3;
$fourthYear = $currentYear-4;
$fifthYear = $currentYear-5;
$sixthYear = $currentYear-6;


// Current Year Calls
/*$qry_currentYear_calls = "SELECT * FROM calls WHERE call_start LIKE '%".$currentYear."%'"; 
$res_currentYear_calls = $db->Execute($qry_currentYear_calls);
$totalcountcurrentYearCalls =  $res_currentYear_calls->RecordCount();*/

// First Year Calls
/*$qry_firstYear_calls = "SELECT * FROM calls WHERE call_start LIKE '%".$firstYear."%'"; 
$res_firstYear_calls = $db->Execute($qry_firstYear_calls);
$totalcountfirstYearCalls =  $res_firstYear_calls->RecordCount();*/

// Second Year Calls
/*$qry_secondYear_calls = "SELECT * FROM calls WHERE call_start LIKE '%".$secondYear."%'"; 
$res_secondYear_calls = $db->Execute($qry_secondYear_calls);
$totalcountsecondYearCalls =  $res_secondYear_calls->RecordCount();*/

// Third Year Calls
/*$qry_thirdYear_calls = "SELECT * FROM calls WHERE call_start LIKE '%".$thirdYear."%'"; 
$res_thirdYear_calls = $db->Execute($qry_thirdYear_calls);
$totalcountthirdYearCalls =  $res_thirdYear_calls->RecordCount();*/

// Fourth Year Calls
/*$qry_fourthYear_calls = "SELECT * FROM calls WHERE call_start LIKE '%".$fourthYear."%'"; 
$res_fourthYear_calls = $db->Execute($qry_fourthYear_calls);
$totalcountfourthYearCalls =  $res_fourthYear_calls->RecordCount();*/

// Fifth Year Calls
/*$qry_fifthYear_calls = "SELECT * FROM calls WHERE call_start LIKE '%".$fifthYear."%'"; 
$res_fifthYear_calls = $db->Execute($qry_fifthYear_calls);
$totalcountfifthYearCalls =  $res_fifthYear_calls->RecordCount();*/

// Sixth Year Calls
/*$qry_sixthYear_calls = "SELECT * FROM calls WHERE call_start LIKE '%".$sixthYear."%'"; 
$res_sixthYear_calls = $db->Execute($qry_sixthYear_calls);
$totalcountsixthYearCalls =  $res_sixthYear_calls->RecordCount();
*/




// Current Year Emails
/*$qry_currentYear_emails = "SELECT * FROM emails WHERE email_date LIKE '%".$currentYear."%'"; 
$res_currentYear_emails = $db->Execute($qry_currentYear_emails);
$totalcountcurrentYearEmails =  $res_currentYear_emails->RecordCount();*/

// First Year Emails
/*$qry_firstYear_emails = "SELECT * FROM emails WHERE email_date LIKE '%".$firstYear."%'"; 
$res_firstYear_emails = $db->Execute($qry_firstYear_emails);
$totalcountfirstYearEmails =  $res_firstYear_emails->RecordCount();
*/
// Second Year Emails
/*$qry_secondYear_emails = "SELECT * FROM emails WHERE email_date LIKE '%".$secondYear."%'"; 
$res_secondYear_emails = $db->Execute($qry_secondYear_emails);
$totalcountsecondYearEmails =  $res_secondYear_emails->RecordCount();*/

// Third Year Emails
/*$qry_thirdYear_emails = "SELECT * FROM emails WHERE email_date LIKE '%".$thirdYear."%'"; 
$res_thirdYear_emails = $db->Execute($qry_thirdYear_emails);
$totalcountthirdYearEmails =  $res_thirdYear_emails->RecordCount();*/

// Fourth Year Emails
/*$qry_fourthYear_emails = "SELECT * FROM emails WHERE email_date LIKE '%".$fourthYear."%'"; 
$res_fourthYear_emails = $db->Execute($qry_fourthYear_emails);
$totalcountfourthYearEmails =  $res_fourthYear_emails->RecordCount();*/

// Fifth Year Calls
/*$qry_fifthYear_emails = "SELECT * FROM emails WHERE email_date LIKE '%".$fifthYear."%'"; 
$res_fifthYear_emails = $db->Execute($qry_fifthYear_emails);
$totalcountfifthYearEmails =  $res_fifthYear_emails->RecordCount();*/

// Sixth Year Calls
/*$qry_sixthYear_emails = "SELECT * FROM emails WHERE email_date LIKE '%".$sixthYear."%'"; 
$res_sixthYear_emails = $db->Execute($qry_sixthYear_emails);
$totalcountsixthYearEmails =  $res_sixthYear_emails->RecordCount();*/

?>
   
<script type="text/javascript">

	function setSortVal(val){
		var sortCriterean = '';
		if(val=='Today'){
			sortCriterean = 'today';
		}else if(val=='Yesterday'){
			sortCriterean = 'yesterday';
		}else if(val=='Last 7 Days'){
			sortCriterean = 'last_7_days';
		}else if(val=='Last 30 Days'){
			sortCriterean = 'last_30_days';
		}else if(val=='This Month'){	
			sortCriterean = 'this_month';
		}else if(val=='Last Month'){
			sortCriterean = 'last_month';
		}
		else if(val=='Lifetime'){
			sortCriterean = 'lifetime';
		}else{
			var first = document.getElementById("daterangepicker_start").value;
			var secon = document.getElementById("daterangepicker_end").value;
			sortCriterean = first+'#'+secon;
				
		}
                showLeadsData(sortCriterean);
			$.ajax({	
		  		url: "<?php echo SURL?>ajaxresponse/ajax.php",
		  		type: "GET",
		  		catche:"false",
		  		data:{act:"prepareLeadsGraph",sortVal:sortCriterean},
		  		success: function (data) {
					$("#showGraph").html(data);	
		  		}
			});	
	}
	
        
        
        
</script>    
    
                
    <script type="text/javascript">
jQuery(document).ready(function() 
{
	
	
	// Area Chart
	var area_chart_demo = $("#area-chart-demo");
	
	area_chart_demo.parent().show();

	/*var area_chart = Morris.Area({
		element: 'area-chart-demo',
		data: [
			{ y: '<?php echo $sixthYear?>', a:<?php echo $totalcountsixthYearCalls?> , b:<?php echo $totalcountsixthYearEmails?> , c:<?php echo $totalcountsixthYearCalls+$totalcountsixthYearEmails?>  },
			
			{ y: '<?php echo $fifthYear?>', a:<?php echo $totalcountfifthYearCalls?> ,  b:<?php echo $totalcountfifthYearEmails?> , c:<?php echo $totalcountfifthYearCalls+$totalcountfifthYearEmails?>  },
			
			{ y: '<?php echo $fourthYear?>', a: <?php echo $totalcountfourthYearCalls?>,  b:<?php echo $totalcountfourthYearEmails?> , c:<?php echo $totalcountfourthYearCalls+$totalcountfourthYearEmails?>  },
			
			{ y: '<?php echo $thirdYear?>', a: <?php echo $totalcountthirdYearCalls?>,  b:<?php echo $totalcountthirdYearEmails?> , c:<?php echo $totalcountthirdYearCalls+$totalcountthirdYearEmails?>  },
			
			{ y: '<?php echo $secondYear?>', a: <?php echo $totalcountsecondYearCalls?>,  b:<?php echo $totalcountsecondYearEmails?> , c:<?php echo $totalcountsecondYearCalls+$totalcountsecondYearEmails?>  },
			
			{ y: '<?php echo $firstYear?>', a: <?php echo $totalcountfirstYearCalls?>,  b:<?php echo $totalcountfirstYearEmails?> , c:<?php echo $totalcountfirstYearCalls+$totalcountfirstYearEmails?>  },
			
			{ y: '<?php echo $currentYear?>', a: <?php echo $totalcountcurrentYearCalls?>, b:<?php echo $totalcountcurrentYearEmails?> , c:<?php echo $totalcountcurrentYearCalls+$totalcountcurrentYearEmails?>  }
		],
		xkey: 'y',
		ykeys: ['a', 'b', 'c'],
		labels: ['Calls','Emails' ,'Leads' ],
		lineColors: ['#00a65a','#00c0ef' , '#f56954']
	});*/
	
	
	
	var area_chart = Morris.Area({
		element: 'area-chart-demo',
		data: [
		
		<?php
	$periods   = getMonths('2014-09-22', date('Y-m-d'));
	$ii=0;

	foreach($periods as $dt){
		$yearmonth = $dt->format("Y-m");
                $yearmonth2 = $dt->format("Y-m");
		$ii++;
		$qry_em_month = "SELECT count(*) as  total_lifetime_emails FROM emails WHERE email_date LIKE '%".$yearmonth."%' AND client_id='".$client_id."'";
		$res_em_month = $db->Execute($qry_em_month);
		$em_total = $res_em_month->fields['total_lifetime_emails'];
		if($em_total==''){
			$em_total=0;	
		}
		
		$qry_ca_month = "SELECT count(*) as  total_lifetime_calls FROM calls WHERE call_start LIKE '%".$yearmonth."%' AND gsm_number IN( ".$client_id_calls." ) ";
		$res_ca_month = $db->Execute($qry_ca_month);
		$ca_total = $res_ca_month->fields['total_lifetime_calls'];
		if($ca_total==''){
			$ca_total=0;	
		}
		
		?>
		{ y: '<?php echo $yearmonth2; ?>', a:<?php echo $ca_total?> , b:<?php echo $em_total?> , c:<?php echo $ca_total+$em_total?>  },
		<?php
		//echo $yearmonth."--".$em_total."<br>";
	
	}
	?>
	
			
			
		],
		xkey: 'y',
		ykeys: ['a', 'b', 'c'],
		labels: ['Calls','Emails' ,'Leads' ],
		lineColors: ['#00a65a','#00c0ef' , '#f56954'],
                xLabelFormat: function(y) { 
                    var month = new Array();
                    month[0] = "January";month[1] = "February";month[2] = "March";
                    month[3] = "April";month[4] = "May";month[5] = "June";
                    month[6] = "July";month[7] = "August";month[8] = "September";
                    month[9] = "October";month[10] = "November";month[11] = "December";
                    return month[(y.getMonth())]+' '+y.getFullYear();
                }
                /*,
                hoverCallback: function (index, options, content, row) { 
                    var c = content;
                    console.log($(c).find('.morris-hover-row-label'));
                    //console.log($(content).find('.morris-hover-row-label'));
                    //$(content).find('')
                    return content;
                  }*/
	});
	
	
	area_chart_demo.parent().attr('style', '');
	
	showLeadsData('today');

});


function showLeadsData(period){
    $.ajax({
        url: "<?php echo SURL ?>ajaxresponse/ajax2.php",
        type: "GET",
        cache:"false",
        data:{act:'get_leads_data',period:period},
        dataType: 'json',
        success: function(data){
                //console.log(data.calls_query);
               //console.log(data.email_query);
               $("#total_leads").text(data.total_leads);
               $("#total_calls").text(data.total_calls);
               $("#total_emails").text(data.total_emails);
        }
    });
}


function getRandomInt(min, max) 
{
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
</script>
    
    <div class="row">
  <div class="col-sm-4">
    <ol class="breadcrumb bc-3">
      <li> <a href="javascript:;"><i class="entypo-home"></i>Home</a> </li>
      <li> <a href="javascript:;">Leads</a> </li>
      <li class="active"> <strong>Dashboard</strong> </li>
    </ol>
  </div>

<?php    include 'bodies/request_call.php'; ?>
  <form>
    <div class="col-sm-4 fr">
      <div class="daterange daterange-inline add-ranges" data-format="MMMM D, YYYY" data-start-date="September 16, 2014" data-end-date="<?php echo date('F d, Y', strtotime(date('Y-m-d')));?>"> <i class="entypo-calendar"></i> <span>September 22, 2014 - <?php echo date('F d, Y', strtotime(date('Y-m-d')));?></span> </div>
    </div>
  </form>
  <div class="clearfix"></div>
</div>
    <br />
    <div class="row">
      <div class="col-sm-4"> <a href="javascript:void(0)">
        <div class="tile-stats tile-red">
          <div class="icon"><i class="entypo-chart-bar"></i></div>
          <div class="num" data-start="0" data-end="<?php echo $totalcountNewCalls+$totalcountNewEmails;?>" data-postfix="" data-duration="1500" data-delay="0" id="total_leads">0</div>
          <h3>New Leads Today</h3>
          <p>Lifetime Leads: <?php echo $totalcountCalls+$totalcountEmails;?></p>
        </div>
        </a> </div>
      <div class="col-sm-4"> <a href="admin.php?act=managecalls">
        <div class="tile-stats tile-green">
          <div class="icon"><i class="entypo-phone"></i></div>
          <div class="num" data-start="0" data-end="<?php echo $totalcountNewCalls;?>" data-postfix="" data-duration="1500" data-delay="600" id="total_calls">0</div>
          <h3>New Calls Today</h3>
          <p>Lifetime Calls: <?php echo $totalcountCalls;?></p>
        </div>
        </a> </div>
      <div class="col-sm-4"> <a href="admin.php?act=manageemails">
        <div class="tile-stats tile-aqua">
          <div class="icon"><i class="entypo-mail"></i></div>
          <div class="num" data-start="0" data-end="<?php echo $totalcountNewEmails;?>" data-postfix="" data-duration="1500" data-delay="1200" id="total_emails">0</div>
          <h3>New Emails Today</h3>
          <p>Lifetime Emails: <?php echo $totalcountEmails;?></p>
        </div>
        </a> </div>
    </div>
    <br />
    <!--<div class="row">
      <div class="col-sm-12">
        <div class="alert alert-success"><strong>Upgrade your package now</strong> to get more leads per day, <a href="#"><strong>Click Here</strong></a> to learn more.</div>
      </div>
    </div>-->
    <br />
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-primary" id="charts_env">
          <div class="panel-heading">
            <div class="panel-title">Leads History</div>
            <div class="panel-options" style="display:none;">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#area-chart" data-toggle="tab">Area Chart</a></li>
                <li class=""><a href="#line-chart" data-toggle="tab">Line Charts</a></li>
                <li class=""><a href="#pie-chart" data-toggle="tab">Pie Chart</a></li>
              </ul>
            </div>
          </div>
          <div class="panel-body">
            <div class="tab-content">
            <div id="showGraph">
              <div class="tab-pane active" id="area-chart">
                <div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
              </div>
              </div>
              <div class="tab-pane" id="line-chart" style="display:none;">
                <div id="line-chart-demo" class="morrischart" style="height: 300px"></div>
              </div>
              <div class="tab-pane" id="pie-chart" style="display:none;">
                <div id="donut-chart-demo" class="morrischart" style="height: 300px;"></div>
              </div>

            </div>
          </div>
          <table class="table table-bordered table-responsive">
            <thead>
              <tr>
                <th width="50%" class="col-padding-1"> <div class="pull-left">
                    <div class="h4 no-margin">Add Views</div>
                    <small>54,127</small> </div>
                  <span class="pull-right pageviews">4,3,5,4,5,6,5</span> </th>
                <th width="50%" class="col-padding-1"> <div class="pull-left">
                    <div class="h4 no-margin">Unique Visitors</div>
                    <small>25,127</small> </div>
                  <span class="pull-right uniquevisitors">2,3,5,4,3,4,5</span> </th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <div class="col-sm-4" style="display:none;">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">
              <h4> Real Time Stats <br />
                <small>current server uptime</small> </h4>
            </div>
            <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
          </div>
          <div class="panel-body no-padding">
            <div id="rickshaw-chart-demo">
              <div id="rickshaw-legend"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />
    <div class="row" style="display:none;">
      <div class="col-sm-4">
        <div class="panel panel-primary">
          <table class="table table-bordered table-responsive">
            <thead>
              <tr>
                <th class="padding-bottom-none text-center"> <br />
                  <br />
                  <span class="monthly-sales"></span> </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="panel-heading"><h4>Monthly Sales</h4></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="panel-title">Latest Updated Profiles</div>
            <div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
          </div>
          <table class="table table-bordered table-responsive">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Position</th>
                <th>Activity</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Art Ramadani</td>
                <td>CEO</td>
                <td class="text-center"><span class="inlinebar">4,3,5,4,5,6</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Filan Fisteku</td>
                <td>Member</td>
                <td class="text-center"><span class="inlinebar-2">1,3,4,5,3,5</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Arlind Nushi</td>
                <td>Co-founder</td>
                <td class="text-center"><span class="inlinebar-3">5,3,2,5,4,5</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script type="text/javascript">
	// Code used to add Todo Tasks
	jQuery(document).ready(function($)

	{
		var $todo_tasks = $("#todo_tasks");
		
		$todo_tasks.find('input[type="text"]').on('keydown', function(ev)
		{
			if(ev.keyCode == 13)
			{
				ev.preventDefault();
				
				if($.trim($(this).val()).length)
				{
					var $todo_entry = $('<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>'+$(this).val()+'</label></div></li>');
					$(this).val('');
					
					$todo_entry.appendTo($todo_tasks.find('.todo-list'));
					$todo_entry.hide().slideDown('fast');
					replaceCheckboxes();
				}
			}
		});
	});
</script>
    <div class="row" style="display:none;">
      <div class="col-sm-3">
        <div class="tile-block" id="todo_tasks">
          <div class="tile-header"> <i class="entypo-list"></i> <a href="#"> Tasks <span>To do list, tick one.</span> </a> </div>
          <div class="tile-content">
            <input type="text" class="form-control" placeholder="Add Task" />
            <ul class="todo-list">
              <li>
                <div class="checkbox checkbox-replace color-white">
                  <input type="checkbox" />
                  <label>Website Design</label>
                </div>
              </li>
              <li>
                <div class="checkbox checkbox-replace color-white">
                  <input type="checkbox" id="task-2" checked />
                  <label>Slicing</label>
                </div>
              </li>
              <li>
                <div class="checkbox checkbox-replace color-white">
                  <input type="checkbox" id="task-3" />
                  <label>WordPress Integration</label>
                </div>
              </li>
              <li>
                <div class="checkbox checkbox-replace color-white">
                  <input type="checkbox" id="task-4" />
                  <label>SEO Optimize</label>
                </div>
              </li>
              <li>
                <div class="checkbox checkbox-replace color-white">
                  <input type="checkbox" id="task-5" checked="" />
                  <label>Minify &amp; Compress</label>
                </div>
              </li>
            </ul>
          </div>
          <div class="tile-footer"> <a href="#">View all tasks</a> </div>
        </div>
      </div>
      <div class="col-sm-9"> 
        <script type="text/javascript">
			jQuery(document).ready(function($)
			{
				var map = $("#map-2");
				
				map.vectorMap({
					map: 'europe_merc_en',
					zoomMin: '3',
					backgroundColor: '#383f47',
					focusOn: { x: 0.5, y: 0.8, scale: 3 }
				});
			});
		</script>
        <div class="tile-group">
          <div class="tile-left">
            <div class="tile-entry">
              <h3>Map</h3>
              <span>top visitors location</span> </div>
            <div class="tile-entry"> <img src="assets/images/sample-al.png" alt="" class="pull-right op" />
              <h4>Albania</h4>
              <span>25%</span> </div>
            <div class="tile-entry"> <img src="assets/images/sample-it.png" alt="" class="pull-right op" />
              <h4>Italy</h4>
              <span>18%</span> </div>
            <div class="tile-entry"> <img src="assets/images/sample-au.png" alt="" class="pull-right op" />
              <h4>Austria</h4>
              <span>15%</span> </div>
          </div>
          <div class="tile-right">
            <div id="map-2" class="map"></div>
          </div>
        </div>
      </div>
    </div>

  
  
  
  
  
  
  <link rel="stylesheet" href="<?php echo SURL?>assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="<?php echo SURL?>assets/js/rickshaw/rickshaw.min.css">
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
<script src="<?php echo SURL?>assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> 
<script src="<?php echo SURL?>assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script> 
<script src="<?php echo SURL?>assets/js/jquery.sparkline.min.js"></script> 
<script src="<?php echo SURL?>assets/js/rickshaw/vendor/d3.v3.js"></script> 
<script src="<?php echo SURL?>assets/js/rickshaw/rickshaw.min.js"></script> 
<script src="<?php echo SURL?>assets/js/raphael-min.js"></script> 
<script src="<?php echo SURL?>assets/js/morris.min.js"></script> 
<script src="<?php echo SURL?>assets/js/toastr.js"></script> 
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
