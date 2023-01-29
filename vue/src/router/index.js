import {
    createRouter,
    createWebHashHistory,
    createWebHistory,
} from "vue-router";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import Post from "../views/Post.vue";
import Form from "../views/Form.vue";
import ForgotPassword from "../views/ForgotPassword.vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import AuthLayout from "../components/AuthLayout.vue";
import store from "../store";

const routes = [
    {
        path: "/auth",
        redirect: "/login",
        name: "Auth",
        component: AuthLayout,
        meta: { isGuest: true },
        children: [
            {
                path: "/login",
                name: "Login",
                component: Login,
            },
            {
                path: "/forgot-password",
                name: "ForgotPassword",
                component: ForgotPassword,
            },
        ],
    },
    {
        path: "/",
        redirect: "/dashboard",
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: "/dashboard",
                name: "Dashboard",
                component: Dashboard,
            },
            {
                path: "/post",
                name: "Post",
                component: Post,
            },
            {
                path: "/form",
                name: "Form",
                component: Form,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: "Login" });
    } else if (to.meta.isGuest && store.state.user.token) {
        next({ name: "Dashboard" });
    } else {
        next();
    }
});

export default router;
