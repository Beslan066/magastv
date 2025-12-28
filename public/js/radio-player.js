document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('radio-stream');
    const playPauseBtn = document.getElementById('play-pause-btn');

    if (!audio || !playPauseBtn) {
        console.error('Audio or play button not found!');
        return;
    }

    const playSvg = playPauseBtn.querySelector('.play-svg--radio');
    const pauseSvg = playPauseBtn.querySelector('.pause-svg--radio');
    const volumeBtn = document.querySelector('.player__mute');
    const volumeSlider = document.querySelector('.range-input');

    console.log('Audio player initialized');

    // Состояние плеера
    const PlayerState = {
        IDLE: 'idle',
        LOADING: 'loading',
        PLAYING: 'playing',
        ERROR: 'error',
        RETRYING: 'retrying'
    };

    let currentState = PlayerState.IDLE;
    let currentSourceIndex = 0;
    let retryCount = 0;
    const MAX_RETRIES = 2;
    const RETRY_DELAYS = [1000, 3000, 5000];

    // Источники аудио - используем ТОЛЬКО прокси из-за Mixed Content
    const audioSources = [
        '/proxy/audio'  // Основной источник через прокси
    ];

    function updateStatus(message) {
        console.log('Player status:', message);
        // Здесь можно обновить UI статуса, если есть элемент для этого
    }

    // Функция для установки источника аудио
    function setAudioSource(source) {
        cleanupAudioListeners();
        
        // Сначала пауза и сброс
        audio.pause();
        audio.src = '';
        
        // Устанавливаем новый источник
        audio.src = source;
        audio.crossOrigin = "anonymous";
        
        console.log('Setting audio source to:', source);
        updateStatus(`Подключение к источнику...`);
        
        setupAudioListeners();
        updatePlayButtonState(false);
        
        // Загружаем аудио
        audio.load();
    }

    // Настройка обработчиков событий аудио
    function setupAudioListeners() {
        audio.addEventListener('play', onAudioPlay);
        audio.addEventListener('pause', onAudioPause);
        audio.addEventListener('error', onAudioError);
        audio.addEventListener('loadstart', onAudioLoadStart);
        audio.addEventListener('canplay', onAudioCanPlay);
        audio.addEventListener('stalled', onAudioStalled);
        audio.addEventListener('waiting', onAudioWaiting);
        audio.addEventListener('playing', onAudioPlaying);
        audio.addEventListener('ended', onAudioEnded);
        audio.addEventListener('volumechange', onVolumeChange);
    }

    // Очистка обработчиков событий
    function cleanupAudioListeners() {
        audio.removeEventListener('play', onAudioPlay);
        audio.removeEventListener('pause', onAudioPause);
        audio.removeEventListener('error', onAudioError);
        audio.removeEventListener('loadstart', onAudioLoadStart);
        audio.removeEventListener('canplay', onAudioCanPlay);
        audio.removeEventListener('stalled', onAudioStalled);
        audio.removeEventListener('waiting', onAudioWaiting);
        audio.removeEventListener('playing', onAudioPlaying);
        audio.removeEventListener('ended', onAudioEnded);
        audio.removeEventListener('volumechange', onVolumeChange);
    }

    // Обработчики событий аудио
    function onAudioPlay() {
        console.log('Audio play event fired');
        currentState = PlayerState.PLAYING;
        updatePlayButtonState(true);
        updateStatus('Воспроизведение');
    }

    function onAudioPause() {
        console.log('Audio pause event fired');
        if (currentState !== PlayerState.RETRYING) {
            currentState = PlayerState.IDLE;
        }
        updatePlayButtonState(false);
        updateStatus('Пауза');
    }

    function onAudioError(e) {
        console.error('Audio error:', audio.error, e);
        currentState = PlayerState.ERROR;
        updatePlayButtonState(false);
        playPauseBtn.classList.remove('loading');
        updateStatus(`Ошибка: ${getErrorMessage(audio.error)}`);
        
        // Только если пользователь хотел воспроизвести, пробуем другой источник
        if (playPauseBtn.classList.contains('user-requested-play')) {
            setTimeout(() => tryNextAudioSource(), 2000);
        }
    }

    function onAudioLoadStart() {
        console.log('Audio loading started');
        currentState = PlayerState.LOADING;
        updateStatus('Загрузка...');
    }

    function onAudioCanPlay() {
        console.log('Audio can play');
        updateStatus('Готов к воспроизведению');
    }

    function onAudioStalled() {
        console.log('Audio stalled');
        updateStatus('Буферизация...');
        
        // Ждем 5 секунд, если все еще пауза - пробуем переподключиться
        setTimeout(() => {
            if (currentState === PlayerState.PLAYING && audio.paused) {
                updateStatus('Проблема с соединением...');
                tryNextAudioSource();
            }
        }, 5000);
    }

    function onAudioWaiting() {
        console.log('Audio waiting');
        updateStatus('Буферизация...');
    }

    function onAudioPlaying() {
        console.log('Audio playing');
        currentState = PlayerState.PLAYING;
        updateStatus('Воспроизведение');
    }
    
    function onAudioEnded() {
        console.log('Audio ended');
        currentState = PlayerState.IDLE;
        updatePlayButtonState(false);
        updateStatus('Воспроизведение завершено');
    }
    
    function onVolumeChange() {
        console.log('Volume changed:', audio.volume, 'muted:', audio.muted);
    }

    function getErrorMessage(error) {
        if (!error) return 'Неизвестная ошибка';
        
        switch(error.code) {
            case MediaError.MEDIA_ERR_ABORTED:
                return 'Воспроизведение прервано';
            case MediaError.MEDIA_ERR_NETWORK:
                return 'Проблема с сетью';
            case MediaError.MEDIA_ERR_DECODE:
                return 'Ошибка декодирования';
            case MediaError.MEDIA_ERR_SRC_NOT_SUPPORTED:
                return 'Формат не поддерживается';
            default:
                return `Ошибка: ${error.message || 'Неизвестная'}`;
        }
    }

    // Основная функция воспроизведения/паузы
    function togglePlayback() {
        // Помечаем, что пользователь хочет воспроизвести
        playPauseBtn.classList.add('user-requested-play');
        
        if (audio.paused) {
            console.log('Attempting to play...');
            currentState = PlayerState.LOADING;
            playPauseBtn.classList.add('loading');
            updateStatus('Подключение...');
            
            // Проверяем, есть ли источник
            if (!audio.src) {
                setAudioSource(audioSources[0]);
            }
            
            // Пытаемся воспроизвести
            const playPromise = audio.play();
            
            if (playPromise !== undefined) {
                playPromise
                    .then(() => {
                        console.log('Playback started successfully');
                        currentState = PlayerState.PLAYING;
                        updatePlayButtonState(true);
                        playPauseBtn.classList.remove('loading');
                        retryCount = 0;
                        updateStatus('Воспроизведение');
                    })
                    .catch(error => {
                        console.error('Playback failed:', error);
                        currentState = PlayerState.ERROR;
                        playPauseBtn.classList.remove('loading');
                        updateStatus('Ошибка воспроизведения');
                        
                        // Пробуем другой источник
                        tryNextAudioSource();
                    });
            }
        } else {
            // Пауза
            audio.pause();
            currentState = PlayerState.IDLE;
            updatePlayButtonState(false);
            playPauseBtn.classList.remove('user-requested-play');
            console.log('Playback paused');
            updateStatus('Пауза');
        }
    }

    // Функция попытки следующего источника (исправленная)
    function tryNextAudioSource() {
        if (retryCount >= MAX_RETRIES) {
            console.error('Max retries exceeded');
            updateStatus('Все источники недоступны');
            showErrorMessage('Не удалось подключиться к радио. Попробуйте позже.');
            playPauseBtn.classList.remove('loading', 'user-requested-play');
            return;
        }
        
        // Увеличиваем счетчик попыток
        retryCount++;
        
        // Пробуем следующий источник (по кругу)
        currentSourceIndex = (currentSourceIndex + 1) % audioSources.length;
        
        currentState = PlayerState.RETRYING;
        const delay = RETRY_DELAYS[retryCount - 1] || 1000;
        
        updateStatus(`Попытка подключения ${retryCount}/${MAX_RETRIES}...`);
        
        // Ждем перед попыткой
        setTimeout(() => {
            console.log('Trying next source:', audioSources[currentSourceIndex]);
            
            // Устанавливаем новый источник
            setAudioSource(audioSources[currentSourceIndex]);
            
            // Пытаемся воспроизвести только если пользователь хотел играть
            if (playPauseBtn.classList.contains('user-requested-play')) {
                audio.play().catch(e => {
                    console.error('Failed with new source:', e);
                    // Рекурсивно пробуем следующий источник
                    tryNextAudioSource();
                });
            }
        }, delay);
    }

    // Обновление кнопки воспроизведения/паузы
    function updatePlayButtonState(isPlaying) {
        if (isPlaying) {
            playSvg.style.display = 'none';
            pauseSvg.style.display = 'block';
            playPauseBtn.classList.add('playing');
        } else {
            playSvg.style.display = 'block';
            pauseSvg.style.display = 'none';
            playPauseBtn.classList.remove('playing');
        }
    }

    // Показать сообщение об ошибке
    function showErrorMessage(message) {
        console.error('Player error:', message);
        
        // Создаем или находим элемент для сообщений
        let errorDiv = document.getElementById('radio-error-message');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.id = 'radio-error-message';
            errorDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #f44336;
                color: white;
                padding: 15px;
                border-radius: 5px;
                z-index: 9999;
                max-width: 300px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            `;
            document.body.appendChild(errorDiv);
        }
        
        errorDiv.innerHTML = `
            <p style="margin: 0 0 10px 0;">${message}</p>
            <button onclick="this.parentElement.remove()" 
                    style="background: none; border: 1px solid white; color: white; padding: 5px 10px; border-radius: 3px; cursor: pointer;">
                Закрыть
            </button>
        `;
        
        setTimeout(() => {
            if (errorDiv && errorDiv.parentElement) {
                errorDiv.remove();
            }
        }, 5000);
    }

    // Управление громкостью (полностью восстановлено)
    function setupVolumeControls() {
        if (volumeBtn && volumeSlider) {
            const muteSvg = volumeBtn.querySelector('.player__mute-muteSvg');
            const unmuteSvg = volumeBtn.querySelector('.player__mute-unmuteSvg');
            
            volumeBtn.addEventListener('click', () => {
                audio.muted = !audio.muted;
                
                if (audio.muted) {
                    muteSvg.style.display = 'none';
                    unmuteSvg.style.display = 'block';
                    updateStatus('Звук выключен');
                } else {
                    muteSvg.style.display = 'block';
                    unmuteSvg.style.display = 'none';
                    updateStatus('Звук включен');
                }
                
                volumeBtn.classList.toggle('muted', audio.muted);
            });

            volumeSlider.addEventListener('input', (e) => {
                audio.volume = e.target.value / 100;
                audio.muted = false;
                
                // Показываем правильную иконку
                if (muteSvg && unmuteSvg) {
                    muteSvg.style.display = 'block';
                    unmuteSvg.style.display = 'none';
                }
                
                volumeBtn.classList.remove('muted');
                updateStatus(`Громкость: ${e.target.value}%`);
            });

            // Устанавливаем начальную громкость
            audio.volume = 0.7;
            volumeSlider.value = 70;
        }
    }

    // Проверка онлайн-статуса
    window.addEventListener('online', () => {
        if (currentState === PlayerState.ERROR) {
            updateStatus('Соединение восстановлено');
        }
    });

    window.addEventListener('offline', () => {
        if (currentState === PlayerState.PLAYING) {
            updateStatus('Потеряно соединение с интернетом');
        }
    });

    // Обработчик клика на кнопку воспроизведения
    playPauseBtn.addEventListener('click', togglePlayback);

    // Предварительная проверка источников
    async function preloadAudioSources() {
        for (let i = 0; i < audioSources.length; i++) {
            try {
                const response = await fetch(audioSources[i], {
                    method: 'HEAD',
                    mode: 'no-cors' // Используем no-cors для обхода CORS
                });
                console.log(`Source ${i + 1} is reachable`);
            } catch (error) {
                console.warn(`Source ${i + 1} may be unreachable:`, error);
            }
        }
    }

    // Инициализация плеера
    function initPlayer() {
        setupAudioListeners();
        setupVolumeControls();
        
        // Устанавливаем начальный источник
        setAudioSource(audioSources[0]);
        
        updateStatus('Готов к воспроизведению');
        
        // Предварительная проверка
        preloadAudioSources();
        
        console.log('Player initialized successfully');
    }

    // Запускаем инициализацию
    initPlayer();

    // Экспорт функций для отладки (можно удалить в продакшене)
    window.radioPlayer = {
        audio,
        getState: () => currentState,
        getCurrentSource: () => audioSources[currentSourceIndex],
        manualRetry: () => tryNextAudioSource(),
        setSource: (index) => {
            if (index >= 0 && index < audioSources.length) {
                currentSourceIndex = index;
                setAudioSource(audioSources[index]);
            }
        },
        play: () => togglePlayback(),
        pause: () => audio.pause()
    };
});