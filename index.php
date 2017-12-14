<?php
session_start();

error_reporting(E_ERROR);

include('includes/functions.php');

//$loginError = $loggedInUser = '';

// Check if login form was submitted
if( isset( $_POST['login'] ) ) {
    
    // Create variables
    // Wrap data with validate function
    $formEmail  = validateFormData( $_POST['email'] );
    $formPass   = validateFormData( $_POST['password'] );
    
    // Connect to database
    include('includes/connection.php');
    
    // Create query
    $query = "SELECT name, password FROM users WHERE email='$formEmail'";
    
    // Store the result
    $result = mysqli_query( $conn, $query ); 
    
    // Verify if result is returned
    if( mysqli_num_rows($result) > 0 ) {
        
        // Store basic user data in variables
        while( $row = mysqli_fetch_assoc($result) ) {
            $name       = $row['name'];
            $hashedPass = $row['password'];
        }
        
        // Verify hashed password with submitted password
        if( password_verify( $formPass, $hashedPass ) ) {
            
            // Correct login details!
            // Store data in SESSION variables
            $_SESSION['loggedInUser'] = $name;
            
            // Redirect user to clients page
            header( "Location: clients.php" );
            
        } else { // hashed password didn't verify or match
            
            // Error message
            $loginError = "<div class='alert alert-danger'>Wrong username/password combination. Try again.</div>";
            
        }
        
    } else { // there are no results in database
        
        // Error message
        $loginError = "<div class='alert alert-danger'>Nu such user in database. Please try again.<a class='close' data-dismiss='alert'>&times;</a></div>";
        
    }
    
}

// check for query string
if( isset( $_GET['alert'] ) ) {
    
    // new client added
    if( $_GET['alert'] == 'success' ) {
        $alertMessage = "<div class='alert alert-success'>New user account created! <a class='close' data-dismiss='alert'>&times;</a></div>"; 
    }
    
}

// Close mysql connection
mysqli_close($conn);

include('includes/header.php');

//$password = password_hash("mypassword", PASSWORD_DEFAULT);
//echo $password;

?>

<h1>Client Address Book</h1>
<p class="lead">Log in to your account.</p>

<?php echo $loginError; ?>
<?php echo $alertMessage; ?>

<form class="form-inline" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
    <div class="form-group">
        <label for="login-email" class="sr-only">Email</label>
        <input type="text" class="form-control" id="login-email" placeholder="email" name="email" value="<?php echo $formEmail; ?>">
    </div>
    <div class="form-group">
        <label for="login-password" class="sr-only">Password</label>
        <input type="password" class="form-control" id="login-password" placeholder="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary" name="login">Login</button>
</form>

<br>

<p><a href="account.php">Create Account</a></p>

<?php
include('includes/footer.php');
?>