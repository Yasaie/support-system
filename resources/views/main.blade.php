@extends('layouts.public.app')

@section('description',config('app.description'))
@section('keywords',config('app.keywords'))

@section('content')
    @include('layouts.public.header')
    @if(config('app.guestTicket.status'))
    <main class="container main">
        <div class="row mb-3">
            <div class="col-12">
                <h4 class="text-center">
                    <span>پاسخ سوالات خود را در میان</span>
                    <a href="{{ route('news.landing') }}">اخبار</a>
                    <span>و</span>
                    <a href="{{ route('faq.landing') }}">سوالات متداول</a>
                    <span>پیدا نکردید؟</span>
                </h4>
                <p class="text-center mt-4 text-medium">
                    <span>میتوانید با</span>
                    <a href="{{ route('register') }}"><strong>عضویت در سامانه پشتیبانی</strong></a>
                    <span>برای کارشناسان ما تیکت ارسال کنید و یا میتوانید بدون عضویت</span>
                    <a href="#sendGuestTicketBTN"><strong>به عنوان مهمان تیکت ارسال کنید</strong></a>
                </p>
            </div>
        </div>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <div class="row mb-5">
            <div class="offset-sm-2 col-sm-4 p-sm-0">
                <button class="btn btn-secondary btn-block rounded-0 py-2" id="sendGuestTicketBTN">ارسال تیکت مهمان</button>
            </div>
            <div class="col-sm-4 p-sm-0">
                <button class="btn btn-outline-secondary btn-block rounded-0 py-2" id="trackGuestTicketBTN">رهگیری تیکت مهمان</button>
            </div>
            <div class="col-sm-2"></div>
        </div>
        <div class="row" id="sendGuestTicketSection">
            <div class="col-sm-7">
                @include('partial.flashMessage')
                <form action="{{ route('ticket.guest.store') }}" method="post" role="form" id="sendGuestTicketForm1">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('subject') ? ' has-error' : '' }}">
                        <input name="subject" value="{{ old('subject') }}" class="form-control" type="text" id="subject" placeholder="موضوع تیکت خود را وارد کنید"/>

                        @if ($errors->has('subject'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('subject') }}</strong>
                            </span>
                        @endif
                    </div>

                    @inject('departmentModel','App\Department')
                    @php
                        $departments=$departmentModel::whereNull('hidden_at')->orderBy('name')->get();
                    @endphp

                    @unless($departments->isEmpty())

                    <div class="form-group {{ $errors->has('department') ? ' has-error' : '' }} row">
                        <div class="col-sm-12">
                            <select name="department" id="department" class="form-control" data-placeholder="دپارتمان تیکت را انتخاب کنید">
                                <option value="" selected disabled>انتخاب دپارتمان</option>
                                @unless($departments->isEmpty())
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department')==$department->id ?' selected ':'' }}>{{ $department->name }}</option>
                                    @endforeach
                                @endunless
                            </select>
                            @if ($errors->has('department'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('department') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @endUnless

                    @inject('priorityClass','App\Http\Controllers\Ticket\TicketPriority')
                    @php
                        $priorities=$priorityClass::getList();
                    @endphp

                    <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }} row">
                        <div class="col-sm-12">
                            <select id="priority" class="form-control" name="priority">
                                <option value="" selected disabled>انتخاب اولویت</option>
                                @foreach($priorities as $priorityId=>$priorityName)
                                    <option value="{{ $priorityId }}" {{ old('priority')==$priorityId ?' selected ':'' }}>{{ $priorityName }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('priority'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('priority') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ ($errors->has('content') || $errors->has('medias')) ? ' has-error' : '' }} row">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="content" placeholder="محتوا تیکت" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
                            @if ($errors->has('content'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                            @if ($errors->has('content'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('captcha') ? ' has-error' : '' }} row">
                        <div class="col-12">
                            <div class="input-group">
                                <input name="captcha" class="form-control" type="text" placeholder="تصویر امنیتی" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="mdi mdi-image"></i></span>
                                </div>
                            </div>
                            @if ($errors->has('captcha'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                            @endif
                            <div style="margin-top:10px" class="text-center position-relative bg-white">
                                <img id="captcha" class="mw-100" src="{{ route('captcha') }}" alt="captcha-image">
                                <button class="btn btn-green btn-sm align-middle" type="button" onclick="document.getElementById('captcha').src='{{ route('captcha') }}'+'?rnd='+Math.random();">
                                    <span class="fa fa-refresh"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <button class="btn btn-secondary w-md pull-left" type="submit">ارسال تیکت</button>
                    </div>
                    <div id="result"></div>
                </form>
            </div>
            <div class="col-sm-5">
                <h6 class="text-primary text-medium">قوانین ارسال تیکت</h6>
                <ol id="rules">
                    <li class="text-justify">
                        قبل از ارسال تیکت با <strong class="text-primary scrollToSearch">جستجو در قسمت مربوطه</strong> ابتدا
                        به دنبال یافتن پاسخ سوالات خود در بخش های <a href="#"><strong class="text-primary">مقالات</strong></a> و <a href="#"><strong class="text-primary">سوالات
                        متداول</strong></a> باشید.
                    </li>
                    <li class="text-justify">
                        چنانچه قبلا تیکتی با موضوع مشابه ارسال کرده اید از ایجاد تیکت جدید خودداری کرده و از تیکت قبل اقدام
                        به پیگیری فرمایید.(تیکت های تکراری در اولویت پایین تری برای پاسخگویی قرار خواهند گرفت).
                    </li>
                    <li class="text-justify">
                        توهین به اشخاص،اقوام و ملیت ها ممنوع بوده و باتوجه به ثبت اطلاعات شما در سامانه امکان پیگیری هرگونه
                        سوء استفاده و توهین وجود خواهد داشت.
                    </li>
                </ol>
            </div>
        </div>
        <div class="row" id="trackGuestTicketSection" style="display:none;">
            <div class="col-sm-8 offset-sm-2 pt-4 pb-3 jumbotron">
                <form action="{{ route('ticket.guest.redirect') }}" method="post" role="form" id="trackGuestTicketForm1">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="access_key" class="form-control" placeholder="کد رهگیری خود را وارد کنید">
                        <span class="form-text guid-text">کد رهگیری خود را که به هنگام ثبت تیکت دریافت کردید در قسمت مشخص شده وارد کنید</span>
                    </div>
                    <div class="form-group clearfix m-0">
                        <button class="btn btn-sm btn-secondary pull-left" type="submit">رهگیری تیکت</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </main>
    @else
    <main class="container main">
        <div class="row mb-3">
            <div class="col-12">
                <h4 class="text-center">
                    <span>پاسخ سوالات خود را در میان</span>
                    <a href="{{ route('news.landing') }}">اخبار</a>
                    <span>و</span>
                    <a href="{{ route('faq.landing') }}">سوالات متداول</a>
                    <span>پیدا نکردید؟</span>
                </h4>
                <p class="text-center mt-4 text-medium">
                    <span>میتوانید با</span>
                    <a href="{{ route('register') }}"><strong>عضویت در سامانه پشتیبانی</strong></a>
                    <span>برای کارشناسان ما تیکت ارسال کنید</span>
                </p>
            </div>
        </div>
    </main>
    @endif
    @include('layouts.public.footer')
@endsection