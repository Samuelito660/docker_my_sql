<?php
$servername = 'db';
$username = 'myuser';
$password = 'mypassword';
$database = 'myapp_db';

echo $servername . "<br />";
echo $username   . "<br />";
echo $password   . "<br />";
echo $database   . "<br />";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

echo "<h1>Connessione riuscita a MySQL!</h1>";

$result = $conn->query("SHOW TABLES;");
echo "<pre>";
while ($row = $result->fetch_array()) {
    print_r($row);
}
echo "</pre>";

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


 <h1>Inserisci i tuoi dati!</h1>

    <form action="index.php" method="post">

        <label>Nome :</label>
        <input type="text" name="nome" required>
        <br>
        <label>Cognome :</label>
        <input type="text" name="cognome" required>
        <br>
        <label>Email :</label>
        <input type="email" name="email" required>
        <br>
        <label>Data di nascita (gg/mm/aaaa) :</label>
        <input type="text" name="eta" required>
        <br>
        <label>Indirizzo :</label>
        <input type="text" name="indirizzo" required>
        <br>
        <label>Citta' :</label>
        <input type="text" name="citta" required>
        <br>
        <label>Provincia :</label>
        <input type="text" name="provincia" required>
        <br>

        <input type="submit" value="Invia">
        <br>
        <br>





    </form>

    
</body>
</html>



<?php 

if(    
    isset($_POST['nome']) && 
    isset($_POST['cognome']) && 
    isset($_POST['email']) && 
    isset($_POST['eta']) && 
    isset($_POST['indirizzo']) && 
    isset($_POST['citta']) && 
    isset($_POST['provincia'])     )
    {
        
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $email = $_POST['email'];
        $eta = $_POST['eta'];
        $indirizzo = $_POST['indirizzo'];
        $citta = $_POST['citta'];
        $provincia = $_POST['provincia'];
        

        $id = (file('csv/users.csv'));
        $id = count($id);

        $path = 'csv/users.csv';
        $handle = fopen($path , 'a');
        echo "<table border = 1;>";

        
        $data = array( 
            $id, 
            $nome, 
            $cognome, 
            $email, 
            $eta, 
            $indirizzo, 
            $citta, 
            $provincia 
        );
        fputcsv($handle, $data, ",", '"', "\\");
        fclose($handle);
    }


    $path = 'csv/users.csv';
    $handle = fopen($path , 'r');
    
    echo "<table border = 1;>";

    while(($riga = fgetcsv($handle)) !== false){
    echo "<tr>";
    foreach($riga as $cella){
        echo "<td>" , $cella , "</td>";
    }
    echo "</tr>";
}

echo "</table>";

fclose($handle);
?>