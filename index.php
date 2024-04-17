<?= include("database.php"); ?>
<?php
$query = "SELECT * FROM todoitems";
$statement = $db->prepare($query);
$statement->execute();
$results = $statement->fetchAll();
$statement->closeCursor();
?>

<?php
//POST data
$newTitle = filter_input(INPUT_POST, "newTitle", FILTER_UNSAFE_RAW);
$newDescription = filter_input(INPUT_POST, "newDescription", FILTER_UNSAFE_RAW);

//GET Data
$title = filter_input(INPUT_GET, "title", FILTER_UNSAFE_RAW);
$description = filter_input(INPUT_GET, "description", FILTER_UNSAFE_RAW);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>ToDoList</title>
</head>

<body>
    <div id="app-container" class="container-xl m-3 p-3 bg-light rounded border border-2">
        <main class="d-flex flex-column justify-content-center p-3">
            <?php
            // Show the TO DO List when item form is does not have data or has data
            ?>
            <?php if (!$newTitle || !$newDescription) { ?>
                <section id="emptyToDoList" class="my-5">
                    <div class=" row">
                        <div class="col-sm-6 col-lg-8 col-xl-12">
                            <div class="card">
                                <div class="card-header display-4 bg-primary">
                                    TO DO List
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Title</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($results as $result) {
                                                echo "<tr>";
                                                echo "<td>" . $result['Title'] . "</td>";
                                                echo "<td>" . $result['Description'] . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="add-item-form" class="my-3">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="border border-2 py-3">
                        <div class="row g-3 m-3">
                            <div class="col-12 form-group form-group-inline ">
                                <label for="newTitle" class="control control-left form-label ">Title</label>
                                <input id="newTitle" name="newTitle" type="text" placeholder="Ex: Title" class="form-control" style="width:30em" required>
                            </div>
                            <div class="col-12 form-group">
                                <label for="newDescription" class="form-label mx-3">Description</label>
                                <input id="newDescription" name="newDescription" type="text" placeholder="Ex: Description" class="form-control" style="width:30em" required>
                            </div>
                            <div class="col-sm-8 d-flex">
                                <button type="submit" class="btn btn-primary" style="width:30em">Add Item</button>
                            </div>
                        </div>
                    </form>
                </section>
            <?php } else { ?>

                <?php
                $outputTitle = "New Title:" . " ";
                $outputDescription = "New Description:" . " ";
                $outputCurrentTitle = "Current Title:" . " ";
                $outputCurrentDescription = "Current Description:" . " ";
                echo  "<script>
                        console.log('" . $outputTitle .  $newTitle . "');
                        console.log('" . $outputDescription .  $newDescription . "');
                    </script>";
                ?>

                <?php
                $query = "SELECT * FROM todoitems ";
                $statement = $db->prepare($query);
                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closeCursor();
                ?>

                <?php
                // Show the To Do List with data if the data exists **/
                ?>
                <?php if (($title || $description)  || ($newTitle || $newDescription)) { ?>
                    <section id="toDoList" class="my-5">
                        <div class=" row g-3">
                            <div class="col-sm-6 col-lg-8 col-xl-12">
                                <div class="card">
                                    <div class="card-header display-4 bg-primary">
                                        TO DO List
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead class="table-dark">
                                                <tr class=>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($results as $result) {
                                                    echo "<tr>";
                                                    echo "<td>" . $result['Title'] . "</td>";
                                                    echo "<td>" . $result['Description'] . "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 d-flex">
                                <a href="index.php" class="btn btn-primary">Go Back</a>
                            </div>
                        </div>
                    </section>
                <?php } ?>

                <?php if (($title || $description)  || ($newTitle || $newDescription)) {
                    // Execute insert query if data exists
                    $query = "INSERT INTO todoitems
                                (Title, Description)
                                VALUES (:newTitle, :newDescription)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':newTitle', $newTitle);
                    $statement->bindValue(':newDescription', $newDescription);
                    $statement->execute();
                    $results = $statement->fetchAll();
                    $statement->closeCursor();
                } ?>
            <?php } ?>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>