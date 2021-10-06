@extends('layouts.user.app')

@section('title',' - اعلامیه های دریافتی')
@section('description','اعلامیه های دریافتی')
@section('keywords','اعلامیه های دریافتی')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/dropzone/dropzone.css') }}"  rel="stylesheet">
    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">

@endsection

@section('content')

    <!-- Navigation Bar-->
    @include('layouts.user.navigationBar')
    <!-- End Navigation Bar-->

    <!-- Start wrapper -->

    <div class="wrapper">
        <div class="container-fluid">

            <div class="row m-t-20">
                <div class="col-12">
                    <div class="card-box">
                        @include('partial.flashMessage')
                        <div class="row">
                            <div class="col-xs-12 col-sm-3">
                                <form action="{{ route('notification.inbox') }}" method="GET" role="form">
                                    <div class="form-group">
                                        <input type="text" name="search" placeholder="جستجو..." class="custom-search-field">
                                        <i class="fa fa-search" onclick="this.parentNode.parentNode.submit()"></i>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                {{ $notifications->links() }}
                            </div>
                        </div>
                        <!-- End row-->
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover custom-tbl">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>عنوان</th>
                                        <th>وضعیت</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>گزینه ها</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notifications as $notification)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $notification->subject }}</td>
                                            <td>{{ ( ($notification->recipients()->where('recipient_id','=',Auth::id())->first()->pivot->read_at) ? 'خوانده شده' : 'جدید' ) }}</td>
                                            <td>{{ Date::make($notification->created_at)->toJalali()->format('Y/m/d') }}</td>
                                            <td>
                                                @can('view',$notification)
                                                    <a class="btn btn-sm btn-success" href="{{ route('notification.show',$notification) }}">
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- end container -->
    </div>

    <!-- End wrapper -->

    <!-- Footer -->
    @include('layouts.user.footer')
    <!-- End Footer -->
    @include('layouts.lockScreenModal')
    <script>
        var resizefunc = [];
    </script>

@endsection

@section('bodyImport.plugin.prepend')

    <script src="{{ asset('js/detect.js') }}"></script>
    <script src="{{ asset('js/fastclick.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/jquery.blockUI.js') }}"></script>

@endsection

@section('bodyImport.plugin.append')

    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <!-- Counter Up  -->
    <script src="{{ asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}"></script>
    <!-- CustomBox -->
    <script src="{{ asset('plugins/custombox/dist/custombox.min.js') }}"></script>
    <script src="{{ asset('plugins/custombox/dist/legacy.min.js') }}"></script>
    <!-- idle timer -->
    <script src="{{ asset('plugins/jquery-idle/jquery.idle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/i18n/fa.js') }}"></script>
    <!-- DropZone -->
    <script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
    </script>
    <script src="{{ asset('js/star-rating.min.js') }}"></script>


@endsection

@section('bodyImport.append')

    <!-- Custom main Js -->
    <script>
        jQuery(document).ready(function ($) {

            $('[data-toggle=tooltip]').tooltip();

            $('.navbar-toggle.nav-link').click(function () {
                $(this).toggleClass('open');
                $('#navigation').slideToggle(400);
            });

            $('#title').keyup(function(){
               var content = '<ul class="m-0"><li><a href="#">عنوان یکی از اخبار یا سوالات متداول</a></li>' + '<li><a href="#">عنوان یکی از اخبار یا سوالات متداول</a></li>' + '<li><a href="#">عنوان یکی از اخبار یا سوالات متداول</a></li></ul>';
               $('.relatedSearchIcon').fadeIn();
               $('.showRelatedContent').fadeIn();
               setTimeout(function(){
                   $('.showRelatedContent').html(content);
               },3000);
            });

            $('#title').blur(function(){
                $('.relatedSearchIcon').hide();
                $('.showRelatedContent').hide();
                $('.showRelatedContent').html('');
            });
        });
    </script>

@endsection
