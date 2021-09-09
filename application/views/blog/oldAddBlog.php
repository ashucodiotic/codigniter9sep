<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adhoc | Add Report</title>

    <?php $this->load->view('common/head.php')?>
    <!-- <link rel="stylesheet" href="../../plugins/simplemde/simplemde.min.css"> -->
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
                            <h1>Article Add</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Article Add</li>
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
                            <div class="card-header">
                                <h3 class="card-title">Add Article</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="inputName">Article Title*</label>
                                        <input type="text" id="inputName" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputName">Url Key*</label>
                                        <input type="text" id="inputName" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inputDescription">Pub ID*</label>
                                        <input type="text" id="inputName" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputDescription">Region*</label>
                                        <input type="text" id="inputName" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inputName">Pages</label>
                                        <input type="number" id="inputName" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputName">Pub Status*</label>
                                        <input type="text" id="inputName" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Premium ?</label>
                                        <select class="form-control select2">
                                            <option selected="selected">Yes</option>
                                            <option>No</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputDescription">Start Date*</label>
                                        <input type="date" id="inputName" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputDescription">Category*</label>
                                        <select class="form-control select2">
                                            <option selected="selected">Select Category</option>
                                            <option>Information Communication Technology</option>
                                            <option>Aerospace & Defense</option>
                                            <option>Food & Agriculture</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputName">Price*</label>
                                        <input type="text" id="inputName" class="form-control">
                                    </div>


                                    <div class="form-group col-md-12">
                                        <label for="inputDescription">Article Description*</label>
                                        <textarea id="inputDescription" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outline card-info">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                Summernote
                                                            </h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body">
                                                            <textarea id="summernote">
                                                      Place <em>some</em> <u>text</u> <strong>here</strong>
                                                    </textarea>
                                                        </div>
                                                        <div class="card-footer">
                                                            Visit <a
                                                                href="https://github.com/summernote/summernote/">Summernote</a>
                                                            documentation for more examples and information about the
                                                            plugin.
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.col-->
                                            </div>
                                            <!-- ./row -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-outline card-info">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                CodeMirror
                                                            </h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body p-0">
                                                            <textarea id="codeMirrorDemo" class="p-3">
                                      <div class="info-box bg-gradient-info">
                                        <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
                                        <div class="info-box-content">
                                          <span class="info-box-text">Bookmarks</span>
                                          <span class="info-box-number">41,410</span>
                                          <div class="progress">
                                            <div class="progress-bar" style="width: 70%"></div>
                                          </div>
                                          <span class="progress-description">
                                            70% Increase in 30 Days
                                          </span>
                                        </div>
                                      </div>
                                                    </textarea>
                                                        </div>
                                                        <div class="card-footer">
                                                            Visit <a href="https://codemirror.net/">CodeMirror</a>
                                                            documentation for more examples and information about the
                                                            plugin.
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.col-->
                                            </div>
                                            <!-- ./row -->
                                        </section>

                                    </div>


                                    <div class="form-group col-md-12">
                                        <label for="inputDescription">Meta description*</label>
                                        <textarea id="inputDescription" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputDescription">Meta Keywords*</label>
                                        <textarea id="inputDescription" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Show on Home*</label>
                                        <select class="form-control select2">
                                            <option selected="selected">No</option>
                                            <option>Yes</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Status*</label>
                                        <select class="form-control select2">
                                            <option selected="selected">Active</option>
                                            <option>Inactive</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="report-btn d-flex 
                                mt-4 ">
                                    <button type="button" class="btn btn-primary ">Save</button>
                                    <button type="button" class="btn btn-secondary ml-3">Back</button>
                                </div>
                            </div>


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
    <!-- ///////////////////////////////////////////////////////////////////// -->
        <?php $this->load->view('common/footer.php')?>
    </div>
    <!-- ./wrapper -->
</body>

</html>