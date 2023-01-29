<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "take-note";
$database_connection = mysqli_connect($servername, $username, $password, $database);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <style>
    <?php
    include ('style.css');
    ?>
    </style>
    <title>Take Note</title>
</head>

<body>

<!-- Navbar Start-->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data- target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
    </nav>

<!-- NavBar End -->

    <?php
    if (!$database_connection) {
        echo '<div class="alert alert-danger" role="alert">
            SERVER IS DOWN!
            </div>';
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $note = $_POST['note'];
        $sql_query = "INSERT INTO `note` (`title`, `note`) VALUES ('$title', '$note');";
        $insert_data = mysqli_query($database_connection, $sql_query);
        if (!$insert_data) {
            echo '<div class="alert alert-danger" role="alert">
                SERVER IS DOWN!
                </div>';
        } else {
            echo '<div class="alert alert-success" role="alert">
                SUCCES! Note succesfully added.
                </div>';
        }
    }
    ?>

    <div class="container my-4">
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="note">Note</label>
                <textarea for="note" class="form-control" id="note" name="note" rows="3"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Note</button>
            </div>
        </form>
    </div>

    <div class="container">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Note</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $note_count = 1;
                $database_note = "SELECT title, note , `time-date` FROM `note`;";
                $data_note = mysqli_query($database_connection, $database_note);
                if (mysqli_num_rows($data_note) > 0) {
                    while ($notes_are = mysqli_fetch_assoc($data_note)) {
                        echo '<tr>
                        <th scope="row">' . $note_count . '</th>
                        <td>' . $notes_are['title'] . '</td>
                        <td>' . $notes_are['note'] . '</td>
                        <td><button type="button" class="btn btn-primary">Edit</button> <button type="button" class="btn btn-danger delete">Delete</button>
                        </tr>';
                        $note_count = $note_count + 1;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
    <script>
        var delete_note = document.getElementsByClassName('delete');
        console.log(delete_note);
    </script>
</html>