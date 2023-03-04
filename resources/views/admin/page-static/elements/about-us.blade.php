<div class="form-group col-md-12 ">
    <label class="control-label" for="name">Title</label>
    <input required="" type="text" class="form-control" name="title" placeholder="Title"
           value="{{old('title',$page->title)}}">
</div>

<div class="form-group col-md-12 ">
    <label class="control-label" for="name">Slug</label>
    <input required="" type="text" class="form-control" name="slug" placeholder="Slug"
           data-slug-origin="title" value="{{old('slug',$page->slug)}}">
</div>

<div class="form-group col-md-12 ">
    <label class="control-label" for="name">Meta Keywords</label>
    <input type="text" class="form-control" name="meta_keywords" placeholder="Meta Keywords"
           value="{{old('meta_keywords',$page->meta_keywords)}}">
</div>

<div class="form-group col-md-12 ">
    <label class="control-label" for="name">Meta Description</label>
    <input type="text" class="form-control" name="meta_description"
           placeholder="Meta Description"
           value="{{old('meta_description',$page->meta_description)}}">
</div>

<div>
    <div class="form-group col-md-12">
        <label class="control-label" for="content_banner">Description Banner</label>
        <textarea type="text" class="form-control" rows="6" name="desc_banner"
               placeholder="Description Banner">{{old('desc_banner',$body->desc_banner ?? null)}}</textarea>
    </div>
    <div class="form-group col-md-12">
        <label class="control-label" for="name">Banner</label>
        <input type="file" name="banner" value="{{old('banner',$body->banner ?? null)}}">
        @if(!empty($body->banner))
            <img src="{{image($body->banner)}}" alt="">
        @endif
    </div>
    <div class="form-group col-md-12">
        <h4>Section 1</h4>
        <label class="control-label" for="content_banner">Description</label>
        <textarea type="text" class="form-control richTextBox" name="desc_section1"
                  placeholder="Desc">{{old('desc_section1',$body->desc_section1 ?? null)}}</textarea>
    </div>

    <div>
        <div class="form-group col-md-4">
            <label class="control-label" for="title_icon_1_section1">Title icon 1</label>
            <input type="text" class="form-control" name="title_icon_1_section1"
                   placeholder="Title"
                   value="{{old('title_icon_1_section1',$body->title_icon_1_section1 ?? null)}}">
        </div>
        <div class="form-group col-md-4">
            <label class="control-label" for="desc_icon_1_section1">Desc icon 1</label>
            <textarea type="text" class="form-control" name="desc_icon_1_section1"
                      placeholder="Desc">{{old('desc_icon_1_section1',$body->desc_icon_1_section1 ?? null)}}</textarea>
        </div>
        <div class="form-group col-md-4">
            <label class="control-label" for="img_icon_1_section1">Icon</label>
            <input type="file" style="padding: 7px;" name="img_icon_1_section1"
                   class="form-control"
                   value="{{old('img_icon_1_section1',$body->img_icon_1_section1 ?? null)}}">
            @if(!empty($body->img_icon_1_section1))
                <img class="img-responsive" src="{{image($body->img_icon_1_section1)}}" alt="">
            @endif
        </div>
    </div>
    <div class="clearfix"></div>
    <div>
        <div class="form-group col-md-4">
            <label class="control-label" for="title_icon_2_section1">Title icon 2</label>
            <input type="text" class="form-control" name="title_icon_2_section1"
                   placeholder="Title"
                   value="{{old('title_icon_2_section1',$body->title_icon_2_section1 ?? null)}}">
        </div>
        <div class="form-group col-md-4">
            <label class="control-label" for="desc_icon_2_section1">Desc icon 2</label>
            <textarea type="text" class="form-control" name="desc_icon_2_section1"
                      placeholder="Desc">{{old('desc_icon_2_section1',$body->desc_icon_2_section1 ?? null)}}</textarea>
        </div>
        <div class="form-group col-md-4">
            <label class="control-label" for="img_icon_2_section1">Icon</label>
            <input type="file" style="padding: 7px;" name="img_icon_2_section1"
                   class="form-control"
                   value="{{old('img_icon_2_section1',$body->img_icon_2_section1 ?? null)}}">
            @if(!empty($body->img_icon_2_section1))
                <img class="img-responsive" src="{{image($body->img_icon_2_section1)}}" alt="">
            @endif
        </div>
    </div>
    <div class="clearfix"></div>
    <div>
        <div class="form-group col-md-4">
            <label class="control-label" for="title_icon_3_section1">Title icon 3</label>
            <input type="text" class="form-control" name="title_icon_3_section1"
                   placeholder="Title"
                   value="{{old('title_icon_3_section1',$body->title_icon_3_section1 ?? null)}}">
        </div>
        <div class="form-group col-md-4">
            <label class="control-label" for="desc_icon_3_section1">Desc icon 3</label>
            <textarea type="text" class="form-control" name="desc_icon_3_section1"
                      placeholder="Desc">{{old('desc_icon_3_section1',$body->desc_icon_3_section1 ?? null)}}</textarea>
        </div>
        <div class="form-group col-md-4">
            <label class="control-label" for="img_icon_3_section1">Icon</label>
            <input type="file" style="padding: 7px;" name="img_icon_3_section1"
                   class="form-control"
                   value="{{old('img_icon_3_section1',$body->img_icon_3_section1 ?? null)}}">
            @if(!empty($body->img_icon_3_section1))
                <img class="img-responsive" src="{{image($body->img_icon_3_section1)}}" alt="">
            @endif
        </div>
    </div>
    <hr>

    <div class="form-group col-md-12">
        <h4>Section 2</h4>
        <label class="control-label" for="name">Link</label>
        <input type="text" class="form-control" name="link_section2"
               placeholder="Title"
               value="{{old('link_section2',$body->link_section2 ?? null)}}">
    </div>
    <div class="form-group col-md-12">
        <label class="control-label" for="content_banner">Description</label>
        <textarea name="desc_section2" class="form-control" id="desc_section2" cols="20"
                  rows="5">{{old('desc_section2',$body->desc_section2 ?? null)}}</textarea>
    </div>
    <div class="form-group col-md-12">
        <input type="file" name="image_section2"
               value="{{old('image_section2',$body->image_section2 ?? null)}}">
        @if(!empty($body->image_section2))
            <img src="{{image($body->image_section2)}}" alt="">
        @endif
    </div>
</div>
