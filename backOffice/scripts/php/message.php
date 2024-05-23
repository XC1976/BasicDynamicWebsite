<?php

if (isset($_GET['message']) && !empty($_GET['message'])) {
    echo '<div class="message">' . htmlspecialchars($_GET['message']) . '</div>';
}