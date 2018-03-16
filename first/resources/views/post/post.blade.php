@extends('layouts.app')
<script>
  $(document).ready(function(){
    $('#category_id').multiselect({
      nonSelectedText:'Select',
      enableFiltering:true,
      enableCaseInsensitiveFiltering:true,
      buttonWidth:'400px',
    });
    $('#framework_form').on('submit',function(event){
      event,preventDefault();
      var form_data=$(this).serialize();
      $.ajax({
        method:"POST",
        data:form_data,
        success:function(data)
        {
          $('#category_id option:selected').each(function(){
            $(this),prop('selected',false);
          });
          $('#category_id').multiselect('refresh');
          alert(data);
        }
      })
    });
  });
</script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                      <div class="row">
                        <form method="POST" id="framework_form" action="{{ url('/addPost') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="post_name" class="col-md-4 col-form-label text-md-right">{{ __('Post Title') }}</label>

                                <div class="col-md-8">
                                    <input id="post_name" type="text" class="form-control{{ $errors->has('post_name') ? ' is-invalid' : '' }}" name="post_name" value="{{ old('post_name') }}" required autofocus>

                                    @if ($errors->has('post_name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('post_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="post_body" class="col-md-4 col-form-label text-md-right">{{ __('Post Body') }}</label>

                                <div class="col-md-8">
                                    <textarea id="post_body" rows="7" type="post_body" class="form-control{{ $errors->has('post_body') ? ' is-invalid' : '' }}" name="post_body" value="{{ old('post_body') }}" required>
                                    </textarea>
                                    @if ($errors->has('post_body'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('post_body') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                                <div class="col-md-8">
                                    <select id="category_id" multiple class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" name="category_id[]" required>
                                        <option value="">select</option>
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

                                <div class="col-md-8">
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
                                        {{ __('Add Post') }}
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
