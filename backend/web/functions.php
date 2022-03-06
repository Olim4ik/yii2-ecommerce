<?php

function pre($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
    die();
}
