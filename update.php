<?php
// Include config file
require_once  "config.php";
// Initialize with empty values;
$card_number = $first_name = $last_name = $phone = $address = $medical_history = $test_result = $billing_info = "";

$card_number_err = $first_name_err = $last_name_err = $phone_err = $address_err = $medical_history_err = $test_result_err = $billing_info_err = "";
 // Processing form data when form is submitted
if(isset($_POST["patient_id"]) && !empty($_POST["patient_id"])){
    // Get hidden input value
    $patient_id = $_POST["patient_id"];

    // Validate card_number
    $input_card_number = trim($_POST["card_number"]);
    if(empty($input_card_number)){
        $card_number_err = "Please enter the number of insurance card.";
    } else{
        $card_number = $input_card_number;
    }

    // Validate first name and last name
    $input_first_name = trim($_POST["first_name"]);
    if(empty($input_first_name)){
        $first_name_err = "Please enter your first name.";
    } elseif(!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $frist_name_err = "Please enter a valid name.";
    } else{
        $first_name = $input_first_name;
    }
    $input_last_name = trim($_POST["last_name"]);
    if(empty($input_last_name)){
        $last_name_err = "Please enter your last name.";
    } elseif(!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $last_name_err = "Please enter a valid last name.";
    } else{
        $last_name = $input_last_name;
    }
    // Validate phone number 
    $input_phone = trim($_POST['phone']);
    if(empty($input_phone)){
        $phone_err = "Please enter a phone number";
    } elseif(!ctype_digit($input_phone)){
        $phone_err = "Please enter the valid phone number";
    } else{
        $phone = $input_phone;
    }

    // Validate address address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    // Validate medical history
    $input_medical_history = trim($_POST["medical_history"]);
    if(empty($input_medical_history)){
        $medical_history_err = "Please enter your medical history such as drugs, allergies and etc.";     
    } else{
        $medical_history = $input_medical_history;
    }
    // Validate test result
    $input_test_result = trim($_POST["test_result"]);
    if(empty($input_test_result)){
        $test_result_err = "Please enter the test result.";     
    } else{
        $test_result = $input_test_result;
    }

    // Validate billing information
    $input_billing_info= trim($_POST["billing_info"]);
    if(empty($input_billing_info)){
        $billing_info_err = "Please enter an billing information.";     
    } else{
        $billing_info = $input_billing_info;
    }
    
    // Check input errors before inserting in database
    if(empty($card_number_err) && empty($first_name_err) && empty($last_name_err) && empty($phone_err) && empty($address_err) && empty($medical_history_err) && empty($test_result_err) && empty($billing_info_err)){
        // Prepare an update statement
        $sql = "UPDATE patients SET card_number=?, first_name=?, last_name=?, phone=?, address=?, medical_history=?, test_result=?, billing_info=? WHERE patient_id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_card_number,$param_first_name, $param_last_name,$param_phone,$param_address, $param_medical_history,$param_test_result,$param_billing_info, $param_patient_id);
            
            // Set parameters
            $param_card_number =$card_number;
            $param_first_name = $first_name;
            $param_last_name =$last_name;
            $param_phone = $phone;
            $param_address = $address;
            $param_medical_history = $medical_history;
            $param_test_result = $test_result;
            $param_billing_info = $billing_info;
            $param_patient_id = $patient_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["patient_id"]) && !empty(trim($_GET["patient_id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM patients WHERE patient_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_patient_id);
            
            // Set parameters
            $param_patient_id = $patient_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $card_number = $row["card_number"];
                    $first_name = $row["first_name"];
                    $last_name = $row["last_name"];
                    $phone = $row["phone"];
                    $address = $row["address"];
                    $medical_history = $row["medical_history"];
                    $test_reasult = $row["test_result"];
                    $billing_info = $row["billing_info"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group <?php echo (!empty($card_number_err)) ? 'has-error' : ''; ?>">
                            <label>Card Number</label>
                            <input type="text" name="card_number" class="form-control" value="<?php echo $card_number; ?>">
                            <span class="help-block"><?php echo $card_number_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
                            <span class="help-block"><?php echo $first_name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
                            <span class="help-block"><?php echo $last_name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                            <span class="help-block"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($medical_history_err)) ? 'has-error' : ''; ?>">
                            <label>Medical History</label>
                            <input type="text" name="medical_history" class="form-control" value="<?php echo $medical_history; ?>">
                            <span class="help-block"><?php echo $medical_history_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($test_result_err)) ? 'has-error' : ''; ?>">
                            <label>Test Result</label>
                            <input type="text" name="test_result" class="form-control" value="<?php echo $test_result; ?>">
                            <span class="help-block"><?php echo $test_result_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($billing_info_err)) ? 'has-error' : ''; ?>">
                            <label>Billing Information</label>
                            <input type="text" name="billing_info" class="form-control" value="<?php echo $billing_info; ?>">
                            <span class="help-block"><?php echo $billing_info_err;?></span>
                        </div>
                        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>