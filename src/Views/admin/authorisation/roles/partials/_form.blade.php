<div class="form-group">
    <label for="first_name">Name</label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    @if ($errors->has('name'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <label for="type">Guard</label>
    {!! Form::select('guard_name', ['web' => 'web', 'api' => 'api'], null, ['class' => 'form-control']) !!}
    @if ($errors->has('guard_name'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('guard_name') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <p><strong>Assign permissions</strong></p>
    <table class="table">
        <thead>
        <tr>
            <th>Permissions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($permissions as $permission)
            <tr>
                <td>
                    <div class="form-check">
                        {{ Form::checkbox('permissions[]', $permission->id, isset($permission) && $role->hasPermissionTo($permission->name) ?? false, ['class' => 'form-check-input', 'id' => 'permission-'.$permission->name]) }}

                        {{ Form::label('permission-'.$permission->name, $permission->name, ['class' => 'form-check-label']) }}
                    </div>
                </td>
        @endforeach
        </tbody>
    </table>
</div>

<div class="form-group">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>