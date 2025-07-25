<!doctype html>

<html
    lang="ru"
    class="layout-menu-fixed layout-compact"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>МагасТВ - админ-панель</title>

    <meta name="description" content="" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('assets/test/assets/vendor/fonts/iconify-icons.css')}}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{asset('assets/test/assets/vendor/css/core.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/test/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{asset('assets/test/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- endbuild -->

    <link rel="stylesheet" href="{{asset('assets/test/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('assets/test/assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{asset('assets/test/assets/js/config.js')}}"></script>


    @stack('styles')


    <style>
        #clearPreview {
            width: 28px;
            height: 28px;
            padding: 0;
            line-height: 1;
        }

        #clearPreview i {
            font-size: 1.2rem;
            vertical-align: middle;
        }
    </style>


</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{route('admin.index')}}" class="app-brand-link">
                    <span class="app-brand-text demo menu-text fw-bold ms-2">МагасТВ</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
                </a>
            </div>

            <div class="menu-divider mt-0"></div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboards -->
                <li class="menu-item active open">
                    <a href="javascript:void(0);" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-smile"></i>
                        <div class="text-truncate" data-i18n="Dashboards">Дашборд</div>
                    </a>
                </li>

                <!-- Apps & Pages -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Контент</span>
                </li>

                @if(auth()->user()->role !== 'Администратор радио')
                    <li class="menu-item">
                        <a href="{{route('news.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-news"></i>
                            <div class="text-truncate" data-i18n="Basic">Новости</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('categories.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-tag"></i>
                            <div class="text-truncate" data-i18n="Basic">Категории</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('files.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div class="text-truncate" data-i18n="Basic">Файлы</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('video-reportages.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-video"></i>
                            <div class="text-truncate" data-i18n="Basic">Видеорепортаж</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('transfers.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            <div class="text-truncate" data-i18n="Basic">Передачи</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('video-transfers.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-video-recording"></i>
                            <div class="text-truncate" data-i18n="Basic">Видеопередачи</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('tv-show-type.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-tag"></i>
                            <div class="text-truncate" data-i18n="Basic">Типы телепередач</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('tv-programs.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            <div class="text-truncate" data-i18n="Basic">Телепрограмма</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('supervisors.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-male"></i>
                            <div class="text-truncate" data-i18n="Basic">Руководитель</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('contacts.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-map"></i>
                            <div class="text-truncate" data-i18n="Basic">Контакты</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('about.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-info-circle"></i>
                            <div class="text-truncate" data-i18n="Basic">О нас</div>
                        </a>
                    </li>

                    <!-- Components -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Пользователи</span></li>
                    <!-- Cards -->

                    <li class="menu-item">
                        <a href="{{route('roles.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-shield"></i>
                            <div class="text-truncate" data-i18n="Basic">Роли</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('users.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div class="text-truncate" data-i18n="Basic">Пользователи</div>
                        </a>
                    </li>

                    <!-- Forms & Tables -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Настройки</span></li>

                    <li class="menu-item">
                        <a class="menu-link">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div class="text-truncate" data-i18n="Basic">Настройки</div>
                        </a>
                    </li>
                @endif


                @if(in_array(auth()->user()->role, ['Администратор радио', 'Супер-админ']))
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Контент радио</span>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('radio-news.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-news"></i>
                            <div class="text-truncate" data-i18n="Basic">Анонсы</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('radio-broadcast.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-calendar-event"></i>
                            <div class="text-truncate" data-i18n="Basic">События</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-tag"></i>
                            <div class="text-truncate" data-i18n="Basic">Категории</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('radio-show-type.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ul"></i>
                            <div class="text-truncate" data-i18n="Basic">Категории передач</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('radio-programs.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            <div class="text-truncate" data-i18n="Basic">Программа передач</div>
                        </a>
                    </li>
                @endif
                <!-- Forms -->

            </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <nav
                class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                        <i class="icon-base bx bx-menu icon-md"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center me-auto">
                        <div class="nav-item d-flex align-items-center">
                            <span class="w-px-22 h-px-22"><i class="icon-base bx bx-search icon-md"></i></span>
                            <input
                                type="text"
                                class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none"
                                placeholder="Найти..."
                                aria-label="Найти..." />
                        </div>
                    </div>
                    <!-- /Search -->

                    <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                        <!-- Place this tag where you want the button to render. -->

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a
                                class="nav-link dropdown-toggle hide-arrow p-0"
                                href="javascript:void(0);"
                                data-bs-toggle="dropdown">
                                <div class="avatar">
                                    <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">John Doe</h6>
                                                <small class="text-body-secondary">Admin</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider my-1"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="icon-base bx bx-cog icon-md me-3"></i><span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 icon-base bx bx-credit-card icon-md me-3"></i
                          ><span class="flex-grow-1 align-middle">Billing Plan</span>
                          <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider my-1"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);">
                                        <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>
                <!-- / Content -->

                <!-- Footer -->
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->

<script src="{{asset('assets/test/assets/vendor/libs/jquery/jquery.js')}}"></script>

<script src="{{asset('assets/test/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/test/assets/vendor/js/bootstrap.js')}}"></script>

<script src="{{asset('assets/test/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

<script src="{{asset('assets/test/assets/vendor/js/menu.js')}}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset('assets/test/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

<!-- Main JS -->

<script src="{{asset('assets/test/assets/js/main.js')}}"></script>

<!-- Page JS -->
<script src="{{asset('assets/test/assets/js/dashboards-analytics.js')}}"></script>

<!-- Place this tag before closing body tag for github widget button. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<!-- Инициализация для старых браузеров -->

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });



</script>

@stack('scripts')

</body>
</html>
