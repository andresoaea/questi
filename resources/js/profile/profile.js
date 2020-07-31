Vue.component("profile", require("./Profile.vue").default);

Vue.component("pagination", require("laravel-vue-pagination"));

// const store = new Vuex.Store({
// 	state: {}
// })

const store = new Vuex.Store({
    state: {
        user: {},
        answersCount: 0,
        questionsCount: 0
    }
});

const GeneralSettings = Vue.component(
    "general-settings",
    require("./GeneralSettings.vue").default
);

const ChangePassword = Vue.component(
    "change-password",
    require("./ChangePassword.vue").default
);

const Questions = Vue.component(
    "questions",
    require("./Questions.vue").default
);

const Answers = Vue.component("answers", require("./Answers.vue").default);

let routes = [
    { path: "/profile", component: GeneralSettings },
    { path: "/profile/change-password", component: ChangePassword },
    { path: "/profile/questions", component: Questions },
    { path: "/profile/answers", component: Answers },
    {
        path: "*",
        component: {
            template: '<h4 style="color: grey">404 Page not found</h4>'
        }
    }
];

questiVue.$store = store;
questiVue.$router.addRoutes(routes);
questiVue.$mount("#questi");

const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;
