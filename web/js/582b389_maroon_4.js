/*
 * Maroon
 */

var Maroon = {};

$(function() {
    $('input[data-bind][type="text"]').keyup(function() {
        var $el = $(this);
        var $tgt = $($el.data('bind'));
        if ( $tgt.length ) {
            var v = $el.val(), p;
            if (v.length && (p = $el.data('bindprefix')) ) {
                v = p + v;
            }
            $tgt.text(v);
        }
    });
});

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
        var p;
        if ( _.size(this.statsInit) > 0 ) {
            p = '';
            _.each(this.statsInit, function(v, k) {
                if ( v == 0 ) return;
                p += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
            if ( p.length ) {
                html += '<br><strong>Initial Stat Bonuses:</strong>' + p;
            }
        }
        if ( _.size(this.statsBonus) > 0 ) {
            p = '';
            _.each(this.statsBonus, function(v, k) {
                if ( v == 0 ) return;
                p += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
            if ( p.length ) {
                html += '<br><strong>Level-up Stat Bonuses:</strong>' + p;
            }
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
        var p;
        if ( _.size(this.statsInit) > 0 ) {
            p = '';
            _.each(this.statsInit, function(v, k) {
                if ( v == 0 ) return;
                p += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
            if ( p.length ) {
                html += '<br><strong>Initial Stat Bonuses:</strong>' + p;
            }
        }
        if ( _.size(this.statsBonus) > 0 ) {
            p = '';
            _.each(this.statsBonus, function(v, k) {
                if ( v == 0 ) return;
                p += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
            if ( p.length ) {
                html += '<br><strong>Level-up Stat Bonuses:</strong>' + p;
            }
        }

        return html;
    }
};

Maroon.Job = function(obj) {
    this.construct(obj);
};

Maroon.Job.prototype = {
    construct: function(obj) {
        this.id = obj.id;
        this.name = obj.name;
        this.description = obj.description;
        this.statsInit = obj.statsInit;
        this.statsBonus = obj.statsBonus;
    },

    fmtNewChar: function() {
        var html = this.description;
        var p;
        if ( _.size(this.statsInit) > 0 ) {
            p = '';
            _.each(this.statsInit, function(v, k) {
                if ( v == 0 ) return;
                p += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
            if ( p.length ) {
                html += '<br><strong>Initial Stat Bonuses:</strong>' + p;
            }
        }
        if ( _.size(this.statsBonus) > 0 ) {
            p = '';
            _.each(this.statsBonus, function(v, k) {
                if ( v == 0 ) return;
                p += ' ' + k.toUpperCase() + (v > 0 ? '+' : '') + v;
            });
            if ( p.length ) {
                html += '<br><strong>Level-up Stat Bonuses:</strong>' + p;
            }
        }

        return html;
    }
};