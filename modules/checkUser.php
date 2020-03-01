<?php
if (($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']) && ($_SESSION['userIp'] != $_SERVER['REMOTE_ADDR'])){
    header("Location: http://localhost/estafas/modules/error.php");
}
?>