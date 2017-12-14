<?php
session_start();

// Check if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // Send them to the login page
    header("Location: index.php");
    
}

// Connect to database
include('includes/connection.php');

// Include Functions file
include('includes/functions.php');

// If add button was submitted
if( isset( $_POST['add'] ) ) {
    
    // Set all variables to empty by default
    $clientName = $clientEmail = $clientPhone = $clientAddress = $clientCompany = $clientNotes = "";
    
    // Check to see if inputs are empty
    // Create variables with form data
    // Wrap the data with our function
    
    if( !$_POST["clientName"] ) {
        $nameError = "Please enter a name <br>";
    } else {
        $clientName = validateFormData( $_POST["clientName"] );
    }
    
    if( !$_POST["clientEmail"] ) {
        $nameError = "Please enter an email address <br>";
    } else {
        $clientEmail = validateFormData( $_POST["clientEmail"] );
    }
    
    // These inputs are not required
    // So we'll just store whatever has been entered
    $clientPhone = validateFormData( $_POST['clientPhone'] );
    $clientAddress = validateFormData( $_POST['clientAddress'] );
    $clientCompany = validateFormData( $_POST['clientCompany'] );
    $clientNotes = validateFormData( $_POST['clientNotes'] );
    
    // if required fields have data
    if( $clientName && $clientEmail ) {
        
        // Create query
        $query = "INSERT INTO clients (id, name, email, phone, address, company, notes, date_added) VALUES (NULL, '$clientName', '$clientEmail', '$clientPhone', '$clientAddress', '$clientCompany', '$clientNotes', CURRENT_TIMESTAMP)";
        
        $result = mysqli_query( $conn, $query );
        
        // if query was successful
        if( $result ) {
            
            // Refresh page with query string
            header( "Location: clients.php?alert=success" );
            
        } else {
            
            // Something went wrong
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
            
        }
        
    }
    
}

// Close the connection
mysqli_close($conn);

include('includes/header.php');
?>

<h1>Add Client</h1>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name *</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email *</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address</label>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"></textarea>
    </div>
    <div class="col-sm-12">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add Client</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>