<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$biersorte = $anzahl = $lagerort = $preis = "";
$biersorte_err = $anzahl_err = $lagerort_err = $preis_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate biersorte
    $input_biersorte = trim($_POST["biersorte"]);
    if(empty($input_biersorte)){
        $biersorte_err = "Du muesch e Biersorte agä";   
    } else{
        $biersorte = $input_biersorte;
    }

    // Validate anzahl
    $input_anzahl = trim($_POST["anzahl"]);
    if(empty($input_anzahl)){
        $anzahl_err = "Du muesch Anzahl Bier igä!";
    } elseif(!ctype_digit($input_anzahl)){
        $anzahl_err = "Du muesch ä Zau igä!";
    } else{
        $anzahl = $input_anzahl;
    }
    
    // Validate lagerort
    $input_lagerort = trim($_POST["lagerort"]);
    if(empty($input_lagerort)){
        $lagerort_err = "Du muesch e Lagerort agä!";     
    } elseif(!ctype_digit($input_lagerort)){
        $lagerort_err = "Du muesch ä Zau igä!";
    } else{
        $lagerort = $input_lagerort;
    }
    
    // Validate preis
    $input_preis = trim($_POST["preis"]);
    if(empty($input_preis)){
        $preis_err = "Du muesch e Priis igä!";
    } elseif(!is_numeric($input_preis)){
        $preis_err = "Du muesch ä Zau igä!";     
    } elseif($input_preis < 0){
        $preis_err = "Isch ds Bier so schlächt, dass du wosch Zahle derfür?!"; 
    } 
    else{
        $preis = $input_preis;
    }
    
    // Check input errors before inserting in database
    if(empty($biersorte_err) && empty($anzahl_err) && empty($lagerort_err) && empty($preis_err)){
        // Prepare an update statement
        $sql = "UPDATE LAGER SET Biersorte=:biersorte, Anzahl=:anzahl, Lagerort=:lagerort, Preis=:preis WHERE ID=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":biersorte", $param_biersorte);
            $stmt->bindParam(":anzahl", $param_anzahl);
            $stmt->bindParam(":lagerort", $param_lagerort);
            $stmt->bindParam(":preis", $param_preis);
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_biersorte = $biersorte;
            $param_anzahl = $anzahl;
            $param_lagerort = $lagerort;
            $param_preis = $preis;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }    
    //Close connection
    unset($pdo);
} else{
    // Check existence of ID parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id=  trim($_GET["id"]);
        
         // Prepare a select statement
         $sql = "SELECT * FROM LAGER WHERE ID = :id";
         if($stmt = $pdo->prepare($sql)){
             // Bind variables to the prepared statement as parameters
             $stmt->bindParam(":id", $param_id);
            
             // Set parameters
             $param_id = $id;
            
             // Attempt to execute the prepared statement
            if($stmt->execute()){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $biersorte = $row["Biersorte"];
                    $anzahl = $row["Anzahl"];
                    $lagerort = $row["Lagerort"];
                    $preis = round($row['Preis'], 2);                 
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
         }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain ID parameter. Redirect to error page
        header("location: error.php");
        exit();
     }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bier ändere</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Lager Updatä</h2>
                    <p>Du chasch hie dr Itrag vo dim Bier apasse.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Biersorte</label>
                            <input type="text" name="biersorte" class="form-control <?php echo (!empty($biersorte_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $biersorte; ?>">
                            <span class="invalid-feedback"><?php echo $biersorte_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Anzahl</label>
                            <textarea name="anzahl" class="form-control <?php echo (!empty($anzahl_err)) ? 'is-invalid' : ''; ?>"><?php echo $anzahl; ?></textarea>
                            <span class="invalid-feedback"><?php echo $anzahl_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Lagerort</label>
                            <input type="text" name="lagerort" class="form-control <?php echo (!empty($lagerort_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lagerort; ?>">
                            <span class="invalid-feedback"><?php echo $lagerort_err;?></span>
                            </div>
                        <div class="form-group">
                            <label>Preis</label>
                            <textarea name="preis" class="form-control <?php echo (!empty($preis_err)) ? 'is-invalid' : ''; ?>"><?php echo $preis; ?></textarea>
                            <span class="invalid-feedback"><?php echo $preis_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Bier Update">
                        <a href="index.php" class="btn btn-secondary ml-2">Abbrächä</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>