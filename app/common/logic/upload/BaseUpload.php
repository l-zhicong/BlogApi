<?php
/**
 * author 梁智聪
 * Date: 2021/5/6
 * Time: 11:23
 * comment:文件说明
 */

/**
 * Class BaseUpload
 * @package app\common\logic\upload
 * author:梁智聪
 * time:11:23
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\logic\upload;

use think\facade\Config;

abstract class BaseUpload
{

    /**
     * 图片信息
     */
    protected $fileInfo;

    /**
     * 验证配置
     */
    protected $validate;

    /**
     * 保存路径
     */
    protected $path = '';

    /**
     * 输入的路径
     * @var string
     */
    protected $topath = '';


    /**
     * 上传文件路径
     * @param string $path
     * @return $this
     */
    public function to(string $path)
    {
        $this->path = '../public/uploads/'.$path;
        $this->topath = $path;
        return $this;
    }

    /**
     * 获取文件信息
     * @return array
     */
    public function getFileInfo()
    {
        return $this->fileInfo;
    }

    protected function checkUploadUrl(string $url)
    {
        if ($url && strstr($url, 'http') === false) {
            $url = 'http://' . $url;
        }
        return $url;
    }

    /**
     * 获取系统配置
     * @return mixed
     */
    protected function getConfig()
    {
        $config = Config::get('upload.upload');
        return $config;
    }

    /**
     * 是否获取系统配置
     * null为系统配置
     * @return
     */
    public function validate(array $validate = null)
    {
        if (is_null($validate)) {
            $validate = $this->getConfig();
        }
        $this->validate = $validate;
        return $this;
    }

    /**
     * 提取文件名
     * @param string $path
     * @param string $ext
     * @return string
     */
    protected function saveFileName($path = null, $ext = 'jpg')
    {
        return ($path ? substr(md5($path), 0, 5) : '') . date('YmdHis') . rand(0, 9999) . '.' . $ext;
    }

    /**
     * 获取文件类型和大小
     * @param string $url
     * @param bool $isData
     * @return array
     */
    protected function getFileHeaders(string $url, $isData = true)
    {
        stream_context_set_default(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
        $header['size'] = 0;
        $header['type'] = 'image/jpeg';
        if (!$isData) {
            return $header;
        }
        try {
            $headerArray = get_headers(str_replace('\\', '/', $url), true);
            if (!isset($headerArray['Content-Length'])) {
                $header['size'] = 0;
            }
            if (!isset($headerArray['Content-Type'])) {
                $header['type'] = 'image/jpeg';
            }
            if (is_array($headerArray['Content-Length']) && count($headerArray['Content-Length']) == 2) {
                $header['size'] = $headerArray['Content-Length'][1];
            }
            if (is_array($headerArray['Content-Type']) && count($headerArray['Content-Type']) == 2) {
                $header['type'] = $headerArray['Content-Type'][1];
            }
        } catch (\Exception $e) {
        }
        return $header;
    }

    /**
     * 获取上传信息
     * @return array
     */
    public function getUploadInfo()
    {
        if (isset($this->fileInfo['info'])) {
            if (strstr($this->fileInfo['path'], 'http') === false) {
                $url = request()->domain() . $this->fileInfo['path'];
            } else {
                $url = $this->fileInfo->filePath;
            }
            $headers = $this->getFileHeaders($url);
            return [
                'name' => $this->fileInfo['name'],
                'size' => $headers['size'] ?? 0,
                'type' => $headers['type'] ?? 'image/jpeg',
                'dir' => $this->fileInfo['path'],
                'time' => time(),
            ];
        } else {
            return [];
        }
    }

    /**
     * 文件上传
     * @return mixed
     */
    abstract public function move($file = 'file');

    /**
     * 文件流上传
     * @return mixed
     */
    abstract public function stream($fileContent, $key = null);

    /**
     * 删除文件
     * @return mixed
     */
    abstract public function delete($filePath);

    /**
     * 实例化上传
     * @return mixed
     */
//    abstract protected function app();

}