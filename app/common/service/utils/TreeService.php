<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/

namespace app\common\service\utils;


use app\common\service\BaseService;

class TreeService extends BaseService
{
    protected $data;

    protected $pk;

    protected $pid;

    protected $child;

    protected $child_html = '└';

    protected $parent_html = '├';

    public function init(array $data,$pk='id',$pid='pid',$child='child'):TreeService
    {
        $this->pk = $pk;

        $this->data = $this->serializeList($data);

        $this->pid = $pid;

        $this->child = $child;

        return $this;
    }

    /**
     * @parma
     * @return array
     */
    public function toTreeList():array
    {
        $refer= [];

        foreach ($this->data as $index => &$value)
        {
            $refer[$value[$this->pk]] = &$value;
        }

        $tree = [];

        foreach ($this->data as $key => $item)
        {
            if ($item[$this->pid] === 0)
            {
               $this->data[$key]['html'] = $this->parent_html;
                $tree[] = &$this->data[$key];
            }else
            {
                $parent = &$refer[$item[$this->pid]];
                $this->data[$key]['html'] = $this->child_html;
                $parent[$this->child][] = &$this->data[$key];
            }
        }

        return $tree;
    }

    /**
     * 序列化数组
     * @param array $data
     * @return array
     */
    protected function serializeList(array $data):array
    {
        $tree = [];

        foreach ($data as $value)
        {
            $tree[$value[$this->pk]] = $value;
        }

        return $tree;
    }

    /**
     * 获取下级
     * @param $mid
     * @return array
     */
    public function getChild($mid):array
    {
        if (!isset($this->data[$mid])) return [];

        $data = $this->data[$mid];

        foreach ($this->data as $value)
        {
            if ($value[$this->pid] == $mid)
            {
                $data['child'][] = array_merge($value,$this->getChild($value[$this->pk]));
            }
        }

        return $data;
    }

    /**
     * @param $mid
     * @return array
     */
    public function getParent($mid):array
    {
        if (!isset($this->data[$mid])) return [];

        $data = $this->data[$mid];

        foreach ($this->data as $value)
        {
            if ($value[$this->pk] == $data[$this->pid])
            {
                $data['parent'] = array_merge($value,$this->getParent($value[$this->pk]));
            }
        }

        return $data;
    }

    /**
     * @param $treeData
     * @param $field
     * @param $levelName
     * @return array
     */
    public function getTreeColumn($treeData,$field,$levelName):array
    {
        $field_data = [];
        foreach ($treeData as $value)
        {
            if (!isset($value[$field])) continue;
            if (isset($value[$levelName]) && !empty($value[$levelName]))
            {
                $field_data = array_merge([$value[$field]],$this->getTreeColumn($value,$field,$levelName));
            }else
            {
                $field_data = [$value[$field]];
            }
        }
        return $field_data;
    }
}