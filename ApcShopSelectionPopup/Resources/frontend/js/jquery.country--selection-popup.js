;
(function ($, window, document) {

    var Popup = {
        arrowIconSelector: '.select_panel_arrow',
        panelSelectSelector: '.select_panel',
        languagePanelSelector: '.lang_panel',
        languageItemSelector: '.lang_sample',
        popupContainerSelector: '.vag_language_selecion',
        popupBoxSelector: '.box',
        pageBody: 'body',
        cname: 'lang_bar',
        ctime: 5 * 365 * 86400, // 5 years
        
        init: function () {
            var me = this;
            
            $.overlay.open().then(function(){
                $(me.popupContainerSelector).show();
                me.showPopup();
                me.openLangBar();
            });
            
            me.choseLanguage();
        },
        showPopup: function () {
            var me = this;
            $(me.popupContainerSelector).fadeIn(300, function () {
                $(me.pageBody).css("overflow", "hidden");
            });
        },
        openLangBar: function () {
            var me = this;
            $(me.panelSelectSelector).click(function () {
                $(me.languagePanelSelector).slideToggle();
                $(me.arrowIconSelector).toggleClass('select_panel_arrow_selected');
            });
            $(me.panelSelectSelector).trigger("click");
        },
        choseLanguage: function () {
            var me = this;
            $(me.languageItemSelector).click(function () {
                var langId = $(this).attr('data-lang-id');
                me.setCookie(me.cname, langId, me.ctime);
                window.location.reload();
            });
        },
        setCookie: function (cname, cvalue, extime) {
            var me = this;
            var d = new Date();
            d.setTime(d.getTime() + (extime * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=1" + ";" + expires + ";path=/";
            document.cookie = 'shop' + "=" + cvalue + ";" + expires + ";path=/";
        },
        getCookie: function () {
            var me = this;
            var name = me.cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return false;
        }
    };

    $(document).ready(function () {
        if (!Popup.getCookie()) {
            Popup.init();
        }
    });
})(jQuery, window, document);