import { createApp } from "vue";
import App from "./app.vue";
import router from "./router";
import i18n from "../langs/i18n";
import Vue3Toasity from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { createPinia } from "pinia";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons";
import { fab } from "@fortawesome/free-brands-svg-icons";
import QuillEditor from "../../js/back/QuillEditor.vue"


library.add(fas, far, fab);
const app = createApp(App);
const pinia = createPinia();
app.use(i18n);
app.use(Vue3Toasity, {
    autoClose: 3000,
});
app.component("font-awesome-icon", FontAwesomeIcon);
app.component("QuillEditor", QuillEditor);
app.use(pinia);
app.use(router);
app.mount("#app");
