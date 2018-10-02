<?php

// wanyibeh@palmtech.com / ttt


session_start();

include 'inc/lib.php';
include 'inc/head.php';



$msg = $email = $psw = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $msg = "";
    $proceed = TRUE;
    
    $loginType = $_POST["loginType"];
    
    
    if ($loginType == "new") {
        $_SESSION['loginType'] = $loginType;
        $_SESSION['email'] = "";
        $_SESSION['timestamp'] = "";
        header ("Location: data.php"); 
        exit;
    }
    else if ($loginType == "login") {

        if (empty($_POST["email"])) {
            $msg = "Please enter an email address";
            $proceed = FALSE;
        } 
        else {
            $email = stripInput($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
            $record = findUserRecord($psw, $email);
       
            if ($loginType == "login") {
                if ($record == "RecordNotFound") {
                    $msg = "Record not found for " . $email; 
                
                }
                else if ($record == "IncorrectCredentials") {
                    $msg = "Incorrect credentials for " . $email; 
                }
                else if ($record == "PasswordCorrect") {
                    $_SESSION['loginType'] = $loginType;
                    $_SESSION['email'] = $email;
                    $_SESSION['timestamp'] = "";
           
                    header ("Location: data.php"); 
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
                    Member Login
                </h4>
            </div>
        </div>
    </div>
</section>


<section class="m50t m50b">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <form method="post" class="col-12 col-md-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" placeholder="Enter Email" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="psw">Password</label>
                    <input type="password" class="form-control" placeholder="Enter Password" name="psw" value="<?php echo $psw; ?>">
                    <input type="hidden" id="loginType" name="loginType" value="login">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" name ="submit" value="login"  class="ahref solid primary">Login</button>
                </div>
            </form>
            <div class="col-12 col-md-6">
                <p><strong>Interested in registering as a member?</strong></p>
                <form class="m25t" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="hidden" id="loginType" name="loginType" value="new">
                    <button type="submit" name ="register" value="register" class="ahref solid dark">Click here</button>
                </form>
                <h2><b></b></h2>
                <p class="m50t" style="color: red;">
                    <i class="far fa-exclamation-circle"></i> <strong><?php echo $msg; ?></strong>
                </p>
            </div>
        </div>
    </div>
</section>



<?php 
include 'inc/footer.php';
include 'inc/foot.php';
;?>

