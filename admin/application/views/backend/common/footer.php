</div>
</div>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 text-center"><?=@$this->copyright?></div>
        </div>
    </div>
</footer>
</div>
</div>
<!-- JAVASCRIPT -->
<script src="<?=site_url('assets/libs/jquery/jquery.min.js')?>"></script>
<script src="<?=site_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<script src="<?=site_url('assets/libs/metismenu/metisMenu.min.js')?>"></script>
<script src="<?=site_url('assets/libs/node-waves/waves.min.js')?>"></script>
<script src="<?=site_url('assets/libs/simplebar/simplebar.min.js')?>"></script>
<!-- App js -->
<script src="<?=site_url('assets/js/app.js')?>"></script>
<script src="<?=site_url('assets/libs/datatables.net/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=site_url('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?=site_url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?=site_url('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')?>"></script>
<script src="<?=site_url('assets/js/pages/datatables.init.js')?>"></script>
<script src="<?=site_url('assets/libs/select2/js/select2.min.js')?>"></script>
<script src="<?=site_url('assets/js/pages/form-advanced.init.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<?php $this->load->view('backend/common/script'); ?>
<script>
    var site_url = '<?=site_url()?>';
    var current_url = '<?=$this->uri->segment(2)?>';
</script>
<script src="<?=site_url('assets/js/custom.js')?>"></script>
<script>
    function goBack() {
        window.history.back();
    }
</script>
<script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
<style>.toggle-password {float: right;cursor: pointer;margin-right: 15px;margin-top: -25px;font-size: 14px;}</style>
<script>
   var button1 = document.getElementById( 'imgbutton' );
   button1.onclick = function() {
       selectFileWithCKFinder( 'imgpath' );
   };
   function selectFileWithCKFinder( elementId ) {
       CKFinder.modal( {
           chooseFiles: true,
           width: 800,
           height: 600,
           onInit: function( finder ) {
               finder.on( 'files:choose', function( evt ) {
                   var file = evt.data.files.first();
                   var output = document.getElementById( elementId );
                   var url= file.getUrl();
                   var myurl=  url.replace('/', '')
                   output.value = myurl;
                   var img = $('<img />',
                   { id: 'Myid',
                       src: url,
                       width: 200
                   });
                   $('#imgsrc').html(img).show();
               } );
               finder.on( 'file:choose:resizedImage', function( evt ) {
                   var output = document.getElementById( elementId );
                   output.value = evt.data.resizedUrl;
               } );
           }
       } );
   }
</script>
<script>
    $("#meta_keywords").tagsinput('items');
</script>
</body>
</html>
