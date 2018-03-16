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


            <div class="card">
                <div class="card-header">View Post</div>

                <div  class="row justify-content-center" class="card-body" >
                    <div class="col-md-4" align="center">
                      <ul class="list=group">
                        @if(count($categories) > 0)
                          @foreach($categories->all() as $category)
                            <li class="list-group-item"><a href='{{url("category/{$category->id}")}}'>{{$category->category}}</a></li>
                          @endforeach
                        @else
                          <p>No category found</p>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                      </ul>
                    </div>
                    <div class="col-md-8">
                      @if(count($posts) > 0)
                        @foreach($posts->all() as $post)
                          <h4>{{$post->post_name}}</h4>
                          <img src="{{ $post->post_image}}" class="abc" alt="">
                            <p>{{ $post->post_body }}</p>

                        @endforeach
                      @else
                        <p>No post avalable!</p>
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
