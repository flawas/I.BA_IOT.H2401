<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<?php
include("functions.php");

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$devices = mysqli_query($db_connect, "Select * from sensor");

?>
<div class="container text-center">
<form method='GET'>
  <div class="row">
  <div class="col-2">
        <input type="week" class="form-control" id="week" name="week" value="">
        <label for="week" class="form-text">Woche</label>
    </div>
    <div class="col-8">
    <select class="form-select" name="device-select">
    <option name="choose" id="choose" value="choose" >Bitte wählen</option>
      <?php
      foreach ($devices as $row){
        ?><option name="<?php echo $row['dev_id']; ?>" value="<?php echo $row['dev_id']; ?>" id="<?php echo $row['dev_id']; ?>"><?php echo $row['dev_place']; ?></option><?php
      }
      ?>
    </select>
    <label for="device-select" class="form-text">Sensor</label>
    </div>
    <div class="col-2">
      <input class="btn btn-secondary" type='submit' name="submit" value='Anzeigen'>
    </div>
  </div>
  </form>
</div>


<div>
  <canvas id="chartDaily"></canvas>
</div>

<script>

  const urlParams = new URL(window.location.toLocaleString()).searchParams;
  var week = urlParams.get('week');
  var device = urlParams.get('device-select');
  if(week != null) {
      document.getElementById('week').value = week;
  } else {
      year = new Date().getFullYear()
      currentDate = new Date();
      startDate = new Date(currentDate.getFullYear(), 0, 1);
      var days = Math.floor((currentDate - startDate) /
          (24 * 60 * 60 * 1000));

      var weekNumber = Math.ceil(days / 7);

      // Display the calculated result
      var weekyear = year + "-W" + weekNumber;
      document.getElementById('week').value = weekyear;
      location.href = location.href + "?week=" + weekyear;
  }
  if(device != null) {
      document.getElementById(device).setAttribute('selected', 'selected');
  } else {
      document.getElementById('choose').setAttribute('selected', 'selected');
  }

</script>

<?php
$week = $_GET['week'];
$weeksplit = explode("-W",$week);
$weekresult = getStartAndEndDate($weeksplit[1], $weeksplit[0]);
$weekstart = ($weekresult["week_start"]);
$weekend = ($weekresult["week_end"]);

$dev_id = $_GET['device-select'];

if(isset($week)) {
  $sql = "SELECT datetime, dev_value_2 as temp1, dev_value_1 as temp2, dev_value_3 as hum FROM data where datetime BETWEEN '$weekstart 00:00:00' AND '$weekend 23:59:00' AND dev_id='$dev_id'";
  $query = mysqli_query($db_connect, $sql);
}



if (mysqli_num_rows($query) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($query)) {
    $temp1 .= "{x: '".$row["datetime"]."', y: ".$row["temp1"]."},";
    $temp2 .= "{x: '".$row["datetime"]."', y: ".$row["temp2"]."},";
    $hum .= "{x: '".$row["datetime"]."', y: ".$row["hum"]."},";
  }
}
$finaltemps1 =  rtrim($temp1, ", ");
$finaltemps2 =  rtrim($temp2, ", ");
$finalhum =  rtrim($hum, ", ");


$sensorvalues = mysqli_query($db_connect, "Select * from sensor WHERE dev_id='$dev_id'");
$sensorrow = mysqli_fetch_assoc($sensorvalues);

if(isset($week)) {
  $forecast = mysqli_query($db_connect, "SELECT datetime, temperature as forecasttemp, humidity as forecasthum FROM data_openmeteo where datetime BETWEEN '$weekstart 00:00:00' AND '$weekend 23:59:00'");
}

if (mysqli_num_rows($forecast) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($forecast)) {
    $forecasttime = explode(" ",$row["datetime"]);
    $forecasthum .= "{x: '".$row["datetime"]."', y: ".$row["forecasthum"]."},";
    $forecasttemp .= "{x: '".$row["datetime"]."', y: ".$row["forecasttemp"]."},";
  }
  $finalforecasttemp = rtrim($forecasttemp, ", ");
}
?>


<script>

  const ctx = document.getElementById('chartDaily');

  new Chart(ctx, {
    type: 'line',
    data: {
      datasets: [{
        label: '<?php echo $sensorrow['value_1_name']; ?>',
        data: [<?php echo $finaltemps1;?>],
        borderWidth: 1,
      },{
        label: '<?php echo $sensorrow['value_2_name']; ?>',
        data: [<?php echo $finaltemps2;?>],
        borderWidth: 1,
      }, {
        label: '<?php echo $sensorrow['value_3_name']; ?>',
        data: [<?php echo $finalhum;?>],
        borderWidth: 1,
      }, {
        label: 'Wettervorhersage Temperatur',
        data: [<?php echo $forecasttemp;?>],
        borderWidth: 1,
      }, {
        label: 'Wettervorhersage Luftfeuchtigkeit',
        data: [<?php echo $forecasthum;?>],
        borderWidth: 1,
      }
    ]
    },
    options: {
       scales: {
            x: {
              type: 'time',
              time: {
                displayFormats: {
                  hour: "d.M. HH:mm"
                }
              },
              ticks: {
                autoSkip: true,
                maxTicksLimit: 50,
                },
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: "Point"
                }
            },
            y: {
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: "Value"
                }
            }
       }
      }
  });
</script>