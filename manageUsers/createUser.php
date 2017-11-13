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
    if($_SESSION['popup'] == "Success"){ # User added successfully
        echo "<script type='text/javascript'> window.onload = function(){goModal('Success','The user was successfully added.', false)}</script>";
    } elseif($_SESSION['popup'] == ""){# Check if the pop up message is empty. This only happens if the submit button was hit but nothing was added for the pop up message. This is unexpected behavior.
        echo "<script type='text/javascript'> window.onload = function(){goModal('Unknown Error','An unknown error occured while processing the request.', false)}</script>";
    } else {# An input error occured. Display what error(s) occured in a pop up.
        echo "<script type='text/javascript'> window.onload = function(){goModal('Input Error','" . $_SESSION['popup'] . "', false)}</script>";
    }
    /*Unset the error value in case of refresh.*/
    unset($_SESSION['popup']);
}
// Error statement in case the pop up does not show when it is supposed to.
else {echo "<!-- The pop up window value was not set. -->";}
?>
<title><?php echo $sv['site_name'];?> User Registration</title>
<!--echo "<script type='text/javascript'> window.onload = function(){goModal('Did this work?','If you can see this message, then I figured out how to make a popup.', false)}</script>";-->
<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create User</h1>
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
                <i class="fa fa-ticket fa-fw"></i> New User Information
            </div>
            <form name="newUserForm" method= "POST"> <!--onsubmit="return insertNewUser();"-->

                <table class="table table-striped">
                    <tr>
                    <td>User Type<a title = "Required">*</a></td>
                    <td><label class="radio-inline">
                        <input type="radio" name="userRadio" value="0">On Campus User
                        </label>
                        <label class="radio-inline">
                        <input type="radio" name="userRadio" value="1">Off Campus User
                        </label>
                    </td>

                    </tr>   
                
                
                    <tr>
                        <td>Role ID<a title = "Required">*</a></td>
                        <td>
                            <div class="form-group">
                            <input type="int" class = "form-control" name="r_id" placeholder="Enter Role ID">
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td>1000's Number<a title = "Required">*</a></td>
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
                        <td>Notes<a title = "Required">*</a></td>
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
                        $error_message = "";
                        if (isset($_POST['submit'])){
    
                            $r_id = mysqli_real_escape_string($mysqli, $_POST['r_id']);
                            $operator = mysqli_real_escape_string($mysqli, $_POST['operator']);
                            $icon = mysqli_real_escape_string($mysqli, $_POST['icon']);
                            $notes = mysqli_real_escape_string($mysqli, $_POST['notes']);

                            $_SESSION['popup'] = "";
                            $input_error = false;
    
                            # Error handling
                            if(empty($r_id)||empty($operator)||empty($notes)){
                                $_SESSION['popup'] .= "Make sure to complete all required fields.<br>";
                                $input_error = true;
                            }
                            #Discuss other inputs with Jon, default expecting specific characters
                            if(!preg_match("/^[0-9]*$/", $r_id)|| !preg_match("/^[0-9]*$/", $operator)|| !preg_match("/^[a-zA-Z]*$/", $icon)){
                                $_SESSION['popup'] .= "Invalid symbols detected, make sure you are entering valid inputs.<br>";
                                $input_error = true;
                            }
                            #Make sure you're not entering a user with a repat 1000s number
                            $sql = "SELECT * FROM users WHERE operator = '$operator'";
                            $result = mysqli_query($mysqli, $sql);
                            $resultCheck = mysqli_num_rows($result);
                                    
                            if($resultCheck>0){ 
                                #if it's a repeat 1000s number, return to create user page with error message
                                $_SESSION['popup'] .= "The user you attempted to add has a 1000s number already in the database.<br>";
                                $input_error = true;
                            }
                            # If there was no input error, then the query should be formatted correctly.
                            if(!$input_error) {
                                $sql = "INSERT INTO users (operator, r_id, icon, notes) VALUES ('$operator', '$r_id', '$icon', '$notes');";
                                mysqli_query($mysqli, $sql);
                                $_SESSION['popup'] = "Success";
                            }

                            header("Location: ../manageUsers/createUser.php");
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
