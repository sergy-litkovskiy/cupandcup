;var CUPS = CUPS || {};

CUPS.Router = (function(core){
    var self = this;

    
    this.extend = function(params) {
        return core.$.extend({}, this, params);
    };

})(CUPS.Core);
