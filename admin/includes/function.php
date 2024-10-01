<?php
function get_safe_value($con, $str)
{
    if ($str != "") {
        $str = trim($str);
        return $con->real_escape_string($str);
    }
}
?>