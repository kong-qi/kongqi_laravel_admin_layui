(function(factory) {
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
}(function($) {
    // Extends plugins for adding hello.
    //  - plugin is external module for customizing.
    $.extend($.summernote.plugins, {
        /**
         * @param {Object} context - context object has status of editor.
         */
        'uploadfile': function(context) {
            var self = this;

            // ui has renders to build ui elements.
            //  - you can create a button with `ui.button`
            var ui = $.summernote.ui;
                
            // add hello button
            context.memo('button.uploadfile', function() {
                
                // create button
                var button = ui.button({
                    contents: '<i class="glyphicon glyphicon-picture"/> ',
                    tooltip: '上传文件',
                    click: function() {
                        var files = new Array();
                        var chunk='';
                        layui.use(['index'], function () {

                        });
                        uploadFile('image', '', 1, '', function(itemObj) {
                            
                            itemObj.each(function(index, el) {
                                path = $(this).data('src');
                                path_prew_src = $(this).find('img').attr('src');
                                size = $(this).find('.time').text();
                                tmpname = $(this).find('.title').text();
                                type = $(this).data('type');
                                oss = $(this).data('oss');


                               
                                if (type == 'image') {
                                    if (oss) {
                                        path=oss;
                                    } 
                                    chunk += '<img title="' + tmpname + '" src="' + path + '" style="max-width:100%" />';

                                } 
                                if(type=='vedio')
                                {
                                    if (oss) {
                                        path=oss;
                                    }

                                     chunk +='<p><video class="upload_img" src="'+path+'"  controls="controls" style="max-width: 100%;"></video></p>';
                                    
                                }
                                
                            });

                            
                            context.invoke('editor.pasteHTML', chunk);
                            
                            

                        });
                        
                      
                        
                    }
                });

                // create jQuery object from button instance.
                var $uploadfile = button.render();
                return $uploadfile;
            });

            // This events will be attached when editor is initialized.
            this.events = {
                // This will be called after modules are initialized.
                'summernote.init': function(we, e) {
                    //console.log('summernote initialized', we, e);
                },
                // This will be called when user releases a key on editable.
                'summernote.keyup': function(we, e) {
                    //console.log('summernote keyup', we, e);
                }
            };

            // This method will be called when editor is initialized by $('..').summernote();
            // You can create elements for plugin
            this.initialize = function() {
                this.$panel = $('<div class="hello-panel"/>').css({
                    position: 'absolute',
                    width: 100,
                    height: 100,
                    left: '50%',
                    top: '50%',
                    background: 'red'
                }).hide();

                this.$panel.appendTo('body');
            };

            // This methods will be called when editor is destroyed by $('..').summernote('destroy');
            // You should remove elements on `initialize`.
            this.destroy = function() {
                this.$panel.remove();
                this.$panel = null;
            };
        }
    });
}));