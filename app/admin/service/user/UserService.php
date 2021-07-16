<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\admin\service\user;

use app\common\model\user\UserModel;
use app\common\validate\UserValidate;
use app\common\service\BaseService;

class UserService extends BaseService
{
    public function __construct(UserModel $model , UserValidate $validate)
    {
        $this->model    = $model;
        $this->validate = $validate;
    }

    /**
     * @param UserModel $name
     * @return void
     */
    public function userLogin(UserModel $user)
    {
        $user->last_login_time = time();

        return $user->save();
    }

    /**
     * @param $unionid
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function unionIdByWechatUser($unionid)
    {
        return $this->where('unionid',$unionid)->find();
    }

    /**
     * @param $openid
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function openIdByWechatUser($openid)
    {
        return $this->where('wechat_open_id',$openid)->find();
    }

    /**
     * @param $user_id
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function userIdByUser($user_id)
    {
        return $this->where('user_id',$user_id)->find();
    }

    /**
     * @param $username
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function userNameByUser($username)
    {
        return $this->where('username',$username)->find();
    }

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

    public function saveWeChatUser($userInfo)
    {
        $data['wechat_open_id'] = $userInfo['openid'];
        if (isset($userInfo['nickname']))
        {
            $data['nickname'] = filter_emoji($userInfo['nickname']);
            $data['avatar'] = $userInfo['headimgurl'];
        }
        return $this->saveSmsUser($data);
    }

    private function saveSmsUser(array &$data)
    {
        $time  = time();
        $data['username'] = 'sms'.$time;
        $data['password'] = md5('sms'.$time);
        $data['last_login_time'] = $time;
        $data['unionid'] = $data['unionid'] ?? '';
        $user = [];
        if (isset($data['unionid']) && !empty($data['unionid']))
        {
            $user = $this->unionIdByWechatUser($data['unionid']);

        }else if (isset($data['wechat_open_id']) && !empty($data['wechat_open_id']))
        {
            $user = $this->openIdByWechatUser($data['wechat_open_id']);
        }
        if ($user)
        {
            $user->last_login_time = $data['last_login_time'];
            $user->save();
            return $user->user_id;
        }
        if ($this->save($data))
        {
            return $this->user_id;
        }
    }
   
}