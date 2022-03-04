<?php
// Check existence of ID parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM LAGER WHERE ID = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_ID);
        
        // Set parameters
        $param_ID = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){           
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve indivIDual field value
                $ID = $row["ID"];
                $biersorte = $row["Biersorte"];
                $anzahl = $row["Anzahl"];  
                $lagerort = $row["Lagerort"];                 
                $preis = round($row['Preis'], 2); 
                $test =  number_format((float)$preis, 2, '.', '')  . ' Fr.';   
                         
        } else{
            echo "Hoppla! Öppis isch schief glüffe. Bitte pro-Bier-s speter nomau...";
        }
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain ID parameter. Redirect to error page
    header("location: error.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row["Biersorte"]; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            wIDth: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluID">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3"><?php echo $row["Biersorte"]; ?></h1>
                    <div class="form-group">
                        <label>ID</label>
                        <p><b><?php echo $row["ID"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Anzahl</label>
                        <p><b><?php echo $row["Anzahl"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Lagerort</label>
                        <p><b><?php echo $row["Lagerort"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Preis pro Einheit</label>
                        <p><b><?php echo $test; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Zrügg</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>