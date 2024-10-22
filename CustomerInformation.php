<?php 
    session_start();
    $_SESSION["hasCustomerInfo"] = false;
    include("./common/header.php"); 

    // Initialize error messages
    $nameError = $postalcodeError = $phoneError = $emailError = $contactMethodError = "";

    // Check if the user has agreed to the disclaimer
    if ($_SESSION["checkDisclaimer"]) {
        // Validate form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') // only validate submitted form
        {
            $formComplete = true; 
            $name = trim($_POST['name']);
            $postalcode = trim($_POST['postalcode']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $contactMethod = isset($_POST['contactMethod']) ? $_POST['contactMethod'] : null; 

            // Validate Name
            if (empty($name)) {
                $formComplete = false;
                $nameError = "Name cannot be empty."; 
            } else {
                $_SESSION['name'] = $name;
            }

            // Validate Postal Code
            $postalCodeRegex = "/[a-z][0-9][a-z]\s*[0-9][a-z][0-9]/i";
            if (empty($postalcode)) {
                $formComplete = false;
                $postalcodeError = "Postal code cannot be empty."; 
            } elseif (!preg_match($postalCodeRegex, $postalcode)) {
                $formComplete = false;
                $postalcodeError = "Postal code is invalid."; 
            } else {
                $_SESSION['postalcode'] = $postalcode;
            }

            // Validate Phone
            $phoneRegex = '/^[1-9][0-9]{2}-[1-9][0-9]{2}-[0-9]{4}$/';
            if (empty($phone)) {
                $formComplete = false;
                $phoneError = "Phone number cannot be empty."; 
            } elseif (!preg_match($phoneRegex, $phone)) {
                $formComplete = false;
                $phoneError = "Invalid phone number."; 
            } else {
                $_SESSION['phone'] = $phone;
            }

            // Validate Email
            $emailRegex = '/^[a-zA-Z]+(\.[a-zA-Z]+)?@[a-zA-Z]+(\.[a-zA-Z]+)+\.[a-zA-Z]{2,4}$/';
            if (empty($email)) {
                $emailError = "Email cannot be empty."; 
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $formComplete = false;
               $emailError = "Email format is invalid."; 
           } else {
               $_SESSION['email'] = $email;
            }
            
            // Validate Contact Method
            if (empty($contactMethod)) {
                $formComplete = false;
                $contactMethodError = "You must choose a contact method."; 
            } else {
                $_SESSION['contactMethod'] = $contactMethod;
            }

            // Proceed if form validation is successful
            if ($formComplete) {
                $_SESSION["hasCustomerInfo"] = true;

                // Redirect based on contact method
                if ($contactMethod == "email") {
                    header("Location: DepositCalculator.php");
                    exit();
                } else {
                    header("Location: ContactTime.php");
                    exit();
                }
            }
        }
    } else {
        // Redirect if disclaimer is not agreed upon
        header("Location: Disclaimer.php");
        exit();
    }
?>

<!-- customer information input form -->
<form name="CustomerInformation" action="CustomerInformation.php" method="POST">
    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php if (isset($_SESSION['name'])) { echo $_SESSION['name']; } ?>"> 
        <span class="text-danger"><?php echo $nameError; ?></span> <!-- Display error message next to input field -->
    </div>

    <!-- Postal Code -->
    <div class="mb-3">
        <label for="postalcode" class="form-label">Postal Code</label>
        <input type="text" class="form-control" id="postalcode" name="postalcode" value="<?php if (isset($_SESSION['postalcode'])) { echo $_SESSION['postalcode']; } ?>">
        <span class="text-danger"><?php echo $postalcodeError; ?></span> 
    </div>

    <!-- Phone -->
    <div class="mb-3">
        <label for="phone" class="form-label">Phone <br> <span> nnn-nnn-nnnn</span></label>
        <input type="tel" class="form-control" id="phone" name="phone" value="<?php if (isset($_SESSION['phone'])) { echo $_SESSION['phone']; } ?>">
        <span class="text-danger"><?php echo $phoneError; ?></span> 
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($_SESSION['email'])) { echo $_SESSION['email']; } ?>">
        <span class="text-danger"><?php echo $emailError; ?></span> 
    </div>

    <!-- Contact Preference (Radio Buttons) --> 
    <div class="mb-3">
        <label class="form-label">Preferred Contact Method</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="contactMethod" id="contactPhone" value="phone" 
                   <?php if (isset($_SESSION['contactMethod']) && $_SESSION['contactMethod'] == 'phone') { echo 'checked'; } ?>>
            <label class="form-check-label" for="contactPhone">Phone</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="contactMethod" id="contactEmail" value="email" 
                   <?php if (isset($_SESSION['contactMethod']) && $_SESSION['contactMethod'] == 'email') { echo 'checked'; } ?>>
            <label class="form-check-label" for="contactEmail">Email</label>
        </div>
        <span class="text-danger"><?php echo $contactMethodError; ?></span> <!-- Display error -->
    </div>
    
    <div><input class="btn btn-primary" name="next" type="submit" value="Next >" /></div>
</form>

<?php include('./common/footer.php'); ?>
