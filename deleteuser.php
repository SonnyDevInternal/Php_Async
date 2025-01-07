<?php 
    require_once "databaseconnection.php";
    $dbconn = new DatabaseConnection();

    if($_SERVER["REQUEST_METHOD"] == "DELETE")
    {
        require_once "Uri.php";

        $formattedList = format_FromURI($_SERVER["REQUEST_URI"]);

        $id_Data = getDataFromFormatted($formattedList, "id");

        if($id_Data !== null)
        {
            $sql = "DELETE FROM user WHERE ID = $id_Data";

            $results = $dbconn->conn->query($sql);

            if(!$results)
            echo "Failed to Delete User!";
            else
            {
                "Deleted User with ID: " + $id_Data;
            }
        }
        else
        {
            echo $formattedList->varList . "Formatted Data was NULL";
        }
    }
?>
