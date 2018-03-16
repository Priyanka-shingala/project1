@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Post</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                      <div class="row">
                        <form method="POST" action="{{ url('/editPost',array($posts->id)) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="post_name" class="col-md-4 col-form-label text-md-right">{{ __('Post Title') }}</label>

                                <div class="col-md-6">
                                    <input id="post_name" type="text" class="form-control{{ $errors->has('post_name') ? ' is-invalid' : '' }}" name="post_name" value="{{ $posts->post_name}}" required autofocus>

                                    @if ($errors->has('post_name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('post_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="post_body" class="col-md-4 col-form-label text-md-right">{{ __('Post Body') }}</label>

                                <div class="col-md-6">
                                    <textarea id="post_body" rows="7" type="post_body" class="form-control{{ $errors->has('post_body') ? ' is-invalid' : '' }}" name="post_body" value="{{ old('post_body') }}" required>
                                     {{ $posts->post_body }}</textarea>
                                    @if ($errors->has('post_body'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('post_body') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Category ID') }}</label>

                                <div class="col-md-6">
                                    <select id="category_id" type="category_id" class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" name="category_id" required>
                                        <option value="{{ $category->id}}">{{$category->category}}</option>
                                        @if(count($categories) > 0)
                                          @foreach($categories->all() as $category)
                                          <option value="{{ $category->id}}">{{ $category->category}}</option>
                                          @endforeach
                                        @endif

                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="post_image" class="col-md-4 col-form-label text-md-right">{{ __('Post Image') }}</label>

                                <div class="col-md-6">
                                    <input id="post_image" type="file" class="form-control{{ $errors->has('post_image') ? ' is-invalid' : '' }}" name="post_image" required>

                                    @if ($errors->has('post_image'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('post_image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-large btn-block">
                                        {{ __('Edit Post') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
