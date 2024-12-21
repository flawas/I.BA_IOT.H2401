<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>


<?php

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$devices = mysqli_query($db_connect, "Select * from sensor");

?>
<div class="container text-center">
    <form method='GET' onsubmit="return checkInput()">
        <div class="row">
            <div class="col-2">
                <input type="date" class="form-control" id="date" name="date" value="">
                <label for="date" class="form-text">Datum</label>
            </div>
            <div class="col-8">
                <select class="form-select" name="device-select" id="device-select">
                    <option name="choose" id="choose" value="choose" >Bitte wählen</option>
                    <?php
                    foreach ($devices as $row){
                        ?><option name="<?php echo $row['dev_id']; ?>" value="<?php echo $row['dev_id']; ?>" id="<?php echo $row['dev_id']; ?>"><?php echo $row['dev_place']; ?></option><?php
                    }
                    ?>
                </select>
                <label for="device-select" id="device-select-label"class="form-text">Sensor</label>
            </div>
            <div class="col-2">
                <input class="btn btn-secondary" type='submit' name="submit" value='Anzeigen'>
            </div>
        </div>
    </form>
</div>

<script>
    const urlParams = new URL(window.location.toLocaleString()).searchParams;
    var date = urlParams.get('date');
    var device = urlParams.get('device-select');
    if(date != null) {
        document.getElementById('date').value = date;
    } else {
        document.getElementById('date').valueAsDate = new Date();
        location.href = location.href + "?date=" + new Date().toISOString().slice(0, 10);
    }
    if(device != null) {
        document.getElementById(device).setAttribute('selected', 'selected');
    } else {
        document.getElementById('choose').setAttribute('selected', 'selected');
    }

</script>

<div>
    <canvas id="chartDaily"></canvas>
</div>

<?php
$dev_id = $_GET['device-select'];
$today = $_GET['date'];

$query = mysqli_query($db_connect, "SELECT datetime, dev_value_2 as temp1, dev_value_1 as temp2, dev_value_3 as hum, dev_value_5 as soil FROM data where datetime like '$today%' and dev_id='$dev_id'");
if (mysqli_num_rows($query) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($query)) {
        $temp1  .= "{x: '".$row["datetime"]."', y: ".$row["temp1"]."},";
        $temp2  .= "{x: '".$row["datetime"]."', y: ".$row["temp2"]."},";
        $hum    .= "{x: '".$row["datetime"]."', y: ".$row["hum"]."},";
        $soil   .= "{x: '".$row["datetime"]."', y: ".$row["soil"]."},";
    }
}
$finaltemps1 =  rtrim($temp1, ", ");
$finaltemps2 =  rtrim($temp2, ", ");
$finalhum =  rtrim($hum, ", ");
$finalsoil =  rtrim($soil, ", ");

$sensorvalues = mysqli_query($db_connect, "Select * from sensor WHERE dev_id='$dev_id'");
$sensorrow = mysqli_fetch_assoc($sensorvalues);

$forecast = mysqli_query($db_connect, "SELECT datetime, temperature as forecasttemp, humidity as forecasthum FROM data_openmeteo where datetime like '$today%'");
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
    function checkInput() {
        if(document.getElementById('device-select').value == "choose") {
            document.getElementById('device-select').setAttribute("class", "form-control is-invalid");
            document.getElementById('device-select-label').setAttribute("class", "invalid-feedback");
            document.getElementById('device-select-label').innerHTML = "Bitte Sensor auswählen";
            return false;
        }
        return true;
    }

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
                label: '<?php echo $sensorrow['value_5_name']; ?>',
                data: [<?php echo $finalsoil;?>],
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
                            hour: "HH:MM"
                        }
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 30,
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