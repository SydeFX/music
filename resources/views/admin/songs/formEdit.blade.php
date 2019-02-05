<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ $song->title }}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('thumbnail') ? 'has-error' : ''}}">
    <label for="thumbnail" class="control-label">{{ 'Thumbnail' }}</label>
    <input class="form-control" name="thumbnail" type="file" id="thumbnail" value="{{ $song->thumbnail}}" >
    {!! $errors->first('thumbnail', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
    <label for="url" class="control-label">{{ 'Url' }}</label>
    <input class="form-control" name="url" type="text" id="url" value="{{ $song->url}}" >
    {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('duration') ? 'has-error' : ''}}">
    <label for="duration" class="control-label">{{ 'Duration' }}</label>
    <input class="form-control" name="duration" type="text" id="duration" value="{{ $song->duration }}" >
    {!! $errors->first('duration', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('artistId') ? 'has-error' : ''}}">
    <label for="artistId" class="control-label">{{ 'Artistid' }}</label>
    
    <select class="form-control" name="artistId"  required>
             <option>--- Please choose one --- </option>
                @foreach ($artists as $row)
                <option value="{{ $row->id }}" @if($row->id == $song->artistId) selected @endif >{{ $row->title }}</option>
                @endforeach
    </select>

    {!! $errors->first('artistId', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
