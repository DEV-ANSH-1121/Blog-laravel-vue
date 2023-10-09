
import { createRouter, createWebHashHistory } from "vue-router";
import Register from '@/components/auth/Register.vue';
import BlogList from '@/components/blog/BlogList.vue';
import CreateBlog from '@/components/blog/CreateBlog.vue';
import UpdateBlog from '@/components/blog/UpdateBlog.vue';
import ShowBlog from '@/components/blog/ShowBlog.vue';
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
            path: "/blogs",
            name: "blog.list",
            component: BlogList
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
        },
        {
            path: "/blog/:uuid",
            name: "blog.show",
            component: ShowBlog
        }
    ],
});

export default router;

