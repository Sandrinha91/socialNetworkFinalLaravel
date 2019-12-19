@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><img src="{{ asset('images/'.$user->id) }}.png" width="20">{{ $user->name }}</div>

                <div class="card-body">

                 @if (file_exists(public_path().'/images/'.$user->id. '.png'))
                            <img src="{{ asset('images/'.$user->id) }}.png" width="20">
                    @endif   

                @foreach($posts as $objava)
                    <!-- <h5>{{$objava->id}}</h5> -->
                    
                    <p class='blue'><i>{{$objava->content}}</i></p>
                    <small>{{$objava->created_at->format('d.m.Y.')}}</small>
                    <small>{{$objava->created_at->diffForHumans()}}</small>
                    <hr>
          
                @endforeach

            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
