<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
if (!$staff || $staff->getRoleID() < 7){
    //Not Authorized to see this Page
    header('Location: /index.php');
	exit();
}

?>
<title><?php echo $sv['site_name'];?> User Management</title>
<body>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">User Management</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user-circle-o fa-fw"></i> Manage Users
                </div>
                <div class="panel-body">    
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Icon</th>
                        <th>UserID</th>
                        <th>Edit</th>
                      
                    </tr>
                    </thead>
                    <?php

                    $result = $mysqli->query ("SELECT `operator`, `icon` FROM `users` WHERE 1 ORDER BY `operator` ASC") or die("Bad Query: $result");
                    ?>
                    <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><i class="fa fa-<?php echo $row['icon'];?> fa-lg"></i></td>
                            <td><?php echo $row['operator']; ?></td>
                            <?php $op = $row['operator']; ?>
                            <?php if ($staff) { ?> <td><a href="/manageUsers/editUsers.php?operator=$row['operator']">Edit Profile</a></td><?php } ?>
                                                        <!-- How to pass operator to next page? -->
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>              
                </div>
            </div>
        </div>
        <!-- /.col-md-8 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user-circle-o fa-fw"></i> User Options
                </div>
                <div class="panel-body">
                    <a href="/manageUsers/createUser.php">Create a new user</a>
                    <p></p>
                    <a href="/manageUsers/editUsers.php">Edit a user</a>
                    <p></p>
                    <a href="/manageUsers/viewMyProfile.php">View My Profile</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
</body>
<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>