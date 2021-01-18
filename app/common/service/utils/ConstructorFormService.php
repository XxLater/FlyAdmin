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
use think\contract\Arrayable;
use think\exception\HttpResponseException;
use think\facade\View;
use think\Response;

class ConstructorFormService extends BaseService
{
    protected $template = 'layui/layout/form';

    protected $page_title;

    protected $item;

    public static function create($page_title,$template=false): ConstructorFormService
    {
        return new self($page_title);
    }

    public function __construct($page_title,$template=false)
    {
        $this->page_title = $page_title;

        if ($template) $this->template = $template;
    }

    /**
     * 文本输入框
     * @param string$title
     * @param string$field
     * @param bool $require
     * @param string $default
     * @param string $tips
     * @return $this
     */
    public function addText(string $title,string $field,$require=false,string $default='',string $tips='12345'):ConstructorFormService
    {
        $data = compact('title','field','require','default','tips');

        $data['type'] = 'text';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 隐藏框
     * @param string$field
     * @param string $default
     * @return $this
     */
    public function addHideText(string $field,$default=''):ConstructorFormService
    {
        $data = compact('field','default');

        $data['type'] = 'hide';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * @param string$title
     * @param string$field
     * @param array $option      显示文本
     * @param array $extend_data 额外定义值
     * @param string $default
     * @param string $tips
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addSwitch(string $title,string $field,array $option=[],array $extend_data=[0,1],string $default='',string $tips='12345'):ConstructorFormService
    {
        if ($option && count($option) != 2) $this->error('option传参错误,示例["禁用","启用"]');

        if ($extend_data && count($extend_data) != 2) $this->error('extend_data,示例["禁用","启用"]');

        $data = compact('title','field','default','tips','option','extend_data');

        $data['type'] = 'switch';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 设置表单默认内容
     * @param $data
     * @param string $pk
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function formData($data, $pk='id'):ConstructorFormService
    {
        if ($data instanceof Arrayable)
        {
            $data = $data->toArray();
        }

        foreach ($data as $key=>$value)
        {
            if (!isset($this->item[$key])) continue;

            $this->item[$key]['default'] = $value;
        }

        if (!isset($data[$pk]) || empty($data[$pk])) $this->error('主键不能为空');

        $this->addHideText($pk,$data[$pk]);

        return $this;
    }

    public function fetch()
    {
        $this->assign([
            'form_item'=>$this->item,
            'page_title'=>$this->page_title
        ]);

        throw new HttpResponseException(Response::create(View::fetch($this->template)));
    }

    protected function assign($key,$value=null)
    {
        View::assign($key,$value);
    }
}