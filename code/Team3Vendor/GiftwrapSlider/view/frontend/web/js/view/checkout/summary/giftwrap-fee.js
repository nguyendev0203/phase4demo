define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magento_Catalog/js/price-utils'
    ],
    function ($, Component, quote, totals, priceUtils) {
        "use strict";
        var giftwrap_label = window.checkoutConfig.giftwrap_label;
        return Component.extend({
            defaults: {
                template: 'Team3Vendor_GiftwrapSlider/checkout/summary/giftwrap-fee'
            },
            totals: quote.getTotals(),
            isDisplayedGiftwrapTotal: function () {
                return true;
            },
            getGiftwrapTotal: function () {
                var price = totals.getSegment('giftwrap').value;
                return this.getFormattedPrice(price);
            },
            getCurrentGiftwrapName: function () {
                return giftwrap_label;
            },
        });
    }
);
