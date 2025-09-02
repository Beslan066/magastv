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

    // Пробуем разные источники аудио
    const audioSources = [
        '/proxy/audio',
        'http://77.87.97.62:8086/ingradio',
        'http://77.87.97.62:8086/ingradio.mp3'
    ];

    let currentSourceIndex = 0;

    // Функция для установки источника аудио
    function setAudioSource(source) {
        audio.src = source;
        audio.crossOrigin = "anonymous";
        audio.load();
        console.log('Setting audio source to:', source);
    }

    // Инициализируем первый источник
    setAudioSource(audioSources[0]);

    function togglePlayback() {
        if (audio.paused) {
            console.log('Attempting to play...');
            playPauseBtn.classList.add('loading');

            audio.play()
                .then(() => {
                    console.log('Playback started successfully');
                    updatePlayButtonState(true);
                    playPauseBtn.classList.remove('loading');
                })
                .catch(error => {
                    console.error('Playback failed:', error);
                    playPauseBtn.classList.remove('loading');

                    // Пробуем следующий источник
                    tryNextAudioSource();
                });
        } else {
            audio.pause();
            updatePlayButtonState(false);
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
                togglePlayback();
            }, 1000);
        } else {
            console.error('All audio sources failed');
            alert('Не удалось воспроизвести радио. Все источники недоступны.');
        }
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

    // Обработчик клика
    playPauseBtn.addEventListener('click', togglePlayback);

    // Обработчики событий аудио
    audio.addEventListener('play', () => {
        console.log('Audio play event fired');
        updatePlayButtonState(true);
    });

    audio.addEventListener('pause', () => {
        console.log('Audio pause event fired');
        updatePlayButtonState(false);
    });

    audio.addEventListener('error', (e) => {
        console.error('Audio error:', audio.error);
        updatePlayButtonState(false);
        playPauseBtn.classList.remove('loading');
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

    // Предзагрузка
    audio.preload = 'auto';
});
