<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ $artist->title}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('thumbnail') ? 'has-error' : ''}}">
    <label for="thumbnail" class="control-label">{{ 'Thumbnail' }}</label>
    <input class="form-control" name="thumbnail" type="file" id="thumbnail" value="{{ $artist->thumbnail}}" >
    {!! $errors->first('thumbnail', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
