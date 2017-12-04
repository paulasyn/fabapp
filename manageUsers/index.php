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

/* Check for error from a previously submitted add user form.*/
if(isset($_SESSION['popup'])){
    /* Handle appropriately*/
    if($_SESSION['popup'] == "Delete"){ # User added successfully
        echo "<script type='text/javascript'> window.onload = function(){goModal('Delete','Are you sure you want to delete this user?', false)}</script>";
    } elseif($_SESSION['popup'] == ""){# Check if the pop up message is empty. This only happens if the submit button was hit but nothing was added for the pop up message. This is unexpected behavior.
        echo "<script type='text/javascript'> window.onload = function(){goModal('Unknown Error','An unknown error occured while processing the request.', true)}</script>";
    }elseif($_SESSION['popup'] == "Table did not update"){# Check if the pop up message is empty. This only happens if the submit button was hit but nothing was added for the pop up message. This is unexpected behavior.
        echo "<script type='text/javascript'> window.onload = function(){goModal('SQL Error','" . $_SESSION['popup'] . "', false)}</script>";
    } else {# An input error occured. Display what error(s) occured in a pop up.
        echo "<script type='text/javascript'> window.onload = function(){goModal('Input Error','" . $_SESSION['popup'] . "', false)}</script>";
    }
    /*Unset the error value in case of refresh.*/
    unset($_SESSION['popup']);
}
// Error statement in case the pop up does not show when it is supposed to.
else {echo "<!-- The pop up window value was not set. -->";}

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
                   
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Icon</th>
                        <th>UserID</th>
                        <th>Edit</th>  
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $result = $mysqli->query ("SELECT `operator`, `icon` FROM `users` WHERE 1 ORDER BY `operator` ASC") or die("Bad Query: $result");             
					while ($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><i class="fa fa-<?php echo $row['icon'];?> fa-lg"></i></td>
                            <td><?php echo $row['operator']; ?></td>
                            <?php $op = $row['operator']; ?>
                            <?php if ($staff) {?> 
							<td><form action="/manageUsers/editUsers.php" method="post">
                                <button type="submit" name="operator" value=<?php echo $op?> class="btn-link">Edit User</button>
                            </form></td>
						    <?php } ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>              
               
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

                    <a href="/manageUsers/myProfile.php">View/Edit My Profile</a>
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
                 
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Icon</th>
                        <th>UserID</th>
                        <th>Edit</th>
        
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
                        <?php if ($staff) {?> 
							<td><form action="/manageUsers/editUsers.php" method="post">
                                <button type="submit" name="operator" value=<?php echo $op?> class="btn-link">Edit User</button>
                            </form></td>
						    <?php } ?>
                       </tr>
                    <?php } ?>
                    </tbody>
                </table>              
                
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