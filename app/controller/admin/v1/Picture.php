<?php
namespace app\controller\admin\v1;

use app\common\Base\AdminBaseController;
use app\common\logic\upload\Upload;
use think\facade\Cache;
use think\facade\Request;


class Picture extends AdminBaseController
{
    protected function initialize()
    {
        // TODO: Implement initialize() method.
    }

    /**
     * 图片上传
     * @param Request $request
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function upload()
    {
        $sys_imguploads = config('upload.sys_imguploads');
        $data = request()->file('files');
        if (!$data) return $this->fail('参数有误');
//        $user_type = input('user_type',1);
//        if (Cache::has('start_uploads_'. $user_type. '_' . $uid) && Cache::get('start_uploads_'. $user_type. '_' . $uid) >= $sys_imguploads['frequency'])
//        {
//            return $this->fail("非法操作");
//        }
        $upload = new Upload(1);//选择本地上传
        $validate = config('upload.local');
        $upload->to('local')->validate($validate)->move("files");
        $res = $upload->getUploadInfo();
//        if (Cache::has('start_uploads_'. $user_type. '_' . $uid))
//            $start_uploads = (int)Cache::get('start_uploads_'. $user_type. '_' . $uid);
//        else
//            $start_uploads = 0;
//        $start_uploads++;
//        Cache::set('start_uploads_'. $user_type. '_' . $uid, $start_uploads, $sys_imguploads['time']);
        return $this->success(['name' => $res['name'], 'url' => $res['dir']],'图片上传成功!');
    }
}

