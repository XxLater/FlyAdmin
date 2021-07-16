<?php


namespace app\common\model;
use think\Model;

class BaseModel extends Model
{
    protected $updateTime = false;

    public function withTrashedDelete($pk)
    {
        [$field,$condition] = $this->getOptions('soft_delete');

        if($field)
        {
            return self::destroy($pk);
        }
        
        return $this->where($this->getPk(),'in',$pk)->delete();
    }
}