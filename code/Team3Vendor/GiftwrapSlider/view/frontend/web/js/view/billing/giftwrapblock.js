define(
    [
        'uiComponent',
        'jquery',
        'ko'
    ],
    function(
        Component,
        $,
        ko
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Team3Vendor_GiftwrapSlider/billing/giftwrapblock'
            },

            initialize: function () {
                var self = this;
                this._super();
            }

        });
    }
);