/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
require("sticky-kit/dist/sticky-kit.js");

// Imports
import Vue from "vue";
import Vuex from "vuex";

import moment from "moment";
import swal from "sweetalert2";
import VueRouter from "vue-router";
import BackToTop from "vue-backtotop";
import VueProgressBar from "vue-progressbar";
import { Form, HasError, AlertError } from "vform";
import ShowAllQuestions from "./components/ShowAllQuestions.vue";

Vue.use(Vuex);
Vue.use(BackToTop);
Vue.use(VueRouter);

window.Vue = Vue;
window.Vuex = Vuex;

window.Form = Form;
window.swal = swal;

Vue.config.productionTip = false;

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

Vue.component(
    "sidebar-widgets",
    require("./components/widgets/Widgets.vue").default
);

Vue.component("questi-footer", require("./components/Footer.vue").default);

Vue.component("sign-in-box", require("./components/SignInBox.vue").default);

let routes = [
    {
        path: "/",
        //component: require("./components/ShowAllQuestions.vue").default
        component: ShowAllQuestions
    },
    {
        path: "/most-answered",
        component: ShowAllQuestions
        // meta: { reuse: false }
    },
    {
        path: "/without-answer",
        component: ShowAllQuestions
        // meta: { reuse: false }
    }
];

const router = new VueRouter({
    mode: "history",
    base: baseUrl,
    routes // short for `routes: routes`
});

//Customize time locale
//moment.locale('ro');\

// Register filters
Vue.filter("relativeTime", (created, format) => {
    return created ? moment(created).format(format) : "Today";
});

Vue.filter("capitalize", string => {
    return string.charAt(0).toUpperCase() + string.slice(1);
});

Vue.filter("setImageSrc", (image, type = "default") => {
    if (!image) {
        return siteUrl + "/images/defaults/user-placeholder.svg";
    }

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

// });
// $(function() {
//   $("html,body").animate({ scrollTop: 0 }, "slow");
// })
