<?php
// 应用公共文件
if (!function_exists('prln'))
{
    function p($arr,$type=1)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        if ($type) exit();
    }
}



