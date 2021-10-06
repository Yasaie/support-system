@extends('layouts.public.app')
@section('content')
    @include('layouts.public.header')
    <main class="container main">
        <h2 class="text-center mb-5">سوالات متداول</h2>
        <div class="row">
            <div class="col-12">
                <div id="accordion">
                    @if($faqs->isNotEmpty())
                        @foreach($faqs as $faq)
                        <div class="card mb-2">
                            <div class="card-header" id="heading{{$loop->index+1}}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$loop->index+1}}" aria-expanded="{{ ($loop->first?'true':'false') }}" aria-controls="collapse{{$loop->index+1}}">
                                        <span>#{{ $loop->index+1 }}</span>
                                        <span>{{ Str::limit(strip_tags($faq->question)) }}</span>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{$loop->index+1}}" class="collapse show" aria-labelledby="heading{{$loop->index+1}}" data-parent="#accordion">
                                <div class="card-body">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="text-center">
            {{ $faqs->links() }}
        </div>
    </main>
    @include('layouts.public.footer')
@endsection