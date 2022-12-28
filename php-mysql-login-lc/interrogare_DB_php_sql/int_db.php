<?php
    // dati per la connessione al db
    define("DB_SERVERNAME", "localhost:3306");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "root");
    define("DB_NAME", "university");

    // Connect
    $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn && $conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
    }

    if( !empty($_GET['id'])){
        $sql = "SELECT * FROM `departments` WHERE `id` = ?";
    } else {
        $sql = "SELECT * FROM `departments`";
    }
    $stmt = $conn->prepare($sql);

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
        $stmt->bind_param("i", $id);
    }
    $stmt->execute();

    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>mysqli DB University</title>
    </head>
    <body>
        <?php if($result && $result->num_rows > 0){ ?>
            <?php if( !empty($_GET['id']) ) {?>
                <p>
                    <a href="int_db.php">Torna alla lista dei dipartimenti</a>
                </p>
            <?php } ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Indirizzo</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><a href="int_db.php?id=<?php echo $row['id'] ?>"><?php echo $row['name'] ?></a></td>
                            <td><?php echo $row['address'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else if ($result){ ?>
            <h2>0 results</h2>
        <?php } else { ?>
            <h2>Query error</h2>
        <?php } ?>
    </body>
</html>