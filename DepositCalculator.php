<?php 
session_start();
include("./common/header.php"); 

// Only proceed if customer has entered valid contact info
if ( !$_SESSION['hasCustomerInfo']) {
    header("Location:CustomerInformation.php");
    exit();
}


$formComplete = true; 
$principalAmount = isset($_POST['principalAmount']) ? $_POST['principalAmount'] : 0; // Handle principal amount
$years = isset($_POST['years']) ? $_POST['years'] : 0; 
$calculate = isset($_POST['calculate']);
$complete = isset($_POST['complete']);
$prev = isset($_POST['prev']);

// Validate form input on page
if (!isset($_POST['years'])) {
    $formComplete = false;
    echo "<li>Must choose a year.</li>";
} 

if ($principalAmount <= 0 || !is_numeric($principalAmount)) {
    $formComplete = false;
    echo "<li>The principal amount must be numeric and greater than zero.</li>";
}

// Only process form data when all checks passed
if ($formComplete) {
    if ($calculate) {
        echo "<table border='1'>";
        echo "<tr><th>Year</th><th>Principal at Year start</th><th>Interest for the year.</th></tr>";
        $interest = 0;
        for ($y = 1; $y <= $years; $y++) {
            $principalAmount = (float)$principalAmount; // strict type during string concat so type casting needed 
            $principalAmount += $interest;
            $interest = 0.03 * $y * $principalAmount;

            echo "<tr><th>$y</th><th>$principalAmount</th><th>$interest</th></tr>";
        }
        echo "</table>";
    } 
    
    
    elseif ($complete) {
        header("Location:Complete.php");
        exit();
    } 
}


if ($prev)  // $prev does not return bool
    {
        if ($_SESSION['contactMethod'] === "email") {
            header("Location:CustomerInformation.php");
        } else {
            header("Location:ContactTime.php");
        }
        exit();
    }
?> 

<form name="DepositCalculator" action="DepositCalculator.php" method="POST">
    <!-- Principal Amount -->
    <div class="mb-3">
        <label for="principal" class="form-label">Principal Amount</label>
        <input type="text" class="form-control" id="principal" name="principalAmount" value="<?php echo htmlspecialchars($principalAmount); ?>">  
    </div>

    
    
    <!-- Years to Deposit -->
    <div class="mb-3">
        <label for="years" class="form-label">Years to Deposit</label>
        <select class="form-select" id="years" name="years">
            <option value="" disabled <?php if ($years == 0) {echo 'selected';} ?>>Select one...</option>
            <?php
            for ($i = 0; $i < 25; $i++) {
                $selected = ($i == $years) ? 'selected' : ''; // Retain selected value
                echo "<option value=\"$i\" $selected>$i Year(s)</option>";
            }
            ?>
        </select>
    </div>

    <!-- Available Actions --> 
    <div class="row form-group">
        <div class="col-md-2"><input class="btn btn-primary" name="prev" type="submit" value="< Back" /></div>
        <div class="col-md-2"><input class="btn btn-primary" name="calculate" type="submit" value="Calculate" /></div>
        <div class="col-md-2"><input class="btn btn-primary" name="complete" type="submit" value="Complete >" /></div>
    </div>
</form>

<?php include('./common/footer.php'); ?>
