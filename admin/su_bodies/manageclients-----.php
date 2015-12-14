<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('SU'))
    die();

include_once 'include/common.php';

$msg = "";$error="";

if(isset($_REQUEST['sub']) && $_REQUEST['sub']=='delete'){
    if(isset($_REQUEST['id'])){
        $id = (int)$_REQUEST['id'];
        //fetch the existing thumbnail
        $sql = "SELECT image from tbl_admin WHERE id='$id'";
        $r1 = $db->Execute($sql);
        if($r1->RecordCount()>0){
            $old_thumb = $r1->fields['image'];
            $upload_path = './assets/images/';
            if(!$old_thumb!='' && $old_thumb!='profile-default.png')
                unlink($upload_path.$old_thumb);
        }
        
        $q = "DELETE from tbl_admin WHERE id=$id";
        $r = $db->Execute($q);
        if($r){
            $msg = 'Client Deleted Successfully';
        } else{
            $error = 'Error deleting client';
        }
    }
}


$q = "SELECT * FROM tbl_admin";
$cl = $db->Execute($q);
$c = $cl->RecordCount();

?>
<div class="row">
  <div class="col-sm-4">
    <ol class="breadcrumb bc-3">
      <li> <a href="admin.php?act=dashboard"><i class="entypo-home"></i>Dashboard</a> </li>
      <li class="active"> <strong>Clients</strong> </li>
    </ol>
  </div><div class="fr custom-btn"> <a href="admin.php?act=addclient" class="btn btn-blue fr">Add Client</a> </div>
    <div class="clearfix"></div>
</div>
<h2>Manage Clients</h2>
<br />
<?php
print_success($msg);
print_error($error);
?>
<div id="sortResult">
    <table class="table table-bordered datatable" id="table-clients">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Client</th>
                <th>Email</th>
                <th>Name</th>
                <th>Username</th>
                <th>No-reply email</th>
                <th>Notify email</th>
                <th>Account Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($c > 0){
                while(!$cl->EOF){
                    ?>
                        <tr>
                        <td></td>
                        <td><?php echo $cl->fields['name'];?> </td>
                        <td><?php echo $cl->fields['email'];?> </td>
                        <td><?php echo $cl->fields['name'];?> </td>
                        <td><?php echo $cl->fields['username'];?> </td>
                        <td><?php echo $cl->fields['noreplyemail'];?> </td>
                        <td><?php echo $cl->fields['notifyemail'];?> </td>
                        <td><?php echo $cl->fields['account_type'];?> </td>
                        <td><a href="admin.php?act=editclient&id=<?php echo $cl->fields['id']; ?>">
                                <i class="fa fa-pencil-square-o"></i></a>
                            <a href="admin.php?act=manageclients&sub=delete&id=<?php echo $cl->fields['id']; ?>"><i class="fa fa-trash-o" onClick="return confirm('Are you sure you want to delete this client?');"></i></a> </td>
                        </tr>
                    <?php
                    $cl->MoveNext();
                }
            }
            ?>
            
        </tbody>
    </table>
</div>
    








<script type="text/javascript">
    jQuery(document).ready(function($)
    {
        var table = $("#table-clients").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-6 col-left'l><'col-xs-6 col-right'<'export-data'T>f>r>t<'row'<'col-xs-6 col-left'i><'col-xs-6 col-right'p>>",
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ){
                var index = iDisplayIndexFull +1;
                $('td:eq(0)',nRow).html(index);
                return nRow;
            },
            "aoColumns": [
              { "bSortable": false },
              null,
              null,
                null,
                null,
                null,
                null,
                null,
              { "bSortable": false }
              ]
        });
    });
    
    
</script>





    
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
