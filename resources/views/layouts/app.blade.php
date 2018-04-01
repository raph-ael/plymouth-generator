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
                <a href="https://github.com/raph-ael/plymouth-generator" target="_blank" class="pseudo button icon-g"><i class="icon-github"></i> GitHub</a>
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
                    <label class="pseudo button toggle" for="tab-1">background color</label>
                    <input id='tab-2' type='radio' name='tabgroupB'>
                    <label class="pseudo button toggle" for="tab-2">logo</label>
                    <input id='tab-3' type='radio' name='tabgroupB'>
                    <label class="pseudo button toggle" for="tab-3">spinner</label>
                    <input id='tab-4' type='radio' name='tabgroupB'>
                    <label class="pseudo button toggle" for="tab-4">background image</label>
                    <div class="row">
                        <div>

                            <button class="jscolor {valueElement:'bg-color-value', styleElement:'preview-bg'}">
                                pick a color
                            </button> <input style="width: 90px;" id="bg-color-value" value="373737">

                        </div>

                        <div>
                            <button id="btn-logo-image">pick a logo image from your computer</button> <button id="btn-logo-image-delete" class="error">delete logo</button>
                        </div>

                        <div>
                            <button id="btn-loading-image">pick spinner image</button> <button id="btn-loading-image-delete" class="error">delete spinner</button>
                        </div>

                        <div>
                            <button id="btn-background-image">choose background image</button> <button id="btn-background-image-delete" class="error">delete image</button>
                        </div>
                    </div>
                </div>


                <div class="center">
                    <p style="text-align: center"><button id="generate" class="success">install plymouth theme</button></p>

                </div>


                <div class="modal">
                    <input id="modal_1" type="checkbox" />
                    <label for="modal_1" class="overlay"></label>
                    <article id="modal-ready" style="display: none;">
                        <header>
                            <h3>Fertig!</h3>
                            <label for="modal_1" class="close">&times;</label>
                        </header>
                        <section class="content">
                            <p>Dein Theme wurde erstellt, <a id="modal-dl-link" href="#">lade es hier herunter</a>, oder führe direkt folgendes script aus um es zu installieren</p>
                            <pre><code class="lang-css" id="modal-code"></code></pre>
                        </section>
                        <footer>
                            <label for="modal_1" class="button dangerous">
                                abbrechen
                            </label>
                        </footer>
                    </article>
                    <article id="modal-loading">
                        <header>
                            <h3>Generiere plymouth Theme</h3>
                            <label for="modal_1" class="close">&times;</label>
                        </header>
                        <section class="content">
                            bitte warten...
                        </section>
                        <footer>

                            <label for="modal_1" class="button dangerous">
                                abbrechen
                            </label>
                        </footer>
                    </article>
                </div>


                <div class="hidden-form">
                    <label id="modal-trigger" for="modal_1" class="button">Show modal</label>
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