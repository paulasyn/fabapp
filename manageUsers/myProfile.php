<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
if(is_null($staff))
{
    header('Location: /index.php');
}
/*if (!$staff || $staff->getRoleID() < 7){
    //Not Authorized to see this Page
    header('Location: /index.php');
	exit();
}*/
/* Check for error from a previously submitted add user form.*/
if(isset($_SESSION['popup'])){
    /* Handle appropriately*/
    if($_SESSION['popup'] == "Success"){ # User added successfully
        echo "<script type='text/javascript'> window.onload = function(){goModal('Success','The user was successfully updated.', true)}</script>";
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



<title><?php echo $sv['site_name'];?> View/Edit My Admin Profile</title>
<!--echo "<script type='text/javascript'> window.onload = function(){goModal('Did this work?','If you can see this message, then I figured out how to make a popup.', false)}</script>";-->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-10">
            <h1 class="page-header">View/Edit My Profile</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <a href="/manageUsers/index.php"><i class="fa fa-user-circle-o fa-fw"></i> Return to User Homepage</a>
    <br>
    <div class="row">
        <div class="col-lg-10">
            <div class="alert alert-danger" role = "alert" id="errordiv" style="display:none;">
                <p id="errormessage"></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user-circle-o fa-fw"></i> View/Edit Information
                </div>
                <form name="saveMyProfile" method= "POST"> <!--onsubmit="return insertNewUser();"-->
                    <table class="table table-striped">
                        <tr>
                        <?php
                            // $result = $mysqli->query ("SELECT * FROM `users`") or die("Bad Query: $result");
                            $thisUser = $staff->getOperator();
                            $result = $mysqli->query ("SELECT * FROM `users` WHERE `operator` = $thisUser") or die("Bad Query: $result");
                            // Check if the user was found in the on campus user table. If they were not found there, search the off campus users.
                            if(mysqli_num_rows($result) == 0)
                            {
                                $result = $mysqli->query ("SELECT * FROM `offcampus` WHERE `operator` = $thisUser") or die("Bad Query: $result");
                                $row = mysqli_fetch_array($result);
                                $oncampus = false;
                            }
                            else
                            {
                                $row = mysqli_fetch_array($result);
                                $oncampus = true;
                            }
                        ?>
                            <td>User ID</td>
                            <td>
                                <?php echo $row['operator'];?>
                            </td>
                        </tr>                    
                        
                        <tr>
                            <td>
                                Icon
                            </td>
                            <td>
                                <?php
                                    if(($row['r_id'] >= 7) && !(($row['icon'] == "user") || ($row['icon'] == NULL)))
                                    echo 'Preview: <i id="iconPreview" class="fa fa-' . $row['icon'] . ' fa-fw"></i>';
                                    else
                                    {
                                        $currentDirectory = getcwd();
                                        if(strpos($currentDirectory, "\\") != false)
                                        {
                                            $lastSlashPos = strrpos($currentDirectory, "\\");
                                            $baseDirectory = substr($currentDirectory, 0, $lastSlashPos);
                                            $fontAwesomePath = $baseDirectory . "\\vendor\\font-awesome\\less\\icons.less";
                                        }
                                        else
                                        {
                                            $lastSlashPos = strrpos($currentDirectory, "/");
                                            $baseDirectory = substr($currentDirectory, 0, $lastSlashPos);
                                            $fontAwesomePath = $baseDirectory . "/vendor/font-awesome/less/icons.less";
                                        }
                                        $iconFile = fopen($fontAwesomePath, "r") or die("Could not open file.");

                                        echo '<select class="form-control" name="icon" id="iconSelector" onChange="changePreviewIcon()" required=true disabled>';
                                        echo '<option value="">Select Icon</option>';
                                        for ($fileLine = fgets($iconFile); $fileLine != false; $fileLine = fgets($iconFile))
                                        { 
                                            $unneededToken = strtok($fileLine, "}");
                                            $iconName = strtok(":");
                                            if($iconName == "")
                                                continue;
                                            $iconName = ltrim($iconName, " -");
                                            $displayName = ucwords(str_replace("-", " ", $iconName));
                                            //echo '<option value="' . $iconName . '"><i class="fa fa' . $iconName . ' fa-fw"></i></option>';
                                            if(strcasecmp($iconName, $row['icon']) == 0)
                                                echo '<option value="' . $iconName . '" selected>' . $displayName . '</option>';
                                            else
                                                echo '<option value="' . $iconName . '">' . $displayName . '</option>';
                                        }
                                        fclose($iconFile);
                                    }
                                ?>
                            </td>
                        </tr>

                        <?php if($row['r_id'] >= 7) { ?>
                        <tr>
                            <td>Notes</td>
                            <td>
                                <?php
                                    echo str_replace("\n", "<br>", $row['notes']);
                                ?>
                                <div class="form-group">
                                <input type="text" class = "form-control" name="notes" placeholder="Add Notes" id="notesInput" disabled>
                            </td>
                        </tr>
                        <?php } ?>

                     
                      
                        <tr>
                            <td>Role ID</td>
                            <td>
                                <?php echo $row['r_id']; ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Current Date</td>
                            <td><?php echo $date = date("m/d/Y h:i a", time());?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input class="btn btn-primary" type="reset" value="Reset" readonly>
                                <input class="btn btn-primary" type="submit" name="submit" value="Update Profile" readonly>
                                <input class="btn btn-primary" type="toggleEditing" name="toggleEditing" value="Toggle Editing" onclick="toggleInputs()" readonly>
                                <!-- Insert Query Here -->
                                <?php
                                    $error_message = "";
                                    if (isset($_POST['submit'])){
                                        $num_updated = 0;
                                        
                                        if ($_POST['icon'] != $row['icon'] && $_POST['icon'] != ""){
                                            $icon = mysqli_real_escape_string($mysqli, $_POST['icon']);
                                            $num_updated += 1;
                                        }
                                        else{
                                            $icon = $row['icon'];
                                        }
                                        if ($_POST['notes'] != ""){
                                            $notes = $row['notes'] . trim(mysqli_real_escape_string($mysqli, $_POST['notes'])) . "\n";
                                            $num_updated += 1;                            
                                        }
                                        else{
                                            $notes = $row['notes'];
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
                                        if(!preg_match("/^[[:alpha:]](-|[[:alpha:]])*[[:alpha:]]$/", $icon)){
                                            $_SESSION['popup'] .= "Invalid symbols detected, make sure you are entering valid inputs.<br>" . "Role:" . $r_id . ", Icon:" . $icon;
                                            $input_error = true;
                                        }
                                      
                                        # If there was no input error, then the query should be formatted correctly.
                                        if(!$input_error) {
                                            $sql = "UPDATE `fabapp-v0.9`.`users` SET `icon` = '$icon', `notes` = '$notes' , `adj_date` = '$adj_date' WHERE `users`.`operator` = '$thisUser'";
                                            mysqli_query($mysqli, $sql);                                
                                            $_SESSION['popup'] = "Success";
                                            
                                        }

                                        header("Location: ../manageUsers/myProfile.php");
                                        exit();
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-calendar fa-fw"></i> Membership End Date
                </div>
                <div class="panel-body" style="text-align:center; font-size:x-large">
                    <?php
                        $result = $mysqli->query ("SELECT users.exp_date FROM users WHERE users.operator = " . $thisUser);
                        $expiration = mysqli_fetch_array($result);
                        if($expiration['exp_date'] == "")
                            echo "Indefinite";
                        else
                            echo $expiration['exp_date'];
                    ?>
                </div>
            </div>
        </div>
    </div>
    


    <?php
        $result = $mysqli->query ("SELECT trainingmodule.title, trainingmodule.tm_desc, tm_enroll.completed FROM tm_enroll INNER JOIN trainingmodule ON tm_enroll.tm_id = trainingmodule.tm_id WHERE tm_enroll.operator = " . $thisUser) or die("Bad Query: $result");
        if(mysqli_num_rows($result) == 0)
            goto certificatesEnd;
    ?>

        <div class = "row">                                
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-vcard-o fa-fw"></i> Training Certificates
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thread>
                            <tr>
                                <th>Training Name</th>
                                <th>Description</th>
                                <th>Date Completed</th>
                            </tr>
                        </thread>
                        <?php
                            while ($certificates = mysqli_fetch_array($result))
                            {
                                echo "<tr>";
                                    echo "<td>" . $certificates['title'] . "</td>";
                                    echo "<td>" . $certificates['tm_desc'] . "</td>";
                                    echo "<td>" . $certificates['completed'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <?php certificatesEnd: ?>
    

        <?php
        $result = $mysqli->query ("SELECT tm_enroll.operator, trainingmodule.title, trainingmodule.tm_desc FROM tm_enroll RIGHT JOIN trainingmodule ON tm_enroll.tm_id = trainingmodule.tm_id AND tm_enroll.operator = " . $thisUser) or die("Bad Query: $result");
        if(mysqli_num_rows($result) == 0)
            goto availableTrainingEnd;
        ?>
        <div class = "row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-list-alt fa-fw"></i> Available Training
                </div>
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thread>
                        <tr>
                            <th>Training Name</th>
                            <th>Description</th>
                        </tr>
                    </thread>
                    <?php
                         while ($availableTraining = mysqli_fetch_array($result))
                        {
                            /*foreach ($availableTraining as $key => $value)
                            {
                                echo "<tr><td>Key: " . $key . ", Value: " . $value . "</td></tr>";
                            }*/
                            if(strcasecmp($availableTraining['operator'], $thisUser) == 0)
                                continue;

                            echo "<tr>";
                                echo "<td>" . $availableTraining['title'] . "</td>";
                                echo "<td>" . $availableTraining['tm_desc'] . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
        </div> 
    </div>
        <?php availableTrainingEnd: ?>

<!-- /.col-md-4 -->


        <div class = "row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-flag fa-fw" style="color:red"></i> Citations
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Issued By</th>
                                <th>Notes</th>
                                <th>Severity</th>       
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $result = $mysqli->query ("SELECT `c_date`, `staff_id`, `c_notes`, `severity` FROM `citation` WHERE `operator` = $thisUser") or die("Bad Query: $result");
                            while ($row = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?php echo $row['c_date'];?></td>
                                    <td><?php echo $row['staff_id']; ?></td>
                                    <td><?php echo $row['c_notes'];?></td>
                                    <td><?php 
                                        if($row['severity'] == 0){?>
                                            <i class="fa fa-flag fa-fw" style="color:green">
                                        <?php } 
                                        else {?> 
                                            <i class="fa fa-flag fa-fw" style="color:red">
                                    <?php }                   
                                    ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>              
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    function changePreviewIcon()
    {
        var icon = document.getElementById("iconSelector").value;
        document.getElementById("iconPreview").className = "fa fa-".concat(icon).concat(" fa-fw");
    }
</script>
<script type="text/javascript">
    function toggleInputs()
    {
        var iconSelector = document.getElementById("iconSelector");
        var notesInput = document.getElementById("notesInput");
        var roleIDinput = document.getElementById("roleIDinput");

        if(iconSelector != null)
            iconSelector.disabled = !iconSelector.disabled;
        if (notesInput != null)
            notesInput.disabled = !notesInput.disabled;
        if(roleIDinput != false)
            roleIDinput.disabled = !roleIDinput.disabled;
    }
</script>

<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>
