<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | View Client</title>
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
            <!-- Content Header (Page header) -->
            <!-- <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>client View</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">client View</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section> -->

            <!-- Main content -->
            <section class="content container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 mt-3">
                        <div class="card card-primary">
                            <div class="card-header add-page-header">
                                <h3 class="card-title add-page-title text-center">Client</h3>

                                <!-- <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="card-body">
                              <?php if(!empty($client)):?> 
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item">
                                    <div class="view-label" >
                                        <i class="fas fa-tags text-primary mr-1"></i>
                                        <label>
                                            Client Name     
                                        </label>
                                    </div>
                                    
                                    <span class=""><?=$client[0]['client_name']?></span>
                                  </li>

                                  <li class="list-group-item">
                                    <div class="view-label" >
                                        <i class="fa fa-mobile text-primary mr-1"></i>
                                        <label>
                                            Client Mobile     
                                        </label>
                                    </div>
                                    
                                    <span class=""><?=$client[0]['client_mobile']?></span>
                                  </li>

                                  <li class="list-group-item">
                                    <div class="view-label" >
                                        <i class="fas fa-envelope text-primary mr-1"></i>
                                        <label>
                                            Client Email     
                                        </label>
                                    </div>
                                    
                                    <span class=""><?=$client[0]['client_email']?></span>
                                  </li>
                                 
                                  <li class="list-group-item">
                                    <div class="view-label" >
                                        <i class="fa fa-ban text-primary mr-1"></i>
                                        <label>Status</label>
                                    </div>
                                    
                                    <span class="">
                                        <?php if($client[0]['is_active']):?>
                                            ACTIVE
                                        <?php else:?>
                                            DEACTIVE
                                        <?php endif;?>
                                    </span>
                                  </li>
                                  <li class="list-group-item">
                                    <div class="view-label" >
                                        <i class="fa fa-image text-primary mr-1"></i>
                                        <label for="inputName">Image</label>
                                    </div>
                                    <span class="">
                                        <img src="<?=site_url($client[0]['image'])?>" height="100px" width="100px" >
                                    </span>
                                  </li>
                                </ul>
                              <?php else:?>
                                <img class="img-fluid" src="<?=site_url('assets/image/no_data_found.png')?>">
                              <?php endif;?> 
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
        </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<!-- ///////////////////////////////////////////////////////////////////// -->
        <?php $this->load->view('common/footer.php')?>
    
    </div>
    <!-- ./wrapper -->

    <script type="text/javascript">
      
    </script>

</body>

</html>