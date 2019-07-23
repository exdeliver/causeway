@include('causeway::admin.common._select', [
    'title' => 'Parent category',
    'name' => 'parent_id',
    'value' => $category->parent_id ?? null,
    'data' => ['' => '--- None, is root ---'] + $categories,
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._text', [
    'title' => 'Title',
    'name' => 'title',
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._textarea', [
    'title' => 'Description',
    'name' => 'description',
    'options' => ['class' => 'form-control', 'id' => 'summernote'],
])

@include('causeway::admin.common._checkbox', [
    'title' => 'Active',
    'name' => 'active',
    'options' => ['class' => 'form-control'],
])

<div class="form-group">
    <hr/>
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

@push('scripts')
    <script type="application/javascript">
        $(document).ready(function () {
            $('#summernote').summernote();
        });
@endpush