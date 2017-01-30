<?php
include_once 'crud.php';

// Give Active Class on active link
function selectActive($link) {
    $page = $_GET['page'];
    if (false !== strpos($page, $link)) {
        echo 'active';
    }
}

function selectCustomActive($link, $value) {
    if (false !== strpos($value, $link)) {
        echo 'active';
    }
}

function selectedCustom($link, $value) {
    if($link == $value){
        echo 'selected=""';
    }
}

// Login From Database
function loginFromDatabase($table_name, $table_rows) {

    if (isset($_POST['email']) and isset($_POST['password'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $custom = "WHERE email='$email' and password='$password'";
        $result = readCustom($table_name, $table_rows, $custom);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            $_SESSION['email'] = $email;
        }
        else {

            echo "Username not found or password did not match the username";
        }
    }
}

// konstruerer pagination
function create_pagination($side, $amount, $total_side, $bread) {

    pageination_first($side, $amount, $bread);
    ?>
    <b><span> <?php echo $side; ?> </span></b>
    <?php
    pageination_last($side, $amount, $total_side, $bread);
}

//Laver den fÃ¸rste del af pagination
function pageination_first($side, $amount, $bread) {
    $previous_current = $side - $amount;
    ?>
    <center><a href = "index.php?page=<?php echo $bread; ?>&side=1">First Page</a>
        <a href = "?page=<?php echo $bread; ?>&side=<?php
        if ($side > 1) {
            echo ($side - 1);
        }
        else {
            echo 1;
        }
        ?>">previous</a>
           <?php
           for ($i = 1; $i <= $amount; $i++) {
               if ($previous_current < 1) {
                   $previous_current++;
               }
               else {
                   ?>
                <a href="?page=<?php echo $bread; ?>&side=<?php echo $previous_current; ?>"><?php echo $previous_current; ?></a>

                <?php
                $previous_current++;
            }
        };
    }

//laver sidste del af pagination
    function pageination_last($side, $amount, $total_side, $bread) {
        $next = $side + 1;
        $next_current = $side + 1;
        if ($next_current > $total_side) {
            
        }
        else {
            for ($i = 1; $i <= $amount; $i++) {
                if ($next_current > $total_side) {
                    break;
                }
                ?>

                <a href="?page=<?php echo $bread; ?>&side=<?php echo $next_current; ?>"><?php echo $next_current; ?></a>

                <?php
                $next_current++;
            }
        };
        ?>
        <a href="?page=<?php echo $bread; ?>&side=<?php
        if ($side < $total_side) {
            echo ($side + 1);
        }
        else {
            echo $total_side;
        }
        ?>">next</a>
        <a href="?page=<?php echo $bread; ?>&side=<?php echo $total_side; ?>">Last Page</a></center>
    <?php
}

function uploadAndResizeImage(array $files, $uploadFolder, array $sizes, $table_name, $bolig_id, $row_id) {

    $imageFiles = reArrayFiles($files);
    $result = [];
    $finalResult = [];
    foreach ($imageFiles as $image) {


        $originalFile = $image['name'];

        $fileType = strtolower(pathinfo($originalFile, PATHINFO_EXTENSION));

        $originalFilename = pathinfo($originalFile, PATHINFO_FILENAME);

        $uploadedFile = $image['tmp_name'];
        $errors = $image['error'];
        $fileSize = $image['size'];

        switch ($fileType) {
            case 'png':

                $sourceImage = imagecreatefrompng($uploadedFile);

                break;

            case 'gif':

                $sourceImage = imagecreatefromgif($uploadedFile);

                break;

            case 'jpeg':
            case 'jpg':

                $sourceImage = imagecreatefromjpeg($uploadedFile);

                break;

            default:

                throw new Exception('Unknown image filetype given');

                break;
        }



        $sourceImageWidth = getimagesize($uploadedFile)[0];
        $sourceImageHeight = getimagesize($uploadedFile)[1];



        list($sourceImageWidth, $sourceImageHeight) = getimagesize($uploadedFile);



        foreach ($sizes as $prefix => $size) {

            $width = $size;
            $height = ($sourceImageHeight / $sourceImageWidth) * $size;



            $newImage = imagecreatetruecolor($width, $height);



            imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $width, $height, $sourceImageWidth, $sourceImageHeight);



            $filename = $uploadFolder . $prefix . '_' . time() . '_' . $originalFilename . '.jpg';
            imagejpeg($newImage, $filename, 100);

            imagedestroy($newImage);


            $result[$prefix] = $filename;
        }


        imagedestroy($sourceImage);

        foreach ($result as $key => $value) {
            echo "Key= " . $key . " " . $value . "<br>";
            $table_data;
            $table_data['type'] = $key;
            $table_data["sted"] = $value;
            $table_data[$row_id] = $bolig_id;
            create($table_name, $table_data);
        }
    }


    return $finalResult;
}

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
