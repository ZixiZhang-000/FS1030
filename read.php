<?php
// Check existence of id parameter before processing further
if(isset($_GET["patient_id"]) && !empty(trim($_GET["patient_id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM patients WHERE patient_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_patient_id);
        
        // Set parameters
        $param_patient_id = trim($_GET["patient_id"]);
        
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
                $test_result = $row["test_result"];
                $billing_info = $row["billing_info"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Card Number</label>
                        <p class="form-control-static"><?php echo $row["card_number"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <p class="form-control-static"><?php echo $row["first_name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <p class="form-control-static"><?php echo $row["last_name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <p class="form-control-static"><?php echo $row["phone"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p class="form-control-static"><?php echo $row["address"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Medical History</label>
                        <p class="form-control-static"><?php echo $row["Medical History"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Test Result</label>
                        <p class="form-control-static"><?php echo $row["test_result"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Billing Information</label>
                        <p class="form-control-static"><?php echo $row["billing_info"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>