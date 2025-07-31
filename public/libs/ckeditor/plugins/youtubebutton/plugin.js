(function () {
    "use strict";

    CKEDITOR.plugins.add("youtubebutton", {
        init: function (editor) {
            editor.addCommand("insertYouTube", {
                exec: function (editor) {
                    var url = prompt("Paste YouTube URL:");
                    if (!url) return;

                    var match = url.match(
                        /(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\s&]+)/
                    );
                    if (match && match[1]) {
                        var embedUrl =
                            "https://www.youtube.com/embed/" + match[1];
                        var iframe =
                            '<iframe width="100%" height="500px" src="' +
                            embedUrl +
                            '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                        editor.insertHtml(iframe);
                    } else {
                        alert("Invalid YouTube URL");
                    }
                },
            });

            editor.ui.addButton("YouTube", {
                label: "Embed YouTube",
                command: "insertYouTube",
                toolbar: "insert",
                icon: "https://img.icons8.com/ios-filled/24/youtube-play.png",
            });
        },
    });
})();
