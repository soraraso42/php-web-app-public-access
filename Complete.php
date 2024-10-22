<?php 
session_start(); // Retrieve PHP session!

if (!isset($_SESSION["name"]) || empty($_SESSION["name"])) {
    header("Location: Disclaimer.php");
    exit();
}

include("./common/header.php"); 
?>
<div class="container">	
    <h1>Thank you, <span class="text-primary"><?php echo htmlspecialchars($_SESSION["name"]); ?></span>, for using the deposit calculator tool!</h1>
    
    <?php
    // Check for the contact method in the session
    if (isset($_SESSION["contactMethod"]) && $_SESSION["contactMethod"] == "email") {
        // Ensure the email is set
        if (isset($_SESSION["email"])) {
            echo 'We will contact you shortly by Email at ' . htmlspecialchars($_SESSION["email"]) . '.';
        }
    } else {
        // Ensure phone and available time are set
        if (isset($_SESSION["phone"])) {
            echo 'We will contact you shortly by Phone at ' . htmlspecialchars($_SESSION["phone"]) . ' during the following hours:<br>';
            if (isset($_SESSION["availableTime"]) && is_array($_SESSION["availableTime"])) {
                foreach ($_SESSION["availableTime"] as $time) {
                    echo htmlspecialchars($time) . '<br>'; 
                }
            }
        }
    }
    
    // Clear all session data
    session_unset(); 
    ?>   
</div>	
<?php include('./common/footer.php'); ?>
