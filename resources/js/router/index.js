
import { createRouter, createWebHashHistory } from "vue-router";
import Register from '@/components/auth/Register.vue';
import BlogList from '@/components/blog/BlogList.vue';
import CreateBlog from '@/components/blog/CreateBlog.vue';
import UpdateBlog from '@/components/blog/UpdateBlog.vue';
import Login from "@/components/auth/Login.vue";
import { useAuthStore } from '@/stores/useAuthStore.js';


function checkIfLogged() {
    const store = useAuthStore();
    if (!store.getUser) return '/login';
}

function checkIfNotLogged() {
    const store = useAuthStore();
    if (store.getUser) return '/';
}


const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: "/",
            name: "home",
            component: BlogList
        },
        {
            path: "/blogs",
            name: "blog.list",
            component: BlogList
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            beforeEnter: [checkIfNotLogged],
        },
        {
            path: '/signup',
            name: "register",
            component: Register,
            beforeEnter: [checkIfNotLogged],
        },
        {
            path: '/create-blog',
            name: 'create-blog',
            component: CreateBlog,
            beforeEnter: [checkIfLogged],
        },
        {
            path: '/update-blog/:uuid',
            name: 'updateBlog',
            component: UpdateBlog,
            beforeEnter: [checkIfLogged],
        }
    ],
});

export default router;

