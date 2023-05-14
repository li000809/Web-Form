<?php require_once('./dao/candidateDAO.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AC Competition</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="candidate">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Candidates Information</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Add New
                            Candidate</a>
                    </div>
                    <?php
                    $candidateDAO = new candidateDAO(); //* refer to the employeeDAO.php file
                    $candidates = $candidateDAO->getCandidates();

                    if ($candidates) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Name</th>";
                        echo "<th>Piece</th>";
                        echo "<th>Duration</th>";
                        echo "<th>Birth Date</th>";
                        echo "<th>Image</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach ($candidates as $candidate) {
                            echo "<tr>";
                            echo "<td>" . $candidate->getId() . "</td>";
                            echo "<td>" . $candidate->getName() . "</td>";
                            echo "<td>" . $candidate->getPiece() . "</td>";
                            echo "<td>" . $candidate->getDuration() . "</td>";
                            echo "<td>" . $candidate->getBirth() . "</td>";
                            echo "<td>" . $candidate->getImage() . "</td>";
                            echo "<td>";
                            echo '<a href="read.php?id=' . $candidate->getId() . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>'; //*link to view ("eye" icon)
                            echo '<a href="update.php?id=' . $candidate->getId() . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo '<a href="delete.php?id=' . $candidate->getId() . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        //$result->free();
                    } else {
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }

                    // Close connection
                    $candidateDAO->getMysqli()->close();
                    include 'footer.php';
                    ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>