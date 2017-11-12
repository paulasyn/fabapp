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
                
                    <label class="pull-right"><input type="radio" name="optradio" value="0" style="margin-right:10px">On Campus User</label>

                    <label class="pull-right"><input type="radio" name="optradio" value="1" style="margin-right:10px">Off Campus User</label>
         
            </div>
            <form name="newUserForm" method= "POST"  action="/manageUsers/CreateSuccess2.php"> <!--onsubmit="return insertNewUser();"-->

                <table class="table table-striped">
                    <tr>
                        <td>Role ID</td>
                        <td>
                            <div class="form-group">
                            <input type="int" class = "form-control" name="r_id" placeholder="1" default="1">
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td>Mav ID</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="operator" placeholder="Enter 1000s Number">
                        </td>
                    </tr>    
                    
                    
					<tr>
                        <td>Icon</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="icon">
                        </td>
                    </tr>

                    
                    <tr>
                        <td>First Name</td>
                        <td> 
                            <input type="text" class = "form-control" name="fname" >
                        </td>
                    </tr>
                
                    <tr>
                        <td>Last Name</td>
                        <td> 
                            <input type="text" class = "form-control" name="lname" >
                        </td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td> 
                            <input type="text" class = "form-control" name="email" >
                        </td>
                    </tr>

                    <tr>
                        <td>Street Address</td>
                        <td> 
                            <input type="text" class = "form-control" name="address" >
                        </td>
                    </tr>


                    <tr>
                        <td>City</td>
                        <td> 
                            <input type="text" class = "form-control" name="city" >
                        </td>
                    </tr>

                    <tr>
                        <td>State</td>
                        <td> 
                            <input type="text" class = "form-control" name="state" >
                        </td>
                    </tr>

                    <tr>
                        <td>Zipcode</td>
                        <td> 
                            <input type="text" class = "form-control" name="zip" >
                        </td>
                    </tr>

                    <tr>
                        <td>Notes</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="notes" placeholder="Notes">
                        </td>
                    </tr>

                    <tr>
                        <td>Created By</td>
                        <td> <?php echo $staff->getOperator();?></td>
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
