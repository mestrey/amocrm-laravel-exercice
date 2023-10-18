import "./bootstrap";
import { createApp, h } from "vue";
import { createRouter, createWebHashHistory } from "vue-router";
import axios from "axios";
import VueAxios from "vue-axios";

import App from "./App.vue";
import Home from "./views/Home.vue";
import Link from "./views/Link.vue";
import Logs from "./views/Logs.vue";

const routes = [
    { path: "/", name: "home", component: Home },
    { path: "/link", name: "link", component: Link },
    { path: "/logs", name: "logs", component: Logs },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

const app = createApp({
    render: () => h(App),
});

const serverURL = "http://localhost:8000/api";

app.config.globalProperties.$server = serverURL;
app.config.globalProperties.$api = (url, params = "") => {
    const urlParams = new URLSearchParams(window.location.search);
    const urlApi =
        serverURL + url + "?account_id=" + urlParams.get("account_id") + params;
    console.log(urlApi);

    return urlApi;
};

app.use(router);
app.use(VueAxios, axios);
app.mount("#app");
