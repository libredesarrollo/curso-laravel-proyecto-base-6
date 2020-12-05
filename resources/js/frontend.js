/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import router from "./assets/router.js";
import VueMask from 'v-mask';
import Vuelidate from 'vuelidate';
import VueAWN from "vue-awesome-notifications"

//import MyUploadAdapter from "./assets/ckeditor/MyUploadAdapter.js";


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component(
//     "list-posts",
//     require("./components/PostListComponent.vue").default
// );

Vue.component(
    "modal-post",
    require("./components/PostModalComponent.vue").default
);

Vue.component(
    "post-list-default",
    require("./components/PostListDefaultComponent.vue").default
);

Vue.use(VueMask);
Vue.use(Vuelidate);
Vue.use(VueAWN);

const app = new Vue({
    el: "#app",
    // render: h => h(App),
    router
}); //.$mount("#app");
