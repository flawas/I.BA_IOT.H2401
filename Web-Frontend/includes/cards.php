<div class="container text-center">
    <div class="row row-cols-1 row-cols-md-3">

        <?php

        $db_connect = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
        if ($db_connect->connect_error) {
            die("Connection failed: " . $db_connect->connect_error);
        }

        $today = date("Y-m-d");

        $sql = "SELECT * FROM sensor";
        $result = $db_connect->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row_device_id = $row['dev_id'];
                $sensor_data = $db_connect->prepare("SELECT * FROM data WHERE dev_id=? ORDER BY id DESC LIMIT 1");
                $sensor_data->bind_param("s", $row_device_id);
                $sensor_data->execute();
                $sensor_row = $sensor_data->get_result()->fetch_assoc();
                $sensor_data->close();
                ?>
                <div class="col-sm-6 md-4 mb-3">
                    <div class="card">
                        <div class="card-header"><?php echo htmlspecialchars($row['dev_type']); ?></div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['dev_place']); ?></h5>
                            <?php if ($row['value_1'] != "") { ?>
                                <p class="card-text"><?php echo htmlspecialchars($sensor_row['dev_value_1'] . " " . $row['value_1']); ?></p>
                            <?php } ?>
                            <?php if ($row['value_2'] != "") { ?>
                                <p class="card-text"><?php echo htmlspecialchars($sensor_row['dev_value_2'] . " " . $row['value_2']); ?></p>
                            <?php } ?>
                            <?php if ($row['value_3'] != "") { ?>
                                <p class="card-text"><?php echo htmlspecialchars($sensor_row['dev_value_3'] . " " . $row['value_3']); ?></p>
                            <?php } ?>
                            <?php if ($row['value_5'] != "") { ?>
                                <p class="card-text"><?php echo htmlspecialchars($sensor_row['dev_value_5'] . " " . $row['value_5']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="card-footer">
                            <small class="text-body-secondary">Letztes Update <?php echo htmlspecialchars($sensor_row["datetime"]); ?></small>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No sensors found.";
        }
        $db_connect->close();
        ?>

    </div>
</div>