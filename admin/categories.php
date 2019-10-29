<?php include "includes/admin_header.php" ?>

    <div id="wrapper">

        <!-- Navigation -->
<?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12"></div>
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>
                        <div class="col-xs-6">
<?php insert_categories() ?>
                          <form action="" method="post">
                            <div class="form-group">
                              <label for="cat-title"> Add Category</label>
                              <input type="text" class="form-control" name="cat_title">
                            </div>
                            <div class="form-group">
                              <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                          </form>

<?php //UPDATE AND INCLUDE QUERY
if(isset($_GET['edit'])) {
$cat_id = $_GET['edit'];
include "includes/update_categories.php";
}
?>

                        </div>
                        <div class="col-xs-6">

                          <table class="table table-bordered table-hover">
                            <thread>
                              <tr>
                                <th>ID</th>
                                <th>Category Title</th>
                              </tr>
                            </thread>
                            <tbody>
<?php findAllCategories() ?>

<?php deleteCategories() ?>
                            </tbody>
                          </table>
                        </div>
                        <!-- <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> テストテストてす
                            </li>
                        </ol> -->
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php" ?>