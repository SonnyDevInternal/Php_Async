<?php 
    require_once "databaseconnection.php";
    $dbconn = new DatabaseConnection();

    $sql = "SELECT * FROM user";
    $results = $dbconn->conn->query($sql);
    $userarray = $results->fetch_all();

    // UPDATE SQL
    // DELETE SQL
?>

<?php foreach($userarray as $user) :?>
    <div class="usercontainer"> <p>Name: <?= $user[1] ?> </p>  <button onmousedown="DeleteUser(<?= $user[0] ?>)"> Click Me </button></div>
<?php endforeach;?>