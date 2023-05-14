<?php

define('BASE_URL', 'https://http://localhost/dashboard//');

// Include employeeDAO file
require_once('./dao/candidateDAO.php');
$candidateDAO = new candidateDAO();

// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Get URL parameter
    $id = trim($_GET["id"]);
    $candidate = $candidateDAO->getCandidate($id);

    if ($candidate) {
        // Retrieve individual field value
        $name = $candidate->getName();
        $piece = $candidate->getPiece();
        $duration = $candidate->getDuration();
        $birth = $candidate->getBirth();
        $image = $candidate->getImage();
        echo "<script>alert('$image');</script>";
    } else {
        // URL doesn't contain valid id. Redirect to error page
        header("location: error.php");
        exit();
    }
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}

// Close connection
$candidateDAO->getMysqli()->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b>
                                <?php echo $name; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>Piece</label>
                        <p><b>
                                <?php echo $piece; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>Duration</label>
                        <p><b>
                                <?php echo $duration; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>Birth</label>
                        <p><b>
                                <?php echo $birth; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <div>
                            <img class="img" src="<?php echo $image; ?>" alt="image">
                            <!-- <img src="<?php echo htmlspecialchars($image); ?>" alt="Candidate Image" style="max-width: 100%; height: auto;"> -->
                            <!-- <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="Candidate Image"> -->
                            <!-- <img src="<?php echo $image; ?>" alt="Candidate Image"
                                style="max-width: 100%; height: auto;"> -->
                        </div>
                        <p>Image path: <?php echo htmlspecialchars($image); ?></p>
                        <!-- <script>
                            console.log('Image path: <?php echo $image; ?>');
                        </script> -->
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<!-- <p><b>
        <?php echo $image; ?>
    </b></p> -->