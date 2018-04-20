<?php
use App\Post;
use App\User;
use App\Role;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|

*/
Route::get('/', function () {
    return view('welcome');
});

/*insert*/
Route::get('/insert',function(){
    DB::insert('insert into posts (title, content) values (?, ?)', ['second Insert in Laravel', 'Content for post 2 goes here!']); 
});
/*insert end*/

/*select*/
Route::get('/read',function(){
    $results=DB::select('select * from posts where id=?',[1]);
    foreach($results as $post){
        echo 'title:' .$post->title;echo '<br/>';
        echo 'content:' .$post->content;
    }
    
});
/*select end*/ 

/*update*/
Route::get('/update',function(){
    $affected = DB::update('update posts set title = "First Insert in Laravel" where id = ?', [1]);
    return $affected;
});
/*update end*/

/*delete*/
Route::get('/delete',function(){
    $deleted = DB::delete('delete from posts where id = ?', [1]);
    return $deleted;
});
/*delete end*/
//Route::get('/post','PostsController');

/*Eloquent*/
/*Eloquent find*/
Route::get('/find',function(){
 //   $posts=Post::find(2);
    $posts=Post::find([2,7]);
   return $posts;
});
/*Eloquent find Emd*/

/*Eloquent findwhere(throw exception)*/
Route::get('/findwhere',function(){
    /*$posts=Post::orderBy('id','desc')->get();
    return $posts;*/
    
    $posts=Post::findOrFail(1);
    return $posts;
});
/*Eloquent findwhere end(throw exception)*/

/*Eloquent insert)*/
Route::get('basicinsert',function(){
    $post=new Post;
    $post->title='New Eloquent title insert';
    $post->content='Wow!eloquent is really cool!';
    $post->save();
});
/*Eloquent insert end)*/

/*Eloquent update)*/
Route::get('basicupdate',function(){
   /* $post=Post::find(8);
    $post->title='New Eloquent title update';
    $post->content='Wow!eloquent is really cool!';
    $post->save();*/
    
    Post::where('id',2)->where('is_admin',0)->update(['title'=>'eloquent update in laravel','content'=>'Updated Content for post goes here!']);   
});
/*Eloquent update end)*/

/*creating data and configuring mass assignment*/ 

Route::get('/create',function(){
   Post::create(['title'=>'the create method-post 2','content'=>'Wow!I\'m learning alot!']);  
});

/*end*/

/*SoftDelete*/
Route::get('/softdelete',function(){
   Post::find(14)->delete(); 
});

Route::get('/readsoftdelete',function(){
   $post=Post::withTrashed()->where('id',14)->get();
   return $post;
});

Route::get('/restore',function(){
   Post::withTrashed()->where('is_admin',0)->restore();
});


Route::get('/forcedelete',function(){
   Post::onlyTrashed()->where('is_admin',0)->forceDelete();
});

/*SoftDelete end*/

/*Eloquent End*/

/*
|--------------------------------------------------------------------------
| Eloquent Relationships
|--------------------------------------------------------------------------
*/

//one to one relationship
  Route::get('/user/{id}/post',function($id){
            return User::find($id)->post;
});


//inverse relationship
Route::get('post/{id}/user',function($id){
   return Post::find($id)->user->name;
});

//one to many relationship
Route::get('/posts_many',function(){
   $user=User::find(1);
    foreach($user->posts as $post){
        echo $post->title .'<br/>';
    }
});

//many to many relationship
Route::get('/user/{id}/role',function($id){
   $user=User::find($id)->roles()->orderBy('id','desc')->get();
    return $user;
   /* foreach($user->roles as $role){
        echo $role->name .'<br/>';
    }*/
});

//Accessing the intermediate table/pivot
Route::get('user/pivot',function(){
   $user= User::find(1);
   foreach($user->roles as $role){
       echo $role->pivot->created_at;
   }
});
/*
|--------------------------------------------------------------------------
| Eloquent Relationships End
|--------------------------------------------------------------------------
*/
Route::resource('posts','PostsController');

Route::resource('contact','PostsController@contact');

Route::resource('post/{id}/{name}','PostsController@show_post');


