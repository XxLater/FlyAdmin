<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service\utils;

use app\common\exception\ServiceException;
use app\common\service\BaseService;
use think\contract\Arrayable;
use think\exception\HttpResponseException;
use think\facade\View;
use think\Response;

class ConstructorFormService extends BaseService
{

    /**
     * 模版路径
     * @var mixed|string
     */
    protected $template = 'constructor@form/layout';

    /**
     * 页面标题
     * @var
     */
    protected $page_title;

    /**
     * 表单控件
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
     * 可用的验证规则
     * @var string[]
     */
    protected $verifyRule = ['phone','email','url','number','date','identity','checkbox'];

    public static function create($page_title,$url='',$template=false): ConstructorFormService
    {
        return new self($page_title,$url,$template);
    }

    public function __construct($page_title,$url='',$method='GET',$template=false)
    {
        $this->page_title = $page_title;

        $this->url = !empty($url) ? $url :get_path();

        if ($template) $this->template = $template;
    }

    /**
     * 设置提交地址
     * @param string $url
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function setUrl($url = ''):ConstructorFormService
    {
        $this->url = $url;
        return $this;
    }

    /**
     * 设置提交方式
     * @param string $url
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function setMethod($method = 'GET'):ConstructorFormService
    {
        $this->method = $method;
        return $this;
    }

    /**
     * 文本输入框
     * @param string $title
     * @param string $field
     * @param string|bool $require
     * @param string $default
     * @param string $tips
     * @param bool $verifyRule
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addText(string $title,string $field,$require=false,string $default='',string $tips='',$verifyRule=false):ConstructorFormService
    {
        if ($verifyRule !== false)
        {
            if (!in_array($verifyRule,$this->verifyRule)) $this->error('请输入正确的验证规则'.json_encode($this->verifyRule));
        }

        $data = compact('title','field','require','default','tips','verifyRule');

        $data['type'] = 'text';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 邮箱输入框
     * @param string $title
     * @param string $field
     * @param string|bool $require
     * @param string $default
     * @param string $tips
     * @param bool $verifyRule
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addEmail(string $title,string $field,$require=false,string $default='',string $tips=''):ConstructorFormService
    {
        return $this->addText($title,$field,$require,$default,$tips,'email');
    }

    /**
     * 手机号码输入框
     * @param string $title
     * @param string $field
     * @param string|bool $require
     * @param string $default
     * @param string $tips
     * @param bool $verifyRule
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addPhone(string $title,string $field,$require=false,string $default='',string $tips=''):ConstructorFormService
    {
        return $this->addText($title,$field,$require,$default,$tips,'phone');
    }

    /**
     * url输入框
     * @param string $title
     * @param string $field
     * @param string|bool $require
     * @param string $default
     * @param string $tips
     * @param bool $verifyRule
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addUrl(string $title,string $field,$require=false,string $default='',string $tips=''):ConstructorFormService
    {
        return $this->addText($title,$field,$require,$default,$tips,'url');
    }

    /**
     * url输入框
     * @param string $title
     * @param string $field
     * @param string|bool $require
     * @param string $default
     * @param string $tips
     * @param bool $verifyRule
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addNumber(string $title,string $field,$require=false,string $default='',string $tips=''):ConstructorFormService
    {
        return $this->addText($title,$field,$require,$default,$tips,'number');
    }

    /**
     * icon选择器
     * @param string $title
     * @param string $field
     * @param string|bool $require
     * @param string $default
     * @param string $tips
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addIcon(string $title,string $field,$require=false,string $default='',string $tips=''):ConstructorFormService
    {
        $data = compact('title','field','require','default','tips');

        $data['type'] = 'icon';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 身份证号码输入框
     * @param string $title
     * @param string $field
     * @param string|bool $require
     * @param string $default
     * @param string $tips
     * @param bool $verifyRule
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addIdentity(string $title,string $field,$require=false,string $default='',string $tips=''):ConstructorFormService
    {
        return $this->addText($title,$field,$require,$default,$tips,'identity');
    }

    /**
     * 隐藏框
     * @param string$field
     * @param string $default
     * @return $this
     */
    public function addHide(string $field,$default=''):ConstructorFormService
    {
        $data = compact('field','default');

        $data['type'] = 'hide';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * @param string $title
     * @param string $field
     * @param  $default
     * @param string $tips
     * @param array $option
     * @param array|int[] $extend_data
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addSwitch(string $title,string $field,$default='',string $tips='',array $option=[],array $extend_data=[0,1]):ConstructorFormService
    {
        if ($option && count($option) != 2) $this->error('option传参错误,示例["禁用","启用"]');

        if ($extend_data && count($extend_data) != 2) $this->error('extend_data,示例["disable","enable"]');

        $data = compact('title','field','default','tips','option','extend_data');

        $data['type'] = 'switch';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 标签
     * @param string $title
     * @param string $field
     * @param string|bool $require
     * @param string $option
     * @param string $tips
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function addTag(string $title, string $field, $require=false, string $option ='',  $tips=''):ConstructorFormService
    {
        $data = compact('title','field','require','option','tips');

        $data['type'] = 'tag';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加下拉列表
     * @param string $title
     * @param string $field
     * @param $require
     * @param $option
     * @param $default
     * @param string $tips
     * @return ConstructorFormService
     */
    public function addSelect(string $title , string $field , $require,array $option,  $default=false , string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','require','option','default','tips');

        $data['type'] = 'select';

        $this->item[$field] = $data;

        return $this;
    }

     /**
     * 添加树型下拉列表
     * @param string $title
     * @param string $field
     * @param bool|string   $require
     * @param string $html   生成的树类型<option>
     * @param string $default
     * @param string $tips
     * @return ConstructorFormService
     */
    public function addTreeSelect(string $title , string $field , $require, string  $html,  $default=false , string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','require','html','default','tips');

        $data['type'] = 'treeSelect';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加多选框
     * @param string $title
     * @param string $field
     * @param bool   $require
     * @param array  $option
     * @param false  $default
     * @param string $tips
     * @return $this
     */
    public function addCheckbox(string $title , string $field , $require,array  $option,  $default=false , string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','require','option','default','tips');

        $data['type'] = 'checkbox';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加单选框
     * @param string $title
     * @param string $field
     * @param $require
     * @param array $option
     * @param false $default
     * @param string $tips
     * @return $this
     */
    public function addRadio(string $title , string $field , $require,array $option,  $default= false , string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','require','option','default','tips');

        $data['type'] = 'radio';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加文本域
     * @param string $title
     * @param string $field
     * @param $require
     * @param false $default
     * @param string $tips
     * @return $this
     */
    public function addTextarea(string $title , string $field , $require = false, $default= false , string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','require','default','tips');

        $data['type'] = 'textarea';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加密码输入框
     * @param string $title
     * @param string $field
     * @param $require
     * @param false $default
     * @param string $tips
     * @return $this
     */
    public function addPassword(string $title , string $field , $require, $default= false , string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','require','default','tips');

        $data['type'] = 'password';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加相同对比输入框
     * @param string $title
     * @param string $field
     * @param string $confirmField
     * @param bool $isPassword
     * @param string $tips
     * @return $this
     */
    public function addConfirm(string $title , string $field , string $confirmField, bool $isPassword = true, string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','confirmField','isPassword','tips');

        $data['type'] = 'confirm';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 添加tinymce编辑器
     * @param string $title
     * @param string $field
     * @param bool $require
     * @param string $default
     * @param string $tips
     * @return $this
     */
    public function addTinymce(string $title , string $field ,  $require = false, $default='',string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','require','default','tips');

        $data['type'] = 'tinymce';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 图片上传
     * @param string $title
     * @param string $field
     * @param false $require
     * @param string $default
     * @param string $tips
     * @return $this
     */
    public function addImage(string $title , string $field ,  $require = false,  $default='', string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','require','default','tips');

        $data['type'] = 'image';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 多图片上传
     * @param string $title
     * @param string $field
     * @param false $require
     * @param string $default
     * @param string $tips
     * @param int|false $least 至少上传图片张数
     * @return $this
     */
    public function addImages(string $title , string $field ,  $require = false,  $default='', string $tips = '', $least = false): ConstructorFormService
    {
        if (is_array($default))
        {
            $default = implode(',',$default);
        }
        if ($least && !is_numeric($least)) $this->error('least 参数必须为数字或布尔值');

        $data = compact('title','field','require','default','tips','least');

        $data['type'] = 'images';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 日期选择器
     * @param string $title
     * @param string $field
     * @param false $require
     * @param string $default
     * @param string $tips
     * @param int|false $least 至少上传图片张数
     * @return $this
     */
    public function addDate(string $title , string $field ,  $require = false,  $default='', string $tips = ''): ConstructorFormService
    {
        $data = compact('title','field','require','default','tips');

        $data['type'] = 'date';

        $this->item[$field] = $data;

        return $this;
    }

    /**
     * 解析模型配置的控件
     * @param  BaseModel $model
     * @return ConstructorFormService;
     */
    public function setItem($model)
    {
        $formItem = $model->getFormItem();

        foreach($formItem as $key=>$value)
        {
            if(isset($value['type']) && isset($value['field']))
            {
                $method  = 'add'.ucfirst($value['type'] ?? $this->error('type不能为空'.print_r($value)));
                $title   = $value['title'] ?? '';
                $field   = $value['field'] ?? $this->error('field不能为空'.print_r($value));
                $require = $value['require'] ?? false;
                $default = $value['default'] ?? '';
                $tips    = $value['tips'] ?? '';
                
                switch($value['type'])
                {
                    case 'text': case 'email': case 'phone': case 'identity': case 'date': case 'url':
                        $verify = $value['type'] == 'text' ? false : $value['type'];
                        call_user_func_array([$this,$method],[$title,$field,$require,$default,$tips,$verify]);
                    break;

                    case 'hide':
                        call_user_func_array([$this,$method],[$field,$default]);
                    break;

                    case 'password':
                        call_user_func_array([$this,$method],[$title,$field,$require,$default,$tips]);
                    break;    

                    case 'confirm':
                        if(!isset($value['confirmFiled']) || empty($value['confirmFiled'])) break;
                        $isPassword = $value['isPassword'] ?? false;
                        call_user_func_array([$this,$method],[$title,$field, $value['confirmFiled'],$isPassword,$tips]); 
                    break;

                    case 'image':
                        call_user_func_array([$this,$method],[$title,$field,$require,$default,$tips]);
                    break;

                    case 'images':
                        $least = $require ? 1 : 0;
                        $least = $value['least'] ?? $least;
                        call_user_func_array([$this,$method],[$title,$field,$require,$default,$tips,$least]);
                    break;

                    case 'select': case 'checkbox': case'radio':
                        $option = $value['option'] ?? [];
                        if(empty($option)) break;    
                        call_user_func_array([$this,$method],[$title,$field,$require,$option,$default,$tips]);
                    break;

                    case 'tag':
                        $option = $value['option'] ?? [];
                        call_user_func_array([$this,$method],[$title,$field,$require,$default,$tips]);
                    break;

                    case 'tinymce': case 'textarea':
                        call_user_func_array([$this,$method],[$title,$field,$require,$default,$tips]);
                    break;    

                    case 'switch':
                        $option = $value['option'] ?? [];
                        $extend_data = $value['extendData'] ?? [0,1];
                        call_user_func_array([$this,$method],[$title,$field,$default,$option,$extend_data,$tips]);
                    break;
                }

            }
        }

        return $this;
    }

    /**
     * 设置表单默认内容
     * @param $data
     * @param string $pk
     * @return $this
     * @throws \app\common\exception\ServiceException
     */
    public function setData($data, $pk='id'):ConstructorFormService
    {
        if (empty($data)) return $this;
        if ($data instanceof Arrayable)
        {
            $data = $data->toArray();
        }

        foreach ($data as $key=>$value)
        {
            if (!isset($this->item[$key])) continue;

            $this->item[$key]['default'] = $value;
        }
        
        if (isset($data[$pk]) && !empty($data[$pk])) $this->addHide($pk,$data[$pk]);

        return $this;
    }

    /**
     * 输出页面
     * @return HttpResponseException
     */
    public function fetch()
    {
        if(empty($this->item)) $this->error('请构造控件');
        $this->method = $this->method ?? 'POST';
        $this->assign([
            'form_item'=>$this->item,
            'page_title'=>$this->page_title,
            'url'=>strtolower((string)url($this->url)),
            'method'=>$this->method,
        ]);

        throw new HttpResponseException(Response::create(View::fetch($this->template)));
    }

    protected function assign($key,$value=null)
    {
        View::assign($key,$value);
    }
}