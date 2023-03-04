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
    <label class="control-label" for="body">Body</label>
    <textarea name="body" id="body" class="form-control richTextBox" cols="50" rows="20">{!! old('body',$page->body) !!}</textarea>
</div>
