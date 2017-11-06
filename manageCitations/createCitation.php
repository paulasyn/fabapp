<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
if (!$staff || $staff->getRoleID() < 7){
    //Not Authorized to see this Page
    header('Location: index.php');
	exit();
}
?>
<title><?php echo $sv['site_name'];?> Create Citation</title>

echo "<script type='text/javascript'> window.onload = function(){goModal('Create Citation','This is the page to create a citation.', true)}</script>";
echo "<script type='text/javascript'> window.onload = function(){goModal('Test','This is a test for creating multiple popups.', true)}</script>";

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
                            <input type="text" class = "form-control" name="id" placeholder="Enter user ID">
                    </td>
                    </tr>

                    <tr>
                        <td>Issued By</td>
                        <td>
                        
                        <?php echo $staff->getOperator();?>
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