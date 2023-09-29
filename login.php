<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form {
            display: flex;
            width: 400px;
            flex-direction: column;
            margin: 50px auto;
            font-size: 25px;
        }

        input{
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <form axtion="/components/loginSuccess.php" method="post">
        <label for="username">Username: </label>
        <input type="text" placeholder="UserName" name="username">
        <label for="password">Password: </label>
        <input type="password" placeholder="Password" name="password">
        <input type="submit" value="submit" />

    </form>
</body>

</html>

<?php
$servername = "localhost";
$usernamedb = "root";
$db_password = "";
$database = "test";

$conn = new mysqli($servername, $usernamedb, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username_first = $_POST['username'];
    $username_second = $_POST['password'];
}



$sql = "select * from users;" or die();
$result = mysqli_query($conn, $sql) or die("query failed");

if (mysqli_num_rows($result) > 0) {
    if (isset($_POST['db_user']) && isset($_POST['db_pass'])) {
        $db_user = $row['username'];
        $db_pass = $row['password'];

        if($db_user == $username_first){
            echo "success";
        }
    }

}
else{
    echo "Error";
}
?>