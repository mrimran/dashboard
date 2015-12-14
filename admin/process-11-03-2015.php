<?php
if(isset($_POST['mode'])){ 
/********************************        START - Edit Login Credential              *********************************/
  
 
 if($_POST['mode']=='send' && $_POST['act']=='loginprofile'){
	
		$sql = "UPDATE ".$tblprefix."admin SET username = '".addslashes($_POST['username'])."', password = '".addslashes($_POST['password'])."' WHERE id = '1'";
		$rs = $db->Execute($sql);
		
		if($rs){
		
			$msg=base64_encode("Login Credential updated successfully.");
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
			
		}else{
		
			$msg=base64_encode("Login Credential could not be updated");
			header("Location: admin.php?errmsg=$msg&act=".$_POST['act']);
			
		}
		exit;
	}
  
/********************************        END - Edit Login Credential              *********************************/
  
  
  
  
/********************************        START - Admin Profile Changes             *********************************/
  
  if($_POST['mode']=='send' && $_POST['act']=='profile'){
  
		 $sql = "UPDATE ".$tblprefix."admin SET
											name = '".addslashes($_POST['name'])."',
											email = '".addslashes($_POST['email'])."',
											noreplyemail = '".addslashes($_POST['noreplyemail'])."',
											notifyemail = '".addslashes($_POST['notifyemail'])."',
											username = '".addslashes($_POST['username'])."',
											paypal_email = '".addslashes($_POST['paypal_email'])."',
											email_status = '".addslashes($_POST['email_status'])."'
											WHERE id = '1'";
		
		$rs = $db->Execute($sql);
		if($rs){
		
			$_SESSION['interior_auth']['name']=$_POST['name'];
			$msg=base64_encode("Profile updated successfully.");
			header("Location: admin.php?okmsg=$msg&act=".$_POST['act']);
			
		}else{
		
			$msg=base64_encode("Profile could not be updated");
			header("Location: admin.php?errmsg=$msg&act=".$_POST['act']);
			
		}
		exit;
	}
  
  
/********************************        END- Admin Profile Changes             *********************************/
 
 
 
/********************************       START- Manage Content Managment            *********************************/
	/* Add Content Page */
 	if($_POST['mode']=='send' && $_POST['act'] == 'addcontentpage' && isset($_POST['addcontentSbt'])){ 
			$page_title = addslashes(trim($_POST['page_title']));
			$meta_title = addslashes(trim($_POST['meta_title']));
			$meta_keyword = addslashes(trim($_POST['meta_keyword']));
			$meta_phrase = addslashes(trim($_POST['meta_phrase']));
			$meta_description = addslashes(trim($_POST['meta_description']));
			$description = addslashes(trim($_POST['description'])); 
			
			$qry_max = "select MAX(porder) as maxid FROM ".$tblprefix."pagecontent";
			$rs_result = $db->Execute($qry_max);
	
			$nextOrder=$rs_result->fields['maxid']+1;
				
			$qry_insert = "INSERT INTO ".$tblprefix."pagecontent SET  page_title = '".$page_title."',meta_title = '".$meta_title."' , meta_keyword = '".$meta_keyword."' , meta_phrase = '".$meta_phrase."' , meta_description = '".$meta_description."' , description = '".addslashes($description)."', porder = $nextOrder, status = 1";		
			$rs_insert = $db->Execute($qry_insert);
	
			if($rs_insert){
				$okmsg = base64_encode('Page added successfully.');
				header("Location: admin.php?act=managecontentpages&okmsg=$okmsg");
				exit;	
			
			}
		}
 	
 
 	/* Edit Content Page */
if($_POST['mode']=='send' && $_POST['act'] == 'editcontentpage' && isset($_POST['editContentSbt'])){ 
			
			
			
			$page_title = addslashes(trim($_POST['page_title']));
			$meta_title = addslashes(trim($_POST['meta_title']));
			$meta_keyword = addslashes(trim($_POST['meta_keyword']));
			$meta_phrase = addslashes(trim($_POST['meta_phrase']));
			$meta_description = addslashes(trim($_POST['meta_description']));
			$description = addslashes(trim($_POST['description'])); 
			$eid=$_POST['eid'];			
										
			 $qry_insert = "UPDATE ".$tblprefix."pagecontent SET  page_title = '".$page_title."',meta_title = '".$meta_title."' , meta_keyword = '".$meta_keyword."' , meta_phrase = '".$meta_phrase."' , meta_description = '".$meta_description."' , description = '".addslashes($description)."' WHERE id=$eid";		
			$rs_insert = $db->Execute($qry_insert);
	
			if($rs_insert){
				$okmsg = base64_encode('Contents Updated successfully.');
				header("Location: admin.php?act=managecontentpages&okmsg=$okmsg");
				exit;	
			
			}
		}
		

	
/********************************       END- Manage Content Managment             *********************************/




	} // end of if(isset($_POST['mode']))
	
	


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if(isset($_GET['mode'])){
	
	
	/* **************************************************** START:  Content Managment Section ****************************************/
	
	 /*START: Change Page Status */
		if($_GET['mode']=='updatepagestatus' && isset($_GET['status'])){

				$oldstatus = $_GET['status'];
				$act=$_GET['act'];
				$eid=$_GET['id'];
				$pid=$_GET['pid'];
				
				if($oldstatus == '0'){
					
					$newstatus = 1;
				}else{
		
					$newstatus = 0;
				}
				
				$update_qry = "UPDATE ".$tblprefix."pagecontent SET status = '".$newstatus."' WHERE id = '".$eid."'";
				$update_rs = $db->Execute($update_qry);
				
				if($update_rs){
				   
					$_SESSION['updatestatus']='yes'; 
					$okmsg = base64_encode('Page Status updated successfully.');
					
					if(isset($_GET['pid'])){
					
						header("Location: admin.php?act=$act&id=$pid&okmsg=$okmsg");
						exit;
					
					}else{
					
						header("Location: admin.php?act=$act&okmsg=$okmsg");
						exit;
					}
					
				
				}//end if($update_rs)
				exit;
		
		}/*END: Change Product Status */
		
		
		
		
		
	/* START: Delete Content Page   */
	
	if($_GET['mode']=='delcontentpage' && isset($_GET['delid'])){
	
		$did=$_GET['delid'];
		$act=$_GET['act'];	
		$pid=$_GET['pid'];
		
		
		// Delete Child pages
		$update_qry = "DELETE FROM ".$tblprefix."pagecontent WHERE parent_id=$did";
		$update_rs = $db->Execute($update_qry);
		
		
		
		// Delete parent page
		$update_qry = "DELETE FROM ".$tblprefix."pagecontent WHERE id=$did";
		$update_rs = $db->Execute($update_qry);
		
		if($update_rs){
		
			$okmsg = base64_encode('Page Deleted successfully.');
			
			
			if(isset($_GET['pid'])){
						
					header("Location: admin.php?act=$act&id=$pid&okmsg=$okmsg");
					exit;
			
				}else{
			
					header("Location: admin.php?act=$act&okmsg=$okmsg");
					exit;
				}
						
			
			}//end if($update_rs)
				
		}
	
	/* END: Delete Content Page  */
	
	
	
	
	
	
	
	/* START: Change Page displaying order */
	
	//if($_GET['mode']=='orderchange' && isset($_GET['status'])){
//			
//			$id=$_GET['id'];
//			$movetype=$_GET['status'];
//			$act=$_GET['act'];
//			
//			$qry_order = "select id,porder FROM ".$tblprefix."pagecontent WHERE id=".$id."";
//			$rs_result = $db->Execute($qry_order);
//			
//			
//			if($movetype=='up'){
//			
//			$neworder=$rs_result->fields['porder']-1;
//			$neworder2=$rs_result->fields['porder'];
//			$qry_order = "select id FROM ".$tblprefix."pagecontent WHERE porder=".$neworder;
//			$rs_result = $db->Execute($qry_order);
//			
//			$newid2=$rs_result->fields['id'];
//			
//			
//			}
//			
//			
//			if($movetype=='down'){
//			
//			
//			$neworder=$rs_result->fields['porder']+1;
//			$neworder2=$rs_result->fields['porder'];
//			
//			$qry_order = "select id FROM ".$tblprefix."pagecontent WHERE porder=".$neworder;
//			$rs_result = $db->Execute($qry_order);
//			
//			$newid2=$rs_result->fields['id'];
//			
//			}
//			
//			$qry_attrib="UPDATE ".$tblprefix."pagecontent SET porder='$neworder2' WHERE id=".$newid2;
//			$rs_attrib=$db->Execute($qry_attrib);
//			//echo "<br>";
//		    $qry_attrib="UPDATE ".$tblprefix."pagecontent SET porder='$neworder' WHERE  id=".$id;
//			$rs_attrib=$db->Execute($qry_attrib);
//			//exit;
//			if($rs_attrib){
//			
//			$okmsg = base64_encode("Page Displaying Order Changed Successfully. !");
//			header("Location: admin.php?act=$act&okmsg=$okmsg");
//			exit;
//			
//			}
//			
//			
//		
//		}
		
	/* END: Chnage Page displaying Order */
	
	/* START: Change category displaying order */
	
	if($_GET['mode']=='orderchange' && isset($_GET['status'])){
			
			$id=$_GET['id'];
			$movetype=$_GET['status'];
			$act=$_GET['act'];
			
			$qry_order = "select id,porder FROM ".$tblprefix."category WHERE id=".$id."";
			$rs_result = $db->Execute($qry_order);
			
			
			if($movetype=='up'){
			
			$neworder=$rs_result->fields['porder']-1;
			$neworder2=$rs_result->fields['porder'];
			
			$qry_order = "select id FROM ".$tblprefix."category WHERE porder=".$neworder;
			$rs_result = $db->Execute($qry_order);
			
			$newid2=$rs_result->fields['id'];
			
			
			}
			
			
			if($movetype=='down'){
			
			
			$neworder=$rs_result->fields['porder']+1;
			$neworder2=$rs_result->fields['porder'];
			
			$qry_order = "select id FROM ".$tblprefix."category WHERE porder=".$neworder;
			$rs_result = $db->Execute($qry_order);
			
			$newid2=$rs_result->fields['id'];
			
			}
			
			$qry_attrib="UPDATE ".$tblprefix."category SET porder='$neworder2' WHERE id=".$newid2;
			$rs_attrib=$db->Execute($qry_attrib);
			//echo "<br>";
		    $qry_attrib="UPDATE ".$tblprefix."category SET porder='$neworder' WHERE  id=".$id;
			$rs_attrib=$db->Execute($qry_attrib);
			//exit;
			if($rs_attrib){
			
			$okmsg = base64_encode("category Displaying Order Changed Successfully. !");
			header("Location: admin.php?act=$act&okmsg=$okmsg");
			exit;
			
			}
			
			
		
		}
	
	/* END: Chnage category displaying Order */
	
/* **************************************************** END:  Content Managment Section ****************************************/
		
	
	} // end  of if(isset($_GET['mode'])){


	 if($_GET['act']=='sendRequestCall'){
		session_start();
		include("include/libmail.php");
		$userName = $_SESSION['lm_auth']['name'];
		$userEmail = $_SESSION['lm_auth']['email'];
		$noreplyemail = $_SESSION['lm_auth']['noreplyemail'];
		//echo $userEmail."ffff";exit;
		$subject = "Call Request";
		$body = "Hi Admin,<br> ".$userName." has requested for call. Please take appropriate action.<br> Thanks,<br>Agency Dashboard";
	
                $q = "SELECT name, notifyemail FROM tbl_admin WHERE account_type='super'"; 
                $r = $db->Execute($q);
                $t = $r->RecordCount();
                $su_emails = array();
                if($t>0){
                    $su_emails[]=$t->fields['notifyemail'];
                }
                $emails = implode(',', $su_emails);
		$mContact = new Mail;
		$mContact->From("Agency Dashboard <".$noreplyemail.">");
		$mContact->To($emails);
                //$mContact->To('dasatti@gmail.com');
		$mContact->Subject($subject);
		$mContact->Body(stripslashes($body));
		$mContact->Priority(3) ; 
		$mContact->Send();
			
	}


?>