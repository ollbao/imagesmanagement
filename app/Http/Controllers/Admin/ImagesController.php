<?php

namespace App\Http\Controllers\Admin;

use App\Library\Y;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\FileUploadHandler;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\DownloadHistories;
use Intervention\Image\Facades\Image as ImagesHandle;
use Illuminate\Support\Facades\Storage;
use App\Library\JiebaTokenizer;


class ImagesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $images = Image::with('admin')->orderBy('id','desc')->paginate(intval($request->post('limit', 10)));
            
            return view('admin.images.index_list', compact('images'));
        } else {
            return view('admin.images.index');
        }

    }

    /**
     * 功能2的开发步骤1
     * 功能1的开发步骤2
     * 测试bug1
     * 测试bug2
     *
     * @param Request $request
     * @return void
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {//dd($request->file('image')->getClientOriginalName());exit;
            
            $uplodeFile = $request->file('image');
            if(!$uplodeFile){
                return Y::error('请上传图片');
            }
            $post  = $request->post();
            $fileName = str_replace(["."," ","["], "_", $uplodeFile->getClientOriginalName());//php会自动把文件名中的点空格转换成下划线
            $data = json_decode($post[$fileName], true);
            $messages = [
                'image_source.required' => '来源必填.',
                'source_link.required' => '来源链接必填.',
                'source_link.url' => '来源链接格式错误.',
                'description.required' => '描述必填.',
            ];
            $validator = Validator::make($data, [
                'description' => 'required',
                'image_source' => 'required',
                'source_link' => 'required|url',
            ], $messages);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            
            $imageInfo = FileUploadHandler::store($uplodeFile, 200, true, true, 'images');
            
            $image = new Image();
            $image->fill($data);
            $image->admin_id = Auth::id();
            $image->show_url = $imageInfo['url'];
            $image->down_path = $imageInfo['store'];
    
            $image->save();
            return Y::success('上传成功',['show_url'=>$imageInfo['url']]);
        } else {
            return view('admin.images.add');
        }
    }

    //修改
    public function edit(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        if ($request->isMethod('post')) {
            $post      = $request->post();
            $messages = [
                'description.required' => '请填写图片描述.',
                'image_source.required' => '请填写图片来源',
                'source_link.required' => '请填写来源链接.',
            ];
            $validator = Validator::make($post, [
                'description' => 'required',
                'image_source' => 'required',
                'source_link' => 'required|url',
            ], $messages);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            $image->fill($request->all())->save();
            return Y::success('更新成功');
        } else {
            return view('admin.images.edit', compact('image'));
        }
    }

    //删除
    public function delete($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();
        //删除原图
        Storage::delete($image->down_path);
        return Y::success('删除成功');
    }

    public function list(Request $request)
    {
        if($request->tag){
            // $jiebaTokenizer = new JiebaTokenizer();
            // $str = str_replace(["，","。","、","（","）"], ' ', $request->tag);
            // //echo $str;exit;
            // echo  dd($jiebaTokenizer->cut($str));
            $images = Image::search($request->tag)->paginate(20);
        }else{
            $images = Image::orderBy('id','desc')->paginate(20);
        }
        if($request->ajax()){
            return $images->toJson();
        }else{
            $pageUrl = $request->fullUrl().(Str::contains($request->fullUrl(), '?') ? '&' : '?').'page=1';
            return view('admin.images.list', compact('images','pageUrl'));
        }
    }

    public function down(Request $request)
    {
        if ($request->post('id')) {
            $id = $request->post('id');
            $image = Image::findOrFail($id);
            //$request->session()->flash('status', 'Task was successful!');
            $downloadHistory = new DownloadHistories();
            $downloadHistory->fill($request->all());
            $downloadHistory->image_id = $id;
            $downloadHistory->admin_name = Auth::user()->username;
            $downloadHistory->save();
            return response()->download(storage_path('app/'.$image->down_path));
        } else {
            return view('admin.images.down');
        }
    }

    public function history(Request $request)
    {
        if ($request->isMethod('post')) {
            $downloadHistories = DownloadHistories::with('image')->orderBy('id','desc')->paginate(intval($request->post('limit', 10)));
            return view('admin.images.history_list', compact('downloadHistories'));
        } else {
            return view('admin.images.history');
        }
    }
}
