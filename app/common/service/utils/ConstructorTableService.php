<?php
namespace app\common\service\utils;

use app\common\service\BaseService;
use think\exception\HttpResponseException;
use think\Response;
use think\facade\View;

/**
 * 表格构造器
 * @author  echo
 * @email   945462788@qq.com
 * @github  https://github.com/945462788
 */
class ConstructorTableService extends BaseService
{
    /**
     * 模版路径
     * @var mixed|string
     */
    protected $template = 'constructor@table/layout';

    protected const ALIGN = 'center';

    protected const WIDTH = 120;

    /**
     * 页面标题
     * @var
     */
    protected $page_title;

    /**
     * 表格控件
     * @var
     */
    protected $item;

    /**
     * 提交地址
     * @var
     */
    protected $url;

    /**
     * 提交方式
     * @var
     */
    protected $method;

    /**
     * 数据主键
     * @var string
     */
    protected $pk = 'id';

    /**
     * 开启复选框
     * @var
     */
    protected $checkBox = true;

    /**
     * 统计字段 
     * @var boolean
     */
    protected $totalFields = false;

    /**
     * 行内按钮组 
     * @var boolean
     */
    protected $lineButton = [];

    /**
     * 表格顶部按钮组 
     * @var boolean
     */
    protected $blockButton = [];

    // /**
    //  * 默认生成行内按钮【编辑，删除】
    //  * @var boolean
    //  */
    // protected $defaultLineButton = true;

    //  /**
    //  * 默认生成表格顶部按钮【新增，批量删除】
    //  * @var boolean
    //  */
    // protected $defaultBlockButton = true;

    /**
     * 排序字段
     * @var boolean
     */
    protected $sortFields = false;

    /**
     * 搜索栏组件
     * @var array
     */
    protected $searchItem = [];

    public static function create($page_title,$template=false): ConstructorTableService
    {
        return new self($page_title,$template);
    }
    
    public function __construct($page_title,$template=false)
    {
        $this->page_title = $page_title;


        if ($template) $this->template = $template;
    }

    /**
     * 设置主键
     * @param string $field
     * @return ConstructorTableService
     */
    public function setPk(string $field)
    {
        $this->pk = $field;

        return $this;
    }

    public function setCheckBox(bool $checkBox)
    {
        $this->checkBox = $checkBox;

        return $this;
    }


    /**
     * @param [type] $fields 需要统计的字段
     * @return ConstructorTableService
     */
    public function setTotalFields($fields)
    {
        if(is_array($fields))
        {
            $fields = implode(',',$fields);
        }
        
        $this->totalFields = $fields;

        return $this;
    }

    /**
     * @param string|array $fields 需要统计的字段
     * @return ConstructorTableService
     */
    public function setSortFields($fields)
    {
        if(is_array($fields))
        {
            $fields = implode(',',$fields);
        }
        
        $this->sortFields = $fields;

        return $this;
    }

    /**
     * 添加文本列
     * @param string $title 标题
     * @param string $field 字段
     * @param [type] $width 列宽度
     * @param string $align 文本样式
     * @return ConstructorTableService
     */
    public function addTextCol(string $title,string $field,$width = null , string $align = self::ALIGN):ConstructorTableService
    {
        $data = compact('title','field','align','width');

        $data['type'] = 'text';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加图像列
     * @param string $title 标题
     * @param string $field 字段
     * @param [type] $width 列宽度
     * @param string $align 文本样式
     * @return ConstructorTableService
     */
    public function addImageCol(string $title,string $field,$width = null , string $align = self::ALIGN):ConstructorTableService
    {
        $data = compact('title','field','align','width');

        $data['type'] = 'image';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加快速编辑文本列
     * @param string $title 标题
     * @param string $field 字段
     * @param [type] $width 列宽度
     * @param string $align 文本样式
     * @return ConstructorTableService
     */
    public function addEditCol(string $title,string $field,$width = null , string $align = self::ALIGN):ConstructorTableService
    {
        $data = compact('title','field','align','width');

        $data['type'] = 'edit';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加表单开关列
     * @param string $title 
     * @param string $field         
     * @param string $width         列宽度         
     * @param array  $extend_text   显示文本
     * @param array  $extend_value  控件值更改
     * @return ConstructorTableService
     */
    public function addSwitchCol(string $title,string $field,$width = null , array $extend_text = [],array $extend_value = [0,1]):ConstructorTableService
    {
        $align = self::ALIGN;

        if($extend_text && count($extend_text) !== 2) $this->error('extend_text传参数错误，实例["关","开"]');

        if(count($extend_value) !== 2) $this->error('extend_value传参数错误，实例["disable","enable"]');

        $data = compact('title','field','extend_text','extend_value','align','width');

        $data['type'] = 'switch';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加行内按钮
     * @param string $tips
     * @param mexid  $type   1表示数据操作，2表示跳转地址操作
     * @param string $icon   按钮图标
     * @param string $color  颜色样式
     * @param string $url    按钮处理地址
     * @return ConstructorTableService
     */
    public function addLineButton(string $tips , $type ,string $icon ,string $color,string $url) 
    {
        $this->lineButton[] = compact('tips','type','icon','color','url');
        return $this;
    }

    /**
     * 添加默认行内按钮
     * @return ConstructorTableService
     */
    public function addDefaultLineButton()
    {
        $this->addLineButton('编辑',2,'layui-icon-edit','primary','update');
        $this->addLineButton('删除',1,'layui-icon-delete','danger','delete');
        return $this;
    } 

    /**
     * 添加表格顶部按钮
     * @param string $title  按钮标题
     * @param mexid  $type   1表示数据操作，2表示跳转地址操作，3表示选中数据跳转到地址
     * @param string $icon   按钮图标
     * @param string $color  颜色样式
     * @param string $url    按钮处理地址
     * @param bool   $check  是否检测选中数据不能为空
     * @return ConstructorTableService
     */
    public function addBlockButton(string $title , $type , string $icon , string $color , string $url , $check = false)
    {
        $this->blockButton[] = compact('title','type','icon','color','url','check');
        return $this;
    }

    /**
     * 添加默认表格顶部按钮组
     */
    public function addDefaultBlockButton(bool $auth = true)
    {
        $this->addBlockButton('新增',2,'layui-icon-add-1','primary','create');
        $this->addBlockButton('删除',1,'layui-icon-delete','danger','delete',true);
        return $this;
    } 

    /**
     * 文本筛选框
     * @param string $title        筛选框标题
     * @param string $field        筛选字段
     * @param string $operate      支持类型 =|等于，<>｜不等于，>|大于, >=|大于等于 , <|小于, =<|小于等于，%like|前段相似、like%|后段相似，%like%|前后相似
     * @return ConstructorTableService
     */
    public function addTextSearch( string $title , string $field, string $operate='=')
    {
        $type = 'text';

        $operate = strtolower($operate);

        $rule = ['=','<>','>','<','>=','=<','%like','like%','%like%'];

        if(!in_array($operate,$rule)) $this->error('operate 参数不正确');

        $this->searchItem[] = compact('type','field','operate','title');

        return $this;
    }   

    /**
     * 下拉列表筛选
     * @param string $title     筛选框标题
     * @param string $field     筛选字段
     * @param array  $list      下拉数据列表
     * @return ConstructorTableService
     */
    public function addSelectSearch( string $title , string $field , array $list)
    {
        $type = 'select';

        $this->searchItem[] = compact('type','field','list','title');

        return $this;
    }

    /**
     * 日期区间筛选
     * @param string  $title   筛选框提示
     * @param string  $field   需要筛选的字段名
     * @param string  $start   筛选起始日期
     * @param string  $end     筛选截止日期
     * @return ConstructorTableService
     */
    public function addTimeSearch(string $title ,string $field , $start = false , $end = false)
    {
        if($start && !is_date($start))
        {
            $this->error('起始时间错误');
        }

        if($end && !is_date($end))
        {
            $this->error('结束时间错误');
        }

        $type = 'time';

        $this->searchItem[] = compact('type','field','start','end','title');

        return $this;
    }

    /**
     * 输出页面
     * @return HttpResponseException
     */
    public function fetch()
    {
        if(empty($this->item)) $this->error('请构造控件');

        // if($this->defaultLineButton) $this->addDefaultLineButton();

        // if($this->defaultBlockButton) $this->addDefaultBlockButton();

        if(!isset($this->item[$this->pk]))
        {
            $this->pk = array_key_first($this->item);
        }

        if(!empty($this->searchItem))
        {
            foreach($this->searchItem as $key => &$value)
            {
                if(isset($this->item[$value['field']]) && empty($value['title']))
                {
                    $value['title'] = $this->item[$value['field']]['title'];
                }
            }
        }

        if(!empty($this->lineButton)) 
        {
            $this->item['lineButton'] = ['type'=>'lineButton','title'=>'操作','align'=>self::ALIGN];
        }

        $this->method = $this->method ?? 'POST';

        $this->assign([
            'table_item'          =>$this->item,
            'page_title'          =>$this->page_title,
            'url'                 =>strtolower((string)url(get_path())),
            'checkbox'            =>$this->checkBox,
            'method'              =>$this->method,
            'total_fields'        =>$this->totalFields,
            'sort_fields'         =>$this->sortFields,
            'pk'                  =>$this->pk,
            'line_button'         =>$this->lineButton,
            'block_button'        =>$this->blockButton,
            'search_item'         =>$this->searchItem,
        ]);

        throw new HttpResponseException(Response::create(View::fetch($this->template)));
    }

    protected function assign($key,$value=null)
    {
        View::assign($key,$value);
    }
}