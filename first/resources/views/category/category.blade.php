@extends('layouts.app')
<style type="text/css">
.pht1{
  border-radius: 100%;
  max-width: 100px;
}
.abc{
  max-width: 400px;
}
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @if(count($errors) > 0)
            @foeeach($errors=>all() as $error)
              <div class="alert">{{ $error }}</div>
            @endforeeach
          @endif

          @if (session('status'))
              <div class="alert alert-success">
                  {{ session('status') }}
              </div>
          @endif
            <div class="card">
                <div class="card-header">Category</div>
                <div class="col-md-12" align="center">
                  <ul class="list=group">
                    @if(count($categories) > 0)
                      @foreach($categories->all() as $category)
                        <li class="list-group-item"><a href='{{url("category/{$category->id}")}}'>{{$category->category}}</a></li>
                      @endforeach
                    @else
                      <p>No category found</p>
                    @endif

                  </ul>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ url('/addCategory') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="category" class="col-sm-4 col-form-label text-md-right">{{ __('Enter Category') }}</label>

                            <div class="col-md-8">
                                <input id="category" type="category" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category" value="{{ old('category') }}" required autofocus>

                                @if ($errors->has('category'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Category') }}
                                </button>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
