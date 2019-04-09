<div class="form-group">
    <label for="first_name">First name</label>
    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
    @if ($errors->has('first_name'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
    @endif
</div>
<div class="form-group">
    <label for="last_name">Last name</label>
    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
    @if ($errors->has('last_name'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
    @endif
</div>
<div class="form-group">
    <label for="email">E-mail</label>
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
    @if ($errors->has('email'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <p><strong>Assign roles</strong></p>
    <table class="table">
        <thead>
        <tr>
            <th>Role</th>
            <th>Permissions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>
                    <div class="form-check">
                        {{ Form::checkbox('roles[]', $role->id, isset($user) && $user->hasRole($role->name) ?? false, ['class' => 'form-check-input', 'id' => 'role-'.$role->name]) }}

                        {{ Form::label('role-'.$role->name, $role->name, ['class' => 'form-check-label']) }}
                    </div>
                </td>
                <td>
                    <ul>
                        @foreach($role->permissions as $permission)
                            <li>{{ $permission->name }}</li>
                        @endforeach
                    </ul>
                </td>
        @endforeach
        </tbody>
    </table>
</div>

<div class="form-group">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>