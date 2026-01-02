// radio-player-fixed.js
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
    let isManualPause = false;
    const MAX_RETRIES = 3;
    const RETRY_DELAYS = [1000, 3000, 5000];

    // Источники аудио - используем ТОЛЬКО прокси с разными URL для ретраев
    const audioSources = [
        '/proxy/audio',
        '/proxy/audio?retry=1',  // Разные URL для обхода кэша
        '/proxy/audio?retry=2'
    ];

    function updateStatus(message) {
        console.log('Player status:', message);
        // Здесь можно обновить UI статуса, если есть элемент для этого
    }

    // Функция для установки источника аудио
    function setAudioSource(source) {
        cleanupAudioListeners();
        
        // Пауза перед сменой источника
        audio.pause();
        
        // Очищаем текущий источник
        audio.src = '';
        
        // Добавляем timestamp для обхода кэша
        const timestamp = Date.now();
        const sourceWithCacheBust = source.includes('?') 
            ? `${source}&_=${timestamp}`
            : `${source}?_=${timestamp}`;
        
        // Устанавливаем новый источник
        audio.src = sourceWithCacheBust;
        audio.crossOrigin = "anonymous";
        audio.preload = "none";
        
        console.log('Setting audio source to:', sourceWithCacheBust);
        updateStatus(`Подключение к источнику...`);
        
        setupAudioListeners();
        updatePlayButtonState(false);
        
        // Загружаем аудио асинхронно
        setTimeout(() => {
            audio.load();
        }, 100);
    }

    // Настройка обработчиков событий аудио
    function setupAudioListeners() {
        audio.addEventListener('play', onAudioPlay);
        audio.addEventListener('pause', onAudioPause);
        audio.addEventListener('error', onAudioError);
        audio.addEventListener('loadstart', onAudioLoadStart);
        audio.addEventListener('canplay', onAudioCanPlay);
        audio.addEventListener('canplaythrough', onAudioCanPlayThrough);
        audio.addEventListener('stalled', onAudioStalled);
        audio.addEventListener('waiting', onAudioWaiting);
        audio.addEventListener('playing', onAudioPlaying);
        audio.addEventListener('ended', onAudioEnded);
        audio.addEventListener('volumechange', onVolumeChange);
        audio.addEventListener('abort', onAudioAbort);
    }

    // Очистка обработчиков событий
    function cleanupAudioListeners() {
        audio.removeEventListener('play', onAudioPlay);
        audio.removeEventListener('pause', onAudioPause);
        audio.removeEventListener('error', onAudioError);
        audio.removeEventListener('loadstart', onAudioLoadStart);
        audio.removeEventListener('canplay', onAudioCanPlay);
        audio.removeEventListener('canplaythrough', onAudioCanPlayThrough);
        audio.removeEventListener('stalled', onAudioStalled);
        audio.removeEventListener('waiting', onAudioWaiting);
        audio.removeEventListener('playing', onAudioPlaying);
        audio.removeEventListener('ended', onAudioEnded);
        audio.removeEventListener('volumechange', onVolumeChange);
        audio.removeEventListener('abort', onAudioAbort);
    }

    // Обработчики событий аудио
    function onAudioPlay() {
        console.log('Audio play event fired');
        currentState = PlayerState.PLAYING;
        updatePlayButtonState(true);
        updateStatus('Воспроизведение');
        isManualPause = false;
        retryCount = 0; // Сбрасываем счетчик при успешном воспроизведении
    }

    function onAudioPause() {
        console.log('Audio pause event fired');
        
        // Если это не ручная пауза и мы не в процессе ретрая
        if (!isManualPause && currentState !== PlayerState.RETRYING) {
            // Проверяем, не произошла ли ошибка
            if (audio.error && audio.error.code === MediaError.MEDIA_ERR_NETWORK) {
                console.log('Network error detected, attempting retry...');
                setTimeout(() => tryNextAudioSource(), 1000);
                return;
            }
        }
        
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
        if (playPauseBtn.classList.contains('user-requested-play') && !isManualPause) {
            console.log('User wanted to play, attempting retry...');
            setTimeout(() => tryNextAudioSource(), 1000);
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
    
    function onAudioCanPlayThrough() {
        console.log('Audio can play through');
        updateStatus('Буферизация завершена');
    }

    function onAudioStalled() {
        console.log('Audio stalled');
        updateStatus('Буферизация...');
        
        // Ждем 3 секунды, если все еще пауза - пробуем переподключиться
        setTimeout(() => {
            if (currentState === PlayerState.PLAYING && audio.paused && !isManualPause) {
                console.log('Stream stalled, attempting recovery...');
                updateStatus('Проблема с соединением...');
                tryNextAudioSource();
            }
        }, 3000);
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
    
    function onAudioAbort() {
        console.log('Audio abort');
        updateStatus('Воспроизведение прервано');
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
            isManualPause = false;
            
            // Проверяем, есть ли источник
            if (!audio.src || audio.error) {
                console.log('Setting initial audio source');
                setAudioSource(audioSources[0]);
                currentSourceIndex = 0;
                retryCount = 0;
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
                        retryCount = 0; // Сбрасываем счетчик при успехе
                        updateStatus('Воспроизведение');
                    })
                    .catch(error => {
                        console.error('Playback failed:', error.name, error.message);
                        currentState = PlayerState.ERROR;
                        playPauseBtn.classList.remove('loading');
                        updateStatus('Ошибка воспроизведения');
                        
                        // Не пытаемся ретраить если пользователь запретил автовоспроизведение
                        if (error.name === 'NotAllowedError') {
                            showErrorMessage('Разрешите воспроизведение звука в настройках браузера');
                        } else {
                            // Пробуем другой источник
                            tryNextAudioSource();
                        }
                    });
            }
        } else {
            // Пауза
            isManualPause = true;
            audio.pause();
            currentState = PlayerState.IDLE;
            updatePlayButtonState(false);
            playPauseBtn.classList.remove('user-requested-play');
            console.log('Playback paused manually');
            updateStatus('Пауза');
        }
    }

    // Функция попытки следующего источника (исправленная без рекурсии)
    function tryNextAudioSource() {
        if (retryCount >= MAX_RETRIES) {
            console.error('Max retries exceeded');
            updateStatus('Все источники недоступны');
            showErrorMessage('Не удалось подключиться к радио. Попробуйте позже или обновите страницу.');
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
            if (playPauseBtn.classList.contains('user-requested-play') && !isManualPause) {
                audio.play()
                    .then(() => {
                        console.log('Retry successful');
                        retryCount = 0; // Сбрасываем счетчик при успехе
                    })
                    .catch(error => {
                        console.error('Failed with new source:', error);
                        
                        // Если это не NotAllowedError, пробуем снова
                        if (error.name !== 'NotAllowedError') {
                            // Следующая попытка через таймаут
                            setTimeout(() => tryNextAudioSource(), 2000);
                        }
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
                padding: 15px 20px;
                border-radius: 8px;
                z-index: 9999;
                max-width: 350px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                font-family: Arial, sans-serif;
                font-size: 14px;
                animation: slideIn 0.3s ease;
            `;
            
            // Добавляем стили анимации
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            document.head.appendChild(style);
            
            document.body.appendChild(errorDiv);
        }
        
        errorDiv.innerHTML = `
            <p style="margin: 0 0 12px 0; font-weight: bold;">Ошибка радио</p>
            <p style="margin: 0 0 15px 0;">${message}</p>
            <button onclick="this.parentElement.remove()" 
                    style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.5); 
                           color: white; padding: 6px 16px; border-radius: 4px; cursor: pointer;
                           font-size: 13px; transition: background 0.2s;">
                Закрыть
            </button>
        `;
        
        // Автоматическое скрытие через 7 секунд
        setTimeout(() => {
            if (errorDiv && errorDiv.parentElement) {
                errorDiv.style.opacity = '0';
                errorDiv.style.transition = 'opacity 0.3s';
                setTimeout(() => {
                    if (errorDiv && errorDiv.parentElement) {
                        errorDiv.remove();
                    }
                }, 300);
            }
        }, 7000);
    }

    // Управление громкостью (полностью восстановлено)
    function setupVolumeControls() {
        if (volumeBtn && volumeSlider) {
            const muteSvg = volumeBtn.querySelector('.player__mute-muteSvg');
            const unmuteSvg = volumeBtn.querySelector('.player__mute-unmuteSvg');
            
            // Инициализация иконок
            if (muteSvg && unmuteSvg) {
                muteSvg.style.display = 'block';
                unmuteSvg.style.display = 'none';
            }
            
            volumeBtn.addEventListener('click', () => {
                audio.muted = !audio.muted;
                
                if (audio.muted) {
                    if (muteSvg && unmuteSvg) {
                        muteSvg.style.display = 'none';
                        unmuteSvg.style.display = 'block';
                    }
                    updateStatus('Звук выключен');
                } else {
                    if (muteSvg && unmuteSvg) {
                        muteSvg.style.display = 'block';
                        unmuteSvg.style.display = 'none';
                    }
                    updateStatus('Звук включен');
                }
                
                volumeBtn.classList.toggle('muted', audio.muted);
            });

            volumeSlider.addEventListener('input', (e) => {
                const volume = e.target.value / 100;
                audio.volume = volume;
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
            
            // Проверяем начальное состояние mute
            if (audio.muted) {
                volumeBtn.classList.add('muted');
                if (muteSvg && unmuteSvg) {
                    muteSvg.style.display = 'none';
                    unmuteSvg.style.display = 'block';
                }
            }
        }
    }

    // Проверка онлайн-статуса
    window.addEventListener('online', () => {
        console.log('Browser is online');
        if (currentState === PlayerState.ERROR) {
            updateStatus('Соединение восстановлено');
            // Автоматически пробуем возобновить воспроизведение
            if (playPauseBtn.classList.contains('user-requested-play')) {
                setTimeout(() => {
                    setAudioSource(audioSources[0]);
                    currentSourceIndex = 0;
                    retryCount = 0;
                    audio.play().catch(e => console.log('Auto-reconnect failed:', e));
                }, 1000);
            }
        }
    });

    window.addEventListener('offline', () => {
        console.log('Browser is offline');
        if (currentState === PlayerState.PLAYING) {
            updateStatus('Потеряно соединение с интернетом');
        }
    });

    // Обработчик клика на кнопку воспроизведения
    playPauseBtn.addEventListener('click', togglePlayback);

    // Инициализация плеера
    function initPlayer() {
        setupAudioListeners();
        setupVolumeControls();
        
        // Устанавливаем начальный источник с задержкой
        setTimeout(() => {
            setAudioSource(audioSources[0]);
            updateStatus('Готов к воспроизведению');
        }, 500);
        
        console.log('Player initialized successfully');
    }

    // Запускаем инициализацию
    initPlayer();

    // Экспорт функций для отладки (можно удалить в продакшене)
    window.radioPlayer = {
        audio,
        getState: () => currentState,
        getCurrentSource: () => audioSources[currentSourceIndex],
        manualRetry: () => {
            retryCount = 0;
            tryNextAudioSource();
        },
        setSource: (index) => {
            if (index >= 0 && index < audioSources.length) {
                currentSourceIndex = index;
                retryCount = 0;
                setAudioSource(audioSources[index]);
            }
        },
        play: () => togglePlayback(),
        pause: () => {
            isManualPause = true;
            audio.pause();
        },
        forceReconnect: () => {
            retryCount = 0;
            currentSourceIndex = 0;
            setAudioSource(audioSources[0]);
            setTimeout(() => audio.play(), 500);
        }
    };
});