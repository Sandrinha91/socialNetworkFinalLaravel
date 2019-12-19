<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post; // ukljucuje se model

use Auth; // klasa za logovanog korisnika

use App\User;
use App\Event;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        // var_dump($posts);
        $user = Auth::user();
        $following = $user->following; //ili ovako skracen zapis
        $followers = $user->followers;
        $events = Event::get();
        // echo $followers;
        // $following = $user->following()->get();
        // var_dump($following);
    //    echo $following;

        //odredjujemo mutual folowing folowers i others
        $followingIds = $user->following->pluck('id')->toArray(); //id svih korisnika koje pratim
        
        
        $followerIds = $user->followers->pluck('id')->toArray();  //id svih korisnika koji mene prate

        //mutual id
        $mutualIds = array_intersect($followingIds, $followerIds);
        
        $followingIds = array_diff($followingIds, $mutualIds);
        $followerIds = array_diff($followerIds, $mutualIds);

        $mutuals = User::whereIn('id', $mutualIds)->orderBy('name')->get();
        $followers = User::whereIn('id', $followerIds)->orderBy('name')->get();
        $following = User::whereIn('id', $followingIds)->orderBy('name')->get();
        $others = User::whereNotIn('id', array_merge( $mutualIds, $followerIds,$followingIds, array($user->id)  ) )->orderBy('name')->get();


        return view('home', array(
            'objave' => $posts,
            'following' => $following,
            'followers' => $followers,
            'mutuals' => $mutuals,
            'others' => $others,
            'events' => $events,
        ));
    }

    public function publish()
    {
        // $_POST['content'] - obican php

        $content =  request('content'); // u laravelu ovde se pamti ono sto je u text area
        // echo Auth::user();
        $id = Auth::user()->id; // id logovanog korisnika

        if( empty($content) )
        {
            return redirect('/home')->with('error', 'Post can not be empty!');
        }
        else
        {
            //ubaciti novi red u tabelu posts
            //1. kreirati novi objekat klase posts
            $post = new Post;
            //2. Popunimo polja ovom objektu
            $post->user_id = $id;
            $post->content = $content;

            //3. Pozvati metodu save()

            $post->save();

            //redirekcija na homepage

            return redirect('/home')->with('success', 'Post published!');
        }

        

        

    }


    
}
