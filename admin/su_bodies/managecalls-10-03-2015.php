<?php
if (!defined('SU'))
    die();


$qry_calls = "SELECT * FROM calls ORDER BY id DESC ";
$res_calls = $db->Execute($qry_calls);
$totalcountCalls = $res_calls->RecordCount();


?>
<script type="text/javascript">

    function setSortVal(val){
        var sortCriterean = '';
        
        if(val=='Today'){
            sortCriterean = 'today';
            showCallData(sortCriterean);
        }else if(val=='Yesterday'){
            sortCriterean = 'yesterday';
            showCallData(sortCriterean);
        }else if(val=='Last 7 Days'){
            sortCriterean = 'last_7_days';
            showCallData(sortCriterean);
        }else if(val=='Last 30 Days'){
            sortCriterean = 'last_30_days';
            showCallData(sortCriterean);
        }else if(val=='This Month'){
            sortCriterean = 'this_month';
            showCallData(sortCriterean);
        }else if(val=='Last Month'){
            sortCriterean = 'last_month';
            showCallData(sortCriterean);
        }else if(val=='Lifetime'){
            sortCriterean = 'lifetime';
            showCallData(sortCriterean);
        }
        else{
            var first = document.getElementById("daterangepicker_start").value;
            var secon = document.getElementById("daterangepicker_end").value;
            showCallDataCustom(first,secon);
        }
        
        $.ajax({	
            url: "<?php echo SURL ?>ajaxresponse/ajax.php",
            type: "GET",
            catche:"false",
            data:{act:"doSelectedSort",sortVal:sortCriterean},
            success: function (data) {
                $("#sortResult").html(data);	
                $.noConflict();
                var table = $("#table-4").dataTable({
                    "sPaginationType": "bootstrap",
                    "sDom": "<'row'<'col-xs-6 col-left'l><'col-xs-6 col-right'<'export-data'T>f>r>t<'row'<'col-xs-6 col-left'i><'col-xs-6 col-right'p>>"
			
                });	 
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
            }
        });		
    }
    
    /*
    * show hide call records from client
    */
    function toggleHide(ck,id){
        //alert(ck.checked);alert(id);
        var msg = (ck.checked)?"hide":"show";
        if(confirm('Are you sure you want to '+msg+' this call record from client?')){
            $.ajax({	
                url: "<?php echo SURL ?>ajaxresponse/ajax.php",
                type: "GET",
                catche:"false",
                data:{act:"showHideCall",hide:ck.checked,call_id:id},
                success: function (data) {

                }
                });
                return true;
         } else return false;
    }
    
    
  
	
</script>


<script type="text/javascript">
    
    var chart;
    
$(document).ready(function(){


        chart = Morris.Line({
                element: 'chart_life_time2',
                data: [0, 0],
                xkey: 'elapsed',
                ykeys: ['value'],
                labels: ['Calls'],
                parseTime: false,
                lineColors: ['#242d3c']
            });
                
        $.ajax({
            url: "<?php echo SURL ?>ajaxresponse/ajax2.php",
            type: "GET",
            cache:"false",
            data:{act:'get_calls_data',period:'lifetime'},
            dataType: 'json',
            success: function(data){
                
                chart.setData(data);
                
            }
        });


});

function showCallData(_period){
    if(_period=='') _period='lifetime';
    
    $.ajax({
            url: "<?php echo SURL ?>ajaxresponse/ajax2.php",
            type: "GET",
            cache:"false",
            data:{act:'get_calls_data',period:_period},
            dataType: 'json',
            success: function(data){
                
                chart.setData(data);
                
            }
        });
}

function showCallDataCustom(_from,_to){
    
    $.ajax({
            url: "<?php echo SURL ?>ajaxresponse/ajax2.php",
            type: "GET",
            cache:"false",
            data:{act:'get_calls_data',period:'custom',from:_from,to:_to},
            dataType: 'json',
            success: function(data){
                
                chart.setData(data);
                
            }
        });
}
                    
</script>




<script type="text/javascript">
   
			
    function data(offset) {
        var ret = [];
        for (var x = 0; x <= 360; x += 10) {
            var v = (offset + x) % 360;
            ret.push({
                x: x,
                y: Math.sin(Math.PI * v / 180).toFixed(4),
                z: Math.cos(Math.PI * v / 180).toFixed(4)
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
            <li> <a href="admin.php?act=dashboard"><i class="entypo-home"></i>Dashboard</a> </li>
            <li class="active"> <strong>Calls</strong> </li>
        </ol>
    </div>
    <form>
        <div class="col-sm-4 fr">
            <div class="daterange daterange-inline add-ranges" data-format="MMMM D, YYYY" data-start-date="September 16, 2014" data-end-date="September 22, 2014"> <i class="entypo-calendar"></i> <span>September 22, 2014 - <?php echo date('F d, Y', strtotime(date('Y-m-d'))); ?></span> </div>
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
<h2>Recent Calls</h2>
<br />
<div id="sortResult">
    <table class="table table-bordered datatable" id="table-4">
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Client</th>
                <th>Numbers</th>
                <th>Time</th>
                <th>Duration</th>
                <th>Date</th>
                <th>Mark as test data</th>
            </tr>
        </thead>
        <tbody>
<?php
if ($totalcountCalls > 0) {
    $i = 0;
    $missed = 0;
    $totalDuration = 0;
    while (!$res_calls->EOF) {
        $i++;

        $call_start = new DateTime($res_calls->fields['call_start']);
        $call_end = new DateTime($res_calls->fields['call_end']);
        $totalDuration+= date_diff($call_start, $call_end);
        ?>
                    <tr class="even gradeA">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $res_calls->fields['gsm_number']; ?></td>
                        <td><?php echo $res_calls->fields['callerid']; ?></td>
                        <td><?php echo timeInAmPm($res_calls->fields['call_start']); ?></td>
                        <td>
        <?php
        //echo timeDifferance($res_calls->fields['call_start'],$res_calls->fields['call_end']);
        if ($res_calls->fields['call_end'] > 0) {
            echo "Successfully transferred";
        } else {
            echo "Busy";
            $missed++;
        }
        $checked = ($res_calls->fields['test_data']==1)?' checked':'';
        ?> 
                        </td>
                        <td><?php echo userdate($res_calls->fields['call_start']); ?></td>
                        <td align="center"><input type="checkbox" name="hide" value="<?php echo $res_calls->fields['id']; ?>" title="Mark as test data" onClick="return toggleHide(this,<?php echo $res_calls->fields['id']; ?>);" <?php echo $checked; ?>></td>
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
                <th>Client</th>
                <th>Numbers</th>
                <th>Time</th>
                <th>Duration</th>
                <th>Date</th>
                <th>Mark as test data</th>
            </tr>

        </tfoot>
    </table>
</div>
<?php
$averageCallDuration = $totalDuration / $totalcountCalls;

$saturday = strtotime("last saturday");
$saturday = date('w', $saturday) == date('w') ? $saturday + 7 * 86400 : $saturday;

$friday = strtotime(date("Y-m-d", $saturday) . " +6 days");

$this_week_sd = date("Y-m-d", $saturday);
$this_week_ed = date("Y-m-d", $friday);

$sql = "SELECT DAYNAME(atr.call_start) as dayname,count(*) as total FROM week_days wd LEFT JOIN ( SELECT * FROM calls WHERE call_start >= '" . $this_week_sd . "' AND call_start <= '" . $this_week_ed . "') atr
    												ON wd.week_day_num = DAYOFWEEK(atr.call_start)
													GROUP BY
  													DAYOFWEEK(atr.call_start)";

$this_week_rec = $db->Execute($sql);

$saturday = 0;
$sunday = 0;
$monday = 0;
$tuesday = 0;
$wednesday = 0;
$thursday = 0;
$friday = 0;

while (!$this_week_rec->EOF) {

    $daynames = $this_week_rec->fields['dayname'];
    $totalcalls = $this_week_rec->fields['total'];

    if ($daynames == 'Saturday') {
        $saturday = $this_week_rec->fields['total'];
    }
    if ($daynames == 'Sunday') {
        $sunday = $this_week_rec->fields['total'];
    }
    if ($daynames == 'Monday') {
        $monday = $this_week_rec->fields['total'];
    }
    if ($daynames == 'Tuesday') {
        $tuesday = $this_week_rec->fields['total'];
    }
    if ($daynames == 'Wednesday') {
        $wednesday = $this_week_rec->fields['total'];
    }
    if ($daynames == 'Thursday') {
        $thursday = $this_week_rec->fields['total'];
    }
    if ($daynames == 'Friday') {
        $friday = $this_week_rec->fields['total'];
    }

    $this_week_rec->MoveNext();
}

$arr = array('Saturday' => $saturday,
    'Sunday' => $sunday,
    'Monday' => $monday,
    'Tuesday' => $tuesday,
    'Wednesday' => $wednesday,
    'Thursday' => $thursday,
    'Friday' => $friday
);

$maxs = array_keys($arr, max($arr));
?>
<script type="text/javascript">
    jQuery(document).ready(function($)
    {
        var table = $("#table-4").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-6 col-left'l><'col-xs-6 col-right'<'export-data'T>f>r>t<'row'<'col-xs-6 col-left'i><'col-xs-6 col-right'p>>"
			
        });
    });
	
	
    var day_data = [
        {"elapsed": "Saturday", "value": <?php echo $saturday; ?>},
        {"elapsed": "Sunday", "value": <?php echo $sunday; ?>},
        {"elapsed": "Monday", "value": <?php echo $monday; ?>},
        {"elapsed": "Tuesday", "value": <?php echo $tuesday; ?>},
        {"elapsed": "Wednesday", "value": <?php echo $wednesday; ?>},
        {"elapsed": "Thursday", "value": <?php echo $thursday; ?>},
        {"elapsed": "Friday", "value": <?php echo $friday; ?>}
    ];
    //console.log(day_data);
	
	
    var month_data = [
<?php
$maxDays = date('t');
for ($i = 1; $i <= $maxDays; $i++) {
    $dayName = date('Y-m-' . $i);

    $qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%" . $dayName . "%'";
    $res_calls_month = $db->Execute($qry_calls_month);
    ?>
    	
                    {"elapsed": "<?php echo userdate($dayName); ?>", "value": <?php echo $res_calls_month->fields['month_calls_total']; ?>} <?php if ($i < $maxDays) {
        echo ",";
    } ?>
    				
<?php } ?>
            ];
			
            //console.log(month_data);
	
	
	
            var last_month_data = [
<?php
$maxDaysInLastMonth = date("t", mktime(0, 0, 0, date("n") - 1));
$lastMonth = date("n") - 1;
for ($i = 1; $i <= $maxDaysInLastMonth; $i++) {
    $dayName = date('Y-' . $lastMonth . '-' . $i);

    $qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%" . $dayName . "%'";
    $res_calls_month = $db->Execute($qry_calls_month);
    ?>
    	
                    {"elapsed": "<?php echo userdate($dayName); ?>", "value": <?php echo $res_calls_month->fields['month_calls_total']; ?>} <?php if ($i < $maxDaysInLastMonth) {
        echo ",";
    } ?>
    				
<?php } ?>
            ];
			
			

            var last_thirty_data = [
<?php
$calls_date_from = date('Y-m-d', strtotime("-30 days"));
$calls_date_to = date('Y-m-d');
$arr_calls = createDateRangeArray($calls_date_from, $calls_date_to);
$i = 0;
foreach ($arr_calls as $arr_call) {
    $i++;
    $qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%" . $arr_call . "%'";
    $res_calls_month = $db->Execute($qry_calls_month);
    ?>
    	
                    {"elapsed": "<?php echo userdate($arr_call); ?>", "value": <?php echo $res_calls_month->fields['month_calls_total']; ?>} <?php if ($i < count($arr_calls)) {
        echo ",";
    } ?>
    				
<?php } ?>
            ];
			
            //console.log(last_thirty_data);
            var last_seven_data = [
<?php
$calls_date_from = date('Y-m-d', strtotime("-06 days"));
$calls_date_to = date('Y-m-d');
$arr_calls = createDateRangeArray($calls_date_from, $calls_date_to);
$i = 0;
foreach ($arr_calls as $arr_call) {
    $i++;
    $qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%" . $arr_call . "%'";
    $res_calls_month = $db->Execute($qry_calls_month);
    ?>
    	
                    {"elapsed": "<?php echo userdate($arr_call); ?>", "value": <?php echo $res_calls_month->fields['month_calls_total']; ?>} <?php if ($i < count($arr_calls)) {
        echo ",";
    } ?>
    				
<?php } ?>
            ];
			
			
            var last_yesterday_data = [
<?php
$calls_date_from = date('Y-m-d', strtotime("-01 days"));
$calls_date_to = date('Y-m-d');
$arr_calls = createDateRangeArray($calls_date_from, $calls_date_to);
$i = 0;
foreach ($arr_calls as $arr_call) {
    $i++;
    $qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%" . $arr_call . "%'";
    $res_calls_month = $db->Execute($qry_calls_month);
    ?>
    	
                    {"elapsed": "<?php echo userdate($arr_call); ?>", "value": <?php echo $res_calls_month->fields['month_calls_total']; ?>} <?php if ($i < count($arr_calls)) {
        echo ",";
    } ?>
    				
<?php } ?>
            ];
			
			
            var today_data = [
<?php
$calls_date_from = date('Y-m-d');
$calls_date_to = date('Y-m-d');
$arr_calls = createDateRangeArray($calls_date_from, $calls_date_to);
$i = 0;
foreach ($arr_calls as $arr_call) {
    $i++;
    $qry_calls_month = "SELECT count(*) as month_calls_total FROM calls WHERE call_start LIKE '%" . $arr_call . "%'";
    $res_calls_month = $db->Execute($qry_calls_month);
    ?>
    	
                    {"elapsed": "<?php echo userdate($arr_call); ?>", "value": <?php echo $res_calls_month->fields['month_calls_total']; ?>} <?php if ($i < count($arr_calls)) {
        echo ",";
    } ?>
    				
<?php } ?>
            ];
	
</script>
<br />
<div class="row">
    <div class="col-lg-12">
        <h2 class="fl" style="margin-top:0px;" id="ch_title">Weekly Calls Breakup</h2>
        <div class="btn-group fr">
            <button type="button" class="btn btn-default" id="dayBtn" onClick="showCallData('daily')">Day</button>
            <button type="button" class="btn btn-default active " id="weekBtn" onClick="showCallData('week')">Week</button>
            <button type="button" class="btn btn-default" id="monthBtn" onClick="showCallData('month')">Monthly</button>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <table class="table table-bordered" id="table8">
                <tbody>
                    <tr>
                        <td><strong>Line Chart</strong> <br />
                            <div id="chart_life_time2" style="height: 300px;"></div>
                        </td>
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
            <div class="icon"><i class="entypo-clock"></i></div>
            <div class="num"><?php echo $averageCallDuration; ?> Sec</div>
            <h3>AVERAGE CALL TIME</h3>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-calendar"></i></div>
            <div class="num"><?php echo strtoupper($maxs[0]); ?></div>
            <h3>MOST ACTIVE DAY</h3>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="tile-stats tile-red">
            <div class="icon"><i class="entypo-phone"></i></div>
            <div class="num"><?php echo $missed; ?></div>
            <h3>MISEED CALLS</h3>
        </div>
    </div>
</div>
<br />
<hr />
<br />

<br />
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/datatables/responsive/css/datatables.responsive.css">
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/select2/select2.css">
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/selectboxit/jquery.selectBoxIt.css">
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/icheck/skins/minimal/_all.css">
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/icheck/skins/square/_all.css">
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/icheck/skins/flat/_all.css">
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/icheck/skins/futurico/futurico.css">
<link rel="stylesheet" href="<?php echo SURL ?>assets/js/icheck/skins/polaris/polaris.css">
<!-- Bottom Scripts -->
<script src="<?php echo SURL ?>assets/js/gsap/main-gsap.js"></script>
<script src="<?php echo SURL ?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?php echo SURL ?>assets/js/bootstrap.js"></script>
<script src="<?php echo SURL ?>assets/js/joinable.js"></script>
<script src="<?php echo SURL ?>assets/js/resizeable.js"></script>
<script src="<?php echo SURL ?>assets/js/neon-api.js"></script>
<script src="<?php echo SURL ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo SURL ?>assets/js/datatables/TableTools.min.js"></script>
<script src="<?php echo SURL ?>assets/js/dataTables.bootstrap.js"></script>
<script src="<?php echo SURL ?>assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
<script src="<?php echo SURL ?>assets/js/datatables/lodash.min.js"></script>
<script src="<?php echo SURL ?>assets/js/datatables/responsive/js/datatables.responsive.js"></script>
<script src="<?php echo SURL ?>assets/js/select2/select2.min.js"></script>
<script src="<?php echo SURL ?>assets/js/neon-chat.js"></script>
<script src="<?php echo SURL ?>assets/js/neon-custom.js"></script>
<script src="<?php echo SURL ?>assets/js/neon-demo.js"></script>
<!-- Bottom Scripts -->
<script src="<?php echo SURL ?>assets/js/raphael-min.js"></script>
<script src="<?php echo SURL ?>assets/js/morris.min.js"></script>
<script src="<?php echo SURL ?>assets/js/jquery.peity.min.js"></script>
<script src="<?php echo SURL ?>assets/js/neon-charts.js"></script>
<script src="<?php echo SURL ?>assets/js/jquery.sparkline.min.js"></script>
<!-- Bottom Scripts -->
<script src="<?php echo SURL ?>assets/js/select2/select2.min.js"></script>
<script src="<?php echo SURL ?>assets/js/typeahead.min.js"></script>
<script src="<?php echo SURL ?>assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="<?php echo SURL ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo SURL ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo SURL ?>assets/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo SURL ?>assets/js/daterangepicker/moment.min.js"></script>
<script src="<?php echo SURL ?>assets/js/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo SURL ?>assets/js/jquery.multi-select.js"></script>
<script src="<?php echo SURL ?>assets/js/icheck/icheck.min.js"></script>
