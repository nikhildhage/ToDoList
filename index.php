<?php
//POST data
$title = filter_input(INPUT_POST, "title", FILTER_UNSAFE_RAW);
$description = filter_input(INPUT_POST, "description", FILTER_UNSAFE_RAW);
$category = filter_input(INPUT_POST, "category", FILTER_UNSAFE_RAW);

//GET Data
$Title = filter_input(INPUT_GET, "title", FILTER_UNSAFE_RAW);
$Description = filter_input(INPUT_GET, "description", FILTER_UNSAFE_RAW);
$Category = filter_input(INPUT_GET, "category", FILTER_UNSAFE_RAW);
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
            <section id="toDoList" class="my-5">
                <div class=" row">
                    <div class="col-sm-6 col-lg-8 col-xl-12">
                        <div class="card">
                            <div class="card-header display-4 bg-primary">
                                TO DO List
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Cras justo odio</li>
                                <li class="list-group-item">Dapibus ac facilisis in</li>
                                <li class="list-group-item">Vestibulum at eros</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (!$title || !$description || !$category) { ?>
                <section id="add-item-form" class="my-3">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="border border-2 py-3">
                        <div class="row g-3 m-3">
                            <div class="col-12">
                                <label for="title" class="form-label">Title</label>
                                <input id="title" name="title" type="text" placeholder="Ex: Title" class="form-control">
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <input id="description" name="description" type="text" placeholder="Ex: Description" class="form-control">
                            </div>
                            <div class="col-lg-12">
                                <label for="category" class="form-label">Category</label>
                                <input id="category" name="category" type="text" placeholder="Ex: Category" class="form-control">
                            </div>
                            <div class="col-sm-8 d-flex">
                                <button type=" submit" class="btn btn-primary">Add Item</button>
                            </div>
                        </div>

                    </form>
                </section>
            <?php } else { ?>
                <?php include("Database.php"); ?>
            <?php } ?>
            <?php echo "<br>" ?>
            <?php echo " " . $title . " ";
            echo  $description . " ";
            echo $category;
            ?>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>