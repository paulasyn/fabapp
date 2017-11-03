<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
?>
<title><?php echo $sv['site_name'];?> User Registration</title>

echo "<script type='text/javascript'> window.onload = function(){goModal('Did this work?','If you can see this message, than I figured out how to make a popup.', false)}</script>";

<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create User</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-10">
        <div class="alert alert-danger" role = "alert" id="errordiv" style="display:none;">
            <p id="errormessage"></p>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-ticket fa-fw"></i> New User Information
            </div>
            <form name="newUserForm" method= "POST"  action="/manageUsers/createUserSuccess.php" onsubmit="return insertNewUser();">

                <table class="table table-striped">
                    <tr>
                        <td>User ID</td>
                        <td>
                            <div class="form-group">
                            <input type="userId" class="form-control" name="u_id" id="firstName" placeholder="Enter first name">
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td>First Name</td>
                        <td>
                            <div class="form-group">
                            <input type="firstName" class="form-control" id="firstName" placeholder="Enter first name">
                        </td>
                    </tr>

                    <tr>
                        <td>Last Name</td>
                        <td>
                            <div class="form-group">
                            <input type="lastName" class="form-control" id="lastName" placeholder="Enter last name">
                        </td>
                    </tr>

                    <tr>
                        <td>Address</td>
                        <td>
                            <div class="form-group">
                            <input type="address" class="form-control" id="address" placeholder="Enter address">
                        </td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>
                            <div class="form-group">
                            <input type="email" class="form-control" id="email" placeholder="Enter email">
                        </td>
                    </tr>

                              
               
                    <tr>
                        <td>Staff ID</td>
                        <td>Default will be put here</td>
                    </tr>
                    <tr>
                        <td>Current Date</td>
                        <td><?php echo $date = date("m/d/Y h:i a", time());?></td>
                    </tr>
                    <tr>
                        <td><input class="btn btn-primary pull-right" type="reset"
                            value="Reset"></td>
                        <td><input class="btn btn-primary" type="submit" name="submit" value="Submit">
                        <!-- Insert Query Here -->
                        <?php
                        


                        
                        
                        
                        ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<!-- /.col-lg-8 -->
</div>
</div>
<!-- /#page-wrapper -->
<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>