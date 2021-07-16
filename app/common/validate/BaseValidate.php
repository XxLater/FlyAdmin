<?php
declare(strict_types=1);

namespace app\common\validate;

use think\Validate;
/**
 * @author echo
 * @email  945462788@qq.com
 * @github https://github.com/945462788
 */

 class BaseValidate extends Validate
 {
     public function sceneQuick()
     {
        $field = $this->request->param('field',null);

        if($field)
        {
            return $this->only([$field]);
        }
     }
 }