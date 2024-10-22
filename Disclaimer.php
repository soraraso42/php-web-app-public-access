<?php 
    session_start();
    include("./common/header.php"); 
    
    $errorMessage="";
    if (isset($_POST["checkDisclaimer"]))
    {
        $_SESSION["checkDisclaimer"] = $_POST["checkDisclaimer"];
        header("Location: CustomerInformation.php"); // direct to Customer Information on agreement
    } 
    else
    {
        $errorMessage = "You must agree to Terms and Conditions!"; // no redirection. display error msg
        
    }
?>
<div class="container">
    <form action="Disclaimer.php" method="POST">
        <!--TOS content-->
        <h3>Terms and Conditions</h3>
        <p> I agree to abide by the Bank's Terms and Conditions and rules in force and the changes thereto in Terms and Conditions from time to time relating to my account as communicated and made available on the Bank's website </p><!--  -->
        <br>
        <p> I agree that the bank before opening any deposit account, will carry out a due diligence as required under Know Your Customer guidelines of the bank. I would be required to submit necessary documents or proofs, such as identity, address, photograph and any such information, I agree to submit the above documents again at periodic intervals, as may be required by the Bank.
        agree that the Bank can at its sole discretion, amend any of the services/facilities given in my account either wholly or partially at any time by giving me at least 30 days notice and/or provide an option to me to switch to other services/facilities.
        </p>
        <br>
        <!--ensure acceptance of ToS-->
        <span class="text-danger"><?php echo $errorMessage;?></span>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="checkDisclaimer" id="checkDisclaimer">
            <label class="form-check-label" for="checkDisclaimer">I have read and agree with the terms and conditions</label>
        </div>
        <input class="btn btn-primary" name="start" type="submit" value="Start" />
    </form>
</div>
<?php include('./common/footer.php'); ?>
 