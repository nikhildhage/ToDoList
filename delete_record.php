<?php
require("database.php");
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $query = "DELETE FROM todoitems WHERE ItemNum =:id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    $deleted = TRUE;
}
header('Location: ' . "index.php");
