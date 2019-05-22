<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset( $campaign->name ) ? $campaign->name : '' }}" required>

    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
    <label for="url" class="control-label">{{ 'Url' }}</label>
    <input class="form-control" name="url" type="text" id="url" value="{{ isset( $campaign->url ) ? $campaign->url : '' }}" required>

    {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('budget') ? 'has-error' : ''}}">
    <label for="budget" class="control-label">{{ 'Budget' }}</label>
    <select name="budget" class="form-control" id="budget" required>
    @foreach (json_decode('{"149":149,"399":399,"999":999}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($campaign->budget) && $campaign->budget == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('budget', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
    <label for="country" class="control-label">{{ 'Country' }}</label>
    <input class="form-control" name="country" type="text" id="country" value="{{ isset( $campaign->country ) ? $campaign->country : '' }}" required>

    {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('category') ? 'has-error' : ''}}">
    <label for="category" class="control-label">{{ 'category' }}</label>
    <input class="form-control" name="category" type="text" id="category" value="{{ isset( $campaign->category ) ? $campaign->category : '' }}">

    {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('goal') ? 'has-error' : ''}}">
    <label for="goal" class="control-label">{{ 'goal' }}</label>
    <select name="goal" class="form-control" id="goal" required>
    @foreach (json_decode('{"0":"Awareness","1":"Conversion"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($campaign->goal) && $campaign->goal == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('goal', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
