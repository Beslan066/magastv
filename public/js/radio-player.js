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

    // Корректные источники аудио
    const audioSources = [
        '/proxy/audio',
        'http://media.zaoitt.ru:8086/ingradio',
    ];


    function updateStatus(message) {
        console.log('Player status:', message);

    }

    function setAudioSource(source) {
        cleanupAudioListeners();
        audio.src = source;
        audio.crossOrigin = "anonymous";
        audio.load();

        console.log('Setting audio source to:', source);
        updateStatus(`Подключение к источнику ${currentSourceIndex + 1}...`);

        setupAudioListeners();
        updatePlayButtonState(false);
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
    }


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


        setTimeout(() => {
            if (currentState === PlayerState.PLAYING && audio.paused) {
                updateStatus('Проблема с соединением, пробуем другой источник...');
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

    function getErrorMessage(error) {
        switch(error?.code) {
            case MediaError.MEDIA_ERR_ABORTED:
                return 'Воспроизведение прервано';
            case MediaError.MEDIA_ERR_NETWORK:
                return 'Проблема с сетью';
            case MediaError.MEDIA_ERR_DECODE:
                return 'Ошибка декодирования';
            case MediaError.MEDIA_ERR_SRC_NOT_SUPPORTED:
                return 'Формат не поддерживается';
            default:
                return 'Неизвестная ошибка';
        }
    }

    function togglePlayback() {

        playPauseBtn.classList.add('user-requested-play');

        if (audio.paused) {
            console.log('Attempting to play...');
            currentState = PlayerState.LOADING;
            playPauseBtn.classList.add('loading');
            updateStatus('Подключение...');

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


                        tryNextAudioSource();
                    });
            }
        } else {
            audio.pause();
            currentState = PlayerState.IDLE;
            updatePlayButtonState(false);
            playPauseBtn.classList.remove('user-requested-play');
            console.log('Playback paused');
            updateStatus('Пауза');
        }
    }

    function tryNextAudioSource() {
        if (retryCount >= MAX_RETRIES) {
            console.error('Max retries exceeded');
            updateStatus('Все источники недоступны');
            showErrorMessage('Не удалось подключиться к радио. Попробуйте позже.');
            playPauseBtn.classList.remove('loading', 'user-requested-play');
            return;
        }

        currentSourceIndex++;
        if (currentSourceIndex >= audioSources.length) {
            currentSourceIndex = 0; 
            retryCount++;
        }

        currentState = PlayerState.RETRYING;
        const delay = RETRY_DELAYS[retryCount] || 3000;

        updateStatus(`Попытка подключения ${retryCount + 1}/${MAX_RETRIES + 1}...`);

        setTimeout(() => {
            console.log('Trying next source:', audioSources[currentSourceIndex]);
            setAudioSource(audioSources[currentSourceIndex]);

            // Пытаемся воспроизвести только если пользователь хотел играть
            if (playPauseBtn.classList.contains('user-requested-play')) {
                audio.play().catch(e => {
                    console.error('Failed with new source:', e);
                    tryNextAudioSource();
                });
            }
        }, delay);
    }

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

    function showErrorMessage(message) {
        // Можно заменить на красивый toast или модальное окно
        console.error('Player error:', message);
        alert(message);
    }

    // Проверка онлайн-статуса
    window.addEventListener('online', () => {
        if (currentState === PlayerState.ERROR) {
            updateStatus('Соединение восстановлено');
            // Автоматически не переподключаемся, ждем действия пользователя
        }
    });

    window.addEventListener('offline', () => {
        if (currentState === PlayerState.PLAYING) {
            updateStatus('Потеряно соединение с интернетом');
        }
    });

    // Обработчик клика
    playPauseBtn.addEventListener('click', togglePlayback);

    // Управление громкостью
    if (volumeBtn && volumeSlider) {
        volumeBtn.addEventListener('click', () => {
            audio.muted = !audio.muted;
            volumeBtn.classList.toggle('muted', audio.muted);
            updateStatus(audio.muted ? 'Звук выключен' : 'Звук включен');
        });

        volumeSlider.addEventListener('input', (e) => {
            audio.volume = e.target.value / 100;
            audio.muted = false;
            volumeBtn.classList.remove('muted');
        });

        // Устанавливаем начальную громкость
        audio.volume = 0.7;
        volumeSlider.value = 70;
    }

    // Инициализация
    setAudioSource(audioSources[0]);
    updateStatus('Готов к воспроизведению');

    // Предварительная проверка источников (опционально)
    preloadAudioSources();

    async function preloadAudioSources() {
        for (let i = 0; i < audioSources.length; i++) {
            try {
                const response = await fetch(audioSources[i], {
                    method: 'HEAD',
                    mode: 'no-cors'
                });
                console.log(`Source ${i + 1} is reachable`);
            } catch (error) {
                console.warn(`Source ${i + 1} may be unreachable:`, error);
            }
        }
    }

    // Экспорт функций для отладки (можно удалить в продакшене)
    window.radioPlayer = {
        audio,
        getState: () => currentState,
        getCurrentSource: () => audioSources[currentSourceIndex],
        manualRetry: () => tryNextAudioSource(),
        setSource: (index) => {
            if (index >= 0 && index < audioSources.length) {
                currentSourceIndex = index - 1;
                tryNextAudioSource();
            }
        }
    };
});
