// radio.js
document.addEventListener('DOMContentLoaded', function() {
    function formatTime(seconds) {
        if (isNaN(seconds)) return '00:00';
        const minutes = Math.floor(seconds / 60);
        seconds = Math.floor(seconds % 60);
        return `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    const audioPlayers = document.querySelectorAll('.radio-item');

    audioPlayers.forEach(container => {
        const audio = container.querySelector('.audio');
        const playBtn = container.querySelector('.radio-item__play_btn');
        const durationEl = container.querySelector('.duration');
        const currentTimeEl = container.querySelector('.current-time');

        console.log('Audio element found:', audio);
        console.log('Audio src:', audio.src);

        // Обработчик клика на кнопку воспроизведения
        playBtn.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                playBtn.classList.add('playing');
            } else {
                audio.pause();
                playBtn.classList.remove('playing');
            }
        });

        // Обновление времени при загрузке метаданных
        audio.addEventListener('loadedmetadata', () => {
            console.log('loadedmetadata event fired');
            console.log('Audio duration:', audio.duration);

            if (audio.duration !== Infinity && !isNaN(audio.duration)) {
                durationEl.textContent = formatTime(audio.duration);
                console.log('Duration set to:', formatTime(audio.duration));
            }
        });

        // Обновление текущего времени
        audio.addEventListener('timeupdate', () => {
            currentTimeEl.textContent = formatTime(audio.currentTime);
        });

        // Альтернативный способ получения длительности
        audio.addEventListener('canplaythrough', () => {
            console.log('canplaythrough event fired');
            if (audio.duration !== Infinity && !isNaN(audio.duration)) {
                durationEl.textContent = formatTime(audio.duration);
            }
        });

        // Обработка ошибок
        audio.addEventListener('error', (e) => {
            console.error('Audio error:', e);
            console.error('Error code:', audio.error ? audio.error.code : 'unknown');
        });

        // Проверка, если метаданные уже загружены
        setTimeout(() => {
            console.log('Checking audio readyState:', audio.readyState);
            if (audio.readyState > 0) {
                if (audio.duration !== Infinity && !isNaN(audio.duration)) {
                    durationEl.textContent = formatTime(audio.duration);
                    console.log('Duration set from readyState:', formatTime(audio.duration));
                }
            }
        }, 1000);

        // Принудительная загрузка метаданных
        audio.load();
    });
});
