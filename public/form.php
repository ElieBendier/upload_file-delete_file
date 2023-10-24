<?php
if($_SERVER['REQUEST_METHOD'] === "POST"){ 
    $data = array_map("htmlentities", array_map("trim", $_POST));
    if(!empty($_FILES['avatar']['name'][0])){
        $avatar = $_FILES['avatar'];
        $authorizedExtensions = ['jpeg', 'jpg' ,'png', 'gif', 'webp',];
        $maxFileSize = 1000000;
        $avatar_size = $avatar['size'];
        $extension = $avatar['type'];
        $extension = explode("/", $extension);
        $extension = end($extension);

        if( (!in_array($extension, $authorizedExtensions))){
            $errors[] = 'Veuillez sélectionner une image de type Jpg, Jpeg, Gif, Webp ou Png !';
        }

        if( file_exists($avatar['tmp_name']) && filesize($avatar['tmp_name']) > $maxFileSize)
        {
            $errors[] = "Votre fichier doit faire moins de 1Mo !";
        }

        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . uniqid() . "." . $extension;
        if (empty($errors)) {
            move_uploaded_file($avatar['tmp_name'], $uploadFile);
        }
        else{
            foreach($errors as $error){
                echo $error;
            }
        }
    }
}


?>

<html>
<form method="post" enctype="multipart/form-data">
    <div>
        <label for="lastname">Lastname :</label>
        <input type="text" name="lastname" id="lastname"/>
    </div>
    <div>
        <label for="firstname">Firstname :</label>
        <input type="text" name="firstname" id="firstname"/>
    </div>
    <div>
        <label for="age">Age :</label>
        <input type="number" name="age" id="age"/>
    </div>
    <div>
        <label for="imageUpload">Upload an profile image</label>    
        <input type="file" name="avatar" id="imageUpload" />
    </div>
    <button name="send">Send</button>
</form>


<?php 
if($_SERVER['REQUEST_METHOD'] === "POST"){ 

    if(empty ($errors)) { ?>
        Hey <?= $data["lastname"]?> <?= $data["firstname"]?>, you are <?= $data["age"]?> years old.</br>
        <img src = "<?=$uploadFile?>" alt="profil picture">
    <?php }?>
    <form action="delete.php" method="post">
    <input type="hidden" name="file" value="<?=$uploadFile?>"/>
    <button name="delete">Delete</button>
    </form>
<?php } ?>

</html>