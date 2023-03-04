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
<div class="col-md-12">
    <h4>Detail</h4>
</div>
<div class="clearfix"></div>
<div class="repeater">
    <div data-repeater-list="detail">
        @if(!empty($body->detail))
            @foreach($body->detail as $detail)
                <div data-repeater-item>
                    <div class="col-md-2 form-group">
                        <label class="control-label" for="title_step">Title Step</label>
                        <input class="form-control" name="title_step" id="content_step" value="{{$detail->title_step ?? null}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="control-label" for="content_step">Content Step</label>
                        <textarea class="form-control" name="content_step" id="content_step">{{$detail->content_step ?? null}}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label" for="image_step">Image Step</label>
                        <input type="file" class="form-control" name="image_step">
                        @if(!empty($detail->image_step))
                            <img src="{{image($detail->image_step)}}" class="img-responsive" alt="">
                        @endif
                    </div>
                    <div class="col-md-2">
                        <input data-repeater-delete class="btn btn-danger" type="button" value="Delete"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endforeach
        @else
            <div data-repeater-item>
                <div class="col-md-2 form-group">
                    <label class="control-label" for="title_step">Title Step</label>
                    <input class="form-control" name="title_step" id="content_step" value="">
                </div>
                <div class="col-md-4 form-group">
                    <label class="control-label" for="content_step">Content Step</label>
                    <textarea class="form-control" name="content_step" id="content_step"></textarea>
                </div>
                <div class="col-md-4">
                    <label class="control-label" for="image_step">Image Step</label>
                    <input type="file" class="form-control" name="image_step" >
                </div>
                <div class="col-md-2">
                    <input data-repeater-delete class="btn btn-danger" type="button" value="Delete"/>
                </div>
                <div class="clearfix"></div>
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <input data-repeater-create type="button" class="btn btn-success" value="Add"/>
    </div>
</div>
@section('javascript')
    <script src="{{asset('front/plugin/repeaterJs/jquery.repeater.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.repeater').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                    $('.img-responsive').last().remove();
                },
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: true
            })
        });

    </script>
@stop
