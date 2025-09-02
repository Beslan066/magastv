document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('radio-stream');
    const playPauseBtn = document.getElementById('play-pause-btn');

    if (!audio || !playPauseBtn) {
        console.error('Audio or play button not found!');
        return;
    }

    const playSvg = playPauseBtn.querySelector('.play-svg');
    const pauseSvg = playPauseBtn.querySelector('.pause-svg');
    const volumeBtn = document.querySelector('.player__mute');
    const volumeSlider = document.querySelector('.range-input');

    console.log('Audio player initialized');

    // Корректные источники аудио
    const audioSources = [
        '/proxy/audio',
        'http://77.87.97.62:8086/ingradio',
        'https://public.mediacdn.ru/magas/'
    ];

    let currentSourceIndex = 0;

    function setAudioSource(source) {
        audio.src = source;
        audio.crossOrigin = "anonymous";
        audio.load();
        console.log('Setting audio source to:', source);

        // Сбрасываем состояние кнопки (показываем play)
        updatePlayButtonState(false);
    }

    // Инициализируем первый источник
    setAudioSource(audioSources[0]);

    function togglePlayback() {
        if (audio.paused) {
            console.log('Attempting to play...');
            playPauseBtn.classList.add('loading');

            const playPromise = audio.play();

            if (playPromise !== undefined) {
                playPromise
                    .then(() => {
                        console.log('Playback started successfully');
                        updatePlayButtonState(true); // Меняем на pause
                        playPauseBtn.classList.remove('loading');
                    })
                    .catch(error => {
                        console.error('Playback failed:', error);
                        playPauseBtn.classList.remove('loading');

                        // Пробуем следующий источник
                        tryNextAudioSource();
                    });
            }
        } else {
            audio.pause();
            updatePlayButtonState(false); // Меняем на play
            console.log('Playback paused');
        }
    }

    function tryNextAudioSource() {
        currentSourceIndex++;

        if (currentSourceIndex < audioSources.length) {
            console.log('Trying next source:', audioSources[currentSourceIndex]);
            setAudioSource(audioSources[currentSourceIndex]);

            // Даем время на загрузку нового источника
            setTimeout(() => {
                audio.play().catch(e => {
                    console.error('Failed with new source:', e);
                    if (currentSourceIndex < audioSources.length - 1) {
                        tryNextAudioSource();
                    }
                });
            }, 1000);
        } else {
            console.error('All audio sources failed');
            alert('Не удалось воспроизвести радио. Все источники недоступны.');
            playPauseBtn.classList.remove('loading');
        }
    }

    function updatePlayButtonState(isPlaying) {
        if (isPlaying) {
            // Когда играет - показываем PAUSE, скрываем PLAY
            playSvg.style.display = 'none';
            pauseSvg.style.display = 'block';
            playPauseBtn.classList.add('playing');
        } else {
            // Когда пауза - показываем PLAY, скрываем PAUSE
            playSvg.style.display = 'block';
            pauseSvg.style.display = 'none';
            playPauseBtn.classList.remove('playing');
        }
    }

    // Обработчик клика
    playPauseBtn.addEventListener('click', togglePlayback);

    // Обработчики событий аудио
    audio.addEventListener('play', () => {
        console.log('Audio play event fired');
        updatePlayButtonState(true); // Показываем pause
    });

    audio.addEventListener('pause', () => {
        console.log('Audio pause event fired');
        updatePlayButtonState(false); // Показываем play
    });

    audio.addEventListener('error', (e) => {
        console.error('Audio error:', audio.error);
        updatePlayButtonState(false); // Показываем play при ошибке
        playPauseBtn.classList.remove('loading');

        // Автоматически пробуем следующий источник при ошибке
        if (currentSourceIndex < audioSources.length - 1) {
            tryNextAudioSource();
        }
    });

    // Управление громкостью
    if (volumeBtn && volumeSlider) {
        volumeBtn.addEventListener('click', () => {
            audio.muted = !audio.muted;
            volumeBtn.classList.toggle('muted', audio.muted);
        });

        volumeSlider.addEventListener('input', (e) => {
            audio.volume = e.target.value / 100;
        });

        // Устанавливаем начальную громкость
        audio.volume = 0.7;
        volumeSlider.value = 70;
    }

    // Добавляем обработку сетевых событий
    audio.addEventListener('loadstart', () => {
        console.log('Audio loading started');
    });

    audio.addEventListener('canplay', () => {
        console.log('Audio can play');
    });

    audio.addEventListener('stalled', () => {
        console.log('Audio stalled, trying next source');
        tryNextAudioSource();
    });

    // Инициализируем правильное состояние кнопки
    updatePlayButtonState(false); // Гарантируем, что показывается play
});
