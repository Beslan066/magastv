import './lib/video.min.js';

(function () {
    console.log('headerLive initialized');

    // Элементы управления из видео-плеера
    const play = document.querySelector('.video-custom-controls__btn--play');
    const pause = document.querySelector('.video-custom-controls__btn--pause');
    const mute = document.querySelector('[data-id="muteVideo"]');
    const unmute = document.querySelector('[data-id="unmuteVideo"]');
    const fullscreenButton = document.querySelector('[data-id="fullScreenVideo"]');

    // Плееры
    const radioStream = document.getElementById('radio-stream');
    let videojsPlayer = null;
    let currentPlayer = 'video';

    // Проверяем наличие радио потока
    if (!radioStream) {
        console.error('Radio stream element not found!');
        return;
    }

    // Простые функции управления
    function playMedia() {
        console.log('Play clicked for:', currentPlayer);
        if (currentPlayer === 'video' && videojsPlayer) {
            videojsPlayer.play();
            updatePlayPauseState(true);
        } else if (currentPlayer === 'radio') {
            radioStream.play().then(() => {
                updatePlayPauseState(true);
                console.log('Radio started');
            }).catch(error => {
                console.error('Radio play error:', error);
            });
        }
    }

    function pauseMedia() {
        console.log('Pause clicked for:', currentPlayer);
        if (currentPlayer === 'video' && videojsPlayer) {
            videojsPlayer.pause();
            updatePlayPauseState(false);
        } else if (currentPlayer === 'radio') {
            radioStream.pause();
            updatePlayPauseState(false);
        }
    }

    function toggleMute() {
        console.log('Mute toggle for:', currentPlayer);
        if (currentPlayer === 'video' && videojsPlayer) {
            videojsPlayer.muted(!videojsPlayer.muted());
            updateMuteState();
        } else if (currentPlayer === 'radio') {
            radioStream.muted = !radioStream.muted;
            updateMuteState();
        }
    }

    function updatePlayPauseState(isPlaying) {
        if (play && pause) {
            play.classList.toggle('hidden', isPlaying);
            pause.classList.toggle('hidden', !isPlaying);
            console.log('Play/Pause state:', isPlaying ? 'playing' : 'paused');
        }
    }

    function updateMuteState() {
        if (!mute || !unmute) return;

        let isMuted = false;
        if (currentPlayer === 'video' && videojsPlayer) {
            isMuted = videojsPlayer.muted();
        } else if (currentPlayer === 'radio') {
            isMuted = radioStream.muted;
        }

        mute.classList.toggle('hidden', !isMuted);
        unmute.classList.toggle('hidden', isMuted);
        console.log('Mute state:', isMuted ? 'muted' : 'unmuted');
    }

    // Инициализация Video.js
    function initVideoPlayer() {
        videojsPlayer = videojs('header__media--video', {
            controls: false,
            muted: true,
            preload: true,
            autoplay: true,
            language: 'ru',
            liveui: false,
            liveTracker: false,
            controlBar: false,
            html5: {
                vhs: {
                    overrideNative: true
                },
                nativeAudioTracks: false,
                nativeVideoTracks: false,
                nativeTextTracks: false
            },
            sources: [{
                src: "https://ingushetia.mediacdn.ru/cdn/ingushetia/playlist.m3u8",
                type: "application/vnd.apple.mpegURL"
            }]
        });

        // Обновляем состояние кнопок
        videojsPlayer.ready(() => {
            updatePlayPauseState(true);
            updateMuteState();
        });
    }

    // Обработчики кнопок
    function initControls() {
        if (play) {
            play.addEventListener('click', playMedia);
            console.log('Play button found');
        }

        if (pause) {
            pause.addEventListener('click', pauseMedia);
            console.log('Pause button found');
        }

        if (mute && unmute) {
            mute.addEventListener('click', toggleMute);
            unmute.addEventListener('click', toggleMute);
            console.log('Mute buttons found');
        }

        if (fullscreenButton) {
            fullscreenButton.addEventListener("click", function () {
                const videoContainer = document.querySelector('.header__media_content--video');
                if (videoContainer) {
                    if (!document.fullscreenElement) {
                        videoContainer.requestFullscreen();
                    } else {
                        document.exitFullscreen();
                    }
                }
            });
        }
    }

    // Переключение табов
    function initTabHandlers() {
        const tvTab = document.querySelector('[data-media-tab="tv"]');
        const radioTab = document.querySelector('[data-media-tab="radio"]');

        if (tvTab) {
            tvTab.addEventListener('click', function() {
                currentPlayer = 'video';
                console.log('Switched to TV');
                // Паузим радио
                if (!radioStream.paused) {
                    radioStream.pause();
                }
                updatePlayPauseState(!videojsPlayer.paused());
                updateMuteState();
            });
        }

        if (radioTab) {
            radioTab.addEventListener('click', function() {
                currentPlayer = 'radio';
                console.log('Switched to Radio');
                // Запускаем радио
                if (radioStream.paused) {
                    radioStream.play().then(() => {
                        updatePlayPauseState(true);
                    }).catch(error => {
                        console.error('Radio autoplay failed:', error);
                        updatePlayPauseState(false);
                    });
                } else {
                    updatePlayPauseState(true);
                }
                updateMuteState();
            });
        }
    }

    // Инициализация
    function init() {
        console.log('Initializing players...');

        // Инициализируем видео
        if (document.getElementById('header__media--video')) {
            initVideoPlayer();
        }

        initControls();
        initTabHandlers();

        console.log('Initialization complete');
    }

    // Запускаем
    init();

})();
