<?php

/*
 * This file is part of the seaony/wangeditor.
 *
 * (c) seaony <seaony@seaony.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Seaony\WangEditor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;

class WangEditorController extends Controller
{

    /**
     * Processing upload files
     *
     * @param Request $request            
     * @return string
     */
    public function serve(Request $request)
    {
        $res = [
            'errno' => 9999,
            'data' => [],
            'info' => '上传图片失败，原因为：非法传参'
        ];
        
        if ($request->hasFile('ChooseFile')) {
            $files = $request->file('ChooseFile');
            
            $maxCount = config('wangeditor.uploadImgMaxLength', 5);
            
            if (count($files) > $maxCount) {
                $res = array_replace([
                    'info' => '上传图片失败，原因为：一次性最多可上传 ' . $maxCount . ' 张图片'
                ], $res);
            } else {
                
                
                $data = $request->all();
                $rules = [
                    'ChooseFile.*'    => 'mimes:jpeg,png,gif|max:5120',
                ];
                $messages = [
                    'ChooseFile.*.required' => '必须传入文件',
                    'ChooseFile.*.mimes'    => '文件类型不允许,请上传常规的图片(jpg、png、gif)文件',
                    'ChooseFile.*.max'      => '文件过大,文件大小不得超出5MB',
                ];
                $validator = Validator::make($data, $rules, $messages);
                
                
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->passes()) {
                    $_data = [];
                    foreach ($files as $file) {
                        
                        if ($file->isValid()) {
                            $storage = Storage::disk(config('wangeditor.upload.disk', 'public'));
                            $result = $storage->url($storage->put(config('wangeditor.upload.path', 'uploads/images'), $file));
                            $_data[] = $result;
                        }
                        
                    }
                    $res = [
                        'errno' => 0,
                        'data' => $_data,
                    ];
                } else {
                    $res = array_replace(['info' => $validator->messages()->first()], $res);
                }
                
             
            }
        }
        
        return $res;
    }
}