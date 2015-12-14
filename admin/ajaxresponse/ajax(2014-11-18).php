<?php 
include('../../adodb/adodb.inc.php');
include('../../include/siteconfig.inc.php');
include('../../include/sitefunction.php');
$db = ADONewConnection('mysql');
$db->Connect(DBHOST,DBUSER,DBPASS,DBNAME) or die("Database not found! please install your application properly");
	
if(isset($_GET['act'])){
	
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
			
		}else{
			
			$sort_arr = explode("#",$sortVal);
			$timestamp_from = strtotime($sort_arr[0]);
			$calls_date_from = date("Y-m-d", $timestamp_from);	
			$timestamp_to = strtotime($sort_arr[1]);
			$calls_date_to = date("Y-m-d", $timestamp_to);
			
			$where.= " call_start >= '".$calls_date_from."' AND call_start <= '".$calls_date_to."'";
		}
		
		$qry_calls = "SELECT * FROM calls WHERE ".$where; 
		$res_calls = $db->Execute($qry_calls);
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
			
		}else{
			
			$sort_arr = explode("#",$sortVal);
			$timestamp_from = strtotime($sort_arr[0]);
			$emails_date_from = date("Y-m-d", $timestamp_from);	
			$timestamp_to = strtotime($sort_arr[1]);
			$emails_date_to = date("Y-m-d", $timestamp_to);
			
			$where.= " email_date >= '".$emails_date_from."' AND email_date <= '".$emails_date_to."'";
		}
		
		$qry_emails = "SELECT * FROM emails WHERE ".$where; 
		$res_emails = $db->Execute($qry_emails);
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
}

?>