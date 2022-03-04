<?php
try {
    $pdo = new PDO("sqlsrv:server = tcp:schlossbergserver.database.windows.net,1433; Database = schlossbergDatabase", "azureuser", "9N7%WkTzyrau");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Hoppla! dr SQL Server isch niene :( Nimm afe e schluck vo dämm feine Schlossbärg-Bier und Pro-Bier-s i es paar minute nomau, er isch vilech no am ufstarte...");
    die();
}
?>