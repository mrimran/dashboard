<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<script type="text/javascript">
    
    jQuery(document).ready(function(){
        //var is_h = jQuery.isFunction(  );
        //console.log(is_h);
        //jQuery.modal();
        jQuery("#modal-recommend-message").hide();
    });
    
    function recommendUs(){
        
        var $ = jQuery;
        
        $.ajax({
            url:"<?php echo SURL ?>ajaxresponse/ajax2.php?act=recommend_us",
            type:"POST",
            cache:false,
            data:{to:$('#recommend-to').val(),message:$('#recommend-message').val()},
            success: function(data){
                var res = jQuery.parseJSON(data);
                $('#modal-recommend-message').removeData();
                if(res.type=='error'){
                    $("#modal-recommend-message").removeClass("alert-success").addClass("alert-danger");
                    $("#modal-recommend-message").html(res.msg);
                    $("#modal-recommend-message").show();
                } else if(res.type=='success'){
                    //$("#modal-recommend-message2").show();
                    //$("#modal-recommend-message2").html(res.msg);
                    $("#modal-recommend-message").removeClass("alert-danger").addClass("alert-success");
                    $("#modal-recommend-message").html(res.msg);
                    $("#modal-recommend-message").show();
                }
            }
        });
    }
    
</script>

<!---
Request A Call Modal Dialog
-->

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
  



<!---
Recommend Us Modal Dialog
-->
        
    <div class="modal fade share-modal" id="modal-recommend">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Recommend Us</h4>
      </div>
      <div class="modal-body">
          
          <div id="modal-recommend-message" class="alert alert-danger" role="alert"></div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="field-1" class="control-label">Recommend To</label>
              <input type="text" class="form-control" id="recommend-to" placeholder="johndoe@example.com">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="field-1" class="control-label">Message</label>
              <textarea class="form-control" id="recommend-message" placeholder="Type Your Message Here..."></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" onclick="recommendUs();">Send Report</button>
      </div>
    </div>
  </div>
</div>
  