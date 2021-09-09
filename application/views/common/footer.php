 <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="https://adminlte.io">Adhoc.com</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- jQuery -->
<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-notify.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery-confirm.min.js') ?>"></script>

<script type="text/javascript">
    var siteurl = "<?=site_url();?>"

    function showMessage(type,msg){
    var i   = '';
    if (type == 'danger') {
        i   = 'fa fa-exclamation-circle';
    }else if(type == 'success'){
        i   = 'fa fa-check-circle';
    }
    $.notify({
        icon : i,
        message:msg,    
        },{
            type:type,
            timer:1000,
            delay: 5000,
            placement:{from:'bottom',align:'center'}
        }
      )
  };

</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/dist/js/demo.js') ?>"></script>


    <!-- Summernote -->
    <script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>
    <!-- CodeMirror -->
    <script src="<?= base_url('assets/plugins/codemirror/codemirror.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/codemirror/mode/css/css.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/codemirror/mode/xml/xml.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/codemirror/mode/htmlmixed/htmlmixed.js') ?>"></script>

    <script src="<?= base_url('assets/js/handlebars.js')?>"></script>

    <!-- select 2 start -->
    <script src="<?= base_url('assets/js/select2.min.js')?>"></script>
    <!-- select 2 end -->
    <script src="<?= base_url('assets/js/halper_script.js')?>"></script>
    <script src="<?= base_url('assets/js/validation.js')?>"></script>
    <script src="<?= base_url('assets/js/script.js')?>"></script>

<script>
    $(function () {
        // Summernote
        $('#summernote').summernote()

        // CodeMirror
        CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "htmlmixed",
            theme: "monokai"
        });
    })
</script>