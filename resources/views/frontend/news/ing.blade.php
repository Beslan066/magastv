@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/pages/news-page.css')}}">
@endpush

@section('content')
    <main class="news-page" data-main>
        <section class="news-content">
            <div class="container">
                <div class="news-content__inner">
                    <div class="news-content__top">
                        <h1 class="page-title">Хоамаш</h1>
                        <div class="news-content__tabs_wrapper">
                            <div class="tabs">
                                <button class="btn-reset news-content__filters_btn news-content__filters_btn--mobile">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 6L13 6" stroke="#1A1A1A" stroke-width="1.5"/>
                                        <path d="M17 14L7 14" stroke="#1A1A1A" stroke-width="1.5"/>
                                        <circle cx="5" cy="14" r="2.25" stroke="#1A1A1A" stroke-width="1.5"/>
                                        <circle cx="15" cy="6" r="2.25" stroke="#1A1A1A" stroke-width="1.5"/>
                                    </svg>
                                </button>
                                <ul class="list-reset tabs__list" id="category-tabs">
                                    <li class="tab active" data-category-id="">
                                        <span>Все</span>
                                    </li>
                                    @foreach($categories as $category)
                                        <li class="tab" data-category-id="{{ $category->id }}">
                                            <span>{{ $category->name }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button class="btn-reset news-content__filters_btn" id="toggle-filters">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 6L13 6" stroke="#1A1A1A" stroke-width="1.5"/>
                                    <path d="M17 14L7 14" stroke="#1A1A1A" stroke-width="1.5"/>
                                    <circle cx="5" cy="14" r="2.25" stroke="#1A1A1A" stroke-width="1.5"/>
                                    <circle cx="15" cy="6" r="2.25" stroke="#1A1A1A" stroke-width="1.5"/>
                                </svg>
                                Фильтры
                            </button>
                        </div>
                        <div class="filters" id="filters-panel" style="display: none;">
                            <div class="filter-item filters--sort">
                                <span class="filter-item__title">Сортировка</span>
                                <div class="dropdown">
                                    <button type="button" class="dropdown__button" id="sort-button">По дате</button>
                                    <ul class="dropdown__list" id="sort-list">
                                        <li class="dropdown__list-item dropdown__list-item_active"
                                            data-value="published_at" data-order="desc">По дате (новые)
                                        </li>
                                        <li class="dropdown__list-item" data-value="published_at" data-order="asc">По
                                            дате (старые)
                                        </li>
                                        <li class="dropdown__list-item" data-value="views" data-order="desc">По
                                            просмотрам
                                        </li>
                                    </ul>
                                    <input type="hidden" name="sort_by" value="published_at" id="sort-input">
                                    <input type="hidden" name="sort_order" value="desc" id="order-input">
                                </div>
                            </div>
                            <div class="filter-item filters--time">
                                <span class="filter-item__title">Период</span>
                                <div class="dropdown">
                                    <button type="button" class="dropdown__button" id="period-button">Весь период
                                    </button>
                                    <ul class="dropdown__list" id="period-list">
                                        <li class="dropdown__list-item dropdown__list-item_active" data-value="all">Весь
                                            период
                                        </li>
                                        <li class="dropdown__list-item" data-value="week">Последняя неделя</li>
                                        <li class="dropdown__list-item" data-value="month">Последний месяц</li>
                                        <li class="dropdown__list-item" data-value="year">Последний год</li>
                                    </ul>
                                    <input type="hidden" name="period" value="all" id="period-input">
                                </div>
                            </div>
                            <button class="btn-reset btn-primary" id="apply-filters">Применить</button>
                        </div>
                    </div>
                    <div class="news-content__bottom">
                        <div class="news-content__left">
                            <div class="news-content__news-block">
                                <ul class="list-reset news-block__list news-block__list--second" id="news-list">
                                    @if($news->count() > 0)
                                        @include('frontend.partials.news.news_items', ['items' => $news])
                                    @else
                                        <li class="no-items">Нет видеорепортажей</li>
                                    @endif
                                </ul>
                            </div>
                            <div id="loading-indicator" style="display: none; text-align: center; padding: 20px;">
                                <div class="spinner"></div>
                                <p>Загрузка...</p>
                            </div>
                            <div class="news-content__right">
                                <div class="ads-block">
                                    <img src="{{asset('assets/add.jpg')}}" alt="add">
                                </div>
                                <div class="content__popular popular-sidebar popular-sidebar--news">
                                    <h3 class="popular-sidebar__title">Популярное</h3>
                                    <ul class="list-reset news-block__list news-block__list--second" id="news-list">
                                        @if($news)
                                            @include('frontend.partials.news.news_items', ['items' => $news])
                                        @endif
                                    </ul>
                                </div>
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
        class NewsLoader {
            constructor() {
                this.currentPage = 1;
                this.isLoading = false;
                this.hasMore = true;
                this.currentCategory = '';
                this.currentSort = 'published_at';
                this.currentOrder = 'desc';
                this.currentPeriod = 'all';

                this.initEvents();
            }

            initEvents() {
                // Табы категорий
                document.querySelectorAll('#category-tabs .tab').forEach(tab => {
                    tab.addEventListener('click', this.handleCategoryFilter.bind(this));
                });

                // Кнопка фильтров
                document.getElementById('toggle-filters').addEventListener('click', this.toggleFilters.bind(this));

                // Выбор сортировки
                document.querySelectorAll('#sort-list .dropdown__list-item').forEach(item => {
                    item.addEventListener('click', this.handleSortSelect.bind(this));
                });

                // Выбор периода
                document.querySelectorAll('#period-list .dropdown__list-item').forEach(item => {
                    item.addEventListener('click', this.handlePeriodSelect.bind(this));
                });

                // Применить фильтры
                document.getElementById('apply-filters').addEventListener('click', this.applyFilters.bind(this));

                // Кнопка "Показать еще"
                document.getElementById('load-more-btn').addEventListener('click', this.loadMore.bind(this));

                // Ленивая подгрузка при скролле
                window.addEventListener('scroll', this.handleScroll.bind(this));
            }

            handleCategoryFilter(e) {
                const categoryId = e.currentTarget.dataset.categoryId;

                if (this.currentCategory === categoryId) return;

                // Обновить активный таб
                document.querySelectorAll('#category-tabs .tab').forEach(tab => {
                    tab.classList.remove('active');
                });
                e.currentTarget.classList.add('active');

                this.currentCategory = categoryId;
                this.resetAndLoad();
            }

            handleSortSelect(e) {
                const sortValue = e.currentTarget.dataset.value;
                const sortOrder = e.currentTarget.dataset.order;

                document.querySelectorAll('#sort-list .dropdown__list-item').forEach(item => {
                    item.classList.remove('dropdown__list-item_active');
                });
                e.currentTarget.classList.add('dropdown__list-item_active');

                document.getElementById('sort-button').textContent = e.currentTarget.textContent;
                document.getElementById('sort-input').value = sortValue;
                document.getElementById('order-input').value = sortOrder;
            }

            handlePeriodSelect(e) {
                const periodValue = e.currentTarget.dataset.value;

                document.querySelectorAll('#period-list .dropdown__list-item').forEach(item => {
                    item.classList.remove('dropdown__list-item_active');
                });
                e.currentTarget.classList.add('dropdown__list-item_active');

                document.getElementById('period-button').textContent = e.currentTarget.textContent;
                document.getElementById('period-input').value = periodValue;
            }

            applyFilters() {
                this.currentSort = document.getElementById('sort-input').value;
                this.currentOrder = document.getElementById('order-input').value;
                this.currentPeriod = document.getElementById('period-input').value;

                this.toggleFilters();
                this.resetAndLoad();
            }

            toggleFilters() {
                const filtersPanel = document.getElementById('filters-panel');
                filtersPanel.style.display = filtersPanel.style.display === 'none' ? 'block' : 'none';
            }

            resetAndLoad() {
                this.currentPage = 1;
                this.hasMore = true;
                this.showLoader();
                this.loadNews(true);
            }

            async loadMore() {
                if (this.isLoading || !this.hasMore) return;

                this.currentPage++;
                await this.loadNews(false);
            }

            handleScroll() {
                if (this.isLoading || !this.hasMore) return;

                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.scrollHeight;

                if (scrollTop + windowHeight >= documentHeight - 500) {
                    this.loadMore();
                }
            }

            async loadNews(reset = false) {
                this.isLoading = true;
                this.showLoader();

                try {
                    const params = new URLSearchParams({
                        page: this.currentPage,
                        category_id: this.currentCategory,
                        sort_by: this.currentSort,
                        sort_order: this.currentOrder,
                        period: this.currentPeriod
                    });

                    const response = await fetch(`/news-ing?${params}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                    if (reset) {
                        document.getElementById('news-list').innerHTML = data.news_html || '';
                    } else {
                        document.getElementById('news-list').insertAdjacentHTML('beforeend', data.news_html || '');
                    }

                    this.hasMore = data.next_page;

                    // Обновить кнопку "Показать еще"
                    const loadMoreBtn = document.getElementById('load-more-container');
                    if (loadMoreBtn) {
                        loadMoreBtn.style.display = this.hasMore ? 'block' : 'none';
                    }

                    this.updateUrl();

                } catch (error) {
                    console.error('Error loading news:', error);
                } finally {
                    this.isLoading = false;
                    this.hideLoader();
                }
            }

            updateUrl() {
                const params = new URLSearchParams();
                if (this.currentCategory) params.set('category_id', this.currentCategory);
                if (this.currentSort !== 'published_at') params.set('sort_by', this.currentSort);
                if (this.currentOrder !== 'desc') params.set('sort_order', this.currentOrder);
                if (this.currentPeriod !== 'all') params.set('period', this.currentPeriod);

                const newUrl = `${window.location.pathname}?${params}`;
                window.history.replaceState({}, '', newUrl);
            }

            showLoader() {
                document.getElementById('loading-indicator').style.display = 'block';
                if (document.getElementById('load-more-btn')) {
                    document.getElementById('load-more-btn').disabled = true;
                }
            }

            hideLoader() {
                document.getElementById('loading-indicator').style.display = 'none';
                if (document.getElementById('load-more-btn')) {
                    document.getElementById('load-more-btn').disabled = false;
                }
            }
        }

        // Инициализация
        document.addEventListener('DOMContentLoaded', () => {
            new NewsLoader();
        });
    </script>
@endpush
