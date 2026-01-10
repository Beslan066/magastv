@extends('layouts.admin')

@section('content')
    <div class="row">

        <h3>МагасТВ - сводка</h3>
        <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <svg width="36" height="36" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                         id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                        <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                        <path
                                            d="M12 7H6v6h6zm-2 4H8V9h2zm3 4H6v2h12v-2zm1-4h4v2h-4zm0-4h4v2h-4z"></path>
                                        <path
                                            d="M4 21h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2M4 5h16v14H4z"></path>
                                    </svg>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt3"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Новости</p>
                            <h4 class="card-title mb-3">{{$newsCount}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <svg width="36" height="36" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                         id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                        <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                        <path
                                            d="M18 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-4.33L22 17V7l-4 3.33zm-2 12H4V6h12z"></path>
                                        <path d="M11 8H9v3H6v2h3v3h2v-3h3v-2h-3z"></path>
                                    </svg>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt6"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Видеорепортажи</p>
                            <h4 class="card-title mb-3">{{$videoReportageCount}}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <svg width="36" height="36" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                         id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                        <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                        <path
                                            d="M12 7H6v6h6zm-2 4H8V9h2zm3 4H6v2h12v-2zm1-4h4v2h-4zm0-4h4v2h-4z"></path>
                                        <path
                                            d="M4 21h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2M4 5h16v14H4z"></path>
                                    </svg>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt3"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Аудио для передач</p>
                            <h4 class="card-title mb-3">{{$radioBroadcastCount}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <svg width="36" height="36" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                         id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                        <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                        <path
                                            d="M12 7H6v6h6zm-2 4H8V9h2zm3 4H6v2h12v-2zm1-4h4v2h-4zm0-4h4v2h-4z"></path>
                                        <path
                                            d="M4 21h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2M4 5h16v14H4z"></path>
                                    </svg>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt3"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Аудиокниги</p>
                            <h4 class="card-title mb-3">{{$audiobooksCount}}</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2 profile-report">
            <div class="row">
                <div class="col-6 mb-6 payments">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <svg width="36" height="36" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                         id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                        <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                        <path d="M3 3h4v4H3zM10 3h4v4h-4z"></path>
                                        <path d="M10 3h4v4h-4zM17 3h4v4h-4zM3 17h4v4H3zM10 17h4v4h-4z"></path>
                                        <path d="M10 17h4v4h-4zM17 17h4v4h-4zM3 10h4v4H3zM10 10h4v4h-4z"></path>
                                        <path d="M10 10h4v4h-4zM17 10h4v4h-4z"></path>
                                    </svg>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt4"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Передачи</p>
                            <h4 class="card-title mb-3">{{$transferCount}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-6 transactions">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <svg width="36" height="36" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                         id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                        <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                        <path
                                            d="M18 10c0-1.1-.9-2-2-2h-1.43l-2.71-4.51c-.18-.3-.51-.49-.86-.49H5v2h5.43l1.8 3H4c-1.1 0-2 .9-2 2v9c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-3l4 2v-7l-4 2zm-2 9H4v-9h12z"></path>
                                        <path d="M6 15h6v2H6z"></path>
                                    </svg>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt1"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Видеопередачи</p>
                            <h4 class="card-title mb-3">{{$videoTransferCount}}</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2 profile-report">
            <div class="row">
                <div class="col-6 mb-6 payments">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <svg width="36" height="36" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                         id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                        <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                        <path d="M3 3h4v4H3zM10 3h4v4h-4z"></path>
                                        <path d="M10 3h4v4h-4zM17 3h4v4h-4zM3 17h4v4H3zM10 17h4v4h-4z"></path>
                                        <path d="M10 17h4v4h-4zM17 17h4v4h-4zM3 10h4v4H3zM10 10h4v4h-4z"></path>
                                        <path d="M10 10h4v4h-4zM17 10h4v4h-4z"></path>
                                    </svg>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt4"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Анонсы Радио</p>
                            <h4 class="card-title mb-3">{{$radioNewsCount}}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-6 transactions">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4">
                                <div class="avatar flex-shrink-0">
                                    <svg width="36" height="36" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                         id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                        <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                        <path
                                            d="M18 10c0-1.1-.9-2-2-2h-1.43l-2.71-4.51c-.18-.3-.51-.49-.86-.49H5v2h5.43l1.8 3H4c-1.1 0-2 .9-2 2v9c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-3l4 2v-7l-4 2zm-2 9H4v-9h12z"></path>
                                        <path d="M6 15h6v2H6z"></path>
                                    </svg>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        id="cardOpt1"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-1">Радиопередачи</p>
                            <h4 class="card-title mb-3">{{$radioTransferCount}}</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Statistics -->
        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1 me-2">Пользователи</h5>
                    </div>
                    <div class="dropdown">
                        <button
                            class="btn text-body-secondary p-0"
                            type="button"
                            id="orederStatistics"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex flex-column gap-1 color-[#14ab28]">
                            <h3 class="mb-1">{{$usersCount}}</h3>
                            <span>Последние пользователи</span>
                        </div>
                    </div>
                    @if(isset($lastUsers))
                        <ul class="p-0 m-0">
                            @foreach($lastUsers as $user)
                                <li class="d-flex align-items-center mb-5">
                                    <div class="avatar flex-shrink-0 me-3">
                                        @if(isset($user->avatar))
                                            <img src="{{asset('storage/public/' . $user->avatar)}}" alt="">
                                        @else
                                            <svg width="24" height="24" fill="#14ab28" viewBox="0 0 24 24" transform="" id="injected-svg" xmlns="http://www.w3.org/2000/svg"><!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free--><path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5m0-8c1.65 0 3 1.35 3 3s-1.35 3-3 3-3-1.35-3-3 1.35-3 3-3M4 22h16c.55 0 1-.45 1-1v-1c0-3.86-3.14-7-7-7h-4c-3.86 0-7 3.14-7 7v1c0 .55.45 1 1 1m6-7h4c2.76 0 5 2.24 5 5H5c0-2.76 2.24-5 5-5"></path></svg>
                                        @endif
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{$user->name}}</h6>
                                            @if(isset($user->role))
                                                <small>{{$user->role->name}}</small>
                                            @endif
                                        </div>
                                        <div class="user-progress">
                                            <h6 class="mb-0">{{$user->created_at}}</h6>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <!--/ Order Statistics -->

        <!-- Expense Overview -->
        <div class="col-md-6 col-lg-4 order-2 mb-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Популярные видеорепортажи</h5>
                    <div class="dropdown">
                        <button
                            class="btn text-body-secondary p-0"
                            type="button"
                            id="transactionID"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    @if(isset($popularVideoReportages))
                        <ul class="p-0 m-0">
                            @foreach($popularVideoReportages as $post)
                                <li class="d-flex align-items-center mb-6">

                                    <div class="d-flex w-100  align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <a href="{{route('home.news.single', $post->slug)}}" target="_blank">
                                                <h6 class="fw-normal mb-0 break-words ">{{$post->title}}</h6>
                                            </a>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-2">
                                            <h6 class="fw-normal mb-0" style="max-width: 200px;">{{$post->views}}</h6>
                                            <svg width="24" height="24" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                                 id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                                <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                                <path d="M12 9a3 3 0 1 0 0 6 3 3 0 1 0 0-6"></path>
                                                <path
                                                    d="M12 19c7.63 0 9.93-6.62 9.95-6.68.07-.21.07-.43 0-.63-.02-.07-2.32-6.68-9.95-6.68s-9.93 6.61-9.95 6.67c-.07.21-.07.43 0 .63.02.07 2.32 6.68 9.95 6.68Zm0-12c5.35 0 7.42 3.85 7.93 5-.5 1.16-2.58 5-7.93 5s-7.42-3.84-7.93-5c.5-1.16 2.58-5 7.93-5"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <!--/ Expense Overview -->

        <!-- Transactions -->
        <div class="col-md-6 col-lg-4 order-2 mb-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Популярные новости</h5>
                    <div class="dropdown">
                        <button
                            class="btn text-body-secondary p-0"
                            type="button"
                            id="transactionID"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    @if(isset($popularPosts))
                        <ul class="p-0 m-0">
                            @foreach($popularPosts as $post)
                                <li class="d-flex align-items-center mb-6">

                                    <div class="d-flex w-100 align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <a href="{{route('home.news.single', $post->slug)}}" target="_blank">
                                                <h6 class="fw-normal mb-0 break-words ">{{$post->title}}</h6>
                                            </a>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-2">
                                            <h6 class="fw-normal mb-0" style="max-width: 200px;">{{$post->views}}</h6>
                                            <svg width="24" height="24" fill="#14ab28" viewBox="0 0 24 24" transform=""
                                                 id="injected-svg" xmlns="http://www.w3.org/2000/svg">
                                                <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                                <path d="M12 9a3 3 0 1 0 0 6 3 3 0 1 0 0-6"></path>
                                                <path
                                                    d="M12 19c7.63 0 9.93-6.62 9.95-6.68.07-.21.07-.43 0-.63-.02-.07-2.32-6.68-9.95-6.68s-9.93 6.61-9.95 6.67c-.07.21-.07.43 0 .63.02.07 2.32 6.68 9.95 6.68Zm0-12c5.35 0 7.42 3.85 7.93 5-.5 1.16-2.58 5-7.93 5s-7.42-3.84-7.93-5c.5-1.16 2.58-5 7.93-5"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </li>

                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <!--/ Transactions -->
    </div>
@endsection

