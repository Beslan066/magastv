import './lib/video.min.js';
// import './lib/videojs.quality.switch.js';

    (function(){
  const play = document.querySelector('.video-custom-controls__btn--play');
  const pause = document.querySelector('.video-custom-controls__btn--pause');
  const mute = document.querySelector('[data-id="muteVideo"]');
  const unmute = document.querySelector('[data-id="unmuteVideo"]');
  const vid = document.querySelector('.header__media--video');
const fullscreenButton = document.querySelector('[data-id="fullScreenVideo"]');
const videoContainer = document.querySelector('.header__media_content--video');
console.log('headerLive');

function toggleFullscreen(element) {
  if (!document.fullscreenElement) {
    // Если не в полноэкранном режиме, запрашиваем его
    if (element.requestFullscreen) {
      element.requestFullscreen(); // Стандартный
    } else if (element.mozRequestFullScreen) {
      /* Firefox */
      element.mozRequestFullScreen();
    } else if (element.webkitRequestFullscreen) {
      /* Chrome, Safari & Opera */
      element.webkitRequestFullscreen();
    } else if (element.msRequestFullscreen) {
      /* IE/Edge */
      element.msRequestFullscreen();
    }
  } else {
    // Если в полноэкранном режиме, выходим из него
    if (document.exitFullscreen) {
      document.exitFullscreen(); // Стандартный
    } else if (document.mozCancelFullScreen) {
      /* Firefox */
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      /* Chrome, Safari and Opera */
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      /* IE/Edge */
      document.msExitFullscreen();
    }
  }
}



function headerLive() {
  console.log('test');
  const player = videojs('header__media--video', {
    controls: false,
    muted: true,
    preload: true,
    autoplay: true,
    language: 'ru',
    liveui: false,
    liveTracker: false,
    controlBar: false,
    html5: [],
    plugins: {},
    sources: [{
      src: "https://ingushetia.mediacdn.ru/cdn/ingushetia/playlist.m3u8",
      type: "application/vnd.apple.mpegURL"
    }]
  });
    document.addEventListener('fullscreenchange', function() {
  if (document.fullscreenElement) {
   videoContainer.classList.add('fullscreen');
  } else {
    videoContainer.classList.remove('fullscreen');
  }
});
  player.on('waiting',function(){
    videoContainer.classList.add('loading');
  })
  player.on('canplay', function() {
   videoContainer.classList.remove('loading');
});

   const updateMuteState = () => {
    const isMuted = player.muted(); // Get current muted state from Video.js
    mute.classList.toggle('hidden', !isMuted);
    unmute.classList.toggle('hidden', isMuted);
};
 player.ready(() => {
    // Check if the stream is live using LiveTracker
    console.log('livetrack')
    // if (player.liveTracker.isLive()) {
    //   console.log('Live stream detected.');
      // You can now trigger any custom UI or logic for live streams
    // }

    // Alternatively, check the duration
    if (player.duration() === Infinity) {
      console.log('Live stream detected (via duration check).');
    }
    play.addEventListener('click',() => {
      player.play().then(() => {
          play.classList.add("hidden");
          pause.classList.remove("hidden");
          console.log('play');
    })
    .catch(error => {
      console.error('Ошибка воспроизведения видео:', error);
    });
  });
pause.addEventListener('click',()=> {
    player.pause();
    console.log('pause');
  play.classList.remove("hidden");
  pause.classList.add("hidden");
});
mute.addEventListener('click', () => {
    player.muted(false); // Unmute the player
    updateMuteState();
});

unmute.addEventListener('click', () => {
    player.muted(true); // Mute the player
    updateMuteState();
});
  });

  setInterval(function() {
    gtag('event', 'heartbeat', { 'non_interaction': true });
    // console.log('send heartbeat');
    // HB once in 5 min
  }, 5 * 60 * 1000);
}
headerLive();
fullscreenButton.addEventListener("click", function () {
  toggleFullscreen(videoContainer);
});



})()


