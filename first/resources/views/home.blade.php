@extends('layouts.app')
  <style type="text/css">
  .profile{
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
            @foreach($errors->all() as $error)
              <div class="alert">{{ $error }}</div>
            @endforeach
          @endif

          @if (session('status'))
              <div class="alert alert-success">
                  {{ session('status') }}
              </div>
          @endif


            <div class="card">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-md-4" align="center"><h3>Dashboard</h3></div>
                      <div class="col-lg-8">
                    <form method="POST" action='{{ url("/search")}}' class="navbar-form navbar-left">
                      {{ csrf_field()}}
                          <div class="form-group">
                              <input type="text" name="search" class="form-control" placeholder="Search">
                            </div>
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-default">Submit</button>
                            </span>
                      </form>
                    </div>
                    </div>
                  </div>
                  <hr/>
                  <div class="panel-body">
                <div  class="row justify-content-center" class="card-body" >
                    <div class="col-md-4" align="center">
                      @if(!empty ($profile))
                        <img src="{{ $profile->profile_pic}}" class="profile" alt="">
                      @else
                        <img src="{{ url('images/profile.png')}}" class="profile" alt="">
                      @endif

                      @if(!empty ($profile))
                        <p class="lead">{{ $profile->name }}</p>
                      @else
                        <p></p>
                      @endif

                      @if(!empty ($profile))
                        <p class="lead">{{ $profile->designation }}</p>
                      @else
                        <p></p>
                      @endif
                    </div>
                    <div class="col-md-8">
                    @if(count($posts) > 0)
                      @foreach($posts->all() as $post)
                        <h4>{{$post->post_name}}</h4>
                        <img src="{{ $post->post_image}}" class="abc" alt="">
                          <p>{{substr($post->post_body,0,100)}}</p>

                          <ul class="nav nav-pills">
                            <li role="presentation">
                              <a href='{{ url("/view/{$post->id}")}}'><span class="fa fa-eye"> VIEW</span></a>
                            </li>
                            <li role="presentation">
                              <a href='{{ url("/edit/{$post->id}")}}'><span class="fa fa-pencil-square-o"> EDIT</span></a>
                            </li>
                            <li role="presentation">
                              <a href='{{ url("/deletePost/{$post->id}")}}'><span class="fa fa-trash"> DELETE</span></a>
                            </li>
                          </ul>
                          <cite style="float:left;">Posted on: {{date('Y-m-d H:i:s',strtotime($post->update_at))}}</cite>
                          <hr/>
                      @endforeach
                    @else
                      <p>No post avalable!</p>
                    @endif

                    {{$posts->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
