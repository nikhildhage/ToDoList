<?php
//POST data
$newTitle = filter_input(INPUT_POST, "newTitle", FILTER_UNSAFE_RAW);
$newDescription = filter_input(INPUT_POST, "newDescription", FILTER_UNSAFE_RAW);
$newCategory = filter_input(INPUT_POST, "newCategory", FILTER_UNSAFE_RAW);

//GET Data
$title = filter_input(INPUT_GET, "title", FILTER_UNSAFE_RAW);
$description = filter_input(INPUT_GET, "description", FILTER_UNSAFE_RAW);
$category = filter_input(INPUT_GET, "category", FILTER_UNSAFE_RAW);
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
            <?php if (!$newTitle || !$newDescription || !$newCategory) { ?>
                <section id="toDoList" class="my-5">
                    <div class=" row">
                        <div class="col-sm-6 col-lg-8 col-xl-12">
                            <div class="card">
                                <div class="card-header display-4 bg-primary">
                                    TO DO List
                                </div>
                                <div class="card-body">
                                    <div>
                                        <p>No Data </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="add-item-form" class="my-3">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="border border-2 py-3">
                        <div class="row g-3 m-3">
                            <div class="col-12 form-group form-group-inline">
                                <label for="newTitle" class="control control-left form-label">Title</label>
                                <input id="newTitle" name="newTitle" type="text" placeholder="Ex: Title" class="form-control">
                            </div>
                            <div class="col-12 form-group">
                                <label for="newDescription" class="form-label">Description</label>
                                <input id="newDescription" name="newDescription" type="text" placeholder="Ex: Description" class="form-control">
                            </div>
                            <div class="col-lg-12 form-group">
                                <label for="newCategory" class="form-label">Category</label>
                                <input id="newCategory" name="newCategory" type="text" placeholder="Ex: Category" class="form-control">
                            </div>
                            <div class="col-sm-8 d-flex">
                                <button type="submit" class="btn btn-primary">Add Item</button>
                            </div>
                        </div>
                    </form>
                </section>
            <?php } else { ?>
                <?php
                $outputLabel = "New Title:" . " ";
                echo  "<script>console.log('" . $outputLabel .  $newTitle . "');</script>";
                ?>
                <?php include("database.php"); ?>

                /* Show the To Do List with data if the data exists*/
                <?php if (($title || $description || $category)  || ($newTitle || $newDescription || $newCategory)) { ?>
                    <section id="toDoList" class="my-5">
                        <div class=" row">
                            <div class="col-sm-6 col-lg-8 col-xl-12">
                                <div class="card">
                                    <div class="card-header display-4 bg-primary">
                                        TO DO List
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">An item</li>
                                            <li class="list-group-item">A second item</li>
                                            <li class="list-group-item">A third item</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php } ?>

                /* Execute query if data exists*/
                <?php if (($title || $description || $category)  || ($newTitle || $newDescription || $newCategory)) {
                    $query = "SELECT * FROM todoitems 
                                WHERE Title = :title ";
                    $statement = $db->prepare($query);
                    if ($title) {
                        $statement->bindValue(":title", $title);
                    } else {
                        $statement->bindValue(":title", $newTitle);
                    }
                    $statement->execute();
                    $results = $statement->fetchAll();
                    $statement->closeCursor();
                    echo $results;
                } ?>
            <?php } ?>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>