<?php 

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());

$sqlResponses = mysqli_query($db_connect, "SELECT * FROM sensor");

?>
<div class="table-responsive">
<table class="table table-hover table-sm text-center">
  <thead>
    <tr>
      <th>Device ID</th>
      <th>Device Platzierung</th>
      <th>Device Typ</th>
      <th>Device Hersteller</th>
      <th>Device Modell</th>
      <th>Batterie</th>
    </tr>
  </thead>
  <tbody>

<?php
foreach ($sqlResponses as $sqlResponse){
    $dev_id = $sqlResponse['dev_id'];
    
    $batterieResponse = mysqli_query($db_connect, "SELECT datetime, dev_value_4 FROM data where dev_id='$dev_id' ORDER BY id DESC LIMIT 1");
    $data_row = mysqli_fetch_array($batterieResponse);
  ?> 
  <tr><th><?php echo $sqlResponse['dev_id'];?></th>
  <td><?php echo $sqlResponse['dev_place'];?></td><td><?php echo $sqlResponse['dev_type'];?></td>
  <td><?php echo $sqlResponse['dev_brand'];?></td><td><?php echo $sqlResponse['dev_model'];?></td><td><?php echo $data_row['dev_value_4'];?></td></tr>
  <?php 
}

?>
</div>
    </tbody>
</table>