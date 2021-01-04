<?php

declare(strict_types=1);

/**
 * @class token服务类
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/
namespace app\common\service\system;

use app\common\service\BaseService;
use Firebase\JWT\JWT;

class TokenService extends BaseService
{
    private $alg = 'sha256';

    private $key = '945462788@qq.com';

    /**
     * 获取头部
     */
    protected function getHeader():string
    {
        $header = [
            'alg' => $this->alg,
            'typ' => 'JWT'
        ];

        return $this->base64urlEncode(json_encode($header, JSON_UNESCAPED_UNICODE));
    }

    protected function getPayload($uni):string
    {
        $payload = [
            'iss' => 'system', //签发人
            'exp' => time() + 7200, //过期时间
            'sub' => 'jwt', //主题
            'aud' => 'every', //受众
            'nbf' => time(), //生效时间
            'iat' => time(), //签发时间
            'uni' => $uni, //私有信息
        ];

        return $this->base64urlEncode(json_encode($payload,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 生成token
     * @param string $uni
     * @return string
     */
    public function create($uni):string
    {
        $header = $this->getHeader();
        $payload = $this->getPayload($uni);
        $raw   = $header . '.' . $payload;
        return $raw . '.' . hash_hmac($this->alg, $raw, $this->key);
    }

    /**
     * 解密校验token
     * @param $token
     * @return string
     */
    public function verify($token)
    {
        if (!$token) {
            return false;
        }

        $tokenArr = explode('.', $token);

        if (count($tokenArr) != 3) {
            return false;
        }

        $header    = $tokenArr[0];
        $payload   = $tokenArr[1];
        $signature = $tokenArr[2];

        $payloadArr = json_decode($this->base64urlDecode($payload), true);

        if (!$payloadArr) {
            return false;
        }

        if (isset($payloadArr['exp']) && $payloadArr['exp'] < time()) {
            return false;
        }

        $expected = hash_hmac($this->alg, $header . '.' . $payload, $this->key);

        //签名不对
        if ($expected !== $signature) {
            return false;
        }

        return $payloadArr['uni'];
    }

    /**
     * 安全的base64 url编码
     * @param $data
     * @return string
     */
    private function base64urlEncode($data):string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * 安全的base64 url解码
     * @param $data
     * @return bool|string
     */
    private function base64urlDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

}