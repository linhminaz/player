<html>
  <head>
    <title>Hls demo</title>
    <meta charset="utf-8" />
 
    <script>
      let sources = [
        { type: "hls", file: "<?php echo $_SERVER['QUERY_STRING'] ?>", label: "720p" },
      ];
    </script>
    <script src="https://ssl.p.jwpcdn.com/player/v/8.26.2/jwplayer.js"></script>
  </head>

  <body style="margin: 0">
    <div id="player" style="width: 100%; height: 100%; display: none"></div>
  </body>
  <script >
      function getValue(key) {
    var url_string = window.location.href
    var url = new URL(url_string);
    return url.searchParams.get(key);
}

//set up jw player
function setupPlayer(sources) {
    jwplayer.key = "eNFaXCjyURVoCCGiHp7HTQ3hDhE/AfL0g8VE1fRbL84=";

    var playerInstance = jwplayer("player");
    playerInstance.setup({
         playlist: [{
            sources,
            adschedule: "https://linhminaz.com/adtags/vmap2-nonlinear.xml"
        }],
		playbackRateControls: [0.25, 0.5, 0.75, 1, 1.25, 1.5, 2],
        primary: "html5",
        hlshtml: true,
        autostart: 1,
        width: "100%",
        height: "100%",
        aspectratio: "16:9",
        stretching: "uniform",
    });

    playerInstance.on("ready", function () {
        const buttonId = "download-video-button";
        const iconPath = "https://onlinepngtools.com/images/examples-onlinepngtools/google-logo-transparent.png";
        const tooltipText = "HLS player";

        // Call the player's `addButton` API method to add the custom button
        // playerInstance.addButton(iconPath, tooltipText, buttonClickAction, buttonId);

        // This function is executed when the button is clicked
        function buttonClickAction() {
          const playlistItem = playerInstance.getPlaylistItem();
          const anchor = document.createElement("a");
          const fileUrl = playlistItem.file;
          anchor.setAttribute("href", fileUrl);
          const downloadName = playlistItem.file.split("/").pop();
          anchor.setAttribute("download", downloadName);
          anchor.style.display = "none";
          document.body.appendChild(anchor);
          anchor.click();
          document.body.removeChild(anchor);
        }

        // Move the timeslider in-line with other controls
        const playerContainer = playerInstance.getContainer();
        const buttonContainer = playerContainer.querySelector(".jw-button-container");
        const spacer = buttonContainer.querySelector(".jw-spacer");
        const timeSlider = playerContainer.querySelector(".jw-slider-time");
        buttonContainer.replaceChild(timeSlider, spacer);
 

        // Forward 10 seconds
        const rewindContainer = playerContainer.querySelector(".jw-display-icon-rewind");
        const forwardContainer = rewindContainer.cloneNode(true);
        const forwardDisplayButton = forwardContainer.querySelector(".jw-icon-rewind");
        forwardDisplayButton.style.transform = "scaleX(-1)";
        forwardDisplayButton.ariaLabel = "Forward 10 Secondsss";
        const nextContainer = playerContainer.querySelector(".jw-display-icon-next");
        nextContainer.parentNode.insertBefore(forwardContainer, nextContainer);

        // control bar icon
        playerContainer.querySelector(".jw-display-icon-next").style.display = "none"; // hide next button
        const rewindControlBarButton = buttonContainer.querySelector(".jw-icon-rewind");
        const forwardControlBarButton = rewindControlBarButton.cloneNode(true);
        forwardControlBarButton.style.transform = "scaleX(-1)";
        forwardControlBarButton.ariaLabel = "Forward 10 Secondsaa";
        rewindControlBarButton.parentNode.insertBefore(forwardControlBarButton, rewindControlBarButton.nextElementSibling);

        // add onclick handlers
        [forwardDisplayButton, forwardControlBarButton].forEach((button) => {
          button.onclick = () => {
            playerInstance.seek(playerInstance.getPosition() + 10);
          };
        });
      });
}

setupPlayer(sources);
  </script>
   
</html>
