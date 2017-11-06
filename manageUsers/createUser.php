<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
?>
<title><?php echo $sv['User Registration'];?> Base</title>

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
            <form name="newUserForm" method= "POST"  action="/manageUsers/CreateSuccess2.php"> <!--onsubmit="return insertNewUser();"-->

                <table class="table table-striped">
                    <tr>
                        <td>Role ID</td>
                        <td>
                            <div class="form-group">
                            <input type="int" class = "form-control" name="r_id" placeholder="Enter Role ID">
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td>1000's Number</td>
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
