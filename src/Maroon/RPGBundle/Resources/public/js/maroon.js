/*
 * Maroon
 */

var Maroon = {};

Maroon.toCollection = function(list, type) {
    return _.map(list, function(v) { return new type(v); });
};

Maroon.Race = function(obj) {
    this.construct(obj);
};

Maroon.Race.prototype = {
    construct: function(obj) {
        this.id = obj.id;
        this.name = obj.name;
        this.description = obj.description;
        this.statsInit = obj.statsInit;
        this.statsBonus = obj.statsBonus;
    },

    fmtNewChar: function() {
        var html = this.description;
        if ( _.size(this.statsInit) > 0 ) {
            html += '<br><strong>Initial Stat Bonuses:</strong>';
            _.each(this.statsInit, function(v, k) {
                html += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
        }
        if ( _.size(this.statsBonus) > 0 ) {
            html += '<br><strong>Level-up Stat Bonuses: </strong>';
            _.each(this.statsBonus, function(v, k) {
                html += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
        }

        return html;
    }
};

// the same thing as Maroon.Race for now at least, but may differ later on
Maroon.Gender = function(obj) {
    this.construct(obj);
};

Maroon.Gender.prototype = {
    construct: function(obj) {
        this.id = obj.id;
        this.name = obj.name;
        this.description = obj.description;
        this.statsInit = obj.statsInit;
        this.statsBonus = obj.statsBonus;
    },

    fmtNewChar: function() {
        var html = this.description;
        if ( _.size(this.statsInit) > 0 ) {
            html += '<br><strong>Initial Stat Bonuses:</strong>';
            _.each(this.statsInit, function(v, k) {
                html += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
        }
        if ( _.size(this.statsBonus) > 0 ) {
            html += '<br><strong>Level-up Stat Bonuses: </strong>';
            _.each(this.statsBonus, function(v, k) {
                html += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
        }

        return html;
    }
};