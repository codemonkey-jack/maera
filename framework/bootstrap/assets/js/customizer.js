(function($){
    var kirki = {
        getParentLess: function(){
            var parentWindow = window.parent;
            // check if loading the first time and if so create object in parent
            if(typeof(parentWindow.SSCustomizer) != "undefined" && parentWindow.SSCustomizer.hasOwnProperty('framework_vars')) {
                return parentWindow.SSCustomizer.framework_vars;
            } else {
                parentWindow.SSCustomizer = {};
                parentWindow.SSCustomizer.framework_vars = {};
            }
        },
        setParentLess: function(prop_name, prop_value){
            window.parent.SSCustomizer.framework_vars[prop_name] = prop_value;
        },
        parent_customizer_base: window.parent.wp.customize.settings, 
        getParentControls: function(){
            return this.parent_customizer_base.controls;
        },
        getParentSettings: function(){
            return this.parent_customizer_base.settings;
        },
        getLessDir: function(){
            var url_parts = $('link[rel="stylesheet/less"]').eq(0).attr('href').split('/');
            return url_parts.splice(0, url_parts.length-1).join('/');
        },
        modifyVars: function(){
            var less_vars =  this.getParentLess();
            less.modifyVars(less_vars);
        },
        bindListeners: function(){
            // Get reference to kirki object literal
            var that = this; 
            for(var setting_name in that.getParentControls()){
                $target = parent.jQuery('input[data-customize-setting-link="'+ setting_name +'"]');
                if($target.hasClass('kirki-color-picker')) {
                    $target.iris({
                        change: function(event,ui){ 
                            var less_var = $(this).data('framework-var');
                            that.setParentLess(less_var, ui.color.toString());
                            that.modifyVars();
                            $(this).parent().siblings('.wp-picker-open').attr('style', 'background-color:' + ui.color.toString() + ';');
                            }
                    });
                }
                else if ($target.hasClass('kirki-slider')) {
                    parent.jQuery('#slider_' + setting_name).slider({
                       change:  function(event,ui){
                            var less_var = $(this).siblings('label').children('input').data('framework-var');
                            var units = (less_var.indexOf('size') != -1 /*|| less_var.indexOf('height') != -1*/) ? 'px' : '';
                            if ( less_var !== "undefined" ) that.setParentLess(less_var, ui.value.toString() + units);
                            that.modifyVars();
                        }
                    });
                }
                else if ($target.hasClass('kirki-text')) {
                    var that = this;
                    var delay = (function(){
                        var timer = 0;
                        return function(callback, ms){
                          clearTimeout (timer);
                          timer = setTimeout(callback, ms);
                        };
                    })(); 

                    var duplicateFilter=(function(){
                      var lastContent;
                      return function(content,callback){
                        content=$.trim(content);
                        if(content!=lastContent){
                          callback(content);
                        }
                        lastContent=content;
                      };
                    })();
                    $target.on("keyup", function(ev) {
                        var me = this;
                        delay(function(){
                            duplicateFilter($(me).val(), function(vals) {
                                var less_var = $(me).data('framework-var');
                                // TODO make setParentLess call modifyVars directly
                                that.setParentLess(less_var, vals);
                                that.modifyVars();
                            });
                        }, 1000);
                    });
                }
                else if(setting_name === "gradients_toggle") {
                    var $link = $("<link type='text/css' rel='stylesheet/less' />");
                    $link.attr('href', that.getLessDir() + '/gradients.less');
                    $('head').append($link);
                    less.sheets.push($link[0]);
                    less.refresh();
                }
            }
        },
        init: function(){
            this.bindListeners();
            this.modifyVars();
        }
    };

    //_(kirki).extend(kirki_functionality);
    kirki.init();

})(jQuery);
