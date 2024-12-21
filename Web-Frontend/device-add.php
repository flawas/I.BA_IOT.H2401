<?php

require 'config.php';
include_once("includes/head.php");
include_once("includes/functions.php");


?>
<html>
    <body>
    <div class="row">
        <?php createAlertBadgeURL();?>
        <div class="col-md-12 themed-grid-col"><?php include_once("includes/device-add.php");?></div>
    </div>

    </body>
</html>

<?php
include_once("includes/footer.php");
?>