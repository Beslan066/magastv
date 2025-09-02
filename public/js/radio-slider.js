// radio-player.js
document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('radio-stream');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const playSvg = playPauseBtn.querySelector('.play-svg');
    const pauseSvg = playPauseBtn.querySelector('.pause-svg');
    const volumeBtn = document.querySelector('.player__mute');
    const volumeSlider = document.querySelector('.range-input');

    console.log('Audio element found:', audio);
    console.log('Play button found:', playPauseBtn);

    // Проверяем, существуют ли элементы
    if (!audio || !playPauseBtn) {
        console.error('Audio or play button not found!');
        return;
    }

    // Функция для переключения воспроизведения
    function togglePlayback() {
        if (audio.paused) {
            audio.play()
                .then(() => {
                    console.log('Playback started');
                    playSvg.style.display = 'none';
                    pauseSvg.style.display = 'block';
                    playPauseBtn.classList.add('playing');
                })
                .catch(error => {
                    console.error('Playback failed:', error);
                    // Показываем сообщение об ошибке пользователю
                    alert('Не удалось воспроизвести радио. Пожалуйста, проверьте ваше интернет-соединение.');
                });
        } else {
            audio.pause();
            playSvg.style.display = 'block';
            pauseSvg.style.display = 'none';
            playPauseBtn.classList.remove('playing');
            console.log('Playback paused');
        }
    }

    // Обработчик клика на кнопку воспроизведения/паузы
    playPauseBtn.addEventListener('click', togglePlayback);

    // Обработчик события окончания загрузки метаданных
    audio.addEventListener('loadedmetadata', () => {
        console.log('Audio metadata loaded');
        console.log('Duration:', audio.duration);
        console.log('Source:', audio.src);
    });

    // Обработчик события начала воспроизведения
    audio.addEventListener('play', () => {
        console.log('Audio started playing');
        playSvg.style.display = 'none';
        pauseSvg.style.display = 'block';
        playPauseBtn.classList.add('playing');
    });

    // Обработчик события паузы
    audio.addEventListener('pause', () => {
        console.log('Audio paused');
        playSvg.style.display = 'block';
        pauseSvg.style.display = 'none';
        playPauseBtn.classList.remove('playing');
    });

    // Обработчик ошибок воспроизведения
    audio.addEventListener('error', (e) => {
        console.error('Audio error:', e);
        console.error('Error code:', audio.error ? audio.error.code : 'unknown');

        // Сброс состояния кнопки при ошибке
        playSvg.style.display = 'block';
        pauseSvg.style.display = 'none';
        playPauseBtn.classList.remove('playing');

        // Сообщение об ошибке
        alert('Ошибка при воспроизведении радио потока. Пожалуйста, попробуйте позже.');
    });

    // Управление громкостью
    if (volumeBtn && volumeSlider) {
        volumeBtn.addEventListener('click', () => {
            audio.muted = !audio.muted;
            volumeBtn.classList.toggle('muted', audio.muted);
        });

        volumeSlider.addEventListener('input', () => {
            audio.volume = volumeSlider.value / 100;
        });

        // Установка начальной громкости
        audio.volume = 0.7;
        volumeSlider.value = 70;
    }

    // Попытка предзагрузки аудио
    audio.preload = 'metadata';

    // Дополнительная проверка через секунду
    setTimeout(() => {
        console.log('Audio readyState after timeout:', audio.readyState);
        if (audio.readyState === 0) {
            console.log('Trying to load audio manually...');
            audio.load();
        }
    }, 1000);
});
