<?php //_dx($result);?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | All Reports</title>
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
                            <h1>All Reports</h1>
                        </div>
                        <div class="col-sm-6">
                            <!-- <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">All reports</li>
                            </ol> -->
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <!-- <h3 class="card-title">All reports</h3> -->

                        <div class="card-tools">
                            <div>
                                <form class="d-inline-block mr-1 search-form" temp-src="report-template" temp-dest="report-container" temp-url="all-reports">
                                  <div class="input-group input-group-sm">
                                    <input type="text" class="form-control input-sm" placeholder="Search here">
                                    <div class="input-group-append">
                                      <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                  </div>
                                </form>
                                <a href="<?=site_url('add-report')?>" class="btn btn-sm btn-outline-primary">Add</a>
                            </div>
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button> -->
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table projects">
                            <thead class="data-table-header">
                                <tr class="text-light" >
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Report Title
                                    </th>
                                    <th>
                                        Industry Name
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="report-container">
                               <?php if(!empty($result['rows'])):?> 
                                <?php $i=1; foreach ($result['rows'] as $rows):?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$rows['report_title']?></td>
                                        <td><?=$rows['industry_name']?></td>
                                        <td><?=$rows['date']?></td>
                                        <td>
                                            <?php if($rows['is_featured'] == 1):?>
                                                 <span class="badge badge-success">Active</span>
                                            <?php else:?>
                                                  <span class="badge badge-danger">Deactive</span>
                                            <?php endif;?>    
                                        </td>
                                        <td class="project-actions">
                                            <a class="btn btn-outline-primary btn-sm" href="<?=site_url('view-report')?>/<?=$rows['report_id']?>" >
                                                <i class="fas fa-folder">
                                                </i>
                                                
                                            </a>
                                            <a class="btn btn-outline-info btn-sm" href="<?=site_url('edit-report')?>/<?=$rows['report_id']?>" >
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            <a reportId="<?=$rows['report_id']?>" class="btn btn-outline-danger btn-sm delete-report" href="#">
                                                <i class="fas fa-trash">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php $i++; endforeach; ?>
                               <?php else:?>
                                  <tr class="text-center">
                                    <td colspan="12">NO DATA FOUND</td>
                                  </tr>
                               <?php endif;?> 
                            </tbody>
                            <script type="text/x-handlebars-template" id="report-template">        
                              {{#if result.rows}}
                                {{#each result.rows}}
                                  <tr>                                 
                                     <td>{{incCount @index ../result.page  ../result.limit}}</td>
                                        <td>{{report_title}}</td>
                                        <td>{{industry_name}}</td>
                                        <td>{{date}}</td>
                                        <td>
                                            {{#if is_featured}}
                                             <span class="badge badge-success">Active</span>  
                                            {{else}}
                                             <span class="badge badge-danger">Deactive</span>
                                            {{/if}}      
                                        </td>
                                        <td class="project-actions">
                                            <a class="btn btn-outline-primary btn-sm" href="#">
                                                <i class="fas fa-folder">
                                                </i>
                                                
                                            </a>
                                            <a class="btn btn-outline-info btn-sm" href="#">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                            <a reportId="{{report_id}}" class="btn btn-outline-danger btn-sm delete-report" href="#">
                                                <i class="fas fa-trash">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                {{/each}}
                                {{else}}
                                  <tr class="text-center">
                                    <td colspan="12">NO DATA FOUND</td>
                                  </tr>
                              {{/if}}
                            </script>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <div class="d-flex flex-wrap justify-content-between px-1">
                         <script id="fromTo" type="text/x-handlebars-template">
                           <b><span class="dataTo">{{result.showing_from}}</span> - <span class="dataUpto">{{result.showing_upto}}</span></b>
                </script>

                <script id="totalResult" type="text/x-handlebars-template">
                  <b>of <span class="totalData">{{result.count}}</span></b>
                </script>

                 <script id="pageCountTemp" type="text/x-handlebars-template">
                  <a class="page-link btn-sm">{{result.page}}</a>                          
                </script>

                <div class="d-none" id="current-page"><?= $result['page']?></div>
                <div class="d-none" id="max-page"><?= $result['pages']?></div>           
                <div class="d-none" id="num-page">10</div>  
                <div class="limit-option">
                  <select class="form-control round input-sm per-page btn-sm" temp-src="report-template" temp-dest="report-container" temp-url="all-reports">
                    <option value="10" selected="">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </div>
                <div class="">
                  <sapn class="m-r-5" id="fromToContainer">
                     <b><span class="dataTo"><?= $result['showing_from']?></span> - <span class="dataUpto"><?= $result['showing_upto']?></span></b>
                  </sapn>

                  <sapn class="m-r-5" id="totalResultContainer">
                    <b>of <span class="totalData"><?= $result['count']?></span></b>
                  </sapn>
                  <ul class="pager pager-round d-inline-block pl-2">
                    <li class="disabled">
                      <a href="#" class="page-link btn-sm  btn-prev" temp-src="report-template" temp-dest="report-container" temp-url="all-reports"><i class="fas fa-angle-double-left"></i></a>
                    </li>
                    <li class="page-item active"  id="pageCountContainer">
                      <a class="page-link btn-sm" href="#">1</a>
                    </li>
                    <li>
                      <a href="#" class="page-link btn-sm  btn-next" temp-src="report-template" temp-dest="report-container" temp-url="all-reports"> <i class="fas fa-angle-double-right"></i></a>
                    </li>
                  </ul>  
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
        var src   = 'report-template';
        var dest  = 'report-container';
        var url   = 'all-reports';      
        var data  = {'page':1, 'limit':10,'query':''};
        var maxPage =  $('#max-page').text();
        var currentPage = $('#current-page').text();
        var totalData = $('.totalData').text();
        var dataUpto = $('.dataUpto').text();

        if(currentPage == 1){
          $('.btn-prev').addClass('d-none')
        }else{
          $('.btn-prev').removeClass('d-none')
        }

        if(totalData == dataUpto){
          
          $('.btn-next').addClass('d-none')   
        }else{
          
          $('.btn-next').removeClass('d-none')        
        }

        $('body').on('click','.delete-report',function(e){
            confirmBoxActiveInactive('delete-report',$(this).attr('reportId'),'Delete','danger','danger')
        })
    </script>    
    
</body>

</html>