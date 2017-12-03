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
                    <i class="fa fa-user-circle-o fa-fw"></i> Manage On Campus Users
                </div>
                <div class="panel-body">    
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Icon</th>
                        <th>UserID</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      
                    </tr>
                    </thead>
                    <?php

                    $result = $mysqli->query ("SELECT `operator`, `icon` FROM `users` WHERE 1 ORDER BY `operator` ASC") or die("Bad Query: $result");
                    ?>
                    <tbody>
                    <?php 
					$i = 0; 
					while ($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><i class="fa fa-<?php echo $row['icon'];?> fa-lg"></i></td>
                            <td><?php echo $row['operator']; ?></td>
                            <?php $op = $row['operator']; ?>
                            <?php if ($staff) { $_SESSION['op'][$op] = $op;?> <td><a href="/manageUsers/editUsers.php?operator=<?php echo $op;?>">Edit Profile</a></td><?php } ?>
                            <!-- Create $_SESSION array of all operators. In editUsers.php, check that $_SESSION['op'][$_GET[operator]] is set.
							if it is, then the user navigated from this page, and the operator existed in the table. If not, then the user
							manually entered operator into the table, and the input should be ignored for sql safety. In the case that the user
							manually entered an operator that does exist through the address bar, it will be ignored as $_SESSION['op']
							will be unset by the time the page is refreshed. The user should have no reason to enter the operator through
							the address bar. The operator value passed through href is strictly to be used for checking the operator that is
							meant to be edited, and that it was accessed through the edit user link in the table created above. It should never 
							directly affect a SQL query.
							If possible, look for a more efficient solution, as large user tables would mean a large number of values in the session array.
							However, this solution works, and, to the knowledge of the team, works securely.-->
                            <td><a href="#">Delete User</a></td>
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

                    <a href="/manageUsers/viewEditMyAdminProfile.php">View/Edit My Profile</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-4 -->

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user-circle-o fa-fw"></i> Manage Off Campus Users
                </div>
                <div class="panel-body">    
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Icon</th>
                        <th>UserID</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      
                    </tr>
                    </thead>
                    <?php

                    $result = $mysqli->query ("SELECT `operator`, `icon` FROM `offcampus` WHERE 1 ORDER BY `operator` ASC") or die("Bad Query: $result");
                    ?>
                    <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                        <td><i class="fa fa-<?php echo $row['icon'];?> fa-lg"></i></td>
                        <td><?php echo $row['operator']; ?></td>
                        <?php $op = $row['operator']; ?>
                        <?php if ($staff) { $_SESSION['op'][$op] = $op;?> <td><a href="/manageUsers/editUsers.php?operator=<?php echo $op;?>">Edit Profile</a></td><?php } ?>
                        <!-- Create $_SESSION array of all operators. In editUsers.php, check that $_SESSION['op'][$_GET[operator]] is set.
                        if it is, then the user navigated from this page, and the operator existed in the table. If not, then the user
                        manually entered operator into the table, and the input should be ignored for sql safety. In the case that the user
                        manually entered an operator that does exist through the address bar, it will be ignored as $_SESSION['op']
                        will be unset by the time the page is refreshed. The user should have no reason to enter the operator through
                        the address bar. The operator value passed through href is strictly to be used for checking the operator that is
                        meant to be edited, and that it was accessed through the edit user link in the table created above. It should never 
                        directly affect a SQL query.
                        If possible, look for a more efficient solution, as large user tables would mean a large number of values in the session array.
                        However, this solution works, and, to the knowledge of the team, works securely.-->
                        <td><a href="#">Delete User</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>              
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
</body>
<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>