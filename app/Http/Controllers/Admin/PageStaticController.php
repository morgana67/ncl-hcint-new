<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;
class PageStaticController extends Controller
{
    protected $errorsMessage;
    protected $hasError = false;
    protected $validateField;
    protected $data;

    public function __construct(Request $request)
    {
        $this->validateField = [
            'title' => 'required',
            'slug' => 'required|unique:pages,slug,'.($request->code ?? null).',code_page',
        ];
    }

    public function index()
    {
        $pages = Page::withoutGlobalScopes()->PageStatic()->paginate(10);
        return view('admin.page-static.index', compact('pages'));
    }

    public function detail(Request $request, $code = null)
    {
        $page = Page::withoutGlobalScopes()->where('code_page', $code)->firstOrFail();
        if ($request->isMethod('POST')) {
            switch ($code) {
                case 'home':
                    $this->prepareHome($request,$page);
                    break;
                case 'faq' :
                    $this->prepareFaq($request);
                    break;
                case 'how-to-order' :
                    $this->prepareHowToOrder($request,$page);
                    break;
                case 'about-us' :
                    $this->prepareAboutUs($request,$page);
                    break;
                default:
                    $this->prepareDefault($request);
                    break;
            }
            if($this->hasError == true){
                return redirect()->back()->withInput($request->all())->withErrors($this->errorsMessage);
            }
            Page::withoutGlobalScopes()->where(['code_page' => $code])->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
                'body' => $this->data,
            ]);
            return redirect()->route('admin.page-static.index')->with([
                'message'    =>  "Successfully Update Page",
                'alert-type' => 'success',
            ]);
        } else {
            return view('admin.page-static.detail', compact('page'));
        }
    }

    public function prepareHome($request,$page)
    {
        $data = $request->except('_token','title','slug','meta_description','meta_keywords');
        $decodeBody = json_decode($page->body);
        $this->validateField['banner'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $this->validateField['img_icon_1_section1'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $this->validateField['img_icon_2_section1'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $this->validateField['img_icon_3_section1'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $this->validateField['image_section3'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $this->validateField['image_section4'] = 'mimes:jpeg,jpg,png,gif|max:10000';

        $validator = Validator::make($request->all(), $this->validateField);
        if ($validator->fails()) {
            $this->hasError = true;
            $this->errorsMessage = $validator->errors();
        }

        if($request->hasFile('banner')){
            $image = uploadFile('/page_static/home','banner');
            $data['banner'] = $image;
        }else{
            $data['banner'] = $decodeBody->banner ?? null;
        }

        if($request->hasFile('img_icon_1_section1')){
            $image = uploadFile('/page_static/home','img_icon_1_section1');
            $data['img_icon_1_section1'] = $image;
        }else{
            $data['img_icon_1_section1'] = $decodeBody->img_icon_1_section1 ?? null;
        }

        if($request->hasFile('img_icon_2_section1')){
            $image = uploadFile('/page_static/home','img_icon_2_section1');
            $data['img_icon_2_section1'] = $image;
        }else{
            $data['img_icon_2_section1'] = $decodeBody->img_icon_2_section1 ?? null;
        }

        if($request->hasFile('img_icon_3_section1')){
            $image = uploadFile('/page_static/home','img_icon_3_section1');
            $data['img_icon_3_section1'] = $image;
        }else{
            $data['img_icon_3_section1'] = $decodeBody->img_icon_3_section1 ?? null;
        }


        if($request->hasFile('image_section3')){
            $image = uploadFile('/page_static/home','image_section3');
            $data['image_section3'] = $image;
        }else{
            $data['image_section3'] = $decodeBody->image_section3 ?? null;
        }

        if($request->hasFile('image_section4')){
            $image = uploadFile('/page_static/home','image_section4');
            $data['image_section4'] = $image;
        }else{
            $data['image_section4'] = $decodeBody->image_section4 ?? null;
        }

        for($i=1; $i <= 8; $i ++) {
            if($request->hasFile("image_{$i}_section5")) {
                $image = uploadFile('/page_static/home',"image_{$i}_section5", ['width' => "200"]);
                $data["image_{$i}_section5"] = $image;
            } else {
                $imageName = "image_{$i}_section5";
                $data["image_{$i}_section5"] = $decodeBody->$imageName ?? null;
            }

        }

        $this->data = json_encode($data);

    }

    public function prepareFaq($request){
        $data = $request->except('_token','title','slug','meta_description','meta_keywords');
        $validator = Validator::make($request->all(), $this->validateField);
        if ($validator->fails()) {
            $this->hasError = true;
            $this->errorsMessage = $validator->errors();
            return;
        }
        $this->data = json_encode($data);
    }

    public function prepareHowToOrder($request,$page){
        $data = $request->except('_token','title','slug','meta_description','meta_keywords');
        $decodeBody = json_decode($page->body);
        $this->validateField['detail.*.title_step'] = 'required';
        $this->validateField['detail.*.content_step'] = 'required';
        $this->validateField['detail.*.image_step'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $validator = Validator::make($request->all(), $this->validateField);
        if ($validator->fails()) {
            $this->hasError = true;
            $this->errorsMessage = $validator->errors();
            return;
        }

        if($request->hasFile('banner')){
            $image = uploadFile('/page_static/how-to-order','banner');
            $data['banner'] = $image;
        }else{
            $data['banner'] = $decodeBody->banner ?? null;
        }
        if(!empty($request->detail)){
            foreach($request->detail as $key  => $detail){
                if(!empty($detail['image_step'])){
                    $file     = $detail['image_step'];
                    $fileName = 'image_step'.$key.'.'.$file->getClientOriginalExtension();
                    $data['detail'][$key]['image_step'] = Storage::disk(config('voyager.storage.disk'))->putFileAs('/page_static/how-to-order',$file,$fileName);
                }else{
                    $data['detail'][$key]['image_step'] = $decodeBody->detail[$key]->image_step ?? null;
                }
            }
        }
        $this->data = json_encode($data);
    }

    public function prepareAboutUs($request,$page){
        $data = $request->except('_token','title','slug','meta_description','meta_keywords');
        $decodeBody = json_decode($page->body);
        $this->validateField['banner'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $this->validateField['img_icon_1_section1'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $this->validateField['img_icon_2_section1'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $this->validateField['img_icon_3_section1'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        $this->validateField['image_section2'] = 'mimes:jpeg,jpg,png,gif|max:10000';

        $validator = Validator::make($request->all(), $this->validateField);
        if ($validator->fails()) {
            $this->hasError = true;
            $this->errorsMessage = $validator->errors();
            return;
        }

        if($request->hasFile('banner')){
            $image = uploadFile('/page_static/about-us','banner');
            $data['banner'] = $image;
        }else{
            $data['banner'] = $decodeBody->banner ?? null;
        }

        if($request->hasFile('img_icon_1_section1')){
            $image = uploadFile('/page_static/about-us','img_icon_1_section1');
            $data['img_icon_1_section1'] = $image;
        }else{
            $data['img_icon_1_section1'] = $decodeBody->img_icon_1_section1 ?? null;
        }

        if($request->hasFile('img_icon_2_section1')){
            $image = uploadFile('/page_static/about-us','img_icon_2_section1');
            $data['img_icon_2_section1'] = $image;
        }else{
            $data['img_icon_2_section1'] = $decodeBody->img_icon_2_section1 ?? null;
        }

        if($request->hasFile('img_icon_3_section1')){
            $image = uploadFile('/page_static/about-us','img_icon_3_section1');
            $data['img_icon_3_section1'] = $image;
        }else{
            $data['img_icon_3_section1'] = $decodeBody->img_icon_3_section1 ?? null;
        }

        if($request->hasFile('image_section2')){
            $image = uploadFile('/page_static/about-us','image_section2');
            $data['image_section2'] = $image;
        }else{
            $data['image_section2'] = $decodeBody->image_section2 ?? null;
        }
        $this->data = json_encode($data);
    }

    public function prepareDefault($request){
        $data = $request->except('_token','title','slug','meta_description','meta_keywords');
        $validator = Validator::make($request->all(), $this->validateField);
        if ($validator->fails()) {
            $this->hasError = true;
            $this->errorsMessage = $validator->errors();
            return;
        }
        $this->data = $data['body'];
    }

}
