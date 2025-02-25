<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enquetes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nova_enquete"])) {
    $pergunta = $_POST["pergunta"];
    $opcoes = explode(",", $_POST["opcoes"]);
    $sql = "INSERT INTO enquetes (pergunta) VALUES ('$pergunta')";
    $conn->query($sql);
    $id_enquete = $conn->insert_id;
    foreach ($opcoes as $opcao) {
        $sql = "INSERT INTO opcoes (id_enquete, opcao) VALUES ($id_enquete, '$opcao')";
        $conn->query($sql);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["votar"])) {
    $id_opcao = $_POST["opcao"];
    $sql = "UPDATE opcoes SET votos = votos + 1 WHERE id = $id_opcao";
    $conn->query($sql);
}

$enquetes = $conn->query("SELECT * FROM enquetes ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Enquetes</title>
</head>
<body>
    <h2>Criar Nova Enquete</h2>
    <form method="post">
        Pergunta: <input type="text" name="pergunta" required>
        Opções (separadas por vírgula): <input type="text" name="opcoes" required>
        <button type="submit" name="nova_enquete">Criar</button>
    </form>
    
    <h2>Enquetes</h2>
    <?php while ($enquete = $enquetes->fetch_assoc()) { ?>
        <h3><?php echo $enquete["pergunta"]; ?></h3>
        <form method="post">
            <?php
            $opcoes = $conn->query("SELECT * FROM opcoes WHERE id_enquete = " . $enquete["id"]);
            while ($opcao = $opcoes->fetch_assoc()) {
                echo "<input type='radio' name='opcao' value='" . $opcao["id"] . "'> " . $opcao["opcao"] . " (" . $opcao["votos"] . " votos)<br>";
            }
            ?>
            <button type="submit" name="votar">Votar</button>
        </form>
    <?php } ?>
</body>
</html>
