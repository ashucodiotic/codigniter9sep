<?php //_dx(base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'));  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | All Articles</title>
    <?php $this->load->view('common/head.php')?>
    
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php $this->load->view('common/navbar.php')?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php $this->load->view('common/sidebar.php')?>
        <!-- ///////////////////////////////////////////////////////////////////// -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            

            <!-- Main content -->
            <section class="content">

              

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- ///////////////////////////////////////////////////////////////////// -->
        <?php $this->load->view('common/footer.php')?>
       
    </div>
    <!-- ./wrapper -->

    
</body>

</html>