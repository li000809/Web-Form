<!-- <html>

<body>

    <form action="fileUploadeCode.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" />
        <br>
        <input type="submit" />

    </form> -->

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['image'])) {
            $errors = array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];

            //   $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    
            //   $expensions= array("jpeg","jpg","png");
    
            //   if(in_array($file_ext,$expensions)=== false){
            //      $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            //   }
    
            if ($_FILES['image']['size'] > 2097152) {
                $errors = 'Faild to upload: File size must be excately 2 MB';
                echo "<br>";
                echo "<br>";
            }

            if (empty($errors) == true && isset($_FILES['image'])) {
                move_uploaded_file($file_tmp, "data/" . $_FILES['image']['name']);
                echo "File Successfully uploaded";
                echo "<br>";
                echo "<br>";
                echo "<h1> print the list of php files</h1>";
                print_r(glob("*.php")); //returns an array of all file names that match a given pattern 
                echo "<br>";
                echo "<br>";
                echo "<h2> print all the folders in specific directory</h2>";
                print_r(scandir("...put your chosen directory...")); //*
                echo "<br>";
                echo "<br>";
                echo "<h2> print current working directory directory</h2>";
                echo (getcwd());
            } else {
                echo "<br>";
                echo "<br>";
                print($errors);
            }
        }
    }
    echo "<br>";
    echo "<br>";
    phpinfo();
    ?>

<!-- </body>

</html> -->