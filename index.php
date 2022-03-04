<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schlossberg Lager</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 850px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 150px;
        }
    </style>
    <style>
        .aligncenter {
            text-align: center;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <p class="aligncenter"><img src = "logo2.png" alt ="Schlossberglogo" width=400 /></p>  
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">      
                    <div class="mt-5 mb-3 clearfix">                    
                        <h2 class="pull-left">Bierlager</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Bier hinzuefüege</a>
                    </div>                   
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM LAGER";
                    if($result = $pdo->query($sql)){                        
                        echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>Sorte</th>";
                                    echo "<th>Anzahl</th>";
                                    echo "<th>Lagerort</th>";
                                    echo "<th>Preis</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = $result->fetch()){
                                echo "<tr>";
                                    echo "<td>" . $row['Biersorte'] . "</td>";
                                    echo "<td>" . $row['Anzahl'] . "</td>";
                                    echo "<td>" . $row['Lagerort'] . "</td>";
                                    $preis = round($row['Preis'], 2);
                                    echo "<td>" . number_format((float)$preis, 2, '.', '')  . ' Fr.' ."</td>";
                                    echo "<td>";
                                        echo '<a href="read.php?id='. $row['ID'] .'" class="mr-3" title="Ahluege" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                        echo '<a href="update.php?id='. $row['ID'] .'" class="mr-3" title="Ändere" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                        echo '<a href="delete.php?id='. $row['ID'] .'" title="Lösche" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                    echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";                            
                        echo "</table>";
                        // Free result set
                        unset($result);
                    } else{
                        echo "Hoppla! Öppis isch schief glüffe. Bitte pro-Bier-s speter nomau...";
                    }
                    
                    // Close connection
                    unset($pdo);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>