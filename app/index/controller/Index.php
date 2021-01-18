<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/
namespace app\index\controller;


use app\BaseController;
use app\common\service\system\AnnotationService;

class Index extends BaseController
{
    public function index()
    {
        $annotationService = AnnotationService::create(app()->getAppPath().'controller');
        $node = $annotationService->getMethod();
        p($annotationService->getMenu($node));


    }
}