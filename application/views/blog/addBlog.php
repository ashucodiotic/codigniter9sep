<?php //_dx($industry);?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | Add Blog</title>
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
                            <h1>Blog Add</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Blog Add</li>
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
                                <h3 class="card-title">Add Blog</h3>

                                <!-- <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="card-body">
                                
                            <form class="add-blog row" > 

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Blog Title</label>
                                    <textarea name="blog_title" type="text"  class="form-control"></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                               
                                <div class="form-group col-md-6">
                                    <label for="inputName">Url Key</label>
                                    <input name="url_key" class="form-control mb-1" id="formFileDisabled" />
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Date</label>
                                    <input name="date" type="date"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Industry</label>
                                    <select name="industry_id" class="form-control select2">
                                            <option value="">select industry</option>
                                            <?php foreach($industry as $industries):?>
                                               <option value="<?=$industries['industry_id']?>"><?=$industries['industry_name']?></option>
                                            <?php endforeach; ?>

                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Image</label>
                                    <input name="blog_img" type="file"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Short Description</label>
                                    <textarea name="short_description" type="text"  class="form-control"></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Description</label>
                                    <textarea name="description" type="text"  class="form-control"></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Meta Description</label>
                                    <textarea name="meta_description" type="text"  class="form-control"></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Meta Keywords</label>
                                    <textarea name="meta_keywords" type="text"  class="form-control"></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Show on Home</label>
                                    <select name="show_on_front" class="form-control select2">
                                        <option value="0" selected="selected">No</option>
                                        <option value="1" >Yes</option>

                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2">
                                        <option value="1" selected="selected">Active</option>
                                        <option value="0">Inactive</option>

                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>




                                <div class="Industries-btn d-flex justify-content-end 
                                mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary mr-1">Save</button>
                                    <button type="button" class="btn btn-info reset-form" form="add-blog" >Reset</button>
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
        $('body').on('submit','.add-blog',function(e){
          e.preventDefault();
              var blog_title                =   $('body').find('textarea[name=blog_title]');
              var industry_id               =   $('body').find('select[name=industry_id]');
              var url_key                   =   $('body').find('input[name=url_key]');

              blog_title = _blankReg(blog_title,"Blog title is required.")
              industry_id  = _selectoptionReg(industry_id,"Industry is required.")
              url_key = _blankReg(url_key,"url key is required.")

              if (blog_title&&industry_id&&url_key) {
                  var data    =   new FormData(this);
                  var url     = 'create-blog';
                  var res     = sendAjaxFrm(url,data);
                  if (res.status == 'ERR') {
                    showMessage('danger',res.msg);
                  }else{
                    showMessage('success',res.msg); 
                    $(this).trigger('reset')
                    window.location = "<?=site_url('blogs')?>";
                  }
              }
          
        });
    </script>

</body>

</html>