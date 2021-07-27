<?php

declare(strict_types=1);

/**
 * @class 基础服务类
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/
namespace app\common\service;
use app\common\exception\ServiceException;
use app\common\model\BaseModel;
use think\Container;
use think\exception\ValidateException;
use think\Model;
use think\Request;
use think\Validate;

class BaseService
{
    /**
     * @var BaseModel
     */
    protected $model;

    /**
     * 验证器
     * @var [type]
     */
    public $validate;

    /**
     * @param mixed ...$args
     * @return BaseService
     */
    public static function instance(...$args):BaseService
    {
        return Container::getInstance()->invokeClass(static::class, $args);
    }

    /**
     * @param string $msg
     * @param array $data
     * @param int $code
     * @throws ServiceException
     */
    protected function error(string $msg ,$data=[],$code=500):void
    {
       throw new ServiceException($msg,$data,$code);
    }

    public function __call($name, $arguments)
    {
        if (!empty($this->model))
        {
            return call_user_func_array([$this->model,$name],$arguments);
        }

        $this->error('方法不存在:'.__CLASS__.'\\'.$name);
    }

    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }
    /**
     * 数据验证
     * @param  string $scene        验证场景
     * @param  array  $param        验证数据
     * @param  array  $field        单字段验证
     * @return $this
     */
    protected function validate(string $scene , array $param , string  $field = null)
    {
        if($this->validate instanceof Validate == false) return $this;

        $validate = $this->validate->scene($scene)->check($param);

        if($validate == false)
        {
            throw new ValidateException($this->validate->getError());
        }
            
        return $this;
    }

    /**
     * 创建数据
     * @param string $scene 验证器场景
     * @param array $param  创建数据
     * @return void
     */
    public function CreateData(string $scene , array $param = [])
    {
        return $this->validate($scene,$param)->save($param);
    }
    
    /**
     * 更新数据
     * @param string|int $pk 主键
     * @param string $scene 验证场景
     * @param array  $data 更新数据
     * @return int   成功更新条数
     */
    public function updateData($pk , string $scene , array $data )
    {
        return $this->validate($scene,$data)->update($data,[$this->model->getPk()=>$pk]);
    }

    /**
     * 快速编辑
     * @param stirng $pk     主键
     * @param stirng $field  更新字段
     * @param stirng $value  更新值
     * @return void
     */
    public function quickUpdateData(string $pk , string $field , string $value)
    {
        return $this->validate('quick',[$field=>$value],$field)->update([$field=>$value],[$this->model->getPk()=>$pk]);
    }

    /**
     * 删除数据
     * @param string|array $pk
     * @param array  $exclude 排除删除的主键
     * @return void
     */
    public function deleteData($pk, $exclude = null)
    {   
        if(is_string($pk))
        {
            $pk = explode(',',$pk);
        }

        if(is_string($exclude))
        {
            $exclude = explode(',',$exclude);
            
            foreach((array) $exclude as $value)
            {
                $key = array_search($value,$pk);

                if($key !== false)
                {
                    unset($pk[$key]);
                }
            }
        }
        return $this->model->withTrashedDelete($pk);
    }

    /**
     * @param string|int 上级id
     * @param array  $parentList 父级数组
     * @return void
     */
    public function getParentList($pid,array $parentList=[])
    {
        $parent = $this->model->findOrEmpty($pid);

        if($parent->isEmpty()) return $parentList;

        array_push($parentList,$parent->toArray());

        if($parent['pid'] <> 0)
        {
            $parentList = $this->getParentList($parent['pid'],$parentList);
        }

        return $parentList;
    }

    /**
     * 快捷查询
     * @param  page|页码 
     * @return array
     */
    public function getList($page = null , $limit = null , $sort = null , $sortMode = 'desc') : array 
    {
        $pk       =  $this->model->getPk();
        $page     = $page       ?? request()->param('page',null);
        $limit    = $limit      ?? request()->param('limit',null);
        $sort     = $sort       ?? request()->param('sort',"{$pk}");
        $sortMode = $sortMode  ?? request()->param('sort_mode','desc');

        $where = $this->getWhere();
        $model = $this->model;
        $model = $model->where($where)->order($sort,$sortMode);
        $total = $model->count();

        if(!empty($page) && !empty($limit))
        {
            $model = $model->page((int)$page)->limit((int)$limit);
            return [$model->select()->toArray(),$total];
        } else 
        {
            return $model->select()->toArray();
        }
    }

    /**
     * 生成where条件
     * @param array $param
     * @return array
     */
    public function getWhere(array $param = [])
    {
        $param = empty($param) ? request()->except(['limit','page','sort','sort_mode']) : $param;
        
        $where = [];

        $operateValidate = ['=','<>','>','>=','=<','<','%like','like%','%like%','between'];

        foreach((array) $param as $name => $value)
        {
            if('_' == substr($name,0,1)) continue;

            $operate = isset($param['_'.$name]) ? $param['_'.$name] : '';
            if(!in_array($operate,$operateValidate) || (empty($value) && !is_numeric($value))) continue;
            switch($operate)
            {
                case '=': case '<>': case '>': case '<': case '>=': case '=<':case 'in':
                    $where[] = [$name,$operate,$value];
                break;

                case '%like':
                    $where[] = [$name,'like','%'.$value];
                break;

                case 'like%':
                    $where[] = [$name,'like',$value.'%'];
                break;

                case '%like%':
                    $where[] = [$name,'like','%'.$value.'%'];
                break;

                case 'between':
                    $time = explode('~',$value);
                    $time[0] = is_date(isset($time[0]) ? trim($time[0],' ') : false);
                    $time[1] = is_date(isset($time[1]) ? trim($time[1],' ') : false);
                    if($time[0] || $time[1])
                    {
                        $where[] = [$name,$operate.' time',$time];
                    }
                break;
            }
        }
        return $where;
    }   

    public function setModelWhere($where=[])
    {
        $this->model = $this->model->where($where);
        return $this;
    }
}