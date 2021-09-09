<?php //_dx($industry);?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | Update News</title>
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
                            <h1>News Update</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">News Update</li>
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
                                <h3 class="card-title">Update News</h3>

                                <!-- <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="card-body">
                            <?php if(!empty($news)):?>    
                            <form class="update-news row" > 

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">News Title</label>
                                    <textarea name="news_title" value="<?=$news[0]['news_title']?>" type="text"  class="form-control"><?=$news[0]['news_title']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputDescription">News Body</label>
                                    <textarea name="news_text" value="<?=$news[0]['news_text']?>" type="text"  class="form-control"><?=$news[0]['news_text']?></textarea>
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                               
                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Date</label>
                                    <input name="news_date" value="<?=$news[0]['news_date']?>" type="date"  class="form-control">
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>

                                
                               
                                <div class="form-group col-md-6">
                                    <label for="inputDescription">Image</label>
                                    <input name="image" value="<?=$news[0]['image']?>" type="file"  class="form-control news-img-input">
                                    <img class="news-img" src="<?=site_url($news[0]['image'])?>" height="100px" width="100px" >
                                    <p class="text-left mb-0 pl-1"><small class="danger text-danger error"></small></p>
                                </div>


                                <div class="Industries-btn d-flex justify-content-end 
                                mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary mr-1">Save</button>
                                    <button type="button" class="btn btn-info reset-form" form="update-news" >Reset</button>
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
        $('body').on('submit','.update-news',function(e){
          e.preventDefault();
              var news_text              =   $('body').find('textarea[name=news_text]');
              var news_title               =   $('body').find('textarea[name=news_title]');

              news_text = _blankReg(news_text,"News body is required.")
              news_title  = _blankReg(news_title,"Title is required.")

              if (news_title&&news_text) {
                  var data    =   new FormData(this);
                  var url     = 'update-news/'+'<?=$news[0]['news_id']?>';
                  var res     = sendAjaxFrm(url,data);
                  if (res.status == 'ERR') {
                    showMessage('danger',res.msg);
                  }else{
                    showMessage('success',res.msg); 
                    //$(this).trigger('reset')
                    window.location.replace("<?=site_url('news')?>");
                  }
              }
          
        });

        $('body').on('change','.news-img-input',function(e){
           var tmppath = URL.createObjectURL(this.files[0])
           //console.log(tmppath)
           $('body').find('.news-img').attr('src',tmppath)
        })

    </script>

</body>

</html>