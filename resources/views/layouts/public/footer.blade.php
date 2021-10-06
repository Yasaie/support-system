<footer>
    <div id="footer1">
        <span class="footer-layer"></span>
        <div class="container">
            <div class="row">

                <div class="col-sm-6">
                    <h4 class="footer-content-title">اخبار</h4>
                    @inject('NewsHelperController','App\Http\Controllers\News\HelperController')
                    @php
                        $lastNews=$NewsHelperController::lastNews();
                    @endphp
                    @if($lastNews->isNotEmpty())
                        <ul class="footer-content-list">
                            @foreach($lastNews as $news)
                                <li>
                                    <a href="{{ route('news.show',$news) }}">{{ $news->title }}</a>
                                    <span class="footer-content-time">
                                        <i class="fa fa-clock-o fa-pull-left mt-1"></i>
                                        <span class="pull-left">
                                            {{ Date::make($news->created_at)->toj()->format('Y/m/d') }}
                                        </span>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="col-sm-6">
                    <h4 class="footer-content-title">سوالات متداول</h4>
                    @inject('FaqHelperController','App\Http\Controllers\Faq\HelperController')
                    @php
                        $lastFaqs=$FaqHelperController::lastFaqs();
                    @endphp
                    @if($lastFaqs->isNotEmpty())
                        <ul class="footer-content-list">
                            @foreach($lastFaqs as $faq)
                                <li>
                                    <a href="{{ route('faq.show',$faq) }}">{{ Str::limit(strip_tags($faq->question)) }}</a>
                                    <span class="footer-content-time">
                                        <i class="fa fa-clock-o fa-pull-left mt-1"></i>
                                        <span class="pull-left">
                                            {{ Date::make($faq->created_at)->toj()->format('Y/m/d') }}
                                        </span>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="subfooter">
        <div class="container">
            <p class="pull-right">
                <span>تمامی حقوق برای </span>
                <a href="{{ config('app.url') }}">
                    <strong>{{ config('app.name') }}</strong>
                </a>
                <span> محفوظ است</span>
            </p>
            <p class="pull-left">
                <span>طراحی و کدنویسی توسط </span>
                <a href="{{ config('app.core.url') }}">
                    <strong>{{ config('app.core.name') }}</strong>
                </a>
            </p>
        </div>
    </div>
</footer>
