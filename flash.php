<?php
function flash($key) {
    if (isset($_SESSION[$key])) {
        $class = $key === 'success' ? 'success' : 'error';
        echo "<div class='alert $class'>{$_SESSION[$key]}</div>";
        unset($_SESSION[$key]);
    }
}