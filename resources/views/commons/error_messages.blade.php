@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-warning">{{ $error }}</div>
    @endforeach
@endif

@if (session('cat_error'))
    <div class="alert alert-warning">
        {{ session('cat_error') }}
    </div>
@endif