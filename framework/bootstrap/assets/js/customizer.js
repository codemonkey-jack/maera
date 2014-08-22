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
