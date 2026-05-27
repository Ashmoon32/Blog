@extends('layouts.app')

@section('content')
    <div class="container">

        @if($errors->any())
            <div class="alert alert-warning">
                <ol>
                    @foreach($errors->all() as $error)
                        <li>{{  $error }}</li>
                    @endforeach
                </ol>
            </div>
        @endif

        <form action="{{ url("/comments/update/$comment->id") }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Content</label>
                <textarea name="content" class="form-control">{{ $comment->content }}</textarea>
            </div>
            <input type="submit" value="Update Comment" class="btn btn-success">
        </form>
    </div>
@endsection