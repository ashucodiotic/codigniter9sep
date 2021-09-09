<?php //_dx($industry);?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | Add Client</title>
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Client Add</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Client Add</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header add-page-header">
                                <h3 class="card-title">Add Client</h3>

                                <!-- <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="card-body">
                                
                            <form class="add-client row" > 

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Client Name</label>
                                    <input name="client_name" type="text"  class="form-control" />
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                               
                                <div class="form-group col-md-6">
                                    <label for="inputName">Client Mobile</label>
                                    <input name="client_mobile" class="form-control mb-1" id="formFileDisabled" />
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Client Email</label>
                                    <input name="client_email" type="text"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Image</label>
                                    <input name="client_img" type="file"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                               
                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control select2">
                                        <option value="1" selected="selected">Active</option>
                                        <option value="0">Inactive</option>

                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>




                                <div class="Industries-btn d-flex justify-content-end 
                                mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary mr-1">Save</button>
                                    <button type="button" class="btn btn-info reset-form" form="add-client" >Reset</button>
                                </div>
                            </form>    
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
        //$('.select2').select2();
        //add item 
        $('body').on('submit','.add-client',function(e){
          e.preventDefault();
              var client_name               =   $('body').find('input[name=client_name]');
              var client_mobile             =   $('body').find('input[name=client_mobile]');
              var client_email              =   $('body').find('input[name=client_email]');

              client_name = _onlyAlphaReg(client_name,"Invalid client name.")
              client_mobile = _indiaMobileReg(client_mobile,"Invalid client mobile.")
              client_email = _emailReg(client_email,"Invalid client email.")

              if (client_mobile&&client_name&&client_email) {
                  var data    =   new FormData(this);
                  var url     = 'create-client';
                  var res     = sendAjaxFrm(url,data);
                  if (res.status == 'ERR') {
                    showMessage('danger',res.msg);
                  }else{
                    showMessage('success',res.msg); 
                    $(this).trigger('reset')
                    window.location = "<?=site_url('clients')?>";
                  }
              }
          
        });
    </script>

</body>

</html>