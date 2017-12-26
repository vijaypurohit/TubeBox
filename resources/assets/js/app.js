
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

let VueResource = require('vue-resource');
let pluralize = require('pluralize');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('video-upload', require('./components/VideoUpload.vue'));
Vue.component('video-player', require('./components/VideoPlayer.vue'));
Vue.component('video-voting', require('./components/VideoVoting.vue'));
Vue.component('video-comments', require('./components/VideoComments.vue'));
Vue.component('subscribe-button', require('./components/SubscribeButton.vue'));
Vue.component('encode-percentage', require('./components/EncodePercentage.vue'));

Vue.use(VueResource);

import Vue from 'vue';
import Vue2Filters from 'vue2-filters';
import VeeValidate from 'vee-validate';

Vue.use(Vue2Filters);
Vue.use(VeeValidate);

const app = new Vue({
    el: '#app',
    data: window.citube
});

function fadeOutEffect() {
    let fadeTarget = document.getElementById("flash-message");
    let fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity < 0.1) {
            clearInterval(fadeEffect);
        } else {
            fadeTarget.style.opacity -= 0.1;
        }
    }, 200);
}
document.addEventListener('DOMContentLoaded', function () {
    let el = document.getElementById('flash-message');
    if(el){
        el.addEventListener('click', fadeOutEffect);
    }
});
