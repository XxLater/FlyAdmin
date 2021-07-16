<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/


namespace app\common\service\utils;


use app\common\model\system\AttachmentModel;
use app\common\service\BaseService;
use app\common\validate\AttachmentValidate;
use think\File;
use think\Filesystem;
use think\exception\ValidateException;

class UploadService extends BaseService
{
    private $fileService;

    protected $model;
    
    const FILEEXTDEFAULT = 'jpg,gif,png,jpeg,xls,xlsx,doc,pdf,mp4,txt,zip,ico';

    const FILESIZE = 20;

    public function __construct(AttachmentModel $model , AttachmentValidate $validate)
    {
        $this->fileService = app()->make(Filesystem::class);

        $this->model = $model;

        $this->validate = $validate;
    }

    protected function check(File $file)
    {
        [$fileSize,$fileExt] = system_config([['file_size',self::FILESIZE],['file_ext',self::FILEEXTDEFAULT]]);

        $fileSize = $fileSize * 1024 * 1024;

        try {
            validate(['file'=>"fileSize:{$fileSize}|fileExt:{$fileExt}"])->check(['file'=>$file]);
        }catch (ValidateException $e)
        {
            $this->error($e->getMessage());
        }
    }

    /**
     * 检验文件是否存在
     * @param File $file
     * @return mixed
     */
    protected function has(File $file)
    {
        return $this->model->md5ByFile($file->md5());
    }

    /**
     * 本地上传图片
     * @param File $image
     * @return mixed
     * @throws \app\common\exception\ServiceException
     */
    public function localUploadImage(File $image)
    {
        $this->check($image);

        $domain = env('app.domain',request()->domain());

        if ($has = $this->has($image)) return $has;

        $savename = $this->fileService->putFile('upload',$image,'md5');

        if ($savename)
        {
            $data['path'] = $domain.'/'.$savename;

            $data['md5']  = $image->md5();

            $data['name'] = $image->getOriginalName();

            $data['type'] = 1;

            if($this->createData('local_create',$data))
            {
                return $this->has($image);
            }

            return false;
        }

        $this->error('文件上传失败');
    }
}