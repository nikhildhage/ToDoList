<?php
include("database.php");

// POST data
$newTitle = filter_input(INPUT_POST, 'newTitle', FILTER_UNSAFE_RAW);
$newDescription = filter_input(INPUT_POST, 'newDescription', FILTER_UNSAFE_RAW);

// Insert new item if form data is posted
if (!empty($newTitle) && !empty($newDescription)) {
    $insertQuery = "INSERT INTO todoitems (Title, Description) VALUES (:newTitle, :newDescription)";
    $insertStatement = $db->prepare($insertQuery);
    $insertStatement->bindValue(':newTitle', $newTitle);
    $insertStatement->bindValue(':newDescription', $newDescription);
    $insertStatement->execute();
    $insertStatement->closeCursor();
    // Redirect to the same page to prevent form re-submission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


// Fetch all items from the database to display
$query = "SELECT * FROM todoitems";
$statement = $db->prepare($query);
$statement->execute();
$results = $statement->fetchAll();
$statement->closeCursor();
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
    <!--App-->
    <div id="app-container" class="container-xl m-3 p-3 bg-light rounded border border-2">
        <main class="d-flex flex-column justify-content-center p-3">
            <? //Show TO DO List = 
            ?>
            <section id="toDoList" class="my-5">
                <div class="row">
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

                                        if (!empty($results)) {
                                            foreach ($results as $result) {
                                                echo "<tr>";
                                                echo "<td>" . $result['Title'] . "</td>";
                                                echo "<td>" . $result['Description'] . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr>";
                                            echo "<td>NO Data Found<td>";
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
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>