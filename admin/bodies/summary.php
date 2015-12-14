<?php
//$qry_calls = "SELECT * FROM ".$tblprefix."calls"; 
//$res_calls = $db->Execute($qry_calls);
//$totalcountCalls =  $res_calls->RecordCount();

?>

<div class="row">
  <div class="col-sm-4">
    <ol class="breadcrumb bc-3">
      <li> <a href="index.html"><i class="entypo-home"></i>Dashboard</a> </li>
      <li> <a href="index.html">Social Media</a> </li>
      <li class="active"> <strong>Summary</strong> </li>
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
<h2>Platforms</h2>
<br />
<div class="row">
  <div class="col-sm-4">
    <div class="tile-stats custom-tile tile-fb">
      <div class="icon icon-fa"><i class="fa fa-facebook-square"></i></div>
      <div class="num">Facebook</div>
      <h3><i class="fa fa-caret-up"></i>200 Likes</h3>
      <h3><i class="fa fa-caret-up"></i>1600 Engagements</h3>
      <h3><i class="fa fa-caret-up"></i>32 Shares</h3>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="tile-stats custom-tile tile-tw">
      <div class="icon icon-fa"><i class="fa fa-twitter-square"></i></div>
      <div class="num">Twitter</div>
      <h3><i class="fa fa-caret-up"></i>50 Followers</h3>
      <h3><i class="fa fa-caret-up"></i>20 Retweets</h3>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="tile-stats custom-tile tile-gplus">
      <div class="icon icon-fa"><i class="fa fa-google-plus-square"></i></div>
      <div class="num">Google Plus</div>
      <h3><i class="fa fa-caret-up"></i>15 Followers</h3>
      <h3><i class="fa fa-caret-up"></i>10 Shares</h3>
    </div>
  </div>
</div>
<br />
<div class="row">
  <div class="col-sm-4">
    <div class="tile-stats custom-tile tile-insta">
      <div class="icon icon-fa"><i class="fa fa-instagram"></i></div>
      <div class="num">Instagram</div>
      <h3><i class="fa fa-caret-up"></i>12 Followers</h3>
      <h3><i class="fa fa-caret-up"></i>50 Likes</h3>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="tile-stats custom-tile tile-linkedin">
      <div class="icon icon-fa"><i class="fa fa-linkedin-square"></i></div>
      <div class="num">Linkedin</div>
      <h3><i class="fa fa-caret-up"></i>10 Followers</h3>
      <h3><i class="fa fa-caret-up"></i>01 Shares</h3>
    </div>
  </div>
</div>
<br />
<br />
<br />
<div class="row">
  <div class="col-sm-12">
    <div class="action-links"> <a href="social-media-timeline.html">Show Me The Timeline</a>
      <hr />
    </div>
  </div>
</div>
<br />
<br />
<div class="row">
  <div class="viral-links">
    <h1>We Are Sure That You’re Happy With Our Service</h1>
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
<link rel="stylesheet" href="<?php echo SURL?>assets/js/vertical-timeline/css/component.css">
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