@extends('layouts.user.app')

@section('title',' - پنل کاربری')
@section('description','پنل کاربری')
@section('keywords','پنل کاربری')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">

@endsection

@section('content')

    <!-- Navigation Bar-->
    @include('layouts.user.navigationBar')
    <!-- End Navigation Bar-->

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row m-t-20">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-dark header-title m-t-0">واپسین تیکت ها</h4>
                                <p class="text-muted m-b-25 font-13">آخرین تیکت هایی که شما ثبت کرده اید</p>
                            </div>
                            @inject('ticketDataController','App\Http\Controllers\Ticket\DataController')
                            @php
                                $tickets=$ticketDataController::tickets();
                            @endphp
                            <div class="col-sm-6">
                                {{ $tickets->links() }}
                            </div>
                        </div>
                        <!-- End Row -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>عنوان</th>
                                    <th>دپارتمان</th>
                                    <th>وضعیت</th>
                                    <th>آخرین پاسخ</th>
                                    <th>گزینه ها</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td><a href="{{ route('ticket.show',$ticket) }}">{{ $ticket->subject }}</a></td>
                                            <td><span class="badge badge-inverse">{{ $ticket->department->name }}</span></td>
                                            <td>
                                                @if($ticket->closed())
                                                    <span class="badge badge-danger">بسته شده</span>
                                                @elseif($ticket->referral())
                                                    <span class="badge badge-dark">ارجاع داده شده</span>
                                                @elseif($ticket->replied())
                                                    <span class="badge badge-primary">پاسخ داده شده</span>
                                                @elseif($ticket->unreaded())
                                                    <span class="badge badge-warning">خوانده نشده</span>
                                                @elseif($ticket->readed())
                                                    <span class="badge badge-info">در انتظار بررسی</span>
                                                @endif
                                            </td>
                                            <td>{{ Date::make($ticket->updated_at)->toJalali()->format('Y/m/d') }}</td>
                                            <td>
                                                @can('delete',$ticket)
                                                <form action="{{ route('ticket.destroy',$ticket) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                @endcan
                                                    @unless($ticket->closed())
                                                    <a class="btn btn-sm btn-secondary" href="{{ route('ticket.close',$ticket)  }}" data-toggle="tooltip" title="بستن تیکت">
                                                        <i class="fa fa-times fa-fw"></i>
                                                    </a>
                                                    @endunless
                                                @can('delete',$ticket)
                                                    <button class="btn btn-sm btn-danger" type="submit">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $tickets->links() }}
                            </div>
                        </div>
                        <!-- End table -->
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->

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

@endsection

@section('bodyImport.append')

    <!-- Custom main Js -->
    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            $('[data-toggle=tooltip]').tooltip();

            $('.navbar-toggle.nav-link').click(function () {
                $(this).toggleClass('open');
                $('#navigation').slideToggle(400);
            });

        });//doc
    </script>

@endsection
