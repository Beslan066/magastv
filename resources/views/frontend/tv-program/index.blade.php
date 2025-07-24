@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/tv-program.page.css')}}">
@endpush
@section('content')
    <main class="tvProgram__page" data-main>
        <section class="tvProgram__tv">
            <div class="container">
                <div class="tvProgram__inner">
                    <h1 class="page-title">
                        Телепрограмма
                    </h1>
                    <div class="tvProgram__main">
                        <div class="tvProgram__left">
                            <div class="ProgramTabBar">
                                <button class="btn-reset ProgramTabBar__btn ProgramTabBar__btn--prev">
                                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.25 1L2.25 10L11.25 19" stroke="#1A1A1A" stroke-width="2"/>
                                    </svg>
                                </button>

                                <div class="ProgramTabBar__scroll-container">
                                    <ul class="list-reset ProgramTabBar__list">
                                        @foreach($dates as $date)
                                            <li class="ProgramTabBar__item {{ $date['is_active'] ? 'active' : '' }}">
                                                <a href="?date={{ $date['date'] }}" class="tab-link">
                                                    <time>{{ $date['day'] }} {{ $date['month'] }}</time>
                                                    <span>{{ $date['weekday'] }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <button class="btn-reset ProgramTabBar__btn ProgramTabBar__btn--next">
                                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.75 1L9.75 10L0.75 19" stroke="#1A1A1A" stroke-width="2"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="programList">

                                @forelse($tvShows as $show)
                                    @php
                                        [$start, $end] = explode('-', $show->time_range);
                                        $now = \Carbon\Carbon::now('Europe/Moscow');
                                        $startTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $show->program_date->format('Y-m-d') . ' ' . trim($start));
                                        $endTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $show->program_date->format('Y-m-d') . ' ' . trim($end));
                                        $isActive = $now->between($startTime, $endTime);
                                    @endphp
                                    <div class="programListItem @if($show->top_show) programListItem--third @endif {{ $isActive ? 'active' : '' }}" style="display: flex; justify-content: space-between">

                                        <div style="display: flex;" >
                                            <div style="margin-right: 10px">
                                                <time datetime="{{ $show->program_date->format('Y-m-d') }} {{ $show->time_range }}">{{ Carbon\Carbon::parse($show->time_range)->format('H:i') }}</time>
                                            </div>
                                            <div class="programListItem__info">
                                                <h6 class="programListItem__title">
                                                    {{$show->title}}
                                                    <span class="programListItem__age"></span>
                                                </h6>
                                                <span class="programListItem__type">
                                                @if($show->tvShowType)
                                                        {{$show->tvShowType->title}}
                                                    @endif
                                            </span>
                                                <div class="programListItem__media programListItem__media--mobile">
                                                    <img src="{{asset('storage/public/' . $show->image)}}" alt="Program item image">
                                                </div>
                                                <p class="programListItem__text">
                                                    {{$show->description}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="programListItem__media">
                                            <img src="{{asset('storage/public/' . $show->image)}}" alt="Program item image">
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-message">
                                        <p>На выбранную дату телепрограмма отсутствует</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="single-news__right-block tvProgram__right">
                            <div class="ads-block">
                                <img src="{{ asset('assets/add.jpg') }}" alt="add">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabContainer = document.querySelector('.ProgramTabBar__scroll-container');
            const tabList = document.querySelector('.ProgramTabBar__list');
            const prevBtn = document.querySelector('.ProgramTabBar__btn--prev');
            const nextBtn = document.querySelector('.ProgramTabBar__btn--next');
            const tabItems = document.querySelectorAll('.ProgramTabBar__item');
            const scrollStep = 150;

            // Предзагрузка данных для соседних дат
            function preloadAdjacentDates() {
                const activeTab = document.querySelector('.ProgramTabBar__item.active');
                if (!activeTab) return;

                const activeIndex = Array.from(tabItems).indexOf(activeTab);
                const preloadDates = [];

                if (activeIndex > 0) preloadDates.push(tabItems[activeIndex - 1].querySelector('a').href);
                if (activeIndex < tabItems.length - 1) preloadDates.push(tabItems[activeIndex + 1].querySelector('a').href);

                preloadDates.forEach(url => {
                    fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                        .catch(() => {});
                });
            }

            // Прокрутка табов
            function scrollTabs(direction) {
                tabContainer.scrollBy({
                    left: direction * scrollStep,
                    behavior: 'smooth'
                });
            }

            prevBtn.addEventListener('click', () => scrollTabs(-1));
            nextBtn.addEventListener('click', () => scrollTabs(1));

            // Автоматическая прокрутка к активному табу
            const activeTab = document.querySelector('.ProgramTabBar__item.active');
            if (activeTab) {
                activeTab.scrollIntoView({
                    block: 'nearest',
                    inline: 'center',
                    behavior: 'auto'
                });
            }

            // Предзагрузка данных при наведении
            tabItems.forEach(tab => {
                tab.addEventListener('mouseenter', preloadAdjacentDates);
            });

            // Инициализация
            preloadAdjacentDates();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const tabBar = document.querySelector('.ProgramTabBar');
            const activeTab = document.querySelector('.ProgramTabBar__item.active');

            if (activeTab) {
                updateActiveTabIndicator(activeTab);
            }

            // Обновляем при клике на табы (если они меняются динамически)
            document.querySelectorAll('.ProgramTabBar__item').forEach(tab => {
                tab.addEventListener('click', () => {
                    updateActiveTabIndicator(tab);
                });
            });

            function updateActiveTabIndicator(tab) {
                const tabRect = tab.getBoundingClientRect();
                const tabBarRect = tabBar.getBoundingClientRect();

                // Вычисляем позицию относительно .ProgramTabBar
                const left = tabRect.left - tabBarRect.left;
                const width = tabRect.width;

                // Устанавливаем CSS-переменные
                tabBar.style.setProperty('--active-tab-left', `${left}px`);
                tabBar.style.setProperty('--active-tab-width', `${width}px`);
            }

            // Ресайз (если нужно обновлять при изменении размера окна)
            window.addEventListener('resize', () => {
                const activeTab = document.querySelector('.ProgramTabBar__item.active');
                if (activeTab) updateActiveTabIndicator(activeTab);
            });
        });
    </script>
@endpush
