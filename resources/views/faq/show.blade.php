@extends('layouts.public.app')
@section('content')
    @include('layouts.public.header')
    <main class="container main">
        <h2 class="text-center mb-5">نمایش سوالات متداول</h2>
        <div class="row">
            <div class="col-12">
                <div id="accordion">
                    <div class="card mb-2">
                        <div class="card-header" id="heading">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse" aria-expanded="true" aria-controls="collapse">
                                    <span>{{ Str::limit(strip_tags($faq->question)) }}</span>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse" class="collapse show" aria-labelledby="heading" data-parent="#accordion">
                            <div class="card-body">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.public.footer')
@endsection