<?php //_dx($industry);?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | Update Report</title>
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
                            <h1>Report Update</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Report Update</li>
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
                                <h3 class="card-title">Update Report</h3>

                                <!-- <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="card-body">
                            <?php if(!empty($report)):?>    
                            <form class="update-report row" > 

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Report Title</label>
                                    <textarea name="report_title" value="<?=$report[0]['report_title']?>" type="text"  class="form-control"><?=$report[0]['report_title']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                               
                                <div class="form-group col-md-6">
                                    <label for="inputName">Url Key</label>
                                    <input name="url_key" value="<?=$report[0]['url_key']?>" class="form-control mb-1" id="formFileDisabled" />
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Publish Id</label>
                                    <input name="pub_id" value="<?=$report[0]['pub_id']?>" type="text"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Region</label>
                                    <input name="region" value="<?=$report[0]['region']?>" type="text"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Pages</label>
                                    <input name="pages" value="<?=$report[0]['pages']?>" type="text"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Publish Status</label>
                                    <input name="pub_status" value="<?=$report[0]['pub_status']?>" type="text"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Premium</label>
                                    <input name="premium" value="<?=$report[0]['premium']?>" type="text"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Start Date</label>
                                    <input name="start_date" value="<?=$report[0]['start_date']?>" type="date"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Industry</label>
                                    <select name="industry_id" class="form-control select2">
                                            <!-- <option value="">select industry</option> -->
                                            <?php foreach($industry as $industries):?>
                                                <?php if($industries['industry_id'] == $report[0]['industry_id']):?>
                                                    <option selected="selected" value="<?=$industries['industry_id']?>"><?=$industries['industry_name']?></option>
                                                <?php else:?>
                                                    <option value="<?=$industries['industry_id']?>"><?=$industries['industry_name']?></option>
                                                <?php endif;?>    
                                            <?php endforeach; ?>

                                    </select>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Price</label>
                                    <input name="price" value="<?=$report[0]['price']?>" type="text"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Discount Price</label>
                                    <input name="discount_price" value="<?=$report[0]['discount_price']?>" type="text"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Brief Intro</label>
                                    <textarea name="brief_intro" value="<?=$report[0]['brief_intro']?>" type="text"  class="form-control"><?=$report[0]['brief_intro']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Content Body</label>
                                    <textarea name="content_body" value="<?=$report[0]['content_body']?>" type="text"  class="form-control"><?=$report[0]['content_body']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Meta Description</label>
                                    <textarea name="meta_description" value="<?=$report[0]['meta_description']?>" type="text"  class="form-control"><?=$report[0]['meta_description']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Meta Keywords</label>
                                    <textarea name="meta_keywords" value="<?=$report[0]['meta_keywords']?>" type="text"  class="form-control"><?=$report[0]['meta_keywords']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Show on Home</label>
                                    <select name="show_on_front" class="form-control select2">
                                        <?php if($report[0]['show_on_front'] == 0):?>
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
                                    <label>Featured</label>
                                    <select name="is_featured" class="form-control select2">
                                        <?php if($report[0]['is_featured'] == 0):?>
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
                                    <select name="status" class="form-control select2">
                                         <?php if($report[0]['status'] == 1):?>  
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
                                    <input name="main_photo" value="<?=$report[0]['main_photo']?>" type="file"  class="form-control report-img-input">
                                    <img class="report-img" src="<?=site_url($report[0]['main_photo'])?>" height="100px" width="100px" >
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>


                                <div class="Industries-btn d-flex justify-content-end 
                                mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary mr-1">Save</button>
                                    <button type="button" class="btn btn-info reset-form" form="update-report" >Reset</button>
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
        $('body').on('submit','.update-report',function(e){
          e.preventDefault();
              var report_title              =   $('body').find('textarea[name=report_title]');
              var industry_id               =   $('body').find('select[name=industry_id]');

              report_title = _blankReg(report_title,"Report title is required.")
              industry_id  = _selectoptionReg(industry_id,"Industry is required.")

              if (report_title&&industry_id) {
                  var data    =   new FormData(this);
                  var url     = 'update-report/'+'<?=$report[0]['report_id']?>';
                  var res     = sendAjaxFrm(url,data);
                  if (res.status == 'ERR') {
                    showMessage('danger',res.msg);
                  }else{
                    showMessage('success',res.msg); 
                    //$(this).trigger('reset')
                    window.location.replace("<?=site_url('reports')?>");
                  }
              }
          
        });

        $('body').on('change','.report-img-input',function(e){
           var tmppath = URL.createObjectURL(this.files[0])
           //console.log(tmppath)
           $('body').find('.report-img').attr('src',tmppath)
        })

    </script>

</body>

</html>