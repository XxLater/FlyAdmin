<?php
declare(strict_types=1);

namespace app\common\service\utils;

use app\common\service\BaseService;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\QrCode;

class QrcodeService extends BaseService
{
    /**
     * 二维码版本
     * @var integer
     */
    protected $version = 5;

    /**
     * @var [Qrcode]
     */
    protected $service;

    /**
     * 图片生成后缀
     * @var [type]
     */
    protected $outputType = QrCode::OUTPUT_IMAGE_PNG;

    /**
     * 二维码容错级别
     * @var [type]
     */
    protected $eccLevel  = QRCode::ECC_H;

    /**
     * 二维码大小
     * @var integer
     */
    protected $scale = 10; 

    protected function init()
    {
        $option = [
            'version'    => $this->version,                             
            'outputType' => $this->outputType,     
            'eccLevel'   => $this->eccLevel,                 
            'scale'      => $this->scale,   
        ];

        $option = new QROptions($option);

        $this->service = new QrCode($option);

        return $this->service;
    }

    public function setEccLevel(int $eccLevel)
    {
        $this->eccLevel = $eccLevel;

        return $this;
    }

    public function setScale(int $scale)
    {
        $this->scale = $scale;

        return $this;
    }

    public function setVersion(int $version)
    {
        $this->version = $version;

        return $this;
    }

    public function setOutputType(string $outputType)
    {
        $this->outputType = $outputType;

        return $this;
    }

    public function create(string $link)
    {
        $this->init();

        $path = app()->getRootPath() . 'public/qrcode';

        $path .= '/'.$this->getFielName($link).'.'.$this->outputType;

        if($this->service->render($link,$path))
        {
            return $path;
        }

        $this->error('二维码生成失败');
    }

    protected function getFielName(string $unique)
    {
        return md5($unique).time();
    }
}