<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Convert;
use App\Http\Controllers\HomeController;
use App\Category;
use App\Post;
use App\Like;
use App\Dislike;
use App\Comment;
use App\Profile;
use Auth;
class PostController extends Controller
{
  public function post()
  {
      $categories = Category::all();
      return view('post.post',['categories' => $categories]);
  }

  public function addPost(Request $request)
  {
    $this->validate($request, [
      'post_name'=>'required',
      'post_body'=>'required',
      'category_id'=>'required',
      'post_image'=>'required'
    ]);
    $posts=new Post;
    $posts->post_name = $request->input('post_name');
    $posts->user_id = Auth::user()->id;
    $posts->post_body = $request->input('post_body');
    //$posts->category_id = $request->input('category_id[]');


    $connect=mysqli_connect("localhost","root","","blog");
    if(isset($_POST["category_id"]))
    {
      $category_id ='';
      foreach ($_POST["category_id"] as $row) {
        $category_id.=$row.',';

      }
      $category_id=substr($category_id,0,20);
      //$query=mysqli_query($connect,"INSERT INTO posts(category_id) VALUES('".$category_id."')");
      $posts->category_id=$category_id;
    }

    if(Input::hasFile('post_image')){
      $file = Input::file('post_image');
      $file->move(public_path(). '/posts/',$file->getClientOriginalName());
      $url = URL::to("/").'/posts/' .$file->getClientOriginalName();

    }
    $posts->post_image = $url;
    $posts->save();
    return redirect('/home')->with('status','Post added successfully');
  }

  public function view($post_id)
  {
      $posts = Post::where('id','=',$post_id)->get();
        $likePost = Post::find($post_id);
        $likeCtr = Like::where(['post_id'=>$likePost->id])->count();
          $dislikeCtr = Dislike::where(['post_id'=>$likePost->id])->count();
      $categories = Category::all();
      $comments = DB::table('users')->join('comments','users.id','=','comments.user_id')
                    ->join('posts','comments.post_id','=','posts.id')
                    ->select('users.name','comments.*')
                    ->where(['posts.id' => $post_id])
                   ->get();
      return view('post.view',['posts'=>$posts,'categories'=>$categories,'likeCtr'=>$likeCtr,'dislikeCtr'=>$dislikeCtr, 'comments'=>$comments]);
  }

  public function edit($post_id)
  {
        $categories = Category::all();
        $posts = Post::find($post_id);
        $category = Category::find($posts->category_id);
      return view('post.edit',['categories'=>$categories, 'posts'=>$posts,'category'=>$category]);
  }

  public function editPost(Request $request, $post_id)
  {
 $this->validate($request, [
      'post_name'=>'required',
      'post_body'=>'required',
      'category_id'=>'required',
      'post_image'=>'required'
    ]);
    $posts=new Post;
    $posts->post_name = $request->input('post_name');
    $posts->user_id = Auth::user()->id;
    $posts->post_body = $request->input('post_body');
      $posts->category_id = $request->input('category_id');
    if(Input::hasFile('post_image')){
      $file = Input::file('post_image');
      $file->move(public_path(). '/posts/',$file->getClientOriginalName());
      $url = URL::to("/").'/posts/' .$file->getClientOriginalName();

    }
    $posts->post_image = $url;
    $data=array(
      'post_name' =>$posts->post_name,
      'user_id' =>$posts->user_id,
      'post_body' =>$posts->post_body,
      'category_id' =>$posts->category_id,
      'post_image' =>$posts->post_image
    );
    Post::where('id', $post_id)->update($data);
    $posts->update();
    return redirect('/home')->with('status','Post Edit successfully');

  }
  public function deletePost($post_id)
  {
        Post::where('id', $post_id)->delete();
        return redirect('/home')->with('status','Post Deleted successfully');

  }

  public function category($cat_id)
  {
        $categories = Category::all();
        $posts = DB::table('posts')->join('categories','posts.category_id','=','categories.id')
                      ->select('posts.*','categories.*')
                      ->where(['categories.id' => $cat_id])
                     ->get();
        return view('category.categoriesposts',['categories'=>$categories, 'posts'=>$posts]);

  }

  public function like($id)
  {
      $loggedin_user=Auth::user()->id;
      $like_user=Like::where(['user_id'=>$loggedin_user,'post_id'=>$id])->first();
      if(empty($like_user->user_id)){
        $user_id=Auth::user()->id;
        $email=Auth::user()->email;
        $post_id=$id;
        $like=new Like;
        $like->user_id=$user_id;
        $like->email=$email;
        $like->post_id=$post_id;
        $like->save();
        return redirect("/view/{$id}");
      }
      else {
        return redirect("/view/{$id}");
      }
  }

  public function dislike($id)
  {
      $loggedin_user=Auth::user()->id;
      $like_user=Dislike::where(['user_id'=>$loggedin_user,'post_id'=>$id])->first();
      if(empty($like_user->user_id)){
        $user_id=Auth::user()->id;
        $email=Auth::user()->email;
        $post_id=$id;
        $like=new Dislike;
        $like->user_id=$user_id;
        $like->email=$email;
        $like->post_id=$post_id;
        $like->save();
        return redirect("/view/{$id}");
      }
      else {
        return redirect("/view/{$id}");
      }
  }

  public function comment(Request $request,$post_id)
  {
    $this->validate($request, [
         'comment'=>'required'
       ]);
       $comment=new Comment;
       $comment->user_id=Auth::user()->id;
       $comment->post_id=$post_id;
       $comment->comment = $request->input('comment');
       $comment->save();
         return redirect("/view/{$post_id}")->with('status','Comment Added successfully');
  }
  public function search(Request $request)
   {
        $user_id=Auth::user()->id;
        $profile=Profile::find($user_id);
        $keyword=$request->input('search');
        $posts=Post::where('post_name','LIKE','%'.$keyword.'%')->get();
          return view('post.searchposts',['profile'=>$profile, 'posts'=>$posts]);
   }
}
