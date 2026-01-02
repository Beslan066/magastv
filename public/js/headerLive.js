import './lib/video.min.js';


// Функция для инициализации радио в хедере
function initHeaderRadio() {
    const radioStream = document.getElementById('radio-stream-header');
    if (!radioStream) {
        console.log('Header radio stream not found');
        return;
    }

    console.log('Header radio initialized');

    // Уникальный URL для хедера
    const uniqueId = 'header-' + Date.now();
    radioStream.src = '/proxy/audio?player=' + uniqueId;
    radioStream.preload = 'none';
    radioStream.crossOrigin = 'anonymous';
    radioStream.volume = 0.7;

    // Простые обработчики ошибок
    radioStream.addEventListener('error', function(e) {
        console.error('Header radio error:', radioStream.error, e);
    });

    radioStream.addEventListener('stalled', function() {
        console.log('Header radio stalled, reloading...');
        setTimeout(() => {
            radioStream.src = '/proxy/audio?player=' + Date.now();
        }, 1000);
    });

    return radioStream;
}

(function () {
    console.log('headerLive initialized');



    //video
    const play = document.querySelector('.video-custom-controls__btn--play');
    const pause = document.querySelector('.video-custom-controls__btn--pause');
    const mute = document.querySelector('[data-id="muteVideo"]');
    const unmute = document.querySelector('[data-id="unmuteVideo"]');
    const fullscreenButton = document.querySelector('[data-id="fullScreenVideo"]');

    // radio
    const playRadio = document.querySelector('.radio-custom-controls__btn--play');
    const pauseRadio = document.querySelector('.radio-custom-controls__btn--pause');
    const muteRadio = document.querySelector('[data-id="muteRadio"]');
    const unmuteRadio = document.querySelector('[data-id="unmuteRadio"]');
    const fullscreenButtonRadio = document.querySelector('[data-id="fullScreenRadio"]');

    // Плееры
    const radioStream = document.getElementById('radio-stream-header');
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
            videojsPlayer.play().then(() => {
                updatePlayPauseState(true);
            }).catch(error => {
                console.error('Video play error:', error);
                updatePlayPauseState(false);
            });
        } else if (currentPlayer === 'radio') {
            radioStream.play().then(() => {
                updatePlayPauseState(true);
                console.log('Radio started');
            }).catch(error => {
                console.error('Radio play error:', error);
                updatePlayPauseState(false);
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
            const newMutedState = !videojsPlayer.muted();
            videojsPlayer.muted(newMutedState);
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
        }

        if (playRadio && pauseRadio) {
            playRadio.classList.toggle('hidden', isPlaying);
            pauseRadio.classList.toggle('hidden', !isPlaying);
        }

        console.log('Play/Pause state:', isPlaying ? 'playing' : 'paused');
    }

    function updateMuteState() {
        let isMuted = false;

        if (currentPlayer === 'video' && videojsPlayer) {
            isMuted = videojsPlayer.muted();
        } else if (currentPlayer === 'radio') {
            isMuted = radioStream.muted;
        }

        // video state
        if (mute && unmute) {
            mute.classList.toggle('hidden', !isMuted);
            unmute.classList.toggle('hidden', isMuted);
        }

// radio state
        if (muteRadio && unmuteRadio) {
            muteRadio.classList.toggle('hidden', !isMuted);
            unmuteRadio.classList.toggle('hidden', isMuted);
        }

        console.log('Mute state:', isMuted ? 'muted' : 'unmuted');
    }

    function toggleFullscreen() {
        const mediaContainer = currentPlayer === 'video'
            ? document.querySelector('.header__media_content--video')
            : document.querySelector('.header__media_content--radio');

        if (mediaContainer) {
            if (!document.fullscreenElement) {
                mediaContainer.requestFullscreen().catch(err => {
                    console.error(`Error attempting to enable fullscreen: ${err.message}`);
                });
                mediaContainer.classList.add("fullscreen");
            } else {
                document.exitFullscreen();
                mediaContainer.classList.remove("fullscreen");
            }
        }
    }

    function initVideoPlayer() {
        const videoElement = document.getElementById('header__media--video');
        if (!videoElement) {
            console.error('Video element not found!');
            return;
        }

        videojsPlayer = videojs('header__media--video', {
            controls: false,
            muted: true,
            preload: 'auto',
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


        videojsPlayer.ready(() => {
            console.log('Video.js player ready');
            updatePlayPauseState(true);
            updateMuteState();
        });

        videojsPlayer.on('play', () => {
            if (currentPlayer === 'video') {
                updatePlayPauseState(true);
            }
        });

        videojsPlayer.on('pause', () => {
            if (currentPlayer === 'video') {
                updatePlayPauseState(false);
            }
        });

        videojsPlayer.on('volumechange', () => {
            if (currentPlayer === 'video') {
                updateMuteState();
            }
        });

        videojsPlayer.on('error', (error) => {
            console.error('Video.js error:', error);
        });
    }


    function initControls() {

        if (play) {
            play.addEventListener('click', playMedia);
            console.log('Video Play button found');
        }

        if (pause) {
            pause.addEventListener('click', pauseMedia);
            console.log('Video Pause button found');
        }

        if (mute && unmute) {
            mute.addEventListener('click', toggleMute);
            unmute.addEventListener('click', toggleMute);
            console.log('Video Mute buttons found');
        }

        if (playRadio) {
            playRadio.addEventListener('click', playMedia);
            console.log('Radio Play button found');
        }

        if (pauseRadio) {
            pauseRadio.addEventListener('click', pauseMedia);
            console.log('Radio Pause button found');
        }

        if (muteRadio && unmuteRadio) {
            muteRadio.addEventListener('click', toggleMute);
            unmuteRadio.addEventListener('click', toggleMute);
            console.log('Radio Mute buttons found');
        }

        if (fullscreenButton) {
            fullscreenButton.addEventListener("click", toggleFullscreen);
        }

        if (fullscreenButtonRadio) {
            fullscreenButtonRadio.addEventListener("click", toggleFullscreen);
        }
    }

    function initTabHandlers() {
        const tvTab = document.querySelector('[data-media-tab="tv"]');
        const radioTab = document.querySelector('[data-media-tab="radio"]');

        if (tvTab) {
            tvTab.addEventListener('click', function() {
                currentPlayer = 'video';
                console.log('Switched to TV');

                if (!radioStream.paused) {
                    radioStream.pause();
                }

                if (videojsPlayer) {
                    updatePlayPauseState(!videojsPlayer.paused());
                    updateMuteState();
                }
            });
        }

        if (radioTab) {
            radioTab.addEventListener('click', function() {
                currentPlayer = 'radio';
                console.log('Switched to Radio');

                if (videojsPlayer && !videojsPlayer.paused()) {
                    videojsPlayer.pause();
                }

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

    // Обработчики для радио
    function initRadioEvents() {
        radioStream.addEventListener('play', () => {
            if (currentPlayer === 'radio') {
                updatePlayPauseState(true);
            }
        });

        radioStream.addEventListener('pause', () => {
            if (currentPlayer === 'radio') {
                updatePlayPauseState(false);
            }
        });

        radioStream.addEventListener('volumechange', () => {
            if (currentPlayer === 'radio') {
                updateMuteState();
            }
        });

        radioStream.addEventListener('error', (error) => {
            console.error('Radio stream error:', error);
        });
    }

    // Инициализация
    function init() {
    console.log('Initializing players...');

    // Инициализируем радио в хедере
    initHeaderRadio();

    // Остальной код...
    if (document.getElementById('header__media--video')) {
        initVideoPlayer();
    }

    initControls();
    initTabHandlers();
    initRadioEvents();

    console.log('Initialization complete');
}

    // ждем пока загрузится DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
