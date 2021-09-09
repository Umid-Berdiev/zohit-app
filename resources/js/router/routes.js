import Home from "../pages/Home.vue";
import About from "../pages/About.vue";
import TheMap from "../pages/TheMap.vue";

export default [
  {
    path: "/",
    component: Home,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: "/about",
    component: About,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: "/map",
    component: TheMap,
    meta: {
      requiresAuth: false,
    },
  },
  { path: "/:catchAll(.*)", redirect: "/" },
];
