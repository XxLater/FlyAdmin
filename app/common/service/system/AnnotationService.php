<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/

namespace app\common\service\system;


use app\common\service\BaseService;
use think\facade\Cache;
class AnnotationService extends BaseService
{
    /**
     * @var string 扫描目录
     */
    protected $path;

    protected $data;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public static function create($path):AnnotationService
    {
        return new self($path);
    }

    public function toUnderScore($str)
    {
        $dstr = preg_replace_callback('/([A-Z]+)/',function($matchs)
        {
            return '_'.strtolower($matchs[0]);
            },$str);

       return trim(preg_replace('/_{2,}/','_',$dstr),'_');
    }

    /**
     * 生成节点
     * @return array
     * @throws \ReflectionException
     * @throws \app\common\exception\ServiceException
     */
    public function getMethod()
    {
        static $data = [];

        if (!is_debug())
        {
            $data = Cache::get('system.auth_menu_'.is_login());
        }

        if ($data)
        {
            $this->data = $data;
            return $data;
        }

        $ignore = ['validate','fetch','initialize','__construct','assign'];

        foreach ($this->scanDirectory($this->path) as $value)
        {
            $file = pathinfo($value);

            if($file['filename'] !== 'Base')
            {
                $name = substr($value,strlen(strtr($this->path,'\\','/'))+1);

                $namespace = substr($this->path,strlen(strtr(app()->getRootPath(),'\\','/'))).'/'.$name;

                $namespace = str_replace('.php','',strtr($namespace,'/','\\'));

                $class = new \ReflectionClass($namespace);

                $class_name = strtolower($this->toUnderScore($file['filename']));

                $data[$class_name] = $this->parseComment($class->getDocComment() == false ? '' : $class->getDocComment() , $class_name);

                foreach ($class->getMethods() as $key => $method)
                {
                    if (!in_array($method->getName(),$ignore))
                    {
                        $method_name = strtolower($this->toUnderScore($method->getName()));
                        $data[$class_name]['child'][$method_name] = $this->parseComment($method->getDocComment() == false ? '' : $method->getDocComment() , $method_name);
                    }
                }
            }
        }

        Cache::set('system.auth_menu_'.is_login(),$data,3600);

        $this->data = $data;

        return $data;
    }

    /**
     * 扫描目录文件
     * @param null $path
     * @param array $data
     * @return array
     * @throws \app\common\exception\ServiceException
     */
    public function scanDirectory($path = null,array $data = []): array
    {
        if(!is_dir($path)) $this->error('路径错误');

        $files = scandir($path);

        foreach ($files as $filename)
        {
            if ($filename !== '.' && $filename !== '..')
            {
                $dir = rtrim($path,'\\/').DIRECTORY_SEPARATOR.$filename;
                if (is_dir($dir) && is_readable($dir))
                {
                    $data = $this->scanDirectory($dir,$data);
                }elseif (is_readable($dir) && pathinfo($dir,4) == 'php')
                {
                    $data[] = strtr($dir,'\\','/');
                }
            }
        }
        return $data;
    }

    /**
     * 解析注释内容
     * @param string $comment
     * @param string $default
     * @return array
     */
    private function parseComment(string $comment, string $default = ''): array
    {
        $text = strtr($comment, "\n", ' ');
        $title = preg_replace('/^\/\*\s*\*\s*\*\s*(.*?)\s*\*.*?$/', '$1', $text);
        if (in_array(substr($title, 0, 5), ['@auth', '@menu'])) $title = $default;
        $title   = preg_match('/@title\s*([^\s]*)/i',$text,$title_array);
        $icon   = preg_match('/@icon\s*([^\s]*)/i',$text,$icon_array);
//        $method  = preg_match('/@method\s*([^\s]*)/i',$text,$method_array);
        return [
            'title' => isset($title_array[1]) && $title_array[1] != '*' ?  $title_array[1] : $default,
            'icon' => isset($icon_array[1]) && $icon_array[1] != '*' ?  $icon_array[1] : '',
//            'method'=> isset($method_array[1]) ? $method_array[1] : 'any',
            'auth'  => intval(preg_match('/@auth\s*true/i', $text)),
            'menu'  => intval(preg_match('/@menu\s*true/i', $text)),
        ];
    }

    /**
     *
     * @param array $data
     * @param null $parent_path
     * @param int  $i
     * @return array
     */
    public function getMenu($data = [],$parent_path='',$i=1): array
    {
        $data = empty($data) ? $this->data : $data;

        $parent = empty($parent_path) ? '/'.app('http')->getName() : $parent_path;

        foreach ($data as $key=>&$value)
        {

            if (!isset($value['menu']) || !$value['menu'])
            {
                unset($data[$key]);
                continue;
            }
            $value['href'] = $parent.'/'.$key;
            $value['openType'] = '_iframe';
            $value['id'] = $i;
            $i++;
            if (isset($value['child']) && !empty($value['child']))
            {
                $value['type'] = 0;
                $data[$key]['child'] = $this->getMenu($value['child'],$value['href'],$i);
            }else
            {
                $value['type'] = 1;
            }
        }

        return array_values($data);
    }


}