(function (factory) {
    /* global define */
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(window.jQuery);
    }
}(function ($) {
    // Extends plugins for adding hello.
    //  - plugin is external module for customizing.
    $.extend($.summernote.plugins, {
        /**
         * @param {Object} context - context object has status of editor.
         */
        'uploader': function (context) {
            var self = this;

            // ui has renders to build ui elements.
            //  - you can create a button with `ui.button`
            var ui = $.summernote.ui;
            var options = context.options;
            var lang = options.langInfo;
            // add hello button
            context.memo('button.uploader', function () {
                // create button
                var button = ui.button({
                    contents: '<i class="layui-icon layui-icon-picture">',
                    tooltip: lang.image.image,
                    click: function () {
                        layui.use(['uploader'], function () {
                            var uploader = layui.uploader;
                            uploader.placeEdit(function (res) {

                                var html = '';
                                for (var i in res) {
                                    html += '<img src="' + res[i].path + '" alt="' + res[i].tmp_name + '">';
                                }
                                context.invoke('editor.pasteHTML', html);
                            }, 'image', 1)
                        });

                    }
                });

                // create jQuery object from button instance.
                var $uploader = button.render();
                return $uploader;
            });

            // This events will be attached when editor is initialized.
            this.events = {
                // This will be called after modules are initialized.
                'summernote.init': function (we, e) {

                },
                // This will be called when user releases a key on editable.
                'summernote.keyup': function (we, e) {

                }
            };

            // This method will be called when editor is initialized by $('..').summernote();
            // You can create elements for plugin
            this.initialize = function () {

            };

            // This methods will be called when editor is destroyed by $('..').summernote('destroy');
            // You should remove elements on `initialize`.
            this.destroy = function () {
                this.$panel.remove();
                this.$panel = null;
            };
        }
    });
}));
