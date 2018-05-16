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

class ImagesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $images = Image::with('admin')->orderBy('id','desc')->paginate(20);
            return view('admin.images.index_list', compact('images'));
        } else {
            return view('admin.images.index');
        }
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $post  = $request->post();
            $messages = [
                'required' => '请填写图片标签.',
            ];
            $validator = Validator::make($post, [
                'tag' => 'required'
            ], $messages);
            if ($validator->fails()) {
                return Y::error($validator->errors());
            }
            if(!$request->image){
               return Y::error('请上传图片');
            }
            $imageInfo = FileUploadHandler::store($request->file('image'), null, true, true, 'images');
            
            $image = new Image();
            $image->fill($request->all());
            $image->admin_id = Auth::id();
            $image->show_url = $imageInfo['url'];
            $image->down_path = $imageInfo['storeOriginalPath'];
    
            $image->save();
            return Y::success('上传成功');
        } else {
            return view('admin.images.add');
        }
    }

    public function list(Request $request)
    {
        
        if($request->ajax()){
            if($request->tag){
                $images = Image::search($request->tag)->paginate(10);
            }else{
                $images = Image::orderBy('id','desc')->paginate(10);
            }
            return $images->toJson();
        }else{
            $pageUrl = $request->fullUrl().(Str::contains($request->fullUrl(), '?') ? '&' : '?').'page=1';
            return view('admin.images.list', compact('pageUrl'));
        }
    }

    public function down(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        if ($request->isMethod('post')) {
            //$request->session()->flash('status', 'Task was successful!');
            $downloadHistory = new DownloadHistories();
            $downloadHistory->fill($request->all());
            $downloadHistory->image_id = $id;
            $downloadHistory->admin_name = Auth::user()->username;
            $downloadHistory->save();
            return response()->download($image->down_path);
        } else {
            return view('admin.images.down', compact('image'));
        }
    }

    public function history(Request $request)
    {
        if ($request->isMethod('post')) {
            $downloadHistories = DownloadHistories::with('image')->orderBy('id','desc')->paginate(20);
            return view('admin.images.history_list', compact('downloadHistories'));
        } else {
            return view('admin.images.history');
        }
    }
}
