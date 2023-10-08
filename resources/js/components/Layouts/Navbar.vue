
<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white rounded-0 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Blog List</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link active" aria-current="page" to="/">Home</router-link>
                    </li>
                </ul>
                <ul v-if="!store.getUser" class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item mr-2">
                        <router-link class="nav-link" aria-current="page" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" aria-current="page" to="/signup">Signup</router-link>
                    </li>
                </ul>
                <ul v-else class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link" aria-current="page" to="#">
                            {{ store.getUser.data.name }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" @click="userLogout" style="cursor:pointer">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { useAuthStore } from '@/stores/useAuthStore.js';
import Swal from 'sweetalert2';
import router from '@/router';

const store = useAuthStore();

const userLogout = async () => {

    try {
        const response = await axios.post('/api/logout', null, {
            headers: store.getHeaderConfig.headers
        });
        Swal.fire({
            icon: 'success',
            text: response.data.message,
        });
        store.clearStoredData();
        router.push('/login');
    } catch (error) {
        console.log(error);
    }
}
</script>
