import "./bootstrap";
import { createApp, h } from "vue";
import { createRouter, createWebHashHistory } from "vue-router";

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

app.use(router);
app.mount("#app");
