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
          @if (session('status'))
              <div class="alert alert-success">
                  {{ session('status') }}
              </div>
          @endif

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

                            <ul class="nav nav-pills">
                              <li role="presentation">
                                <a href='{{ url("/like/{$post->id}")}}'><span class="fa fa-thumbs-up"> LIKE({{$likeCtr}})</span></a>
                              </li>
                              <li role="presentation">
                                <a href='{{ url("/dislike/{$post->id}")}}'><span class="fa fa-thumbs-down"> DISLIKE({{$dislikeCtr}})</span></a>
                              </li>
                              <li role="presentation">
                                <a href='{{ url("/comment/{$post->id}")}}'><span class="fa fa-comment-o"> COMMENT</span></a>
                              </li>
                            </ul>
                        @endforeach
                      @else
                        <p>No post avalable!</p>
                      @endif

                      <form method="POST" action='{{ url("/comment/{$post->id}") }}'>
                           @csrf
                           <div class="form-group row">
                                   <textarea id="comment" rows="7" class="form-control" name="comment"  required autofocus>
                                   </textarea>
                           </div>
                           <div class="form-group row mb-0">
                                   <button type="submit" class="btn btn-primary btn-large btn-block">
                                       Post Comment
                                   </button>
                           </div>
                       </form>
                       <h3>Comments</h3>
                     </div>
                     <div class="col-md-4"></div>
                     <div class="col-md-8">
                     @if(count($comments) > 0)
                         @foreach($comments->all() as $comment)
                            <p>{{ $comment->comment}}</p>
                            <p>Posted by: {{ $comment->name}}</p>
                            <hr/>
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
</div>
@endsection
