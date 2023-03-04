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
    <label class="control-label" for="name">Meta Title</label>
    <input type="text" class="form-control" name="meta_title" placeholder="Meta Title"
           value="{{old('meta_title',$page->meta_title)}}">
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
        <h4>Banner</h4>
        <label class="control-label" for="name">Title Banner</label>
        <input type="text" class="form-control" name="title_banner"
               placeholder="Title Banner"
               value="{{old('title_banner',$body->title_banner ?? null)}}">
    </div>
    <div class="form-group col-md-12">
        <label class="control-label" for="content_banner">Description Banner</label>
        <input type="text" class="form-control" name="desc_banner"
               placeholder="Description Banner"
               value="{{old('desc_banner',$body->desc_banner ?? null)}}">
    </div>
    <div class="form-group col-md-12">
        <label class="control-label" for="name">Banner</label>
        <input type="file" name="banner" value="{{old('banner',$body->banner ?? null)}}">
        @if(!empty($body->banner))
            <img src="{{image($body->banner)}}" alt="">
        @endif
    </div>
    <div class="form-group col-md-12">
        <h4>Counter Section</h4>
        <label class="control-label" for="name">Counter Number</label>
        <input type="text" class="form-control" name="counter_number" placeholder="Counter Number"
               value="{{old('counter_number',$body->counter_number ?? 0)}}">
    </div>


    <div class="form-group col-md-12">
        <h4>Section 1</h4>
        <label class="control-label" for="name">Title</label>
        <input type="text" class="form-control" name="title_section1"
               placeholder="Title"
               value="{{old('title_section1',$body->title_section1 ?? null)}}">
    </div>
    <div class="form-group col-md-12">
        <label class="control-label" for="content_banner">Description</label>
        <input type="text" class="form-control" name="desc_section1"
               placeholder="Desc"
               value="{{old('desc_section1',$body->desc_section1 ?? null)}}">
    </div>
    <div class="form-group col-md-12">
        <label class="control-label" for="link_video">Link video (*Youtube)</label>
        <input type="text" class="form-control" name="link_video_section1"
               placeholder="Desc Banner"
               value="{{old('link_video_section1',$body->link_video_section1 ?? null)}}">
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
            <input type="text" class="form-control" name="desc_icon_1_section1"
                   placeholder="Desc"
                   value="{{old('desc_icon_1_section1',$body->desc_icon_1_section1 ?? null)}}">
        </div>
        <div class="form-group col-md-4">
            <label class="control-label" for="img_icon_1_section1">Icon</label>
            <input type="file" style="padding: 7px;" name="img_icon_1_section1"
                   class="form-control"
                   value="{{old('img_icon_1_section1',$body->img_icon_1_section1 ?? null)}}">
            @if(!empty($body->img_icon_1_section1))
                <img class="img-responsive" src="{{image($body->img_icon_1_section1)}}" alt="">
            @endif
            {{--        </div>--}}
        </div>
        <div>
            <div class="form-group col-md-4">
                <label class="control-label" for="title_icon_2_section1">Title icon 2</label>
                <input type="text" class="form-control" name="title_icon_2_section1"
                       placeholder="Title"
                       value="{{old('title_icon_2_section1',$body->title_icon_2_section1 ?? null)}}">
            </div>
            <div class="form-group col-md-4">
                <label class="control-label" for="desc_icon_2_section1">Desc icon 2</label>
                <input type="text" class="form-control" name="desc_icon_2_section1"
                       placeholder="Desc"
                       value="{{old('desc_icon_2_section1',$body->desc_icon_2_section1 ?? null)}}">
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

        <div>
            <div class="form-group col-md-4">
                <label class="control-label" for="title_icon_3_section1">Title icon 3</label>
                <input type="text" class="form-control" name="title_icon_3_section1"
                       placeholder="Title"
                       value="{{old('title_icon_3_section1',$body->title_icon_3_section1 ?? null)}}">
            </div>
            <div class="form-group col-md-4">
                <label class="control-label" for="desc_icon_3_section1">Desc icon 3</label>
                <input type="text" class="form-control" name="desc_icon_3_section1"
                       placeholder="Desc"
                       value="{{old('desc_icon_3_section1',$body->desc_icon_3_section1 ?? null)}}">
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
            <label class="control-label" for="name">Title</label>
            <input type="text" class="form-control" name="title_section2"
                   placeholder="Title"
                   value="{{old('title_section2',$body->title_section2 ?? null)}}">
        </div>
        <div class="form-group col-md-12">
            <label class="control-label" for="content_banner">Description</label>
            <textarea name="desc_section2" class="form-control" id="desc_section2" cols="20"
                      rows="5">{{old('desc_section2',$body->desc_section2 ?? null)}}</textarea>
        </div>
        <div class="form-group col-md-6">
            <label class="control-label" for="price_section2">Price</label>
            <input type="text" class="form-control" name="price_section2"
                   value="{{old('price_section2',$body->price_section2 ?? null)}}">
        </div>
        <div class="form-group col-md-6">
            <label class="control-label" for="sale_price_section2">Sale Price</label>
            <input type="text" class="form-control" name="sale_price_section2"
                   value="{{old('sale_price_section2',$body->sale_price_section2 ?? null)}}">
        </div>

        <div class="form-group col-md-12">
            <h4>Section 3</h4>
            <label class="control-label" for="name">Title</label>
            <input type="text" class="form-control" name="title_section3"
                   placeholder="Title"
                   value="{{old('title_section3',$body->title_section3 ?? null)}}">
        </div>
        <div class="form-group col-md-12">
            <label class="control-label" for="content_banner">Description</label>
            <textarea name="desc_section3" class="form-control" id="desc_section3" cols="20"
                      rows="5">{{old('desc_section3',$body->desc_section3 ?? null)}}</textarea>
        </div>
        <div class="form-group col-md-12">
            <input type="file" name="image_section3"
                   value="{{old('image_section3',$body->image_section3 ?? null)}}">
            @if(!empty($body->image_section3))
                <img src="{{image($body->image_section3)}}" alt="">
            @endif
        </div>

        <div class="form-group col-md-12">
            <h4>Section 4</h4>
            <label class="control-label" for="name">Title</label>
            <input type="text" class="form-control" name="title_section4"
                   placeholder="Title"
                   value="{{old('title_section4',$body->title_section4 ?? null)}}">
        </div>

        <div class="form-group col-md-12">
            <input type="file" name="image_section4"
                   value="{{old('image_section4',$body->image_section4 ?? null)}}">
            @if(!empty($body->image_section4))
                <img class="img-responsive" src="{{image($body->image_section4)}}" alt="">
            @endif
        </div>



        <div class="form-group col-md-12" style="margin-top: 1.5rem">
            <h4>Section 5</h4>
            <label class="control-label" for="name">Title</label>
            <input type="text" class="form-control" name="title_section5"
                   placeholder="Title"
                   value="{{old('title_section5',$body->title_section5 ?? null)}}">
        </div>

        <div class="form-group col-md-12">
            @for($i = 1; $i <= 8; $i++)
            @php $fieldName = "image_{$i}_section5" @endphp
            <div class="col-md-3" style="margin-top: 1.5rem">
                <input type="file" name="{{$fieldName}}"
                       value="{{old($fieldName,$body->$fieldName ?? null)}}">
                @if(!empty($body->$fieldName))
                    <div style="width: 200px; height: 200px; margin-top: 1rem"><img class="img-responsive" style="object-fit: contain; width: 100%" src="{{image($body->$fieldName)}}" alt=""></div>
                @endif
            </div>
            @endfor
        </div>

    </div>


</div>
