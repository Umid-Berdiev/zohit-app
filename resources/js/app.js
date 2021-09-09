require("./bootstrap");

import { createApp } from "vue";
import "bootstrap";

import router from "./router";
import store from "./store";
import App from "./App.vue";

// styles
import "bootstrap/dist/css/bootstrap.min.css";
import "./assets/css/style.css";

const app = createApp(App);

app.use(router);
app.use(store);
app.mount("#app");
