(function($){

    var kirki_functionality = {
        less_vars: {},
        //config_array: [],
        parent_customizer_base: window.parent.wp.customize.settings, 
        getParentControls: function(){
            var self = this;
            return self.parent_customizer_base.controls;
        },
        getParentSettings: function(){
            var self = this;
            return self.parent_customizer_base.settings;
        },
        init: function(){
            this.configs2array();
            //this.bindListeners();
        },
        modifyVars: function(){
            less.modifyVars(this.less_vars);
        },
        id2var: function(data_str){
            //convert the setting name to a pre-processor variable
        },
        bindPreProcessor: function(e, ui, setting){
            var self = this;
            //var pre_processor_var = self.id2var(setting);
            console.log(setting);
        },
        bindListeners: function(){
            // Get reference to kirki object literal
            var self = this; 
            for(var setting_name in self.getParentControls()){
                $target = parent.jQuery('input[data-customize-setting-link="'+ setting_name +'"]');
                if($target.hasClass('kirki-color-picker')) {
                    $target.iris({
                        change: function(event,ui){ 
                            var less_var = $(this).data('framework-var');
                            self.less_vars[less_var] = ui.color.toString();
                            self.modifyVars();
                            }
                    });
                }
            }
        }
    };

    _(kirki).extend(kirki_functionality);
    kirki.bindListeners();

})(jQuery);
