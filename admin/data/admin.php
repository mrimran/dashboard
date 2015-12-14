<?php 
error_reporting(0);
include('file_include.php');
include('process.php');
	
######################
#
# 	POST SECTION
#
######################

if(isset($_POST['mode'])){

	$inner_page = $_POST['request_page'];
	
	if($inner_page==""){
		$inner_page = "index";
	}
	
	include("query.include/".$inner_page.".php");

}//end if(isset($_POST['mode']))

######################
#
# 	GET SECTION
#
######################

if(isset($_GET['mode'])){
	
	$inner_page = $_GET['request_page'];
	
	if($inner_page==""){
		$inner_page = "index";
	}

	include("query.include/".$inner_page.".php");
		
}// END if(isset($_GET['mode']))
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Neon Admin Panel" />
<meta name="author" content="" />
<title><?php echo ADMIN_TITLE?></title>
<?php include('script_include.php');?>
</head>
<body class="page-body  page-fade" data-url="http://neon.dev">
<div class="page-container">
  <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
  <?php
  if($_SESSION['lm_auth']['account_type']=='super'){
        define('SU',1);
        define('SU_PRE','su');
  	include("include/leftpanel_admin.php");
  }else{
	include("include/leftpanel_client.php");  
  }
  ?>
  <div class="main-content">
    <?php
	  include("include/header.php"); 
	  
            $dir = (defined('SU'))?'su_bodies/':'bodies/';
            
                if(isset($_REQUEST['act'])){
                   
                        $f = $_REQUEST['act'].'.php';
                        //if(defined('SU')) $f = SU_PRE.$f;
                        
                        if(file_exists("$dir"."$f")){ include "$dir"."$f";}
                        
                        
//                        /echo 'here',$dir.$f; die();
                        
                        else include $dir.'/error.php';

                        /*if(file_exists("bodies/".$_REQUEST['act'].".php")){

                                include("bodies/".$_REQUEST['act'].".php");

                        }else{
                                include("bodies/error.php");

                        }*/
                }else{

                        include($dir."dashboard.php");
                }
			
		include("include/footer.php"); 
		?>
  </div>

<div class="modal fade" id="modal-4" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Request A Call</h4>
      </div>
      <div class="modal-body"> Our Support Department Will Call you Shortly.<br />
        <br />
        Thank You. </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" onClick="sendRequestCall();">Continue</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

	function sendRequestCall(){		
		$.ajax({	
		  url: "<?php echo SURL?>process.php",
		  type: "GET",
		  catche:"false",
		  data:{act:"sendRequestCall"},
		  success: function (data) {		  
			 
			  }
		})
	}

</script>

</div>
</body>
</html>