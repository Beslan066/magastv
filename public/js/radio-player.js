// radio-player.js (упрощенная версия для страницы радио)
document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('radio-stream');
    const playPauseBtn = document.getElementById('play-pause-btn');
    
    if (!audio || !playPauseBtn) {
        console.error('Audio elements not found');
        return;
    }
    
    const playSvg = playPauseBtn.querySelector('.play-svg--radio');
    const pauseSvg = playPauseBtn.querySelector('.pause-svg--radio');
    const volumeBtn = document.querySelector('.player__mute');
    const volumeSlider = document.querySelector('.range-input');
    
    console.log('Radio page player initialized');
    
    // БАЗОВАЯ НАСТРОЙКА
    audio.preload = 'none';
    audio.crossOrigin = 'anonymous';
    audio.volume = 0.7;
    
    // Уникальный URL для каждого плеера (чтобы избежать конфликтов)
    const uniqueId = 'page-' + Date.now();
    audio.src = '/proxy/audio?player=' + uniqueId;
    
    // ПРОСТАЯ ЛОГИКА ВОСПРОИЗВЕДЕНИЯ
    function togglePlayback() {
        if (audio.paused) {
            console.log('Starting playback...');
            
            // Визуальная обратная связь
            playSvg.style.display = 'none';
            pauseSvg.style.display = 'block';
            
            audio.play().catch(error => {
                console.error('Playback error:', error);
                
                // Возвращаем иконку плей
                playSvg.style.display = 'block';
                pauseSvg.style.display = 'none';
                
                // Простое сообщение
                if (error.name === 'NotAllowedError') {
                    alert('Разрешите воспроизведение звука в браузере');
                } else {
                    console.log('Trying to reload stream...');
                    // Перезагружаем поток
                    audio.src = '/proxy/audio?player=' + Date.now();
                    setTimeout(() => audio.play(), 500);
                }
            });
        } else {
            audio.pause();
            playSvg.style.display = 'block';
            pauseSvg.style.display = 'none';
            console.log('Playback paused');
        }
    }
    
    // ОБНОВЛЕНИЕ ИКОНОК
    audio.addEventListener('play', function() {
        playSvg.style.display = 'none';
        pauseSvg.style.display = 'block';
        console.log('Radio: playing');
    });
    
    audio.addEventListener('pause', function() {
        playSvg.style.display = 'block';
        pauseSvg.style.display = 'none';
        console.log('Radio: paused');
    });
    
    audio.addEventListener('error', function(e) {
        console.error('Radio error:', audio.error, e);
        playSvg.style.display = 'block';
        pauseSvg.style.display = 'none';
    });
    
    // ГРОМКОСТЬ
    if (volumeSlider) {
        volumeSlider.value = audio.volume * 100;
        
        volumeSlider.addEventListener('input', function(e) {
            audio.volume = e.target.value / 100;
            audio.muted = false;
        });
    }
    
    if (volumeBtn) {
        const muteSvg = volumeBtn.querySelector('.player__mute-muteSvg');
        const unmuteSvg = volumeBtn.querySelector('.player__mute-unmuteSvg');
        
        if (muteSvg && unmuteSvg) {
            volumeBtn.addEventListener('click', function() {
                audio.muted = !audio.muted;
                
                if (audio.muted) {
                    muteSvg.style.display = 'none';
                    unmuteSvg.style.display = 'block';
                } else {
                    muteSvg.style.display = 'block';
                    unmuteSvg.style.display = 'none';
                }
            });
        }
    }
    
    // КЛИК ПО КНОПКЕ
    playPauseBtn.addEventListener('click', togglePlayback);
    
    // ОТЛАДКА
    audio.addEventListener('loadstart', () => console.log('Radio: loadstart'));
    audio.addEventListener('canplay', () => console.log('Radio: canplay'));
    audio.addEventListener('stalled', () => console.log('Radio: stalled'));
    audio.addEventListener('waiting', () => console.log('Radio: waiting'));
    
    console.log('Radio player setup complete');
});