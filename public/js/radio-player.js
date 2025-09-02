// radio-player.js
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

    console.log('Audio element initialized');

    // Устанавливаем CORS атрибут для аудио
    audio.crossOrigin = "anonymous";

    function togglePlayback() {
        if (audio.paused) {
            console.log('Attempting to play...');

            // Показываем состояние загрузки
            playPauseBtn.classList.add('loading');

            audio.play()
                .then(() => {
                    console.log('Playback started successfully');
                    playSvg.style.display = 'none';
                    pauseSvg.style.display = 'block';
                    playPauseBtn.classList.remove('loading');
                    playPauseBtn.classList.add('playing');
                })
                .catch(error => {
                    console.error('Playback failed:', error);
                    playPauseBtn.classList.remove('loading');

                    // Пробуем альтернативный источник
                    tryAlternativeSource();
                });
        } else {
            audio.pause();
            playSvg.style.display = 'block';
            pauseSvg.style.display = 'none';
            playPauseBtn.classList.remove('playing');
            console.log('Playback paused');
        }
    }

    function tryAlternativeSource() {
        console.log('Trying alternative source...');

        // Сохраняем текущий volume
        const currentVolume = audio.volume;
        const currentTime = audio.currentTime;

        // Пробуем прямой URL
        audio.src = 'http://77.87.97.62:8086/ingradio';
        audio.load();

        setTimeout(() => {
            audio.play()
                .then(() => {
                    console.log('Alternative source working!');
                    playSvg.style.display = 'none';
                    pauseSvg.style.display = 'block';
                    playPauseBtn.classList.add('playing');

                    // Восстанавливаем volume и время
                    audio.volume = currentVolume;
                    audio.currentTime = currentTime;
                })
                .catch(error => {
                    console.error('Alternative source also failed:', error);
                    alert('Не удалось воспроизвести радио. Возможно, проблема с подключением или радио поток временно недоступен.');
                });
        }, 1000);
    }

    // Обработчик клика
    playPauseBtn.addEventListener('click', togglePlayback);

    // Обработчики событий аудио
    audio.addEventListener('play', () => {
        console.log('Audio play event fired');
        playSvg.style.display = 'none';
        pauseSvg.style.display = 'block';
        playPauseBtn.classList.add('playing');
    });

    audio.addEventListener('pause', () => {
        console.log('Audio pause event fired');
        playSvg.style.display = 'block';
        pauseSvg.style.display = 'none';
        playPauseBtn.classList.remove('playing');
    });

    audio.addEventListener('error', (e) => {
        console.error('Audio error event:', e);
        console.error('Error details:', audio.error);

        playSvg.style.display = 'block';
        pauseSvg.style.display = 'none';
        playPauseBtn.classList.remove('playing', 'loading');
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

        audio.volume = 0.7;
        volumeSlider.value = 70;
    }

    // Предзагрузка
    audio.preload = 'auto';
});
