<?php
function current_page(): string
{
    return basename(path: $_SERVER['PHP_SELF']);
}

?>