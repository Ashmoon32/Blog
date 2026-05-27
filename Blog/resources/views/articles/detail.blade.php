<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail</title>
    <script src="https://kit.fontawesome.com/0303a573f3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    @extends("layouts.app")

    @section("content")
        <div class="container">
            @if(session('info'))
                <div class="alert alert-info " role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div>
                <a href="{{ url("/articles") }}" class="btn btn-dark mb-2">&laquo; Back to List</a>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">{{  $article->title  }}</h5>
                    <div class="card-title mb-2 text-muted small">
                        {{  $article->created_at->diffForHumans() }}
                        {{-- Category:: <b>{{ $article->category->name }}</b> --}}
                        Category: <b>{{ $article->category->name ?? 'Uncategorized' }}</b>
                    </div>
                    <p class="card-text">{{  $article->body }}</p>
                    @auth
                        @if(auth()->user()->id == $article->user_id)
                            <a 
                                href="{{  url("/articles/delete/$article->id") }}" 
                                class="btn btn-warning">
                                Delete
                            </a>
                            <a href="{{ url("/articles/edit/$article->id") }}" class="btn btn-info">
                                Edit
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
                <ul class="list-group mb-2">
                        @if($errors->any())
                            <div class="alert alert-warning">
                                <div>{{  $errors->first() }}</div>
                            </div>
                        @endif

                        @auth
                            <li class="list-group-item active">
                                <b>Comments ({{ count($article->comments) }})</b>
                            </li>
                            @foreach($article->comments as $comment)
                                <li class="list-group-item">
                                    @if (auth()->user()->id == $comment->user_id)
                                        <a href="{{ url("/comments/delete/$comment->id") }}" class="float-end text-danger"><i class="fa-solid fa-xmark fs-4"></i></a>
                                        <a href="{{ url("/comments/edit/$comment->id") }}" class="float-end mx-2 text-primary">
                                        <i class="fa-regular fa-pen-to-square fs-4"></i>
                                        </a>
                                    @endif
                                    {{ $comment->content }}
                                    <div class="small mt-2">
                                        By <b>{{  $comment->user->name }}</b>,
                                        {{  $comment->created_at->diffForHumans() }}
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <div class="alert alert-danger text-center">Only logged in users can see comments</div>
                        @endauth
                </ul>

            @auth
                <form action="{{ url("/comments/add") }}" method="post">
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
                    <input type="submit" value="Add Comment" class="btn btn-secondary">
                </form>
            @endauth
        </div>
    @endsection
</body>
</html>