<?php

namespace App\Library;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class FileUploadHandler
{
    /**
     * 文件保存
     *
     * @param UploadedFile $file Illuminate\Http\UploadedFile
     * @param int $maxWith 裁剪最大宽度-裁剪图片类型文件 
     * @param boolean $public 是否可以公开访问
     * @param boolean $original 是否保存原件
     * @param str $foldeName 目录名称
     * @return array
     */
    public static function store(UploadedFile $file, $maxWith = null, $public = true, $original = false, $folderName = 'file')
    {
        $folderName .= '/'.date('Ym');
        if ($public) {
            $filePath = $file->store($folderName, 'public');
        } 
        if($original){
            $file->store($folderName);
        }

        
        //文件url路径
        $urlPath = Storage::url($filePath);
        

        //获取文件扩展名
        $extension = strtolower($file->getClientOriginalExtension());
        // 如果限制了图片宽度，就进行裁剪
        if ($maxWith && $extension != 'gif') {
            //文件保存路径(外部可访问)
            $storePath = config('filesystems.disks.public.root').'/'.$filePath;
            //此类中封装的函数，用于裁剪图片
            self::reduceSize($storePath, $maxWith);
        }

        return [
            'store' => $filePath,
            'url' => $urlPath
        ];
        
    }

    /**
     * 裁剪图片
     *
     * @param string 图片路径
     * @param int 裁剪最大宽度
     * @return void
     */
    public static function reduceSize($filePath, $maxWith)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($filePath);

        // 进行大小调整的操作
        $image->resize($maxWith, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}