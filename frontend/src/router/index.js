import { createRouter, createWebHistory } from "vue-router";
import Login from "@/components/Auth/LoginComponent.vue";
import Register from "@/components/Auth/RegisterComponent.vue";
import ContactList from "@/components/Contacts/ContactListComponent.vue";

const routes = [
  { path: "/", redirect: "/login" },
  { path: "/login", component: Login },
  { path: "/register", component: Register },
  { path: "/contacts", component: ContactList },
  { path: "/:catchAll(.*)", redirect: "/login" }, // Catch-all fallback
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});


export default router;
