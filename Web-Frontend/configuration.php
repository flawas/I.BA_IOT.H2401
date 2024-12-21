<?php

require 'config.php';
include_once("includes/head.php");
include_once("includes/functions.php");


?>
<html>
    <body>
    <div class="row">
        <?php createAlertBadgeURL();?>
        <h1>Systemkonfiguration</h1>
        <div class="col-md-6 themed-grid-col"><?php include_once("includes/system-config-slack.php");?></div>
        <div class="col-md-6 themed-grid-col"><?php include_once("includes/system-config-system.php");?></div>
    </div>

    </body>
</html>

<?php
include_once("includes/footer.php");
?>