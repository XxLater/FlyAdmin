<?php

namespace app\backup\service\user;

use app\backup\model\user\UserModel;
use app\common\service\BaseService;

class UserService extends BaseService
{
    public function __construct(UserModel $userModel)
    {
        $this->model = $userModel;
    }

    public function getShareQrcode()
    {
        // if(empty($this->model->share_qr_code))
        // {
        //     $path = system_config('');

        //     $this->setShareQrcode();
        // }

    }

    protected function setShareQrcode(string $link)
    {

    }
}