<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$biersorte = $anzahl = $lagerort = $preis = "";
$biersorte_err = $anzahl_err = $lagerort_err = $preis_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

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
        // Prepare an insert statement
        $sql = "INSERT INTO LAGER (Biersorte, Anzahl, Lagerort, Preis) VALUES (:biersorte, :anzahl, :lagerort, :preis)";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":biersorte", $param_biersorte);
            $stmt->bindParam(":anzahl", $param_anzahl);
            $stmt->bindParam(":lagerort", $param_lagerort);
            $stmt->bindParam(":preis", $param_preis);
            
            // Set parameters
            $param_biersorte = $biersorte;
            $param_anzahl = $anzahl;
            $param_lagerort = $lagerort;
            $param_preis = $preis;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Hoppla! Öppis isch schief glüffe. Bitte pro-Bier-s speter nomau...";
            }
        }         
        // Close statement
        unset($stmt);
    }    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bier hinzuefüege</title>
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
                    <h2 class="mt-5">Neus Bier hinzuefüege</h2>
                    <p>Hie chasch du es neus Bier im Schlossberg Lager erfasse.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Biersorte</label>
                            <input type="text" name="biersorte" class="form-control <?php echo (!empty($biersorte_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $biersorte; ?>">
                            <span class="invalid-feedback"><?php echo $biersorte_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Anzahl</label>
                            <input type="text" name="anzahl" class="form-control <?php echo (!empty($anzahl_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $anzahl; ?>">
                            <span class="invalid-feedback"><?php echo $anzahl_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Lagerort</label>
                            <input type="text" name="lagerort" class="form-control <?php echo (!empty($lagerort_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lagerort; ?>">
                            <span class="invalid-feedback"><?php echo $lagerort_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Preis</label>
                            <input name="preis" class="form-control <?php echo (!empty($preis_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $preis; ?>">
                            <span class="invalid-feedback"><?php echo $preis_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Bier Erfasse">
                        <a href="index.php" class="btn btn-secondary ml-2">Abbrechen</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>