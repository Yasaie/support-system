<div id="lockScreenModal" class="modal-demo">
    <button type="button" class="close" onclick="location.href='{{ route('login') }}'">
        <span>×</span><span class="sr-only">بستن</span>
    </button>
    <h4 class="custom-modal-title">صفحه قفل شده است</h4>
    <div class="custom-modal-text">
        <div class="wrapper-page">
            <div class="text-center">
                <a href="{{ config('app.url') }}" title="{{ (getConfig::site_name() ? getConfig::site_name() : config('app.name','Laravel')) }}" class="logo-lg">
                    <span>{{ (getConfig::site_name() ? getConfig::site_name() : config('app.name','Laravel')) }}</span>
                </a>
            </div>
            <form method="post" id="unlockScreenForm" action="" role="form" class="text-center m-t-20">
                <div class="user-thumb">
                    <img src="../assets/images/users/avatar-2.jpg" class="rounded-circle img-thumbnail" alt="thumbnail">
                </div>
                <div class="form-group">
                    <h5 class="text-uppercase mt-2">{{ Auth::user()->name }}</h5>
                    <p class="text-muted">از آخرین فعالیت شما در صفحه بیش از 10 دقیقه گذشته است و ما نگران مسائل امنیتی شما هستیم.لطفا برای ادامه فعالیت کلمه عبور خود را وارد نمایید</p>
                    <div class="input-group m-t-30">
                        <input class="form-control" placeholder="کلمه عبور" type="password">
                        <i class="md md-vpn-key form-control-feedback l-h-34" style="left:6px;z-index: 99;"></i>
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-email btn-primary waves-effect waves-light"> ورود </button>
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('login') }}" class="text-muted"> تمایل به ادامه فعالیت ندارید؟</a>
                </div>
            </form>
        </div>
    </div>
</div>
