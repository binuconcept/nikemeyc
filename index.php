<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nike Make Every Yard Count</title>
        <meta property="og:title" content="Make Every Yard Count binu" /> 
        <meta name="description" content="Make Every Yard Count" >
            <meta property="og:description" content="Make Every Yard Count">
                <meta property="og:image" content="images/fbnike.png'; ?>"/>
                <link rel="shortcut icon" href="images/favicon.ico"/>   
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
                <link href="css/jquery.bxslider.css" rel="stylesheet" />
                <link href="css/media.css" rel="stylesheet" type="text/css" />
                <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.custom.css" />
                <link href="css/style.css" rel="stylesheet" type="text/css" />
                <style type="text/css">
                    *{
                        padding: 0px;
                        margin:0px;
                    }

                    #a{
                        width:100%;
                    }

                    ul#slider{
                        list-style-type: none;
                        display:inline-block;
                    }

                    ul li{
                        width:450px;
                        height: 200px;
                        float:left;
                    }

                    #drag{
                        height:26px;
                        border:1px solid #9d9d9d;
                        background:url(images/drag_bg.jpg) repeat-x;
                        -webkit-border-radius: 20px;
                        -moz-border-radius: 20px;
                        border-radius: 20px;
                        margin-top:10px;
                        width:99%;

                    }
                </style>
                </head>

                <body>
                    <div class="overlay" style="display:none"></div>
                    <div class="pop_holder" style="display:none">
                        <a href="javascript:void(0);" class="close"><img src="images/close.png" /></a>   
                        <div class="pop_form">               
                            <div class="input_title" style="margin-top:22px;">
                                share
                            </div>
                            <a href="javascript:void(0);" data-share="twitter" class="social_pop">
                                <img src="images/twitter.png" />
                            </a>
                            <a href="javascript:void(0);" data-share="facebook" class="social_pop">
                                <img src="images/fb.png" />
                            </a>                
                        </div>
                    </div>

                    <div class="padding10">
                        <div class="logo">
                            <img src="images/logo.png" />
                        </div>
                        <div class="main_video">
                            <div class="padding10">                
                                <iframe id="ytplayer" type="text/html" width="100%" height="400px" src="https://www.youtube.com/embed/JtxLmInvFcw?version=3&amp;showinfo=0&amp;wmode=opaque" frameborder="0" allowfullscreen=""></iframe>
                            </div>             
                        </div>
                        <p class="clear"></p>
                        <div class="view_head">
                            <img src="images/view_story.png" />
                        </div>

                        <div id="a">
                            <div >
                                <ul id="slider"></ul>
                                <div id="drag"><div class="drag"></div></div>
                            </div>
                        </div>

                    </div>

                    <div class="share_btn_holder">
                        <a href="javascript:void(0);" class="share_btn"><img src="images/share_btn.png" /></a>
                        <div class="tw">
                            <a href="https://twitter.com/share" class="twitter-share-button" data-text="Make Every Yard Count" data-url="http://www.makeeveryyardcount.in">Tweet</a>
                            <script>!function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                    if (!d.getElementById(id)) {
                                        js = d.createElement(s);
                                        js.id = id;
                                        js.src = p + '://platform.twitter.com/widgets.js';
                                        fjs.parentNode.insertBefore(js, fjs);
                                    }
                                }(document, 'script', 'twitter-wjs');</script>
                        </div>
                        <div class="fb">
                          <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2F22feetlabs.com%2Fproject%2Fnike%2Fmeyc&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=255062638009241" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>
                        </div>
                        <p class="clear"></p>
                    </div>


                    <div class="footer">
                        <span>&copy; 2014 Nike, Inc. All Right Reserved</span>
                    </div>

                    <script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script>
                    <script type="text/javascript" src="js/modernizr.custom.js"></script>
                    <script type="text/javascript" src="js/touchswipe.js"></script>
                    <script type="text/javascript" src="js/drag.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            var options = {
                                "autocenter": false,
                                "loadmoreoption": true,
                                "overflow": false,
                                "smoothscroll": false
                            }
                            $("#a").css("width", $(window).width());
                            $(".drag").css("width", $(window).width() - 87);
                            $("#slider").dragslider(options);
                            // Find all YouTube videos
                            var $allVideos = $("iframe[src^='http://www.youtube.com']"),
                                    // The element that is fluid width
                                    $fluidEl = $("body");

                            // Figure out and save aspect ratio for each video
                            $allVideos.each(function() {

                                $(this)
                                        .data('aspectRatio', this.height / this.width)

                                        // and remove the hard coded width/height
                                        .removeAttr('height')
                                        .removeAttr('width');

                            });

                            // When the window is resized
                            $(window).resize(function() {

                                var newWidth = $fluidEl.width();

                                // Resize all videos according to their own aspect ratio
                                $allVideos.each(function() {

                                    var $el = $(this);
                                    $el
                                            .width(newWidth)
                                            .height(newWidth * $el.data('aspectRatio'));

                                });

                                // Kick off one resize to fix all videos on page load
                            }).resize();
                        });
                        $(".close").click(function() {
                            $(".overlay").hide();
                            $(".pop_holder").hide();
                        });
                        $(".share_btn").click(function() {
                            $(".overlay").fadeIn();
                            $(".pop_holder").fadeIn();
                        });
                        $(".social_pop").click(function(e) {
                            e.preventDefault();
                            var attrs = $(this).attr("data-share");
                            if (typeof attrs != "undefined") {
                                if (attrs.length > 0) {
                                    share(attrs);
                                }
                            }
                        });
                        function share(tr) {
                            var urls = "http://dev.nikemeyc.com/";
                            if (urls.length > 0) {
                                switch (tr) {
                                    case "facebook":
                                        var link = 'https://www.facebook.com/sharer.php?u=' + encodeURIComponent(urls);
                                        window.open(link, '', 'width=600,height=400,resizable=yes,scrollbars=yes');
                                        break;
                                    case "twitter":
                                        var link = 'https://twitter.com/intent/tweet?text=Make Every Yard Count!&url=' + encodeURIComponent(urls);
                                        window.open(link, '', 'width=600,height=400,resizable=yes,scrollbars=yes');
                                        break;
                                }
                            }
                            return false;
                        }
                    </script>
                </body>
                </html>
