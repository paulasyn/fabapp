<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
    include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');


    if(isset($_POST['submit']))
    {
        //include_once '~fabapp/fabapp-v0_9.sql';
        $u_id = $_POST['u_id'];
        // $u_id = mysqli_real_escape_string($conn, $_POST['u_id']); where $conn is database name
    } 
    else
    {
        header("Location: ../createUser.php");
        exit();
    }
?>


<title><?php echo $sv['User Registration'];?> Base</title>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Create User</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-ticket fa-fw"></i> New User Information
                </div>
                <div class="panel-body">
                    
                </div>
            </div>
        </div>
        <!-- /.col-md-8 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>