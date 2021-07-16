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
     * @param string $default
     * @return mixed
     */
    function system_config($name,$default='')
    {
        return \app\common\service\system\ConfigService::instance()->get($name,$default);
    }
}

if (!function_exists('param_list'))
{
    function param_list(...$args)
    {
        $request = request()->param();

        $data = [];
        
        foreach ($args as $name=>&$value)
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
        $module = app('http')->getName();
        $controller = explode('.',request()->controller(true));
        $controller = is_array($controller) ? end($controller) : $controller;
        $action = request()->action(true);
        return '/'.$module.'/'.$controller.'/'.$action;
    }
}

if(!function_exists('get_client'))
{
    function get_client()
    {
        $user_agent = request()->header('user-agent');

        if (false !== stripos($user_agent, 'MSIE')) {
            $user_browser = 'MSIE';
        } elseif (false !== stripos($user_agent, 'Firefox')) {
            $user_browser = 'Firefox';
        } elseif (false !== stripos($user_agent, 'Chrome')) {
            $user_browser = 'Chrome';
        } elseif (false !== stripos($user_agent, 'Safari')) {
            $user_browser = 'Safari';
        } elseif (false !== stripos($user_agent, 'Opera')) {
            $user_browser = 'Opera';
        } else {
            $user_browser = 'Other';
        }
        return  $user_browser;
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

if (!function_exists('is_date'))
{
    function is_date($date)
    {
        if($date !== date('Y-m-d',strtotime($date)))
        {
            return false;
        }

        return $date;
    }
}

if (!function_exists('get_tree_select'))
{
    function get_tree_select($optionList,$default=null,$pk='id',$pid='pid',$child='child',$level=0)
    {
        $html = '';

        $parentHtml = '├';
        
        $childHtml  = '└';

        foreach($optionList as $value)
        {
            $title = str_repeat("&nbsp;&nbsp;&nbsp;",$level);

            $title .= !empty($value[$child]) ? $parentHtml : $childHtml;

            $title .= isset($value['title']) ? $value['title'] : $value['name'];

            if($default && $default == $value[$pk])
            {
                $html  .= '<option selected value='.$value[$pk].'>'.$title.'</option>';
            }else 
            {
                $html  .= '<option value='.$value[$pk].'>'.$title.'</option>';
            }

            if(!empty($value[$child]))
            {
                $html .= get_tree_select($value[$child],$default,$pk,$pid,$child,$level+1);
            }

        }

        return $html;
    }
}