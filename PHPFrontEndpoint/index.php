<!DOCTYPE HTML>
<!--
Esanin News
Created By: Sidath Gajanayaka
Date: 10th of April 2017
Last edited date: 25th of April 2017
(C) All rights reserved.

Note: These files should reside in Apache PHP server.
-->
<html>
    <head>
        <title>එසැනින් News</title>
        <link rel="icon" type="image/png" href="images/newspaper.png">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
        <script src="js/jquery.min.js"></script>
        <script src="js/skel.min.js"></script>
        <script src="js/skel-layers.min.js"></script>
        <script src="js/init.js"></script>
        <script src="js/loader1.js"></script>
        <script src="js/loader2.js"></script>
        <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
        </noscript>
    </head>
    <body id="top">       
        <!-- Banner -->
        <section id="banner">
            <div class="inner">
                <h2>එසැනින් News</h2>
                <p><i>Your news classified...</i></p>
                <div id="loading-image">
                    <img src="svg-loaders/circles.svg" width="100" height="100" />
                </div>
                <br/>
                <ul class="actions">
                    <li  onclick="getNews()"><a class="button big special">Read classified news</a></li>
                    <li><a target="new" href="classifyuser.php" class="button big special">Get an article classified</a></li>
                </ul>              
            </div>
        </section>		

        <footer id="footer"><center>© 2017 - Group 5 - Computer Science</center></footer>	
        <script>

            $(document).ready(function () {
                $('#loading-image').hide();
            });

            function post(path, params, method) {
                method = method || "post"; // Set method to post by default if not specified.

                // The rest of this code assumes you are not using a library.
                // It can be made less wordy if you use one.
                var form = document.createElement("form");
                form.setAttribute("method", method);
                form.setAttribute("action", path);

                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", key);
                        hiddenField.setAttribute("value", params[key]);

                        form.appendChild(hiddenField);
                    }
                }

                document.body.appendChild(form);
                form.submit();
            }

            function getNews() {
                $('#loading-image').show();

                var customElement = $("<div>", {
                    id: "countdown",
                    css: {
                        "font-size": "30px"
                    },
                    text: 'Please wait! Extracting news from the web. This may take a while...'
                });

                $.LoadingOverlay("show", {
                    image: "",
                    custom: customElement
                });

                $.ajax({
                    url: 'http://localhost:3030/getNews',
                    method: 'POST',
                    success: function (msg) {
                        $('#loading-image').hide();
                        $.LoadingOverlay("hide");
                        console.log(msg);

                        post('classified.php', {newsarray: msg});

                    },
                    error: function (request, status, errorThrown) {
                        $('#loading-image').hide();
                        $.LoadingOverlay("hide");
                        alert("There was an error in processing the request. Please retry!")
                    }
                });
            }
        </script>
    </body>
</html>