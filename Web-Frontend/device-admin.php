<?php

require 'config.php';
include_once("includes/head.php");
include_once("includes/functions.php");


?>
<html>
    <body>
    <div class="row">
        <div class="col-md-12 themed-grid-col">
            <a href="device-add.php"><button type="button" class="btn btn-primary">Gerät hinzufügen</button></a>
        </div>
        <br><br>
        <div class="col-md-12 themed-grid-col"><?php include_once("includes/device-overview.php");?></div>
    </div>

    </body>
</html>

<?php
include_once("includes/footer.php");
?>