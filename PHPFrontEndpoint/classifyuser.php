<!DOCTYPE HTML>
<!--
Esanin News
Created By: Sidath Gajanayaka
Date: 10th of April 2017
Last edited date: 25th of April 2017
(C) All rights reserved.
-->
<html>
    <head>
        <title>එසැනින් News</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="images/newspaper.png">
        <script src="js/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->        
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
        <style>
            body, html {
                height: 100%;
                margin: 0;
                background-image: url("images/1.jpg");
                background-repeat: repeat;
            }
        </style>
    </head>
    <body id="top">

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Think we got it wrong? Let us know...</h4>
                    </div>
                    <div class="modal-body">
                        <p>To which category does the article belong? Select from below:</p>

                        <div class="form-group">
                            <label for="sel1">Select Category:</label>
                            <select class="form-control" id="sel1">
                                <option>Business</option>
                                <option>Politics</option>
                                <option>Entertainment</option>
                                <option>Sports</option>
                                <option>Technology</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="modal-submit" class="btn btn-default" data-dismiss="modal">Submit</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="myModalCorrect" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Thank You!</h4>
                    </div>
                    <div class="modal-body">
                        <p>Great! Thank you for using එසැනින් news...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="modal_correct" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main -->
        <section id="main">
            <header class="major">
                <br/>
                <h2>එසැනින් News</h2>
                <h2>-USER ENDPOINT-</h2>
            </header>
            <div id="loading-image" style="text-align: center">
                <img src="svg-loaders/circles.svg" width="100" height="100" />
            </div>
            <div class="container">
                <div class="row">
                    <section>
                        <h3>Enter your text to analyze: </h3>
                        <div class="col-sm-12">
                            <textarea id="text-classify"  class="form-control" cols="500" rows="10"></textarea>
                        </div>
                    </section>
                </div>
                <br/>
                <div class="input-group-btn ">
                    <button id="classify-button" type="button" class="btn-lg btn-danger btn pull-right">Classify</button>
                </div>
                <h3>Result: </h3>
                <h2><span id="result" class="label label-default"></span></h2>
                <!--p id="result"><b></b></p-->
                <p>
                <div class="input-group-btn ">
                    <button id="modal-submit-correct" type="button" class="btn-lg btn-success btn pull-right"   data-toggle="modal">Correct</button>
                    <button type="button" class="btn-lg btn-link btn pull-right"  data-toggle="modal" data-target="#myModal">Report an error</button>
                </div>
                </p>

            </div>
        </section>
        <footer><center>© 2017 - Group 5 - Computer Science</center></footer>
        <script>
            $(document).ready(function () {
                $('#loading-image').hide();
            });

            $("#modal-submit-correct").click(function () {
                var text = $('textarea#text-classify').val();
                if (text === "") {
                    alert("Please enter a text to classify...");
                } else {
                    $('#myModalCorrect').modal('show');
                }
            });

            $("#modal_correct").click(function () {
                window.location.href = 'index.php';
            });

            $("#modal-submit").click(function () {

                var text = $('textarea#text-classify').val();
                if (text === "") {
                    alert("Please enter a text to classify...");
                    $('textarea#text-classify').focus();
                } else {
                    $('#loading-image').show();
                    var customElement = $("<div>", {
                        id: "countdown",
                        css: {
                            "font-size": "30px"
                        },
                        text: 'Please wait! Adding to your text to dataset... This may take a while...'
                    });

                    $.LoadingOverlay("show", {
                        image: "",
                        custom: customElement
                    });
                    var result = "";
                    var text = $('textarea#text-classify').val();
                    var category = $("#sel1").val();
                    $.ajax({
                        url: "http://localhost:3030/classifyUser?category=" + category + "&textToClassify=" + encodeURI(text),
                        method: "GET",                       
                        success: function (msg) {
                            $('#loading-image').hide();
                            $.LoadingOverlay("hide");
                            alert("Thank you for your feedback!");
                        },
                        error: function (request, status, errorThrown) {
                            $('#loading-image').hide();
                            $.LoadingOverlay("hide");
                            alert("There was an error in processing the request. Please retry!")
                        }
                    });
                }

            });

            $("#classify-button").click(function () {
                var text = $('textarea#text-classify').val();
                if (text === "") {
                    alert("Please enter a text to classify...");
                    $('textarea#text-classify').focus();
                } else {
                    $('#loading-image').show();
                    var customElement = $("<div>", {
                        id: "countdown",
                        css: {
                            "font-size": "30px"
                        },
                        text: 'Please wait! Classifying your text... This may take a while...'
                    });

                    $.LoadingOverlay("show", {
                        image: "",
                        custom: customElement
                    });
                    var result = "";
                    $.ajax({
                        url: "http://localhost:3030/classify?textToClassify=" + text,
                        method: "GET",
                        success: function (msg) {
                            $('#loading-image').hide();
                            $.LoadingOverlay("hide");
                            console.log(msg);
                            switch (msg) {
                                case "politics":
                                    console.log("politics");
                                    result = "POLITICS";
                                    break;
                                case "business":
                                    result = "BUSINESS";
                                    break;
                                case "entertainment":
                                    result = "ENTERTAINMENT";
                                    break;
                                case "sports":
                                    result = "SPORTS";
                                    break;
                                case "technology":
                                    result = "TECHNOLOGY";
                                    break;
                            }
                            $('#result').text("Your article belongs to " + result + " category...");
                        },
                        error: function (request, status, errorThrown) {
                            $('#loading-image').hide();
                            $.LoadingOverlay("hide");
                            alert("There was an error in processing the request. Please retry!")
                        }
                    });
                }
            });
        </script>
    </body>
</html>