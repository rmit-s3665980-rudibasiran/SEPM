<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Palm Tech</title>
<style>
body, html {
    height: 100%;
    font-family: Arial, Helvetica, sans-serif;
}

* {
    box-sizing: border-box;
}

.bg-img {
    /* The image used */
    background-image: url("images/background.png");

    min-height: 1368px;

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    box-shadow: 5px 5px 5px grey;
}

/* Add styles to the form container */
.container {
    position: absolute;
    left: 0;
    margin: 20px;
    max-width: 300px;
    padding: 16px;
    background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password], input[type=date] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    border: none;
    background: #f1f1f1;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
}

input[type=text]:focus, input[type=password]:focus, input[type=date]:focus {
    background-color: #ddd;
    outline: none;
}

/* Set a style for the submit button */
.btn {
    background-color: black;
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 1;
    font-family: Arial, Helvetica, sans-serif;
}

.btn:hover {
    opacity: 0.7;
}
</style>
</head>
<body>

<?php
session_start();
include 'inc/lib.php';

$id = $name = $date_of_birth = $title_c = "";
$addr_t1 = $addr_t2 = $addr_t3 = $addr_t4 = $addr_postal = "";
$addr_state = $addr_ctry = $contact_n = $email = $psw = "";
$timestamp = "";

$loginType = stripInput($_SESSION["loginType"]); 

$email = stripInput($_SESSION["email"]);
$timestamp = stripInput($_SESSION["timestamp"]);
    

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $name = stripInput($_POST["name"]);
    $date_of_birth = $_POST["date_of_birth"];
    $title_c = stripInput($_POST["title_c"]);
    $addr_t1 = stripInput($_POST["addr_t1"]);
    $addr_t2 = stripInput($_POST["addr_t2"]);
    $addr_t3 = stripInput($_POST["addr_t3"]);
    $addr_t4 = stripInput($_POST["addr_t4"]);
    $addr_postal = stripInput($_POST["addr_postal"]);
    $addr_state = stripInput($_POST["addr_state"]);
    $addr_ctry = stripInput($_POST["addr_ctry"]);
    $contact_n = stripInput($_POST["contact_n"]);
    $email = stripInput($_POST["email"]);
    $psw = stripInput($_POST["psw"]);
        
    
    if ($loginType == "new") {
        $readonly = "";
        $_SESSION['email'] = "";
        $_SESSION['timestamp'] = "";
        
        $id = getNextID($email);
        $sql = "INSERT INTO PEOPLE (ID, NAME, DATE_OF_BIRTH, TITLE_C, ADDR_T1, ADDR_T2, ADDR_T3, ADDR_T4, ADDR_POSTAL, ADDR_STATE, ADDR_CTRY, CONTACT_N, EMAIL, PIN) " .
                "VALUES " .
                " ( '" . $id . "'," . 
                "'" . $name . "'," .
                "'" . $date_of_birth . "'," .
                "'" . $title_c . "'," .
                "'" . $addr_t1 . "'," .
                "'" . $addr_t2 . "'," .
                "'" . $addr_t3 . "'," .
                "'" . $addr_t4 . "'," .
                "'" . $addr_postal . "'," .
                "'" . $addr_state . "'," .
                "'" . $addr_ctry . "'," .
                "'" . $contact_n . "'," .
                "'" . $email . "'," .
                "'" . $psw . "'" .
                ")" ;
                
        $_SESSION['errorMsg'] = $sql;  
                
        
        $proceed = TRUE;
        
    }
    else if ($loginType = "login") {
        
    
        $sql =  "UPDATE     PEOPLE " .
                "SET        NAME = '" . $name . "'," .
                "           DATE_OF_BIRTH = '" . $date_of_birth . "'," .
                "           TITLE_C = '" . $title_c . "'," .
                "           ADDR_T1 = '" . $addr_t1 . "'," .
                "           ADDR_T2 = '" . $addr_t2 . "'," .
                "           ADDR_T3 = '" . $addr_t3 . "'," .
                "           ADDR_T4 = '" . $addr_t4 . "'," .
                "           ADDR_POSTAL = '" . $addr_postal . "'," .
                "           ADDR_STATE = '" . $addr_state . "'," .
                "           ADDR_CTRY = '" . $addr_ctry . "'," .
                "           CONTACT_N = '" . $contact_n . "'" .
                "WHERE      EMAIL = '" . $email . "'";
                
                $_SESSION['errorMsg'] = "Error 150:" . $sql;
                $proceed = TRUE;
    }
    
    if ($proceed) {
        $conn = OpenCon();     
        if ($conn->query($sql) === TRUE) {
            CloseCon($conn);
    
            $_SESSION['loginType'] = "login";
            $_SESSION['email'] = $email;
            $_SESSION['timestamp'] = getTimeStamp(); 
           
            header ("Location: data.php"); 
            exit;
        } else {
            $_SESSION['errorMsg'] = "Error 166: [" . $sql . "]";
            header ("Location: error.php"); 
            exit;
        }
    }

}


if ($loginType == "login") {
    $conn = OpenCon();
    $readonly = "readonly";
    
    $sql =  "SELECT     ID, NAME, DATE_OF_BIRTH, TITLE_C, " .
            "           ADDR_T1, ADDR_T2, ADDR_T3, ADDR_T4, ADDR_POSTAL, " .
            "           ADDR_STATE, ADDR_CTRY, CONTACT_N, PIN " .
            "FROM       PEOPLE " .
            "WHERE      EMAIL = '" . $email . "'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        
            $name = $row["NAME"]; 
            $date_of_birth = $row["DATE_OF_BIRTH"];
            $title_c = $row["TITLE_C"];
            $addr_t1 = $row["ADDR_T1"];
            $addr_t2 = $row["ADDR_T2"];
            $addr_t3 = $row["ADDR_T3"];
            $addr_t4 = $row["ADDR_T4"];
            $addr_postal = $row["ADDR_POSTAL"];
            $addr_state = $row["ADDR_STATE"];
            $addr_ctry = $row["ADDR_CTRY"];
            $contact_n = $row["CONTACT_N"];
            $psw = $row["PIN"];
         
        }
    }
    else {
        // $_SESSION['errorMsg'] = "Error 206: [" . $email . "]";
        header ("Location: error.php"); 
        CloseCon($conn);
        exit;
    }
}
else if ($loginType == "new") {
    $readonly = "";
    $_SESSION['email'] = "";
    $_SESSION['timestamp'] = "";
}
else {
    $_SESSION['errorMsg'] = "Error 218: [" . $email . "]";
    header ("Location: error.php"); 
    exit;
}


?>

<script>
function myFunction() {
    var x = document.getElementById("myPSW");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

<div class="bg-img">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="container">
            <h2 style="font-family: Arial; color: Black;font-size: 20px;">Member Details</h2>
            <h3 style="font-family: Arial; color: Black;font-size: 10px;"><?php echo $timestamp; ?> </h3>

            <label style="font-family: Arial; color: Black;font-size: 12px;" for="email"><b>Email</b></label>
            <input type="text" name="email" value="<?php echo $email; ?>"  <?php echo $readonly; ?> >
    
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="name"><b>Name</b></label>
            <input type="text" name="name" value="<?php echo $name; ?>">
      
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="date_of_birth"><b>Date of Birth</b></label>
            <input type="date" name="date_of_birth" value="<?php echo $date_of_birth; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="title_c"><b>Title</b></label>
            <input type="text" name="title_c" value="<?php echo $title_c; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="addr_t1"><b>Address Line 1</b></label>
            <input type="text" name="addr_t1" value="<?php echo $addr_t1; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="addr_t2"><b>Address Line 2</b></label>
            <input type="text" name="addr_t2" value="<?php echo $addr_t2; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="addr_t3"><b>Address Line 3</b></label>
            <input type="text" name="addr_t3" value="<?php echo $addr_t3; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="addr_t4"><b>Address Line 4</b></label>
            <input type="text" name="addr_t4" value="<?php echo $addr_t4; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="addr_postal"><b>Postal Code</b></label>
            <input type="text" name="addr_postal" value="<?php echo $addr_postal; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="addr_state"><b>State</b></label>
            <input type="text" name="addr_state" value="<?php echo $addr_state; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="addr_ctry"><b>Country</b></label>
            <input type="text" name="addr_ctry" value="<?php echo $addr_ctry; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="contact_n"><b>Contact Number</b></label>
            <input type="text" name="contact_n" value="<?php echo $contact_n; ?>">
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="psw"><b>PIN</label>
            <input type="password" name="psw" id="myPSW" value="<?php echo $psw; ?>" <?php echo $readonly; ?> >
            
            <label style="font-family: Arial; color: Black;font-size: 12px;" for="show_psw"><b>Show PIN</b></label>
            <input type="checkbox" name = "show_psw" onclick="myFunction()">
      
            <h2 style="font-family: Arial; color: White;"></h2>
            <button type="submit" class="btn" >Save</button>
        </div>
    </form>
</div>
</body>
</html>

