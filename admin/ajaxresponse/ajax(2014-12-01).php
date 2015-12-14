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
	
	
	//################################//
	//######## Calls Listing ########//
	//##############################//
	
	if($_GET['act']=='doSelectedSort'){
	
		$sortVal = $_GET['sortVal'];
		$client_id = $_SESSION['lm_auth']['client_id'];
		$where = " gsm_number = '".$client_id."'";
		if($sortVal=='today'){
			
			$calls_date = date('Y-m-d');
			$where.= " AND call_start LIKE '%".$calls_date."%'";
			
		}elseif($sortVal=='yesterday'){
			
			$calls_date = date('Y-m-d',strtotime("-1 days"));
			$where.= " AND call_start LIKE '%".$calls_date."%'";
			
		}elseif($sortVal=='last_7_days'){
			
			$calls_date_from = date('Y-m-d',strtotime("-7 days"));
			$calls_date_to = date('Y-m-d');
			$where.= " AND call_start > '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
			
		}elseif($sortVal=='last_30_days'){
			
			$calls_date_from = date('Y-m-d',strtotime("-30 days"));
			$calls_date_to = date('Y-m-d');
			$where.= " AND call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
			
		}elseif($sortVal=='this_month'){
			
			$calls_date_from = date('Y-m-01'); // hard-coded '01' for first day
			$calls_date_to  = date('Y-m-t');
			$where.= " AND call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
			
		}elseif($sortVal=='last_month'){
			
			$calls_date_from = date("Y-n-j", strtotime("first day of previous month"));
			$calls_date_to  = date("Y-n-j", strtotime("last day of previous month"));
			$where.= " AND call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
			
		}elseif($sortVal=='lifetime'){
			
			$lifeTimeCheck.= "lifetimecalls";
			
		}else{
			
			$sort_arr = explode("#",$sortVal);
			$timestamp_from = strtotime($sort_arr[0]);
			$calls_date_from = date("Y-m-d", $timestamp_from);	
			$timestamp_to = strtotime($sort_arr[1]);
			$calls_date_to = date("Y-m-d", $timestamp_to);
			
			$where.= " AND call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
		}
		
		if($lifeTimeCheck =='lifetimecalls'){
			$qry_calls = "SELECT * FROM calls WHERE gsm_number='".$client_id."'"; 
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
                      <td>
					  <?php //echo timeDifferance($res_calls->fields['call_start'],$res_calls->fields['call_end']);
						  if($res_calls->fields['call_end']>0){
							echo "Successfully transferred";  
						  }else{
							echo "Busy";  
						  }
					  ?>
                      </td>
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
	
	
	//################################//
	//##### Custom range Calls ######//
	//##############################//
	
	if($_GET['act']=='prepareCallsGraph'){
		$client_id = $_SESSION['lm_auth']['client_id'];
		$sortVal = $_GET['sortVal'];
		$where = '';
			
		$sort_arr = explode("#",$sortVal);
		$timestamp_from = strtotime($sort_arr[0]);
		$calls_date_from = date("Y-m-d", $timestamp_from);	
		$timestamp_to = strtotime($sort_arr[1]);
		$calls_date_to = date("Y-m-d", $timestamp_to);
			
		$where.= " call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."' AND gsm_number = '".$client_id."'";
		
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
                
                // Morris.js Graphs
                if(typeof Morris != 'undefined')
                {
                    
                    Morris.Line({
                        element: 'chart_custom_range',
                        data: custom_range_data,
                        xkey: 'elapsed',
                        ykeys: ['value'],
                        labels: ['Calls'],
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
        
        
        var custom_range_data = [
            <?php 
                $arr_calls = createDateRangeArray($calls_date_from,$calls_date_to);
                $i=0;
                foreach($arr_calls as $arr_call){
                    $i++;
                    $qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%".$arr_call."%' AND gsm_number = '".$client_id."'"; 
                    $res_calls_month = $db->Execute($qry_calls_month);
            ?>
            
                        {"elapsed": "<?php echo userdate($arr_call);?>", "value": <?php echo $res_calls_month->fields['month_calls_total'];?>} <?php if($i<count($arr_calls)){ echo ",";}?>
                        
            <?php }?>
                    ];
                    
        </script>
		<div id="chart_custom_range"></div>
        <?php
		
	}
	
	
	//################################//
	//####### Lifetime Calls ########//
	//##############################//
	
	if($_GET['act']=='prepareLifeTimeCallsGraph'){
		$client_id = $_SESSION['lm_auth']['client_id'];
		$qry_calls_graph = "SELECT * FROM calls WHERE gsm_number = '".$client_id."' order by id asc limit 1";
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
                // Morris.js Graphs
                if(typeof Morris != 'undefined')
                {
                    
                    Morris.Line({
                        element: 'chart_life_time',
                        data: life_time_data,
                        xkey: 'elapsed',
                        ykeys: ['value'],
                        labels: ['Calls'],
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
        
        
        var life_time_data = [
            <?php 
                $calls_date_from = $res_calls_graph->fields['call_start'];
                $calls_date_to = date('Y-m-d');
                $arr_calls = createDateRangeArray($calls_date_from,$calls_date_to);
                $i=0;
                foreach($arr_calls as $arr_call){
                    $i++;
                    $qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%".$arr_call."%' AND gsm_number = '".$client_id."'"; 
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
	
	//###############################//
	//######## Emails Listing ######//
	//#############################//
	
	if($_GET['act']=='doSelectedSortEmail'){
		$client_id = $_SESSION['lm_auth']['tbl_id'];
		$sortVal = $_GET['sortVal'];
		$where = " client_id='".$client_id."'";
		if($sortVal=='today'){
			
			$emails_date = date('Y-m-d');
			$where.= " AND email_date LIKE '%".$emails_date."%'";
			
		}elseif($sortVal=='yesterday'){
			
			$emails_date = date('Y-m-d',strtotime("-1 days"));
			$where.= " AND email_date LIKE '%".$emails_date."%'";
			
		}elseif($sortVal=='last_7_days'){
			
			$emails_date_from = date('Y-m-d',strtotime("-7 days"));
			$emails_date_to = date('Y-m-d');
			$where.= " AND email_date > '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
			
		}elseif($sortVal=='last_30_days'){
			
			$emails_date_from = date('Y-m-d',strtotime("-30 days"));
			$emails_date_to = date('Y-m-d');
			$where.= " AND email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
			
		}elseif($sortVal=='this_month'){
			
			$emails_date_from = date('Y-m-01'); // hard-coded '01' for first day
			$emails_date_to  = date('Y-m-t');
			$where.= " AND email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
			
		}elseif($sortVal=='last_month'){
			
			$emails_date_from = date("Y-n-j", strtotime("first day of previous month"));
			$emails_date_to  = date("Y-n-j", strtotime("last day of previous month"));
			$where.= " AND email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
			
		}elseif($sortVal=='lifetime'){
			
			$lifeTimeCheck.= "lifetimeemails";
			
		}else{
			
			$sort_arr = explode("#",$sortVal);
			$timestamp_from = strtotime($sort_arr[0]);
			$emails_date_from = date("Y-m-d", $timestamp_from);	
			$timestamp_to = strtotime($sort_arr[1]);
			$emails_date_to = date("Y-m-d", $timestamp_to);
			
			$where.= " AND email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
		}
		if($lifeTimeCheck =='lifetimeemails'){
			$qry_emails = "SELECT * FROM emails WHERE client_id='".$client_id."'"; 
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
	
	
	//################################//
	//### Custom range Emails #######//
	//##############################//
	
	if($_GET['act']=='prepareEmailsGraph'){
		$client_id = $_SESSION['lm_auth']['tbl_id'];
		$where = " client_id='".$client_id."'";
		$sortVal = $_GET['sortVal'];
		$where = '';
			
		$sort_arr = explode("#",$sortVal);
		$timestamp_from = strtotime($sort_arr[0]);
		$emails_date_from = date("Y-m-d", $timestamp_from);	
		$timestamp_to = strtotime($sort_arr[1]);
		$emails_date_to = date("Y-m-d", $timestamp_to);
			
		$where.= " email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."' AND client_id='".$client_id."'";
		
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
                
                // Morris.js Graphs
                if(typeof Morris != 'undefined')
                {
                    
                    Morris.Line({
                        element: 'chart_custom_range',
                        data: custom_range_data,
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
        
        
        var custom_range_data = [
            <?php 
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
        <div id="chart_custom_range"></div>
        <?php
		
	}
	
	
	//################################//
	//###### Life time Emails #######//
	//##############################//
	
	if($_GET['act']=='prepareLifeTimeEmailsGraph'){
		$client_id = $_SESSION['lm_auth']['tbl_id'];
		$qry_emails_graph = "SELECT * FROM emails WHERE client_id='".$client_id."' order by id asc limit 1";
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
                // Morris.js Graphs
                if(typeof Morris != 'undefined')
                {	
                    Morris.Line({
                        element: 'chart_life_time',
                        data: life_time_data,
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
        
        
        var life_time_data = [
            <?php 
                $emails_date_from = $res_emails_graph->fields['email_date'];
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
		<div id="chart_life_time"></div>
        <?php
		
	}
	
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//****************************************************************** ROI Section ******************************************************//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	//################################//
	//###### Custome range ROI ######//
	//##############################//
	
	
	if($_GET['act']=='prepareRoiGraph'){
		$client_id = $_SESSION['lm_auth']['tbl_id'];
		$sortVal = $_GET['sortVal'];
		$where = '';
			
		$sort_arr = explode("#",$sortVal);
		$timestamp_from = strtotime($sort_arr[0]);
		$roi_date_from = date("Y-m-d", $timestamp_from);	
		$timestamp_to = strtotime($sort_arr[1]);
		$roi_date_to = date("Y-m-d", $timestamp_to);
			
		$where.= " roi_date >= '".$roi_date_from."' AND roi_date <= '".$roi_date_to."' AND client_id='".$client_id."'";
		
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
            
                // Morris.js Graphs
                if(typeof Morris != 'undefined')
                {
                    
                    Morris.Area({
                        element: 'chart_custom_range',
                        data: [
                        
                        <?php 
                            $arr_rois = createDateRangeArray($roi_date_from,$roi_date_to);
                            $i=0;
                            foreach($arr_rois as $arr_roi){
                                $i++;
                    
                                $qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$arr_roi."%' AND client_id='".$client_id."'"; 
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
	
	
	//################################//
	//######## Life time ROI ########//
	//##############################//
	
	if($_GET['act']=='prepareLifeTimeRoiGraph'){
		$client_id = $_SESSION['lm_auth']['tbl_id'];
		$qry_roi_graph = "SELECT * FROM roi WHERE client_id='".$client_id."' order by id asc limit 1";
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
            
                // Morris.js Graphs
                if(typeof Morris != 'undefined')
                {
                    
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
                    
                                $qry_roi_month = "SELECT SUM(avg_sale_revenue) as total_lifetime FROM roi WHERE roi_date LIKE '%".$arr_roi."%' AND client_id='".$client_id."'"; 
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