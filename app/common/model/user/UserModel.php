<?php

declare(strict_types=1);

/**
 * @class
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\model\user;


use app\common\model\BaseModel;

class UserModel extends BaseModel
{
    protected $name = 'user';

    protected $pk = 'user_id';

    /**
     * @param array $userInfo
     * @return int|mixed
     */
    public function saveWeChatAppUser($userInfo)
    {
        $data['nickname'] = filter_emoji($userInfo['nickName']);
        $data['wechat_open_id'] = $userInfo['openId'];
        $data['avatar'] = $userInfo['avatarUrl'];
        return $this->saveSmsUser($data);
    }

    private function saveSmsUser(array &$data)
    {
        $data['username'] = 'sms'.time();
        $data['password'] = md5('sms'.time());
        $data['last_login_time'] = time();
        if ($this->save($data))
        {
            return $this->user_id;
        }
    }
}