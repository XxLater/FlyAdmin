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

if (!function_exists('system_config'))
{
    /**
     * @param $name
     * @return mixed
     */
    function system_config($name)
    {
        return \app\common\service\system\ConfigService::instance()->get($name);
    }
}

if (!function_exists('param_list'))
{
    function param_list(...$args)
    {
        $request = request()->param();
        $data = [];
        foreach ($args as $name=>$value)
        {
            if (!is_array($value)) continue;

            $data[] = $request[$value[0]] ?? ($value[1] ?? '');
        }
        return $data;
    }
}

if (!function_exists('get_path'))
{
    function get_path()
    {
        $controller = explode('.',request()->controller(true));
        $controller = is_array($controller) ? end($controller) : $controller;
        $action = request()->action(true);
        return $controller.'/'.$action;
    }
}

if (!function_exists('is_login'))
{
    function is_login()
    {
        $token = session('user_token');
        return \app\common\service\utils\TokenService::instance()->verify($token);
    }
}