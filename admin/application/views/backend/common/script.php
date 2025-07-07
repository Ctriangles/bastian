<?php if($this->uri->segment(2) == 'add_settings' || $this->uri->segment(2) == 'EditSettings') { 
    if(@$editdata->setting_name == "site_logo" || @$editdata->setting_name == "site_otherlogo" ||  @$editdata->setting_name == "site_favicon"||  @$editdata->setting_name == "site_whitelogo" ) {
   echo '<script> $("#setting_value").hide();
   $("#file_logo").show(); </script>';
} else {
    echo '<script> $("#setting_value").show();
    $("#file_logo").hide(); </script>';
}
?>
<script>
   $("#sitesetting").change(function () {
       var selectedText = $(this).find("option:selected").text();
       var selectedValue = $(this).val();
       if(selectedValue=="site_logo" || selectedValue=="site_otherlogo" || selectedValue=="site_favicon" || selectedValue=="site_whitelogo") {
           $("#setting_value").hide();
           $("#file_logo").show();
        } else {
            $("#file_logo").hide();
            $("#setting_value").show();
        }
    });
</script>
<?php } ?>


<?php if($this->uri->segment(2) == 'EditRoles' || $this->uri->segment(2) == 'add_roles') { ?>
<script>
    $(document).ready(function() {
        $('.parentcheck').change(function() {
            var $childCheckboxes = $(this).closest('.rolesbox').find('.childcheck');
            if ($(this).is(':checked')) {
                $childCheckboxes.prop('checked', true);
                $childCheckboxes.prop('disabled', false);
            } else {
                $childCheckboxes.prop('checked', false);
                $childCheckboxes.prop('disabled', true);
            }
        });
    });
</script>
<?php } ?>

<?php if($this->uri->segment(2) == 'add_pages' || $this->uri->segment(2) == 'EditPage') { ?>
<?php if(@$editdata->add_menu == "1" && @$editdata->post_parent == '0') {
   echo '<script>$("#menupriority").show();</script>';
} else if(@$editdata->add_menu == "1" && @$editdata->post_parent != '0') {
   echo '<script>$("#menupriority").show();</script>';
} else {
   echo '<script>$("#menupriority").hide();</script>';
}
?>
<script>
   jQuery(document).ready(function() {
      jQuery('#add_menu').change(function() {
         if ($('#post_parent').val() == '' && $(this).prop('checked')) {
            $("#menupriority").show();
         } else if($(this).prop('checked')) {
            $("#menupriority").show(); 
         } else {
            $("#menupriority").hide();
         }
      });
   });
</script>
<?php } ?>


<?php if($this->uri->segment(2) == 'add_users' || $this->uri->segment(2) == 'EditUsers' || $this->uri->segment(2) == 'profile') {
if(@$editdata->user_for == "backend") {
    echo '<script> $("#user_types").show();</script>';
 } else {
     echo '<script> $("#user_types").hide();</script>';
 }
 ?>
<script>
   $("#user_for").change(function () {
       var selectedText = $(this).find("option:selected").text();
       var selectedValue = $(this).val();
       if(selectedValue=="front") {
           $("#user_types").hide();
        } else  {
            $("#user_types").show();
        }
    });
</script>
<?php } ?>
