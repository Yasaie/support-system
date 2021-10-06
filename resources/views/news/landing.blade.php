@extends('layouts.public.app')

@section('title','- اخبار')
@section('description','آخرین اخبار مربوط به سایت')
@section('keywords','اخبار,خبر,اطلاع رسانی')

@section('content')
    @include('layouts.public.header')
    <main class="container main" id="news">
        <h2 class="text-center mb-5">اخبار</h2>
        @if($news->isNotEmpty())
            @foreach($news as $new)
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body bg-light">
                                <a href="{{ route('news.show',$new) }}" class="color-inherit">
                                    <h4 class="card-title">{{ $new->title }}</h4>
                                </a>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ Date::make($new->created_at)->toj()->format('Y/m/d') }}
                                </h6>
                                <article class="card-text">
                                    {{ Str::limit(strip_tags($new->content),500) }}
                                </article>
                                <a href="{{ route('news.show',$new) }}" class="card-link">مشاهده کامل خبر</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row mb-3">
                <div class="col-sm-12">
                    <p class="alert alert-danger">
                        هیچ خبری یافت نشد
                    </p>
                </div>
            </div>
        @endif
        <div class="text-center">
            {{ $news->links() }}
        </div>
    </main>
    @include('layouts.public.footer')
@endsection