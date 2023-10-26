<?php
function logger($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('[LOG::] $output' );</script>";
}
?>