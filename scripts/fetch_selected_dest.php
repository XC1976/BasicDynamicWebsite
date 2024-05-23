<?php
session_start();
if (isset($_SESSION['selected_dest']) && !empty($_SESSION['selected_dest'])) {
    echo 0;
}
echo -1;
exit();