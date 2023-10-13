<html>
  <head>
    <title>Hls demo</title>
    <meta charset="utf-8" />
    <script>
      let sources = [
        { type: "hls", file: "<?php echo $_SERVER['QUERY_STRING'] ?>", label: "720p" },
      ];
    </script>
    <script src="https://cdn.jsdelivr.net/gh/linhminaz/jwplayer@main/jw.8.21.2.min.js"></script>
  </head>

  <body style="margin: 0">
    <div id="player" style="width: 100%; height: 100%; display: none"></div>
  </body>
  <script>
    function getValue(key) {
    var url_string = window.location.href
    var url = new URL(url_string);
    return url.searchParams.get(key);
}

//set up jw player
function setupPlayer(sources) {
    jwplayer.key = "eNFaXCjyURVoCCGiHp7HTQ3hDhE/AfL0g8VE1fRbL84=";
   
    var advertising
    var tracks
    var image = getValue("image")
    try {
        var xml = getValue("ads")
        var xml1 = getValue("ads1")
        if (getValue("ads") !== null) {
            advertising = {
                client: 'vast',
                skipoffset: getValue("skipoffset") ? getValue("skipoffset") : 5,
                schedule: [
                    {
                      "offset": "pre",
                      "tag": xml
                    },
                    {
                      "offset": "pre",
                      "tag": xml1
                    },
                  ],
                // { "myAds1": { "offset": "pre", "tag": xml } },
                loadingAd: "Đang tải quảng cáo",
                admessage: "Quảng cáo sẽ đóng sau xx giây.",
                skipmessage: "Bỏ qua quảng cáo sau xx giây.",
                skiptext: "Bỏ qua quảng cáo",
            }
        }

        if (getValue("subs") != null) {
            var subs = getValue("subs").split("|")
            var langs = getValue("lang").split("|")
            tracks = []
            for (var index = 0; index < subs.length; index++) {
                var file = subs[index];
                var label = langs[index];
                tracks.push({
                    kind: "captions",
                    file,
                    label,
                    default: index === 0
                })
            }
        }
    } catch (error) {

    }

    var playerInstance = jwplayer("player");
    playerInstance.setup({
        playlist: [{
            image,
            sources,
            tracks,
             adschedule: "https://playertest.longtailvideo.com/adtags/vmap2-nonlinear.xml"
        }],
        
		playbackRateControls: [0.25, 0.5, 0.75, 1, 1.25, 1.5, 2],
		"logo": {
			"file": getValue("logo"),
			"link": getValue("logolink"),
			"hide": "false",
			"position": "top-left"
		},
        advertising,
        primary: "html5",
        hlshtml: true,
        autostart: getValue("autoplay") === "1" ? true : false,
        width: "100%",
        height: "100%",
        aspectratio: "16:9",
        stretching: "uniform",
    });

    playerInstance.on("ready", function () {
        if (getValue("autoplay") === "1") {
            setTimeout(() => {
                playerInstance.play()
            }, 2000);
        }
        playerInstance.addButton('<svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon jw-svg-icon-rewind2" viewBox="0 0 240 240" focusable="false"><path d="m 25.993957,57.778 v 125.3 c 0.03604,2.63589 2.164107,4.76396 4.8,4.8 h 62.7 v -19.3 h -48.2 v -96.4 H 160.99396 v 19.3 c 0,5.3 3.6,7.2 8,4.3 l 41.8,-27.9 c 2.93574,-1.480087 4.13843,-5.04363 2.7,-8 -0.57502,-1.174985 -1.52502,-2.124979 -2.7,-2.7 l -41.8,-27.9 c -4.4,-2.9 -8,-1 -8,4.3 v 19.3 H 30.893957 c -2.689569,0.03972 -4.860275,2.210431 -4.9,4.9 z m 163.422413,73.04577 c -3.72072,-6.30626 -10.38421,-10.29683 -17.7,-10.6 -7.31579,0.30317 -13.97928,4.29374 -17.7,10.6 -8.60009,14.23525 -8.60009,32.06475 0,46.3 3.72072,6.30626 10.38421,10.29683 17.7,10.6 7.31579,-0.30317 13.97928,-4.29374 17.7,-10.6 8.60009,-14.23525 8.60009,-32.06475 0,-46.3 z m -17.7,47.2 c -7.8,0 -14.4,-11 -14.4,-24.1 0,-13.1 6.6,-24.1 14.4,-24.1 7.8,0 14.4,11 14.4,24.1 0,13.1 -6.5,24.1 -14.4,24.1 z m -47.77056,9.72863 v -51 l -4.8,4.8 -6.8,-6.8 13,-12.99999 c 3.02543,-3.03598 8.21053,-0.88605 8.2,3.4 v 62.69999 z" stroke="white" fill="white"></path></svg>', "Tua đi 15 giây", function () {
            playerInstance.seek(playerInstance.getPosition() + 10);
        }, "Tua đi 15 giây");
        playerInstance.addButton('<svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon jw-svg-icon-rewind" viewBox="0 0 240 240" focusable="false"><path d="M113.2,131.078a21.589,21.589,0,0,0-17.7-10.6,21.589,21.589,0,0,0-17.7,10.6,44.769,44.769,0,0,0,0,46.3,21.589,21.589,0,0,0,17.7,10.6,21.589,21.589,0,0,0,17.7-10.6,44.769,44.769,0,0,0,0-46.3Zm-17.7,47.2c-7.8,0-14.4-11-14.4-24.1s6.6-24.1,14.4-24.1,14.4,11,14.4,24.1S103.4,178.278,95.5,178.278Zm-43.4,9.7v-51l-4.8,4.8-6.8-6.8,13-13a4.8,4.8,0,0,1,8.2,3.4v62.7l-9.6-.1Zm162-130.2v125.3a4.867,4.867,0,0,1-4.8,4.8H146.6v-19.3h48.2v-96.4H79.1v19.3c0,5.3-3.6,7.2-8,4.3l-41.8-27.9a6.013,6.013,0,0,1-2.7-8,5.887,5.887,0,0,1,2.7-2.7l41.8-27.9c4.4-2.9,8-1,8,4.3v19.3H209.2A4.974,4.974,0,0,1,214.1,57.778Z" stroke="white" fill="white"></path></svg>', "Tua lại 15 giây", function () {
            playerInstance.seek(playerInstance.getPosition() - 10);
        }, "Tua lại 15 giây");
		
    });
}

setupPlayer(sources);
  </script>
   
</html>
