<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: index.php");
}

// connect to database
include('includes/connection.php');

// query & result
$query = "SELECT * FROM clients";
$result = mysqli_query( $conn, $query );

// check for query string
if( isset( $_GET['alert'] ) ) {
    
    // new client added
    if( $_GET['alert'] == 'success' ) {
        $alertMessage = "<div class='alert alert-success'>New client added! <a class='close' data-dismiss='alert'>&times;</a></div>";
        
    // client updated
    } elseif( $_GET['alert'] == 'updatesuccess' ) {
        $alertMessage = "<div class='alert alert-success'>Client updated! <a class='close' data-dismiss='alert'>&times;</a></div>";
    
    // client deleted
    } elseif( $_GET['alert'] == 'deleted' ) {
        $alertMessage = "<div class='alert alert-success'>Client deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
      
}

// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<h1>Client Address Book</h1>

<?php echo $alertMessage; ?>

<div class="table-responsive">
    <table class="table table-striped table-bordered ">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Company</th>
            <th>Notes</th>
            <th>Edit</th>
        </tr>
        
        <?php
                
        if( mysqli_num_rows($result) > 0 ) {

            // We have data
            // Output the data

            while( $row = mysqli_fetch_assoc($result) ) {
                echo "<tr>";

                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['company'] . "</td>";
                echo "<td>" . $row['notes'] . "</td>";

                echo '<td><a href="edit.php?id=' . $row['id'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                </a></td>';

                echo "</tr>";
            }

        } else { // if no entries

            echo "<div class='alert alert-warning'>You have no clients!</div>";

        }
                    
        mysqli_close($conn);
        
        ?>
        
<!--
        <tr>
            <td>John Doe</td>
            <td>john@doe.com</td>
            <td>(123) 456-7890</td>
            <td>111 Address Street, Calgary, AB  T1G 2KY</td>
            <td>Brightside Studios Inc.</td>
            <td>Usually pays early. He's awesome.</td>
            <td><a href="edit.php" type="button" class="btn btn-default btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a></td>
        </tr>
        <tr>
            <td>Jane Doe</td>
            <td>jane@doe.com</td>
            <td>(123) 456-7890</td>
            <td>12a Address Avenue, Calgary, AB  T1G 2KY</td>
            <td>Brightside Studios Inc.</td>
            <td>Nice lady. Pays in high fives though...</td>
            <td><a href="edit.php" type="button" class="btn btn-default btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a></td>
        </tr>
-->

        <tr>
            <td colspan="7"><div class="text-center"><a href="add.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
        </tr>
    </table>
</div>

<?php
include('includes/footer.php');
?>