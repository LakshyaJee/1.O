document.addEventListener("DOMContentLoaded", function() {
  // Retrieve key, type, and slug parameters from the URL
  var urlParams = new URLSearchParams(window.location.search);
  var keyParam = urlParams.get('key');
  var typeParam = urlParams.get('type');
  var slugParam = urlParams.get('slug');

  // Construct the URL
  var fetchUrl = `https://devjisu.com/old_web/drm/fetch.php?key=${encodeURIComponent(keyParam)}&type=lecture&slug=null`;

  // Fetch request
  fetch(fetchUrl)
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok ' + response.statusText);
      }
      return response.json();
    })
    .then(response => {
      // Continue with your existing code
      var drmKey = response.keys[0].k;
      var drmKeyId = response.keys[0].kid;
      var drmURL = response.keys[0].video_url;
      var image_url = response.keys[0].image_url;
      var telegram_link = response.keys[0].telegram_link;

      // JWPlayer instance setup (same as your existing code)
      setupJWPlayer(drmKey, drmKeyId, drmURL, image_url, telegram_link);
    })
    .catch(error => {
      console.error('Error:', error);
    });
});
function setupJWPlayer(drmKey, drmKeyId, drmURL, image_url, telegram_link) {
  const playerInstance = jwplayer("player").setup({
    controls: true,
    sharing: false,
    displaytitle: false,
    displaydescription: false,
    abouttext: "Join StudyRays Telegram",
    aboutlink: telegram_link,
    skin: {
      name: "netflix"
    },
    captions: {
      color: "#FFF",
      fontSize: 14,
      backgroundOpacity: 0,
      edgeStyle: "raised"
    },
    playlist: [
      {
        image: image_url,
        file: drmURL,
        drm: {
          clearkey: {
            key: drmKey,
            keyId: drmKeyId
          }
        }
      }
    ],
    playbackRateControls: true,
    playbackRates: [0.5, 0.75, 1, 1.25, 1.5, 1.75, 2, 2.25, 2.5, 2.75, 3, 3.25, 3.5, 3.75, 4]
  });

  // Add event listeners to thumbnails
  document.querySelectorAll('.thumbnail').forEach(thumbnail => {
    thumbnail.addEventListener('click', () => {
      const time = thumbnail.getAttribute('data-time');
      playerInstance.seek(time);
    });
  });

  playerInstance.on("ready", function () {
    // Move the timeslider in-line with other controls
    const playerContainer = playerInstance.getContainer();
    const buttonContainer = playerContainer.querySelector(".jw-button-container");
    const spacer = buttonContainer.querySelector(".jw-spacer");
    const timeSlider = playerContainer.querySelector(".jw-slider-time");
    buttonContainer.replaceChild(timeSlider, spacer);

    // Detect adblock
    playerInstance.on("adBlock", () => {
      const modal = document.querySelector("div.modal");
      modal.style.display = "flex";

      document.getElementById("close").addEventListener("click", () => location.reload());
    });

    // Forward 10 seconds
    const rewindContainer = playerContainer.querySelector(".jw-display-icon-rewind");
    const forwardContainer = rewindContainer.cloneNode(true);
    const forwardDisplayButton = forwardContainer.querySelector(".jw-icon-rewind");
    forwardDisplayButton.style.transform = "scaleX(-1)";
    forwardDisplayButton.ariaLabel = "Forward 10 Seconds";
    const nextContainer = playerContainer.querySelector(".jw-display-icon-next");
    nextContainer.parentNode.insertBefore(forwardContainer, nextContainer);

    // Control bar icon
    playerContainer.querySelector(".jw-display-icon-next").style.display = "none";
    const rewindControlBarButton = buttonContainer.querySelector(".jw-icon-rewind");
    const forwardControlBarButton = rewindControlBarButton.cloneNode(true);
    forwardControlBarButton.style.transform = "scaleX(-1)";
    forwardControlBarButton.ariaLabel = "Forward 10 Seconds";
    rewindControlBarButton.parentNode.insertBefore(forwardControlBarButton, rewindControlBarButton.nextElementSibling);

    [forwardDisplayButton, forwardControlBarButton].forEach((button) => {
      button.onclick = () => {
        playerInstance.seek(playerInstance.getPosition() + 10);
      };
    });
  });
}


  // Add interactivity for submitting new comments
  document.querySelector('.submit-btn').addEventListener('click', function() {
    const commentText = document.querySelector('.comment-form input').value;
    if (commentText.trim()) {
      const commentSection = document.querySelector('.comments-section');
      const newComment = document.createElement('div');
      newComment.classList.add('comment');
      newComment.innerHTML = `
        <span class="username">New User</span>
        <span class="time">Just now</span>
        <p>${commentText}</p>
        <div class="comment-actions">
          <button class="like-btn"><i class="fas fa-thumbs-up"></i> 0</button>
          <button class="report-btn"><i class="fas fa-exclamation-triangle"></i></button>
        </div>
      `;
      commentSection.insertBefore(newComment, document.querySelector('.comment-form'));
      document.querySelector('.comment-form input').value = '';
    }
  });

