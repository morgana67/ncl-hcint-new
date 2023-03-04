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

<div class="form-group col-md-12 ">
    <label class="control-label" for="title">Content Page</label>
    <textarea name="content_page" class="richTextBox form-control" id="richTextBox" cols="30" rows="10">{{old('content_page',$body->content_page ?? null)}}</textarea>
</div>
<div class="repeater">
    <h4>Faq Detail</h4>
    <div data-repeater-list="detail">
        @if(!empty($body->detail) || !empty(old('detail')))
            @foreach(old('detail',$body->detail) as $detail)
                <div data-repeater-item style="display: flex;align-items: center">
                    <div class="col-md-5 form-group">
                        <input class="form-control" type="text" name="left_title" placeholder="Left Title" value="{{$detail->left_title ?? null}}"/>
                        <textarea class="form-control" name="left_content" id="" cols="30" rows="3" placeholder="Left Content" >{{$detail->left_content ?? null}}</textarea>
                    </div>
                    <div class="col-md-5 form-group">
                        <input class="form-control" type="text" name="right_title" placeholder="Right Title" value="{{$detail->right_title ?? null}}"/>
                        <textarea  class="form-control" name="right_content" id="" cols="30" rows="3" placeholder="Right Content">{{$detail->right_content ?? null}}</textarea>
                    </div>
                    <div class="col-md-2">
                        <input data-repeater-delete class="btn btn-danger" type="button" value="Delete"/>
                    </div>
                </div>
            @endforeach
        @else
            <div data-repeater-item style="display: flex;align-items: center">
                <div class="col-md-5 form-group">
                    <input class="form-control" type="text" name="left_title" placeholder="Left Title" value=""/>
                    <textarea class="form-control" name="left_content" id="" cols="30" rows="3" placeholder="Left Content"></textarea>
                </div>
                <div class="col-md-5 form-group">
                    <input class="form-control" type="text" name="right_title" placeholder="Right Title" value="{{$detail->right_title ?? null}}"/>
                    <textarea  class="form-control" name="right_content" id="" cols="30" rows="3" placeholder="Right Content">{{$detail->right_content ?? null}}</textarea>
                </div>
                <div class="col-md-2">
                    <input data-repeater-delete class="btn btn-danger" type="button" value="Delete"/>
                </div>
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
                },
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },

            })
        });

    </script>
@stop
