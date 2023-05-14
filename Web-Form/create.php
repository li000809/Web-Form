<?php
// Include employeeDAO file
require_once('./dao/candidateDAO.php');


// Define variables and initialize with empty values
$name = $piece = $duration = $birth = $image = "";
$name_err = $piece_err = $duration_err = $birth_err = $image_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate address
    $input_piece = trim($_POST["piece"]);
    if (empty($input_piece)) {
        $piece_err = "Please enter the name of a piece that candidate will play.";
    } elseif (strlen($input_piece) > 50) {
        $piece_err = "Please enter the piece name no longer than 50 characters.";
    } else {
        $piece = $input_piece;
    }

    // validate piece duration
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

    //validate age
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
            echo "<script>alert('$destination');</script>";
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file_tmp, $destination)) {
                $image = $file_name; // Save only the file name
            } else {
                $image_err = "Error uploading the image. Please try again.";
            }
        } else {
            $image_err = "Invalid file type. Please upload a JPG, JPEG, PNG, or GIF image.";
        }
    } else {
        $image_err = "Please upload an image.";
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($piece_err) && empty($duration_err) && empty($birth_err) && empty($image_err)) {
        $candidateDAO = new candidateDAO();
        $candidate = new Candidate(0, $name, $piece, $duration, $birth, $image); //* object
        $addResult = $candidateDAO->addCandidate($candidate);
        header("refresh:2; url=index.php");
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';
        // Close connection
        $candidateDAO->getMysqli()->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Candidate File</title>
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
                    <h2 class="mt-5">Create Candidate File</h2>
                    <p>Please fill this form and submit to add candidate to the AC Competition committee.</p>

                    <!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <? include 'footer.php'; ?>
    </div>
</body>

</html>

<!-- <form action="fileUploadeCode.php" method="POST" enctype="multipart/form-data">
                                <input type="file" name="image" />
                                <br>
                                <input type="submit" />
                            </form> -->