<?php //_dx($industry); ?>
<?php //echo( $industry[0]['is_active'] == 1 ? 'selected' : '' ); ?>
<?php //echo( $industry[0]['is_active'] == 0 ? 'selected' : '' ); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | Update Industry</title>
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
                            <h1>Industry Update</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Industry Update</li>
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
                                <h3 class="card-title">Update Industry</h3>

                                <!-- <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="card-body">
                            <?php if(!empty($industry)):?>    
                            <form class="update-industry row" > 

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Industry Name</label>
                                    <input value="<?=$industry[0]['industry_name']?>" name="industry_name" type="text" id="inputName" class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Show on Home</label>
                                    <select name="show_on_front" class="form-control select2">
                                        <?php if($industry[0]['show_on_front'] == 0):?>
                                            <option selected="selected" value="0" >No</option>
                                            <option value="1" >Yes</option>
                                        <?php else:?>
                                            <option value="0" >No</option>
                                            <option selected="selected" value="1" >Yes</option>
                                        <?php endif;?>    
                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control select2">
                                      <?php if($industry[0]['is_active'] == 1):?>  
                                        <option selected="selected" value="1" >Active</option>
                                        <option value="0" >Inactive</option>
                                      <?php else:?>  
                                        <option value="1" >Active</option>
                                        <option selected="selected" value="0" >Inactive</option>
                                      <?php endif;?>  
                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Popular</label>
                                    <select name="is_popular" class="form-control select2">
                                        <?php if($industry[0]['is_popular'] == 0):?>
                                            <option selected="selected" value="0" >No</option>
                                            <option value="1" >Yes</option>
                                        <?php else:?>
                                            <option value="0" >No</option>
                                            <option selected="selected" value="1" >Yes</option>
                                        <?php endif;?>    
                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputName">Image</label>

                                    <input name="industry_img" class="form-control mb-1 industry-img-input" type="file" id="formFileDisabled" />

                                    <img class="industry-img" src="<?=$industry[0]['industry_img']?>" height="100px" width="100px" >
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>


                                <div class="Industries-btn d-flex justify-content-end 
                                mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary mr-1">Update</button>
                                    <button type="button" class="btn btn-info reset-form" form="update-industry" >Reset</button>
                                </div>
                            </form>
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
        //add item 
        $('body').on('submit','.update-industry',function(e){
          e.preventDefault();
              var industry_name              =   $('body').find('input[name=industry_name]');
              var is_active                  =   $('body').find('select[name=is_active]');
              var show_on_front              =   $('body').find('select[name=show_on_front]');
              var industry_img               =   $('body').find('input[name=industry_img]');

              industry_name = _blankReg(industry_name,"Industry name is required.")

              if (industry_name) {
                  var data    =   new FormData(this);
                  var url     = 'update-industry/'+'<?=$industry[0]['industry_id']?>';
                  var res     = sendAjaxFrm(url,data);
                  if (res.status == 'ERR') {
                    showMessage('danger',res.msg);
                  }else{
                    showMessage('success',res.msg); 
                    //$(this).trigger('reset')
                    window.location.replace("<?=site_url('industries')?>");
                  }
              }
          
        });

        $('body').on('change','.industry-img-input',function(e){
           var tmppath = URL.createObjectURL(this.files[0])
           //console.log(tmppath)
           $('body').find('.industry-img').attr('src',tmppath)
        })
    </script>

</body>

</html>