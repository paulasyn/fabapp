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
if(isset($_SESSION['CCmsg'])){
/* Handle appropriately*/
	if($_SESSION['CCmsg'] == "Success"){ #User added successfully
		echo "<script type='text/javascript'> window.onload = function(){goModal('Success','The citation was successfully submitted.', true)}</script>";
	} elseif($_SESSION['CCmsg'] == "Field"){#Field has invalid characters
		echo "<script type='text/javascript'> window.onload = function(){goModal('Symbol Error','Invalid symbols detected, make sure you are entering valid inputs.', true)}</script>";
	} elseif($_SESSION['CCmsg'] == "Empty"){#Required field left empty
		echo "<script type='text/javascript'> window.onload = function(){goModal('Empty Field','Make sure to complete all required fields.', true)}</script>";
	}
/*Unset the error value in case of refresh.*/
unset($_SESSION['CCmsg']);
}

?>
<title><?php echo $sv['site_name'];?> Create Citation</title>


<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create Citation</h1>
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
                <i class="fa fa-ticket fa-fw"></i> Citation
            </div>
            <form name="newCitationForm" method= "POST">

                <table class="table table-striped">
                    <tr>
                        <td>User ID<a title = "Required">*</a></td>
                        <td>
                            <input type="text" class = "form-control" name="user_id" placeholder="Enter user ID">
                    </td>
                    </tr>

                    <tr>
                        <td>Issued By</td>
                        <td>
                        
                        <?php echo $staff->getOperator();?>
                        </td>
                    </tr>

                    <tr>
                        <td>Citation<a title = "Required">*</a></td>
                        <td>
                        <div class="form-group">
                            <textarea class="form-control" id="notes" rows="5" name="notes"
                                style="resize: none"></textarea>
                        </div>
                    </td>
                    </tr>
                    
                    <tr>
                        <td>Severity<a title = "Required">*</a></td>
                        <td>
                            <label class="radio-inline">
                                <input type="radio" name="severityRadio" value="0" checked="checked">Low Priority<i class="fa fa-flag fa-fw" style="color:green"></i>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="severityRadio" value="1">High Priority<i class="fa fa-flag fa-fw" style="color:red"></i>
                            </label>

                        </td>
                    </tr>

                        <td>Current Date</td>
                        <td><?php echo $date = date("m/d/Y h:i a", time()); echo $_POST['severityRadio'];?> </td>
                    </tr>
                    <tr>
                        <td><input class="btn btn-primary pull-right" type="reset"
                            value="Reset"></td>
                        <td><input class="btn btn-primary" type="submit" name="submit" value="Submit">
                        <!-- Insert Query Here -->
                        <?php
                        if (isset($_POST['submit'])){
                            
                            $staff_id = mysqli_real_escape_string($mysqli, $staff->getOperator());
							$operator = mysqli_real_escape_string($mysqli, $_POST['user_id']);
							$notes = mysqli_real_escape_string($mysqli, $_POST['notes']);
                            $sqldate = date("Y-m-d h:i:s", time());
                            $radioValue = mysqli_real_escape_string($mysqli,$_POST['severityRadio']);
							# Error handling
							if(empty($operator)||empty($notes)){
								$_SESSION['CCmsg'] = "Empty";
								header("Location: ../manageCitations/createCitation.php");
								exit();
							}else{
								#Discuss other inputs with Jon, default expecting specific characters
								if(!preg_match("/^[0-9]*$/", $staff_id)||
								!preg_match("/^[0-9]*$/", $operator)){
									$_SESSION['CCmsg'] = "Field";
									header("Location: ../manageCitations/createCitation.php");
									exit();
								}else{
									$sql = "INSERT INTO citation (staff_id, operator, c_date, c_notes, severity) VALUES ('$staff_id', 
									'$operator', '$sqldate', '$notes', '$radioValue');";
									mysqli_query($mysqli, $sql);
									$_SESSION['CCmsg'] = "Success";
									header("Location: ../manageCitations/createCitation.php");
									exit();
								}
							}
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