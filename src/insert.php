<?php
include_once("db_connect.php");

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['nome']) && isset($_POST['email'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $conn->query("INSERT INTO utenti (nome, email) VALUES ('$nome', '$email')");
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id']) && isset($_POST['azione']) && $_POST['azione'] == 'elimina') {
    $id = $_POST['id'];
    $conn->query("DELETE FROM utenti WHERE id = $id");
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['azione']) && $_POST['azione'] == 'modifica') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $conn->query("UPDATE utenti SET nome='$nome', email='$email' WHERE id=$id");
}

$modifica_id = null;
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['azione']) && $_POST['azione'] == 'mostra_modifica') {
    $modifica_id = $_POST['id'];
}

$result = $conn->query("SELECT id, nome, email FROM utenti");

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuova Pagina</title>
</head>
<body>

<h2>Inserisci Nuovo Utente</h2>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome">
    <input type="email" name="email" placeholder="Email">
    <button type="submit">Aggiungi Utente</button>
</form>




<h3>Utenti Registrati</h3>
<table>
    <tr>
        <th style="color: lightseagreen;">ID</th>
        <th>Nome</th>
        <th>Email</th>
       <strong> <th style="color: black;">Azioni</th> </strong>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td style='color: lightseagreen;'>{$row['id']}</td>
                <td>{$row['nome']}</td>
                <td>{$row['email']}</td>
                <td>
                    </form>
                </td>
              </tr>";

              echo "<tr data-row=\"{$row['id']}\" style=\"display: none;\">
                        
                         <button type='submit' style='color: orange;'>🛠️Modifica🛠️</button> 


                    </form>
                </td>
              </tr>";

               if ($modifica_id == $row['id']) {
                    echo "<tr style='background:#f0f0f0;'>
                    <td colspan='4'>
                        <form method='POST'>
                            <input type='hidden' name='azione' value='modifica'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <input type='text' name='nome' value='{$row['nome']}'>
                            <input type='email' name='email' value='{$row['email']}'>
                            <button type='submit'>Salva</button>
                        </form>
                    </td>
              </tr>";
    }
}
    ?>
</table>

</body>
</html>

<?php
$conn->close();
?>

