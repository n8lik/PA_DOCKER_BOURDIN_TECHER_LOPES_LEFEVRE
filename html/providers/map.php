<?php 

include 'settings.php';
?>

<script async defer src="<?php echo $apikey?>"></script>
<link rel="stylesheet" href="/css/map.css" />


<div>
  <input id="place-input" type="text" name="place" value="<?php if(isset($_SESSION['data']["description"])){echo $_SESSION['data']["description"];}
  if(isset($place)){echo $place;}?>" placeholder="Entrez un lieu" size="50">
</div>
<br>
<div>
  <label for="radiusSlider">Rayon max de déplacement (de 1 à 50km)</label><br>
  <input type="range" min="1" max="50" value="0" class="slider" id="radiusSlider" name ="radiusSlider"  title="Radius in km">
</div>

<script src="/providers/map.js"></script>
<div id="map">

</div>