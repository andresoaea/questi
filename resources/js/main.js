/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
// require("sticky-kit.js");
require("sticky-kit/dist/sticky-kit.js");

//require('sticky-sidebar')
//window.Vue = require('vue')

import Vue from "vue";
import Vuex from "vuex";

// Imports
import moment from "moment";
import swal from "sweetalert2";
//import Affix from 'vue-affix';
import VueRouter from "vue-router";
import BackToTop from "vue-backtotop";
import VueProgressBar from "vue-progressbar";
import { Form, HasError, AlertError } from "vform";
//import ReallySmoothScroll from 'really-smooth-scroll'

//Vue.use(Affix);
Vue.use(Vuex);
Vue.use(BackToTop);
Vue.use(VueRouter);

window.Vue = Vue;
window.Vuex = Vuex;

window.Form = Form;
window.swal = swal;

Vue.use(VueProgressBar, {
    color: "rgb(0, 153, 43)",
    failedColor: "red",
    thickness: "3px"
});

// Register components
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.component("navigation-bar", require("./components/Navigation.vue").default);

Vue.component(
    "show-all-questions",
    require("./components/ShowAllQuestions.vue").default
);

Vue.component(
    "add-new-question",
    require("./components/AddNewQuestion.vue").default
);

Vue.component(
    "show-single-question",
    require("./components/ShowSingleQuestion.vue").default
);

Vue.component(
    "show-single-answer",
    require("./components/ShowSingleAnswer.vue").default
);

let routes = [
    {
        path: "/",
        component: require("./components/ShowAllQuestions.vue").default
    }
];

const router = new VueRouter({
    mode: "history",
    base: baseUrl,
    routes // short for `routes: routes`
});

//Customize time locale
//moment.locale('ro');

// Register filters
Vue.filter("relativeTime", (created, format) => {
    return moment(created).format(format);
});

Vue.filter("capitalize", string => {
    return string.charAt(0).toUpperCase() + string.slice(1);
});

Vue.filter("setImageSrc", (image, type = "default") => {
    let filePath =
        type === "default"
            ? "/images/defaults/"
            : "/image-storage/" + type + "/small-";
    let base = !image.includes("https://graph.facebook.com")
        ? siteUrl + filePath
        : "";
    return base + image;
});

Vue.directive("tooltip", function(el, binding) {
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: "hover"
    });
});

export const bus = new Vue();

window.isHome = typeof isHome !== "undefined" && isHome === true;
// let isProfile = typeof isProfile !== "undefined" && isProfile === true

let questiVue = new Vue({
    //el: '#questi',
    router
});

if (typeof isProfile === "undefined") {
    questiVue.$mount("#questi");
}

window.questiVue = questiVue;

// Fix for popover
$(document).mouseup(function(e) {
    var container = $(".popover");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.popover("hide");
    }
});

// Init smooth scroll
// ReallySmoothScroll.shim()
// ReallySmoothScroll.config({
//   mousewheelSensitivity: 5
// })

// $(function() {
//   let siebarAffix = $(".sidebar-affix")
//   let parentWidth = siebarAffix.parent().width()

//   siebarAffix.width(parentWidth)

// });
// $(function() {
//   $("html,body").animate({ scrollTop: 0 }, "slow");
// })

// var stickySidebar = new StickySidebar('#sidebar', {
//       topSpacing: 20,
//       bottomSpacing: 0,
//       containerSelector: '.container',
//       innerWrapperSelector: '.sidebar__inner'
//     })

// var sidebar = new StickySidebar('.sidebar', {innerWrapperSelector: '.sidebar__inner'});

// Sticky Sidebar Initialization
$(function() {
    return $("[data-sticky_column]").stick_in_parent({
        parent: "[data-sticky_parent]",
        offset_top: 10
    });
});

// $(window).on("resize", function() {
//     $(document.body).trigger("sticky_kit:recalc")
// })
