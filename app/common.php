<?php
// 应用公共文件
if (!function_exists('p'))
{
    /**
     * @param $arr
     * @param int $type
     */
    function p($arr,$type=1):void
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        if ($type) exit();
    }
}

if (!function_exists('is_debug'))
{
    /**
     * @return bool
     */
    function is_debug():bool
    {
        return !!env('APP_DEBUG');
    }
}

if (!function_exists('filter_emoji')) {
    /**
     * 过滤掉emoji表情
     * @param $str
     * @return string|string[]|null
     */
    function filter_emoji(string $str)
    {
        $str = preg_replace_callback(    //执行一个正则表达式搜索并且使用一个回调进行替换
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);
        return $str;
    }
}
