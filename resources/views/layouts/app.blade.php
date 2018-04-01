<!DOCTYPE html>
<html lang="en">
<head>
    <title>Plymouth - Generator</title>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="css, library, picnic, picnicss, light">
    <meta name="description" content="A lightweight CSS library">
    <link href="https://unpkg.com/picnic" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="web/img/basket.png" type="image/png">
    <link rel="stylesheet" media="bogus">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js"></script>
    <script type="text/javascript" src="/js/jscolor/jscolor.js"></script>
    <script type="application/javascript" src="/js/script.js"></script>

</head>

    <body>
        <nav class="transparent">
            <a href="#" class="brand">
                <span>Plymouth Generator</span>
            </a>

            <!-- responsive-->
            <input id="bmenub" type="checkbox" class="show">
            <label for="bmenub" class="burger pseudo button"><i class="icon-menu"></i></label>

            <div class="menu">
                <a href="#" class="pseudo button icon-picture">Demo</a>
                <a href="#" class="button icon-puzzle">Plugins</a>
            </div>
        </nav>
        <main>
            <header class="hero">
                <div class="content">
                    <h1>Plymouth Generator</h1>
                    <p class="slogan">brand your tux</p>
                </div>
            </header>
            <div id="content" class="visual">

                <div id="theme">

                    <img src="/img/16_9.png" class="preview-bg" id="preview-bg" />
                    <img src="/img/anarchy-white.png" class="preview-logo" id="preview-logo" />
                    <img src="/img/loader.png" class="preview-loader" id="preview-loader" />

                </div>


                <div style="text-align: center;" class="tabs four">
                    <input id='tab-1' type='radio' name='tabgroupB' checked />
                    <label class="pseudo button toggle" for="tab-1">Hintergrundfarbe</label>
                    <input id='tab-2' type='radio' name='tabgroupB'>
                    <label class="pseudo button toggle" for="tab-2">Logo</label>
                    <input id='tab-3' type='radio' name='tabgroupB'>
                    <label class="pseudo button toggle" for="tab-3">Loader</label>
                    <input id='tab-4' type='radio' name='tabgroupB'>
                    <label class="pseudo button toggle" for="tab-4">Hintergrund-Bild</label>
                    <div class="row">
                        <div>

                            <button class="jscolor {valueElement:'bg-color-value', styleElement:'preview-bg'}">
                                Farbe auswählen
                            </button> <input style="width: 90px;" id="bg-color-value" value="373737">

                        </div>

                        <div>
                            <button id="btn-logo-image">Logo auswählen</button> <button id="btn-logo-image-delete" class="error">Logo löschen</button>
                        </div>

                        <div>
                            <button id="btn-loading-image">Logo auswählen</button> <button id="btn-loading-image-delete" class="error">Spinner löschen</button>
                        </div>

                        <div>
                            <button id="btn-background-image">Bild auswählen</button> <button id="btn-background-image-delete" class="error">Bild löschen</button>
                        </div>
                    </div>
                </div>


                <div class="center">
                    <p style="text-align: center"><button id="generate" class="success">Theme generieren</button></p>

                </div>





                <div class="hidden-form">
                    <form id="data-form">
                        <input name="background-image" id="background-image" type="file" />
                        <input name="background-color" id="background-color" type="hidden" />
                        <input name="logo-image" id="logo-image" type="file" />
                        <input name="loading-image" id="loading-image" type="file" />
                        <input name="logo-position" id="logo-position" type="hidden" />
                        <input name="logo-size" id="logo-size" type="hidden" />
                        <input name="theme-name" id="theme-name" type="hidden" />
                        {{ csrf_field() }}
                    </form>
                </div>


            </div>

        </main>

    </body>
</html>