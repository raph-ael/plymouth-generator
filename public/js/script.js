
var app = {
    init: function(){
        preview.init();
        control.init();

        $('#generate').click(function(){

            var bg_image = $("#background-image").prop("files")[0];   // Getting the properties of file from file field
            var logo_image = $('#logo-image').prop("files")[0];
            var loader_image = $('#loading-image').prop("files")[0];


            var form_data = new FormData();

            form_data.append("bgimage", bg_image);
            form_data.append("logoimage", logo_image);
            form_data.append("loaderimage", loader_image);
            form_data.append("bgcolor", $('#background-color').val());
            form_data.append("_token", $('#data-form input[name="_token"]').val());

            $.ajax({
                url: "/generate",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         // Setting the data attribute of ajax with file_data
                type: 'POST',
                success: function(json){
                    downloadFile('./download/theme/' + json.file);
                }
            });
        });

    }
};

var preview = {
    init: function(){
        preview_bg.init();
        preview_logo.init();
        preview_loader.init();

        window.onresize = function(event) {
            preview.reposition();
        };

        this.reposition();

    },
    reposition: function () {
        preview_bg.reposition();
        preview_logo.reposition();
        preview_loader.reposition();
    }
};

var preview_logo = {

    element: null,
    resize_faktor:0.2,

    init: function()
    {
        this.element = $('.preview-logo');
    },

    reposition: function()
    {
        var new_width = preview_bg.width * this.resize_faktor;

        this.element.css({
            position:'absolute',
            width: new_width + 'px',
            height: 'auto',
            left: preview_bg.center.x - (new_width/2) + 'px'
        });

        var new_height = this.element.height();

        this.element.css('top', (preview_bg.center.y - (new_height/2))+ 'px');


    }
};

var preview_loader = {

    element: null,
    resize_faktor:0.05,

    init: function () {
        this.element = $('.preview-loader');
    },
    reposition: function() {

        var new_width = preview_bg.width * this.resize_faktor;

        this.element.css({
            position:'absolute',
            width: new_width + 'px',
            height: 'auto',
            left: preview_bg.center.x - (new_width/2) + 'px'
        });

        var new_height = this.element.height();

        this.element.css('top', (preview_bg.pos.top + (preview_bg.height - (new_height+(0.05*preview_bg.height)))));
    }
};

var preview_bg = {

    pos:null,
    width:null,
    height:null,
    center:null,
    element: null,

    init: function () {
        preview_bg.element = $('.preview-bg');

    },

    reposition: function()
    {
        this.pos = preview_bg.element.position();
        this.width = this.element.width();
        this.height = this.element.height();
        this.center = {
            x: preview_bg.pos.left + (preview_bg.width/2),
            y: preview_bg.pos.top + (preview_bg.height/2)
        };
    }
};

var control = {
    init: function(){
        control_bg.init();
        control_bg_color.init();
        control_logo.init();
        control_loader.init();
    }
};

var control_bg_color = {

    element: null,
    element_value: null,

    init: function(){
        this.element = $('#background-color');
        this.element_value = $('#bg-color-value');
        this.element_value.change(function(){
            control_bg_color.element.val(this.value);
        });
        control_bg_color.element.val(this.element_value.val());
    }
};

var control_logo = {

    btn: null,
    btn_delete: null,
    element: null,

    init: function(){

        this.element = $('#logo-image');
        this.preview = $('#preview-logo');
        this.btn = $('#btn-logo-image');
        this.btn_delete = $('#btn-logo-image-delete');

        /*
         choose logo button
         */
        this.btn.click(function(){
            control_logo.element.trigger('click');
        });

        /*
         preview image
         */
        this.element.change(function(e){
            var inputfile = this, reader = new FileReader();
            reader.onloadend = function(){
                control_logo.preview.attr('src', ''+reader.result+'');
                preview.reposition();
                /*
                  hm stupid fix :)
                 */
                setTimeout(function(){
                    preview.reposition();
                },100);
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        /*
         delete logo button
         */
        this.btn_delete.click(function(){
            preview_logo.element.attr('src','/img/16_9.png');
            control_logo.element[0].value = '';
        });
    }
};

var control_loader = {

    btn: null,
    btn_delete: null,
    element: null,

    init: function(){

        this.element = $('#loading-image');
        this.preview = $('#preview-loader');
        this.btn = $('#btn-loading-image');
        this.btn_delete = $('#btn-loading-image-delete');

        /*
         choose logo button
         */
        this.btn.click(function(){
            control_loader.element.trigger('click');
        });

        /*
         preview image
         */
        this.element.change(function(e){
            var inputfile = this, reader = new FileReader();
            reader.onloadend = function(){
                control_loader.preview.attr('src', ''+reader.result+'');
                preview.reposition();
                /*
                 hm stupid fix :)
                 */
                setTimeout(function(){
                    preview.reposition();
                },100);
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        /*
         delete logo button
         */
        this.btn_delete.click(function(){
            preview_loader.element.attr('src','/img/16_9.png');
            control_loader.element[0].value = '';
        });
    }
};

var control_bg = {
    element: null,
    file_element:null,
    delete_element:null,

    init: function(){

        this.element = $('#btn-background-image');
        this.file_element = $('#background-image');
        this.delete_element = $('#btn-background-image-delete');

        this.element.click(function(){
            control_bg.file_element.trigger('click');
        });

        this.file_element.change(function(e){
            var inputfile = this, reader = new FileReader();
            reader.onloadend = function(){
                preview_bg.element.css('background-image', 'url('+reader.result+')');
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        this.delete_element.click(function(){
            preview_bg.element.css('background-image','none');
            control_bg.file_element[0].value = '';
        });



        /*
        img.onchange = function(e){
            var inputfile = this, reader = new FileReader();
            reader.onloadend = function(){
                inputfile.style['background-image'] = 'url('+reader.result+')';
            }
            reader.readAsDataURL(e.target.files[0]);
        }
        */
    }
};

Zepto(function($){



    app.init();
    var navi = $('nav');

    window.onscroll = function () {
        var top = window.scrollY ? window.scrollY : document.documentElement.scrollTop;
        if (top == 0) {
            navi.addClass('transparent');
        }
        else
        {
            navi.removeClass('transparent');
        }
    }




});

window.downloadFile = function (sUrl) {

    //iOS devices do not support downloading. We have to inform user about this.
    if (/(iP)/g.test(navigator.userAgent)) {
        alert('Your device does not support files downloading. Please try again in desktop browser.');
        return false;
    }

    //If in Chrome or Safari - download via virtual link click
    if (window.downloadFile.isChrome || window.downloadFile.isSafari) {
        //Creating new link node.
        var link = document.createElement('a');
        link.href = sUrl;

        if (link.download !== undefined) {
            //Set HTML5 download attribute. This will prevent file from opening if supported.
            var fileName = sUrl.substring(sUrl.lastIndexOf('/') + 1, sUrl.length);
            link.download = fileName;
        }

        //Dispatching click event.
        if (document.createEvent) {
            var e = document.createEvent('MouseEvents');
            e.initEvent('click', true, true);
            link.dispatchEvent(e);
            return true;
        }
    }

    // Force file download (whether supported by server).
    if (sUrl.indexOf('?') === -1) {
        sUrl += '?download';
    }

    window.open(sUrl, '_self');
    return true;
}

window.downloadFile.isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
window.downloadFile.isSafari = navigator.userAgent.toLowerCase().indexOf('safari') > -1;