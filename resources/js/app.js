require('./bootstrap')

window.Vue = require('vue').default

Vue.directive('click-outside', {
    bind: function (el, binding, vnode) {
        this.event = function (event) {
            if (!(el == event.target || el.contains(event.target))) {
            vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', this.event)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', this.event)
    },
});

Vue.component('weather-app', require('./components/WeatherApp.vue').default)

new Vue({
    el: '#app'
})
