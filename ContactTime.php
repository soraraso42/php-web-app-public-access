<?php 
    session_start();
    include("./common/header.php"); 
    
    
    // ensure customer info has been entered
    if(!isset($_SESSION["hasCustomerInfo"]) ||!$_SESSION["hasCustomerInfo"] || isset($_POST['prev']))
    {
        header("Location:CustomerInformation.php");
        exit();
    }
   
    elseif(isset($_POST['next']))
    {
        if (empty($_POST['availableTime']))
        {
            $availableTimeError = "please choose at least one time slot.";
        }
        else
        {
            header("Location:DepositCalculator.php");
            exit();
        }
    }
    
?>

<!--TODO make time selection persistent across sessions--> 
<form action="ContactTime.php" method="POST">

    <label class="form-label" for="availableTime">When can you contact you? Select all applicable.</label>
    <select class="form-select" name="availableTime[]" id="availableTime" multiple>
        <option value="9 AM">9-10 AM</option>
        <option value="10 AM">10-11 AM</option>
        <option value="11 AM">11-12 AM</option>
        <option value="12 PM">12-1 PM</option>
        <option value="1 PM">1-2 PM</option>
        <option value="2 PM">2-3 PM</option>
        <option value="3 PM">3-4 PM</option>
        <option value="4 PM">4-5 PM</option>
        <option value="5 PM">5-6 PM</option>
    </select>
    
    <br>
    <div class="row form-group">
        <div><input class="btn btn-primary" name="prev" type="submit" value="< Back" /></div>
        <div><input class="btn btn-primary" name="next" type="submit" value="Next >" /></div>
        <span class="text-danger"> <?php if(isset($availableTimeError)){echo $availableTimeError; } ?> </span>
    </div>
</form>            




<?php include('./common/footer.php'); ?>
