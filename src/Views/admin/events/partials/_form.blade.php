<div class="form-group">
    <label for="name">Title</label>
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    @if ($errors->has('title'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
    @endif
</div>
<div class="form-group">
    <label for="name">Description</label>
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    @if ($errors->has('description'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
    @endif
</div>
<div class="form-group">
    <label for="full_day_event">Full day event?</label>
    {!! Form::checkbox('full_day', 1, null, ['class' => 'form-control']) !!}
    @if ($errors->has('full_day'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('full_day') }}</strong>
                </span>
    @endif
</div>
<div class="form-group">
    <label for="start">Start date</label>
    <datepicker-component format="DD-MM-YYYY H:i" name="start_datetime" value="{{ $event->start_datetime ?? '' }}"></datepicker-component>
    @if ($errors->has('start_datetime'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('start_datetime') }}</strong>
                </span>
    @endif
</div>
<div class="form-group">
    <label for="end">End date</label>
    <datepicker-component format="DD-MM-YYYY H:i" name="end_datetime" value="{{ $event->end_datetime ?? '' }}"></datepicker-component>
    @if ($errors->has('end_datetime'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('end_datetime') }}</strong>
                </span>
    @endif
</div>
<div class="form-group">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>