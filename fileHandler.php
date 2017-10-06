<?php
namespace FH;

class fileHandler
{
    private $file;
    private $fileName;
    private $fileSize;
    private $fileExtension;

    //实例化文件处理
    public function __construct($file,$fileName = null)
    {
        $this->file = $file;
        //如果没传文件名参数，不修改文件名
        if ($fileName === null)
            $this->fileName = substr($file["name"],0,strpos($file["name"],"."));
        else
            $this->fileName = $fileName;
        //计算文件大小，单位kb，四舍五入保留一位小数
        $this->fileSize = round($file["size"]/1024,1);
        $this->fileExtension = substr($file["name"],strpos($file["name"],"."));
    }

    //移动文件，当文件已存在并且第二个参数不为0 时，强制上传覆盖原文件
    public function move_to($path,$force = 0){
        $path = $path . "/" . $this->fileName . $this->fileExtension;
        if (file_exists($path) && $force === 0)
            return false;
        return move_uploaded_file($this->file["tmp_name"],$path);
    }

    //返回文件信息
    public function getFileInfo(){
        return
            json_encode([
                "文件名" => $this->fileName,
                "文件大小" => $this->fileSize . "kb",
                "文件后缀" => $this->fileExtension
            ],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }


    //返回文件名称
    public function getFileName(){
        return $this->fileName;
    }

    //设置文件名称
    public function setFileName($fileName){
        $this->fileName = $fileName;
    }

    //返回文件大小
    public function getFileSize()
    {
        return $this->fileSize;
    }

    //返回文件后缀名
    public function getFileExtension()
    {
        return $this->fileExtension;
    }


}