<?php
session_start();

include 'inc/lib.php';
include 'inc/head.php';


$msg = $adminEmail = $psw = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $msg = "";
    $proceed = TRUE;
    
    $adminLoginType = $_POST["adminLoginType"];
    
    if ($adminLoginType == "login") {

        if (empty($_POST["adminEmail"])) {
            $msg = "Please enter an email address";
            $proceed = FALSE;
        } 
        else {
            $adminEmail = stripInput($_POST["adminEmail"]);
            if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                $msg = "Invalid email format";
                $proceed = FALSE;
            }
        }
        
        if ($proceed) {
            if (!empty($_POST["psw"])) {
                $psw =  stripInput($_POST["psw"]);
            }
            else {
                $msg = "Please enter password"; 
                $proceed = FALSE;
            }
        }
   
        if($proceed) {

            $record = "";
            $record = findAdminRecord($psw, $adminEmail);
       
            if ($adminLoginType == "login") {
                if ($record == "RecordNotFound") {
                    $msg = "Record not found for " . $adminEmail; 
                
                }
                else if ($record == "IncorrectCredentials") {
                    $msg = "Incorrect credentials for " . $adminEmail; 
                }
                else if ($record == "PasswordCorrect") {
                    $_SESSION['adminLoginType'] = "adminLogin";
                    $_SESSION['adminEmail'] = $adminEmail;
           
                    header ("Location: admindata.php"); 
                    exit;
                
                }
            }
        }
    }
}

?>


<header>
    <div class="container h-100">
        <div class="top row h-100 justify-content-between align-items-center">
            <div class="col text-center">
                <a href="index.php">
                    <img src="images/logo.svg" id="logo" width="50px" height= "50px" />
                </a>
            </div>    
        </div>
    </div>
</header>

<section id="title" class="products navcat b-primary p10t p10b">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col">
                <h4 class="heading">
                    Admin Login
                </h4>
            </div>
        </div>
    </div>
</section>


<section class="m50t m50b">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <form method="post" class="col-12 col-md-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                <div class="form-group">
                    <label for="adminEmail"><b>Email</b></label>
                    <input type="text" class="form-control" placeholder="Enter Email" name="adminEmail" value="<?php echo $adminEmail; ?>">
                </div>
                <div class="form-group">
                    <label for="psw"><b>Password</label>
                    <input type="password" class="form-control" placeholder="Enter Password" name="psw" value="<?php echo $psw; ?>">
                    <input type="hidden" id="adminLoginType" name="adminLoginType" value="login">
                </div>
            
                <button type="submit" name ="submit" value="login" class="ahref solid dark">Login</button>
                
            </form>
            <div class="col-12 col-md-6">
                <h2><b></b></h2>
                 <h2><b><?php echo $msg; ?></b></h2>
            </div>
        </div>
    </div>
</section>

        
        
       

<?php 
include 'inc/footer.php';
include 'inc/foot.php';
;?>
