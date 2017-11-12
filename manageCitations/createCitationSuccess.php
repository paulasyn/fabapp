<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
?>
<title><?php echo $sv['Citation Creation'];?> Create Citation</title>

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
            <form name="newUserForm" method= "POST"  action="/manageUsers/createUserSuccess.php" onsubmit="return insertNewUser();">

                <table class="table table-striped">
                    <tr>
                        <td>User ID</td>
                        <td>
                        <select class="form-control" name="devGrp" id="devGrp" onChange="change_group()" >
                            <option value="" > Select User</option>
                            <!-- <?php
                                if (! $result = $mysqli->query ( "SELECT * FROM `users`" )) {
                                    die("There was an error loading device_group ");
                                }
                                
                                while ( $rows = mysqli_fetch_array ( $result ) ) {
                                    $public_devices = $mysqli->query ( "SELECT * FROM `users`");
                                    if($public_devices->num_rows > 0)
                                        echo "<option value=" . $rows ['dg_id'] . ">" . $rows ['dg_desc'] . "</option>";
                                }
                                ?>  -->
                        </select>
                    </td>
                    </tr>

                    <tr>
                        <td>Issued By</td>
                        <td>
                        
                        Gets current user ID
                        </td>
                    </tr>

                    <tr>
                        <td>Citation</td>
                        <td>
                        <div class="form-group">
                            <textarea class="form-control" id="notes" rows="5" name="notes"
                                style="resize: none"></textarea>
                        </div>
                    </td>
                    </tr>
                    
                    
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