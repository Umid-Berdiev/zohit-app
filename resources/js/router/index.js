import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes.js";

const router = createRouter({
  history: createWebHistory(),
  routes,
  linkActiveClass: "active",
  linkExactActiveClass: "exact-active",
});

// router.beforeEach((to, from, next) => {});

export default router;
