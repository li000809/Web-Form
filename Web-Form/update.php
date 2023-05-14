<?php
// Include employeeDAO file
require_once('./dao/candidateDAO.php');

// Define variables and initialize with empty values
$name = $piece = $duration = $birth = $image = "";
$name_err = $piece_err = $duration_err = $birth_err = $image_err = "";
$candidateDAO = new candidateDAO();

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate address address
    $input_piece = trim($_POST["piece"]);
    if (empty($input_piece)) {
        $piece_err = "Please enter the name of a piece that candidate will play.";
    } elseif (strlen($input_piece) > 50) {
        $piece_err = "Please enter the piece name no longer than 50 characters.";
    } else {
        $piece = $input_piece;
    }

    // Validate salary
    $input_duration = trim($_POST["duration"]);
    if (empty($input_duration)) {
        $duration_err = "Please enter the duration of the piece.";
    } elseif (!ctype_digit($input_duration)) {
        $duration_err = "Please enter a valid duration as a whole number.";
    } elseif ($input_duration > 20) {
        $duration_err = "Please enter the duration no longer than 20 minutes.";
    } else {
        $duration = $input_duration;
    }

    // validate age
    $input_birth = trim($_POST['birth']);
    $birth_date = new DateTime($input_birth);
    $today = new DateTime();
    $interval = $today->diff($birth_date);
    $age = $interval->y;
    if ($age < 16) {
        $birth_err = "Candidate must be older than 16 years old.";
    } else {
        $birth = $input_birth;
    }

    $image_updated = false;
    // $original_image = $candidate->getImage();
    //validate image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Check if the file is an image
        $valid_mime_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($file_type, $valid_mime_types)) {
            $upload_dir = 'image/'; // Specify the upload directory
            $destination = $upload_dir . $file_name;
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file_tmp, $destination)) {
                $image = $file_name; // Save only the file name
                $image_updated = true;
            } else {
                $image_err = "Error uploading the image. Please try again.";
            }
        } else {
            $image_err = "Invalid file type. Please upload a JPG, JPEG, PNG, or GIF image.";
        }
    } elseif ($_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        // No new image was uploaded, so use the existing image
        $image_updated = false;
        // $image = $original_image;
    } else {
        $image_err = "Please upload an image.";
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($piece_err) && empty($duration_err) && empty($birth_err) && empty($image_err)) {
        $candidate = new Candidate($id, $name, $piece, $duration, $birth, $image);

        echo "Updated birth date: " . $candidate->getBirth() . "<br>";

        $result = $candidateDAO->updateCandidate($candidate);
        header("refresh:2; url=index.php");
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';
        // Close connection
        $candidateDAO->getMysqli()->close();
    }

} else {
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
            // echo '<script>alert("hi")</script>';
            $image = $candidate->getImage();
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the content and submit to update the candidate file.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post"
                        enctype="multipart/form-data">
                        <!-- the following "value" as same as input tag of HTML -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name"
                                class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $name; ?>">
                            <span class="invalid-feedback">
                                <?php echo $name_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Piece</label>
                            <textarea name="piece"
                                class="form-control <?php echo (!empty($piece_err)) ? 'is-invalid' : ''; ?>"><?php echo $piece; ?></textarea>
                            <span class="invalid-feedback">
                                <?php echo $piece_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Duration</label>
                            <input type="text" name="duration"
                                class="form-control <?php echo (!empty($duration_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $duration; ?>">
                            <span class="invalid-feedback">
                                <?php echo $duration_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Birth Date</label>
                            <input type="date" name="birth"
                                class="form-control <?php echo (!empty($birth_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $birth; ?>">
                            <span class="invalid-feedback">
                                <?php echo $birth_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image"
                                class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $image; ?>">
                            <span class="invalid-feedback">
                                <?php echo $image_err; ?>
                            </span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>