<?php
/**
 * author 梁智聪
 * Date: 2021/5/6
 * Time: 11:08
 * comment:文件说明
 */

/**
 * Class Local
 * @package app\common\logic\upload\storage
 * author:梁智聪
 * time:11:08
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\logic\upload\storage;

use app\common\logic\upload\BaseUpload;
use think\File;

class Local extends BaseUpload
{
    /**
     * 默认存放路径
     * @var string
     */
    protected $defaultPath;

    /**
     * 生成上传文件目录
     * @param $path
     * @param null $root
     * @return string
     */
    protected function uploadDir($path, $root = null)
    {
        if ($root === null) $root = app()->getRootPath() . 'public' . DS;
        return str_replace('\\', '/', $root . 'uploads/local/' . DS . $path);
    }

    /**
     * 检查上传目录不存在则生成
     * @param $dir
     * @return bool
     */
    protected function validDir($dir)
    {
        return is_dir($dir) == true || mkdir($dir, 0777, true) == true;
    }

    /**
     * 文件上传
     * @param string $file
     * @return array|bool|mixed|\StdClass
     */
    public function move($file = 'file')
    {
        $fileHandle = request()->file('files');
        if (!$fileHandle) {
            E('没有要上传的文件');
        }
        $fileInfo = $fileHandle->move($this->path);
        if (!$fileInfo)E($fileHandle->getExtension());
        $this->fileInfo['name'] = $fileInfo->getFilename();
        $this->fileInfo['info'] = $fileInfo->getFileInfo();
        $this->fileInfo['getMime'] = $fileInfo->getMime();
        $this->fileInfo['md5'] = $fileInfo->md5();
        $this->fileInfo['sha1'] = $fileInfo->sha1();
        $this->fileInfo['path'] =str_replace('\\', '/', '/uploads/local/'.$fileInfo->getFilename());
        return $this->fileInfo;
    }


    public function stream($fileContent,  $key = null)
    {
        if (!$key) {
            $key = $this->saveFileName();
        }
        $dir = $this->path;
        if (!$this->validDir($dir)) {
            E('Failed to generate upload directory, please check the permission!');
        }
        $fileName = $dir . '/' . $key;
        file_put_contents($fileName, $fileContent);
        $this->fileInfo['uploadInfo'] = new File($fileName);
        $this->fileInfo['fileName'] = $key;
        $this->fileInfo['filePath'] = '/uploads/'.$this->topath.'/'. $key;
        return $this->fileInfo;
    }

    /**
     * 删除文件
     * @param string $filePath
     * @return bool|mixed
     * @throws
     */
    public function delete($filePath)
    {

    }
}