@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-header">
                    @if(session()->has('success'))
                        <div class="alert-success">
                            {{ session()->get('success') }}
                        </div>
                        <br>
                    @elseif( session()->has('error') )
                        <div class="alert-danger">
                            {{ session()->get('error') }}
                        </div>
                        <br>
                    @endif
                    <form action="/home" method="post">
                        @csrf
                        <textarea name="content" id="" cols="30" rows="5" class="form-control" placeholder="What's on your mind..."></textarea>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Post">
                    </form>
                </div>

                <div class="card-body">
                    

                @foreach($objave as $objava)
                    
                    <!-- <h5>{{$objava->id}}</h5> -->
                    @if( Auth::user()->id != $objava->user->id )
                        
                        @if (file_exists(public_path().'/images/'.$objava->user->id. '.png'))
                            <img src="{{ asset('images/'.$objava->user->id) }}.png" width="20">
                        @else
                            <img src="{{ asset('images/default.png') }}" width="20">
                        @endif

                        <h6>
                        
                        <a href="user/{{$objava->user->id}}"><strong>{{$objava->user->name}}</strong> ( {{ $objava->user->email }} )</a></h6>
                        <p style="color:blue"><i>{{$objava->content}}</i></p>
                        <small>{{$objava->created_at->format('d.m.Y.')}}</small>
                        <small>{{$objava->created_at->diffForHumans()}}</small>
                        <hr>

                        
                    
                    @else
                        
                        @if (file_exists(public_path().'/images/'.$objava->user->id. '.png'))
                            <img src="{{ asset('images/'.$objava->user->id) }}.png" width="20">
                        @else
                            <img src="{{ asset('images/default.png') }}" width="20">
                        @endif
                            
                        <h6>
                        
                            
                        <a href="user/{{$objava->user->id}}"><strong>{{$objava->user->name}}</strong> ( {{ $objava->user->email }} )</a></h6>
                        <p style="color:red"><i>{{$objava->content}}</i></p>
                        <small>{{$objava->created_at->format('d.m.Y.')}}</small>
                        <small>{{$objava->created_at->diffForHumans()}}</small>
                        <hr>
                        
                    
                    @endif
                    
                @endforeach

                <!-- Varijablu event cita kao nedefinisanu -->
                <!-- Uradjeno je sve ostalo -->
                 @foreach( $events as $event ) 
                    <h5><a href="event/{{$event->id}}">{{ $event->name }}</a></h5>
                @endforeach

                </div>
            </div>
        </div>

        <div class="col-md-4">

            @if( count($mutuals) )
                <div class="card">
                    <div class="card-header">
                        Mutual friends
                    </div>
                    <div class="card-body">
                        @foreach( $mutuals as $follow )
                            <h6><a href="user/{{$follow->id}}"><i>{{ $follow->name }}</i></a></h6>
                        @endforeach
                    </div>
                </div>
            @endif

            <br>

            @if( count($following) )
                <div class="card">
                    <div class="card-header">
                        Users I'm following
                    </div>
                    <div class="card-body">
                        @foreach( $following as $follow )
                            <h6><a href="user/{{$follow->id}}"><i>{{ $follow->name }}</i></a></h6>
                        @endforeach
                    </div>
                </div>
            @endif

            <br>

            @if( count($followers) )
                <div class="card">
                    <div class="card-header">
                        My followers
                    </div>
                    <div class="card-body">
                        @foreach( $followers as $follow )
                            <h6><a href="user/{{$follow->id}}"><i>{{ $follow->name }}</i></a></h6>
                        @endforeach
                    </div>
                </div>
            @endif

            <br>

            @if( count($others) )
                <div class="card">
                    <div class="card-header">
                        Suggestions
                    </div>
                    <div class="card-body">
                        @foreach( $others as $follow )
                            <h6><a href="user/{{$follow->id}}"><i>{{ $follow->name }}</i></a></h6>
                        @endforeach
                    </div>
                </div>
            @endif
        
        </div>
    </div>
</div>
@endsection
