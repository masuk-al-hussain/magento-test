define([
    'uiComponent',
    'ko'
], function (Component, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Strativ_KnockoutDemo/demo'
        },

        message: ko.observable('Hello from Knockout in Magento 2!'),

        updateMessage: function () {
            this.message('Message updated!');
        }
    });
});
