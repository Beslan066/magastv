const livePlayBtn = document.querySelector(".main-media__play");
const liveMuteBtn = document.querySelector(".main-media__mute");
const liveVideo = document.querySelector(".live__main-media");
const liveVideoTag = document.querySelector(".live-video-tag");
const fullScreenBtn = document.querySelector(".navigation-bar__fullscreen");
const liveVideoStatus = document.querySelector(".main-media__status");

// Check if video is online
if (liveVideoStatus.dataset.status === 'online') {
    livePlayBtn.disabled = false;
    liveVideoStatus.classList.add("online");
} else {
    livePlayBtn.disabled = true;
    liveVideoStatus.classList.remove("online");
}

// Play/Pause button
livePlayBtn.addEventListener("click", (e) => {
    if (e.target.closest(".main-media__play")) { // Better event delegation
        if (liveVideoTag.paused) {
            liveVideoTag.play().catch(err => console.error("Play failed:", err));
            livePlayBtn.classList.add("pause");
        } else {
            liveVideoTag.pause();
            livePlayBtn.classList.remove("pause");
        }
    }
});

// Fullscreen toggle
fullScreenBtn.addEventListener('click', () => {
    if (document.fullscreenElement) {
        document.exitFullscreen();
    } else {
        liveVideo.requestFullscreen().catch(err => console.error("Fullscreen error:", err));
    }
});

// Mute toggle
liveMuteBtn.addEventListener("click", () => {
    liveVideoTag.muted = !liveVideoTag.muted;
    liveMuteBtn.classList.toggle('muted', liveVideoTag.muted);
});
