<?php
session_start();

error_reporting(E_ERROR);

include('includes/functions.php');

//$loginError = $loggedInUser = '';

// If add button was submitted
if( isset( $_POST['account'] ) ) {
    
    // Set all variables to empty by default
    $userName = $userEmail = $userPassword = "";
    
    // Check to see if inputs are empty
    // Create variables with form data
    // Wrap the data with our function
    
    if( !$_POST["userName"] ) {
        $nameError = "Please enter your name <br>";
    } else {
        $userName = validateFormData( $_POST["userName"] );
    }
    
    if( !$_POST["userEmail"] ) {
        $nameError = "Please enter an email address <br>";
    } else {
        $userEmail = validateFormData( $_POST["userEmail"] );
    }
    
    if( !$_POST["userPassword"] ) {
        $nameError = "Please enter a password <br>";
    } else {
        $userPassword = validateFormData( $_POST["userPassword"] );
    }
    
    // if required fields have data
    if( $userName && $userEmail && $userPassword ) {
        
        // Connect to database
        include('includes/connection.php');
        
        // Hashed password
        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        
        // Create query
        $query = "INSERT INTO users (id, email, name, password) VALUES (NULL, '$userEmail', '$userName', '$hashedPassword')";
        
        $result = mysqli_query( $conn, $query );
        
        // if query was successful
        if( $result ) {
            
            // Refresh page with query string
            header( "Location: index.php?alert=success" );
            
        } else {
            
            // Something went wrong
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
            
        }
        
    } else {
        
        // Error message
        $accountError = "<div class='alert alert-danger'>Please fill out all fields. Try again.</div>";
        
    }
    
}

// Close the connection
mysqli_close($conn);

include('includes/header.php');

//$password = password_hash("mypassword", PASSWORD_DEFAULT);
//echo $password;

?>

<h1>Client Address Book</h1>
<p class="lead">Create an account.</p>

<?php echo $accountError; ?>

<form class="form-inline" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
    <div class="form-group">
        <label for="login-name" class="sr-only">Name</label>
        <input type="text" class="form-control" id="login-name" placeholder="your name" name="userName" value="<?php echo $userName; ?>">
    </div>
    <div class="form-group">
        <label for="login-email" class="sr-only">Email</label>
        <input type="text" class="form-control" id="login-email" placeholder="your email" name="userEmail" value="<?php echo $userEmail; ?>">
    </div>
    <div class="form-group">
        <label for="login-password" class="sr-only">Password</label>
        <input type="password" class="form-control" id="login-password" placeholder="create password" name="userPassword">
    </div>
    <button type="submit" class="btn btn-primary" name="account">Create account</button>
</form>

<br>

<p><a href="index.php">Back to login page</a></p>

<?php
include('includes/footer.php');
?>