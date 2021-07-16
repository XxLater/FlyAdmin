<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/

namespace app\admin\controller;


use app\common\service\utils\UploadService;

class Api extends Base
{
    /**
     * @author echo
     * @time  2021 - 02 - 24
     * @commit 上传图片
     */
    public function uploadImage()
    {
        if($this->request->isPost())
        {
            $file = $this->request->file('image');

            if ($file)
            {
                if($attachment = UploadService::instance()->localUploadImage($file))
                {
                    app('response')->success($attachment);
                }
            }
            app('response')->fail('请上传图片');
        }
        
        $this->fetch();
    }
}