<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $wangEditorFile = $request->file('wangEditorFile');
        if ($file) {
            $info = $file->move('uploads');

            if ($info) {
//                $this->result('/qzwechat/public'.$info->getPathname(), 1, "上传成功");
                return back(1, '上传成功', '/qzwechat/public/'.$info->getPathname());
            } else {
//                $this->result('/qzwechat/public/'.$info->getPathname(), 0, "上传失败");
//                return back(0, '上传失败', __STATIC__.$info->getPathname());
                return back(0, '上传失败', '/qzwechat/public/'.$info->getPathname());
            }

        } elseif($wangEditorFile) {
            $info = $wangEditorFile->move('uploads');

            if ($info) {
                echo 'http://localhost/singwao2o/public/'.$info->getPathname();
            } else {
                echo '上传失败';
            }
        }
    }
}
