(function($){

    var kirki_functionality = {
        current_el: '',
        less_vars: {},
        config_array = [],
        parent_customizer_base: window.parent.wp.customize.settings, 
        /*parent_customizer_controls: this.parent_customizer_base.controls,
        parent_customizer_settings: this.parent_customizer_base.settings,*/
        init: function(){
            this.configs2array();
            //this.bindListeners();
        },
        modifyVars: function(){
        },
        id2var: function(data_str){
            //convert the setting name to a pre-processor variable
        },
        bindPreProcessor: function(e, ui, setting){
            var self = this,
            pre_processor_var = self.id2var(setting);
        },
        bindListeners: function(){
            // Get reference to kirki object literal
            var self = this; 
            console.log(arguments);
            console.log(that);
            for(var setting_name in self.parent_customizer_controls){
                self.current_el = parent.jQuery('input[data-customize-setting-link="'+ setting_name +'"]');
                if($target.hasClass('kirki-color-picker')) {
                    $target.iris({change: (function(_setting){
                        return function(event,ui){
                            self.bindPreProcessor(event,ui,_setting);
                        }
                    }(setting_name))});
                }
            }
        }
    };

    _(kirki).extend(kirki_functionality);

    function bindListeners() {
        for(var setting_name in parent_customizer_controls){
            var $target = parent.jQuery('input[data-customize-setting-link="'+ setting_name +'"]');
            // TODO move to bindPreProcessor fxn
            if($target.hasClass('kirki-color-picker')) {
                $target.iris({change: (function(_setting){
                    return function(event,ui){
                        kirki.bindPreProcessor(event,ui,_setting);
                    }
                }(setting_name))});
            }
        }
    }

})(jQuery);
