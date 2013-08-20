<?php 
echo "<pre>";
$getData = file_get_contents('http://apps.circussocial.com/navy/createjson.php');

$jsonData = json_decode($getData, true);

 foreach ($jsonData as $row)
 { ?>
    
    <div class="slide">
        <h2><?php echo $row['posts']['author']; ?></h2>
        <img src="<?php echo $row['posts']['imageUrl']; ?>" width="300" height="375" />
        <p><?php echo $row['posts']['post']; ?></p>
        </div>
	
 <?php }

?>
