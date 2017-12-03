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
	$receivedOperator = $_POST['operator'];
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
        <h1 class="page-header">Edit User <?php if(isset($receivedOperator)){$thisUser = $receivedOperator; echo $thisUser;}?></h1>
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
            <form name="newUserForm" method= "POST"> <!--onsubmit="return insertNewUser();"-->

                <table class="table table-striped">
                    <?php
                        $offcampus_user = FALSE;
                        $oncampus_user = FALSE;

                        
                        if (!($mysqli->query ("SELECT count(*) FROM `users` WHERE `operator` = '$thisUser'"))){
                            $result = $mysqli->query ("SELECT * FROM `users` WHERE `operator` = '$thisUser'") or die("Bad Query: $result");  
                            $oncampus_user = TRUE;  
                        }
                        else if (!($mysqli->query("SELECT count(*) FROM `offcampus` WHERE `operator` = '$thisUser'"))){
                            $result = $mysqli->query ("SELECT * FROM `offcampus` WHERE `operator` = '$thisUser'") or die("Bad Query: $result");                              
                            $offcampus_user = TRUE;       
                        }  
                        $row = mysqli_fetch_array($result);
                    ?>

                <tbody class="offCampus" id="offCampus" style="visibility:visible" >
                    
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
                            <input type="text" class = "form-control" name="icon" placeholder="Icon" value="<?php echo $row['icon'];?>">
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
                            $num_updated = 0;
                            if ($_POST['fname'] != $row['fname']){
                                $r_id = mysqli_real_escape_string($mysqli, $_POST['fname']);
                                $num_updated += 1;                            
                            }
                            else{
                                $r_id = $row['fname'];
                            }
                            if ($_POST['lname'] != $row['lname']){
                                $r_id = mysqli_real_escape_string($mysqli, $_POST['lname']);
                                $num_updated += 1;                            
                            }
                            else{
                                $r_id = $row['lname'];
                            }
                            if ($_POST['phone'] != $row['phone']){
                                $r_id = mysqli_real_escape_string($mysqli, $_POST['phone']);
                                $num_updated += 1;                            
                            }
                            else{
                                $r_id = $row['phone'];
                            }
                            if ($_POST['email'] != $row['email']){
                                $r_id = mysqli_real_escape_string($mysqli, $_POST['email']);
                                $num_updated += 1;                            
                            }
                            else{
                                $r_id = $row['email'];
                            }
                            if ($_POST['address'] != $row['address']){
                                $r_id = mysqli_real_escape_string($mysqli, $_POST['address']);
                                $num_updated += 1;                            
                            }
                            else{
                                $r_id = $row['address'];
                            }
                            if ($_POST['city'] != $row['city']){
                                $r_id = mysqli_real_escape_string($mysqli, $_POST['city']);
                                $num_updated += 1;                            
                            }
                            else{
                                $r_id = $row['city'];
                            }
                            if ($_POST['state'] != $row['state']){
                                $r_id = mysqli_real_escape_string($mysqli, $_POST['state']);
                                $num_updated += 1;                            
                            }
                            else{
                                $r_id = $row['state'];
                            }
                            if ($_POST['zip'] != $row['zip']){
                                $r_id = mysqli_real_escape_string($mysqli, $_POST['zip']);
                                $num_updated += 1;                            
                            }
                            else{
                                $r_id = $row['zip'];
                            }

                            if ($_POST['icon'] != $row['icon']){
                                $icon = mysqli_real_escape_string($mysqli, $_POST['icon']);
                                $num_updated += 1;
                            }
                            else{
                                $icon = $row['icon'];
                            }
                            if ($_POST['notes'] != $row['notes']){
                                $notes = mysqli_real_escape_string($mysqli, $_POST['notes']);
                                $num_updated += 1;                            
                            }
                            else{
                                $notes = $row['notes'];
                            }
                            if ($_POST['r_id'] != $row['r_id']){
                                $r_id = mysqli_real_escape_string($mysqli, $_POST['r_id']);
                                $num_updated += 1;                            
                            }
                            else{
                                $r_id = $row['r_id'];
                            }
                            $adj_date = date("Y-m-d h:i:s", time());
                            $_SESSION['popup'] = "";
                            $input_error = false;
    
                            # Error handling
                            if($num_updated == 0){
                                $_SESSION['popup'] .= "You did not update anything.<br>";
                                $input_error = true;
                            }
                            #Discuss other inputs with Jon, default expecting specific characters
                            if(!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname) || !preg_match("/^[0-9]*$/", $phone) 
                            || !preg_match("/^[a-zA-Z-0-9]*$/", $email) || !preg_match("/^[a-zA-Z-0-9]*$/", $address) || !preg_match("/^[a-zA-Z]*$/", $city) 
                            || !preg_match("/^[a-zA-Z]*$/", $state) || !preg_match("/^[0-9]*$/", $zip) || !preg_match("/^[a-zA-Z]*$/", $icon) 
                            || !preg_match("/^[a-zA-Z-0-9]*$/", $notes) || !preg_match("/^[0-9]*$/", $r_id)){
                                $_SESSION['popup'] .= "Invalid symbols detected, make sure you are entering valid inputs.<br>";
                                $input_error = true;
                            }
                          
                            # If there was no input error, then the query should be formatted correctly.
                            // if(!$input_error && $oncampus_user && !$offcampus_user) {
                            //     $sql = "UPDATE `fabapp-v0.9`.`users` SET `icon` = '$icon', `notes` = '$notes' , `adj_date` = '$adj_date' WHERE `users`.`operator` = '$thisUser'";
                            //     mysqli_query($mysqli, $sql);                                
                            //     $_SESSION['popup'] = "Success";
                            // }
                            else if (!$input_error && !$oncampus_user && $offcampus_user){
                                $sql = "UPDATE `fabapp-v0.9`.`offcampus` SET `fname` = '$fname', `lname` = '$lname',`phone` = '$phone',`email` = '$email',`address` = '$address',`city` = '$city',
                                `state` = '$state',`zip` = '$zip',`icon` = '$icon', `notes` = '$notes' , `adj_date` = '$adj_date' WHERE `offcampus`.`operator` = '$thisUser'";
                                mysqli_query($mysqli, $sql);                                
                                // $_SESSION['popup'] = "Success";
                            }

                            header("Location: ../manageUsers/editUser.php?");
                            exit();
                        }
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
