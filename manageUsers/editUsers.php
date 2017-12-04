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
if(isset($_POST['operator'])){
	$thisUser = $_POST['operator'];
}elseif(isset($_SESSION['operator'])){
	$thisUser = $_SESSION['operator'];
	unset($_SESSION['operator']);
}
/* Check for error from a previously submitted add user form.*/
if(isset($_SESSION['popup'])){
    /* Handle appropriately*/
    if($_SESSION['popup'] == "Success"){ # User added successfully
        echo "<script type='text/javascript'> window.onload = function(){goModal('Success','The user was successfully added.', false)}</script>";
    } elseif($_SESSION['popup'] == ""){# Check if the pop up message is empty. This only happens if the submit button was hit but nothing was added for the pop up message. This is unexpected behavior.
        echo "<script type='text/javascript'> window.onload = function(){goModal('Unknown Error','An unknown error occured while processing the request.', true)}</script>";
    } else {# An input error occured. Display what error(s) occured in a pop up.
        echo "<script type='text/javascript'> window.onload = function(){goModal('Input Error','" . $_SESSION['popup'] . "', true)}</script>";
    }
    /*Unset the error value in case of refresh.*/
    unset($_SESSION['popup']);
}
// Error statement in case the pop up does not show when it is supposed to.
else {echo "<!-- The pop up window value was not set. -->";}
?>
<title><?php echo $sv['site_name'];?> User Edit</title>
<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit User <?php if(isset($thisUser)){ echo $thisUser;}?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<a href="/manageUsers/index.php"><i class="fa fa-user-circle-o fa-fw"></i> Return to User Homepage</a>
<div class="row">
    <div class="col-lg-10">
        <div class="alert alert-danger" role = "alert" id="errordiv" style="display:none;">
            <p id="errormessage"></p>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-users fa-fw"></i> Edit User Information
            </div>
            <form name="editUserForm" method= "POST">
				<?php if (!isset($thisUser)){ ?>
				<table class= "table table-striped">
				    <tr>
				        <td> ID of User to Edit </td>
			            <td> <input type="text" class = "form-control" name="opToChange" placeholder="xxxxxxxxxx"></td>
					</tr>
				    <tr>
                        <td><input class="btn btn-primary" type="submit" name="submitOperator" value="Continue">
						<?php 
						if(isset($_POST['submitOperator'])){
							$opToChange = mysqli_real_escape_string($mysqli,$_POST['opToChange']);
							$result = mysqli_query($mysqli, "SELECT `operator` FROM `users` WHERE `operator` = $opToChange");
							if ($result->num_rows == 1){ 
							    $_SESSION['operator']=$opToChange;
                            }else{
								$result = mysqli_query($mysqli, "SELECT `operator` FROM `offcampus` WHERE `operator` = $opToChange");
                                if ($result->num_rows == 1){
									$_SESSION['operator']=$opToChange;
                                }  
							    else{
							 	    $_SESSION['popup']="User not found.";
							    }
							}
							header("Location: ../manageUsers/editUsers.php");
                            exit();
						}
						?>
						</td>
				    </tr>
				</table>
				<?php }else{ ?>
                <table class="table table-striped">
                    <?php
                        $offcampus_user = FALSE;
                        $oncampus_user = FALSE;
						
                        $result = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `operator` = $thisUser");
					    if ($result->num_rows == 1){ 
						    $oncampus_user = TRUE;
							$row = mysqli_fetch_array($result);
                        }else{
							$result = mysqli_query($mysqli, "SELECT * FROM `offcampus` WHERE `operator` = $thisUser");
                            if ($result->num_rows == 1){
			    			    $offcampus_user = TRUE;
								$row = mysqli_fetch_array($result);
                            } 
					    }
                    ?>

                <tbody class="offCampus" id="offCampus" style="visibility:visible" >
                    <?php 
					if($offcampus_user){ ?>
                    <tr>
                        <td>First Name</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="fname" placeholder="First Name" value="<?php echo $row['fname'];?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Last Name</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="lname" placeholder="Last Name" value="<?php echo $row['lname'];?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Phone Number</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="phone" placeholder="xxx-xxx-xxxx" value="<?php echo $row['phone'];?>">
                        </td>
                    </tr>

                    <tr >
                        <td>Email</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="email" placeholder="example@url.com"value="<?php echo $row['email'];?>">
                        </td>
                    </tr>

                    <tr >
                        <td>Address</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="address" placeholder="Street Address" value="<?php echo $row['address'];?>">
                        </td>
                    </tr>

                    <tr >
                        <td>City</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="city" placeholder="Example: Arlington" value="<?php echo $row['city'];?>">
                        </td>
                    </tr>

                    <tr >
                        <td>State</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="state" placeholder="Example: Texas" value="<?php echo $row['state'];?>">
                        </td>
                    </tr>

                    <tr >
                        <td>Zip</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="zip" placeholder="xxxxx" value="<?php echo $row['zip'];?>">
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>  
                    <tr>
                        <td>User ID</td>
                        <td>
						    <?php echo $thisUser;?>
                        </td>
                    </tr>                    
                    
                    <tr>
                        <td>Icon</td>
                        <td>
                            <div class="form-group">
							<?php
							if(($row['r_id'] >= 7) && !(($row['icon'] == "user") || ($row['icon'] == NULL)))
                                echo 'Preview: <i id="iconPreview" class="fa fa-' . $row['icon'] . ' fa-fw"></i>';
						    else{
							?>
                            <input type="text" class = "form-control" name="icon" placeholder="Icon" value="<?php echo $row['icon'];?>">
							<?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Notes</td>
                        <td>
                            <div class="form-group">
                            <input type="text" class = "form-control" name="notes" placeholder="Notes" value="<?php echo $row['notes'];?>">
                        </td>
                    </tr>
                       
                    <tr>
                        <td>Role ID</td>
                        <td>
                            <div class="form-group">
                            <input type="int" class = "form-control" name="r_id" placeholder="Enter Role ID" value="<?php echo $row['r_id'];?>">
                        </td>
                    </tr>
      
                    <tr>
                        <td>Updated By</td>
                        <td> <?php echo $staff->getOperator();?></td>
                    </tr>
                    <tr>
                        <td>Current Date</td>
                        <td><?php echo $date = date("m/d/Y h:i a", time());?></td>
                    </tr>
                    <tr>
                        <td><input class="btn btn-primary pull-right" type="reset"
                            value="Reset"></td>
                        <td><input class="btn btn-primary" type="submit" name="submit" value="Update Profile">
                        <!-- Insert Query Here -->
                        <?php
                        $error_message = "";
                        if (isset($_POST['submit'])){
                            $r_id = mysqli_real_escape_string($mysqli, $_POST['r_id']);
							$_SESSION['popup']=$r_id;

                            header("Location: ../manageUsers/editUser.php?");
                            exit();
                        }
                        ?>
                        </td>
                    </tr>
                </table>
				<?php } ?>
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
