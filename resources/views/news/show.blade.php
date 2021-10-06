@extends('layouts.public.app')

@section('title',$news->title.' - ')
@section('description',$news->title)
@section('keywords',$news->title)

@section('content')
    @include('layouts.public.header')
    <main class="container main" id="news">
        <h2 class="text-center mb-5">{{ $news->title }}</h2>
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body bg-light">
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ Date::make($news->created_at)->toj()->format('Y/m/d') }}
                        </h6>
                        <article class="card-text">
                            {!! $news->content !!}
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.public.footer')
@endsection