<?php //_dx($industry);?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | Update Article</title>
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
                            <h1>Article Update</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Article Update</li>
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
                                <h3 class="card-title">Update Article</h3>

                                <!-- <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="card-body">
                            <?php if(!empty($blog)):?>    
                            <form class="update-blog row" > 

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Blog Title</label>
                                    <textarea name="blog_title" value="<?=$blog[0]['blog_title']?>" type="text"  class="form-control" ><?=$blog[0]['blog_title']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                               
                                <div class="form-group col-md-6">
                                    <label for="inputName">url key</label>
                                    <input name="url_key" value="<?=$blog[0]['url_key']?>" class="form-control mb-1" id="formFileDisabled" />
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Date</label>
                                    <input name="date" value="<?=$blog[0]['date']?>" type="date"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                 <div class="form-group col-md-6">
                                    <label for="inputDescription">Industry</label>
                                    <select name="industry_id" class="form-control select2">
                                            <option value="">select industry</option>
                                            <?php foreach($industry as $industries):?>
                                            <?php if($industries['industry_id'] == $blog[0]['industry_id']):?>
                                               <option selected value="<?=$industries['industry_id']?>"><?=$industries['industry_name']?></option>
                                            <?php else:?> 
                                               <option value="<?=$industries['industry_id']?>"><?=$industries['industry_name']?></option>  
                                            <?php endif;?>   
                                            <?php endforeach; ?>

                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Short Description</label>
                                    <textarea name="short_description" value="<?=$blog[0]['short_description']?>" type="text"  class="form-control"><?=$blog[0]['short_description']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Description</label>
                                    <textarea name="description" type="text" value="<?=$blog[0]['description']?>" class="form-control"><?=$blog[0]['description']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Meta Description</label>
                                    <textarea value="<?=$blog[0]['meta_description']?>" name="meta_description" type="text"  class="form-control"><?=$blog[0]['meta_description']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Meta Keywords</label>
                                    <textarea value="<?=$blog[0]['meta_keywords']?>" name="meta_keywords" type="text"  class="form-control"><?=$blog[0]['meta_keywords']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Show on Home</label>
                                    <select name="show_on_front" class="form-control select2">
                                        <?php if($blog[0]['show_on_front'] == 1):?>  
                                            <option selected="selected" value="1" >Yes</option>
                                            <option value="0" >No</option>
                                          <?php else:?>  
                                            <option value="1" >Yes</option>
                                            <option selected="selected" value="0" >No</option>
                                          <?php endif;?>

                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                
                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2">
                                         <?php if($blog[0]['status'] == 1):?>  
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
                                    <label for="inputDescription">Image</label>
                                    <input name="blog_img" value="<?=$blog[0]['blog_img']?>" type="file"  class="form-control blog-img-input">
                                    <img class="blog-img" src="<?=site_url($blog[0]['blog_img'])?>" height="100px" width="100px" >
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>


                                <div class="Industries-btn d-flex justify-content-end 
                                mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary mr-1">Save</button>
                                    <button type="button" class="btn btn-info reset-form" form="update-blog" >Reset</button>
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
        //$('.select2').select2();
        //add item 
        $('body').on('submit','.update-blog',function(e){
          e.preventDefault();
               var blog_title              =   $('body').find('textarea[name=blog_title]');
              var industry_id               =   $('body').find('select[name=industry_id]');
              var url_key                   =   $('body').find('input[name=url_key]');
              
              blog_title = _blankReg(blog_title,"Blog title is required.")
              industry_id  = _selectoptionReg(industry_id,"Industry is required.")
              url_key = _blankReg(url_key,"url key is required.")

              if (blog_title&&industry_id&&url_key) {
                  var data    =   new FormData(this);
                  var url     = 'update-blog/'+'<?=$blog[0]['blog_id']?>';
                  var res     = sendAjaxFrm(url,data);
                  if (res.status == 'ERR') {
                    showMessage('danger',res.msg);
                  }else{
                    showMessage('success',res.msg); 
                    //$(this).trigger('reset')
                    window.location.replace("<?=site_url('blogs')?>");
                  }
              }
          
        });

        $('body').on('change','.blog-img-input',function(e){
           var tmppath = URL.createObjectURL(this.files[0])
           //console.log(tmppath)
           $('body').find('.blog-img').attr('src',tmppath)
        })

    </script>

</body>

</html>