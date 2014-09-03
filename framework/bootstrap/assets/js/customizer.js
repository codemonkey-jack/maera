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
        triggerSavePublish: function(setting, value) {
            parent.window.wp.customize(setting, function(obj){
                obj.set(value);
            });
        },
        hex2rgb: function(hex, opacity) {
                var h=hex.replace('#', '');
                h =  h.match(new RegExp('(.{'+h.length/3+'})', 'g'));
        
                for(var i=0; i<h.length; i++)
                    h[i] = parseInt(h[i].length==1? h[i]+h[i]:h[i], 16);
        
                if (typeof opacity != 'undefined')  h.push(opacity);
        
                return 'rgba('+h.join(',')+')';
        },
        bindListeners: function(){
            // Get reference to kirki object literal
            var that = this; 
            for(var setting_name in that.getParentControls()){
                var _selector = 'input[data-customize-setting-link="'+ setting_name +'"]';
                var $target = parent.jQuery(_selector);

                if ($target.data('framework-var') === "") continue;

                if($target.hasClass('kirki-color-picker')) {
                    $target.iris({
                        change: function(event,ui){ 
                            var less_var = $(this).data('framework-var');
                            var _setting = $(this).data('customize-setting-link');
                            var _val = ui.color.toString();
                            that.setParentLess(less_var, _val);
                            that.modifyVars();
                            $(this).parent().siblings('.wp-picker-open').attr('style', 'background-color:' + ui.color.toString() + ';');
                            that.triggerSavePublish(_setting, _val);
                        }
                    });
                }
                else if ($target.hasClass('kirki-slider')) {
                    if ($target.data('framework-var') === "") continue;
                    parent.jQuery('#slider_' + setting_name).slider({
                        change:  function(event,ui){
                            var $_target = $(this).siblings('label').children('input');
                            var less_var = $_target.data('framework-var');
                            var units = (less_var.indexOf('size') != -1 /*|| less_var.indexOf('height') != -1*/) ? 'px' : '';
                            var _setting =  $_target.data('customize-setting-link');
                            var _val = ui.value.toString();
                            if (_setting.indexOf('opacity') > 1 ) {
                                var related_el = _setting.split('_');
                                related_el.pop();
                                related_el.push('color');
                                related_el = related_el.join('_');
                                color_val = parent.jQuery('[data-customize-setting-link="' + related_el + '"]').val();
                                less_val =  that.hex2rgb(color_val, ui.value/100);
                                if ( less_var !== "undefined" ) {
                                    that.setParentLess(less_var, less_val + units);
                                    that.modifyVars();
                                }
                            } else if ( less_var !== "undefined" ) {
                                that.setParentLess(less_var, _val + units);
                                that.modifyVars();
                            }
                            that.triggerSavePublish(_setting, _val);
                        }
                    });
                }
                else if ($target.hasClass('kirki-text')) {
                    //var that = this;
                    $target.off("keyup").on("keyup", _.debounce(function(ev) {
                        var me = this; 
                        var less_var = $(me).data('framework-var');
                        var _setting = $(me).data('customize-setting-link');
                        var vals = $(me).val().trim();
                        // TODO make setParentLess call modifyVars directly
                        that.setParentLess(less_var, vals);
                        that.modifyVars();
                        that.triggerSavePublish(_setting, vals);
                     }, 500));
                }
                else if (setting_name === "gradients_toggle") { // TODO change this to a listener for all relevant toggles if necessary and then check type inside; use the type to check instead of setting_name
                    $target.on("change", function(ev){
                        var href = that.getLessDir() + '/gradients.less';
                        if ( $(this).is(":checked") && $(this).val() === "0") {
                            $('[href="' + href + '"').remove();
                        } else {
                            var $link = $("<link type='text/css' rel='stylesheet/less' />");
                            $link.attr('href', href);
                            $('head').append($link);
                            less.sheets.push($link[0]);
                        }
                        less.refresh();
                        that.modifyVars();
                        that.triggerSavePublish("gradients_toggle", "")
                    });
                }
            }
        },
        init: function(){
            parent.window.kirkiDelayTimer = "";
            this.bindListeners();
            this.modifyVars();
        }
    };

    //_(kirki).extend(kirki_functionality);
    kirki.init();

})(jQuery);
