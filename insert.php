<?php
// Include config file
ini_set('display_errors',1); error_reporting(E_ALL);
require_once "config.php";
 
// Define variables and initialize with empty values
$card_number = $first_name = $last_name = $phone = $address = $medical_history = $test_result = $billing_info = "";

$card_number_err = $first_name_err = $last_name_err = $phone_err = $address_err = $medical_history_err = $test_result_err = $billing_info_err = "";
 
// Processing form data when form is submitted
// if($_SERVER["REQUEST_METHOD"] == "POST"){
    //Validate card number
    $input_card_number = trim($_REQUEST["card_number"]);
    if(empty($input_card_number)){
        $card_number_err = "Please enter the number of insurance card.";
    } else{
        $card_number = $input_card_number;
    }
    // Validate name
    $input_first_name = trim($_REQUEST["first_name"]);
    if(empty($input_first_name)){
        $first_name_err = "Please enter your first name.";
    } elseif(!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $frist_name_err = "Please enter a valid first name.";
    } else{
        $first_name = $input_first_name;
    }

    $input_last_name = trim($_REQUEST["last_name"]);
    if(empty($input_last_name)){
        $last_name_err = "Please enter your last name.";
    } elseif(!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $last_name_err = "Please enter a valid last name.";
    } else{
        $last_name = $input_last_name;
    }
    //Validate phone number
    $input_phone = trim($_REQUEST['phone']);
    if(empty($input_phone)){
        $phone_err = "Please enter a phone number";
    } elseif(!ctype_digit($input_phone)){
        $phone_err = "Please enter the valid phone number";
    } else{
        $phone = $input_phone;
    }
    // Validate address
    $input_address = trim($_REQUEST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    $input_medical_history = trim($_REQUEST["medical_history"]);
    if(empty($input_medical_history)){
        $medical_history_err = "Please enter your medical history such as drugs, allergies and etc.";     
    } else{
        $medical_history = $input_medical_history;
    }
    // Validate test result
    $input_test_result = trim($_REQUEST["test_result"]);
    if(empty($input_test_result)){
        $test_result_err = "Please enter the test result.";     
    } else{
        $test_result = $input_test_result;
    }

    $input_billing_info= trim($_REQUEST["billing_info"]);
    if(empty($input_billing_info)){
        $billing_info_err = "Please enter an billing information.";     
    } else{
        $billing_info = $input_billing_info;
    }

    
    // Check input errors before inserting in database
    if(empty($card_number_err) && empty($first_name_err) && empty($last_name_err) && empty($phone_err) && empty($address_err) && empty($medical_history_err) && empty($test_result_err) && empty($billing_info_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO patients (card_number, first_name, last_name, phone, address, medical_history, test_result, billing_info) VALUES (?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_card_number,$param_first_name, $param_last_name,$param_phone,$param_address, $param_medical_history,$param_test_result,$param_billing_info);
            
            // Set parameters
            $param_card_number =$card_number;
            $param_first_name = $first_name;
            $param_last_name =$last_name;
            $param_phone = $phone;
            $param_address = $address;
            $param_medical_history = $medical_history;
            $param_test_result = $test_result;
            $param_billing_info = $billing_info;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                // header("location: index.php");
                echo "Record submitted";
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
// }
?>
 