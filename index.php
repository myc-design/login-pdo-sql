<?php
if (isset($_POST['submit'])) {
//store name and password in session variables
    session_start();
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['password'] = $_POST['password'];
//encript password using bcrypt
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $storeHash = $hash;
    $inputPassword = $password;
    $check = password_verify($inputPassword, $storeHash);
//connect to loginDB database
    $db = new PDO('mysql:host=db; dbname=loginDB', 'root', 'password');
//store name in variable
    $username = $_POST['name'];
  
//prepare query by passing in bound params
    $query=$db->prepare('INSERT INTO `users`(`username`, `password`) 
   VALUES (:username, :password)');
//fetch associative array from db
    $query->setFetchMode(PDO::FETCH_ASSOC);
//execute query and pass in params
    $query->execute([':username'=>$username, ':password'=> $password]);
    $result = $query->fetchAll();
//redirect to login
   header("Location:login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>php tuts</title>
</head>
<body>
<form action="" method="POST">
    <input type="text" name="name" placeholder="Enter Name">
    <input type="text" name="password" placeholder="Enter Password">
    <input type="submit" name="submit" value="submit">
</form>
</body>
</html>