<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form{
            display: flex;
            width: 200px;
            flex-direction: column;
            margin: 50px auto;
        }
    </style>
</head>
<body>
    <form axtion="loginSuccess.php" method="post">
        <label for="username">Username: </label>
        <input type="text" name="username">
        <label for="password">Password: </label>
        <input type="password" name="password">
        <input type="submit" value="submit"/>

    </form>
</body>
</html>

<?php
if(isset($_POST['username']) && isset($_POST['password'])){
    echo $username_first=$_POST['username'];
    echo $username_second=$_POST['password'];
}
?>