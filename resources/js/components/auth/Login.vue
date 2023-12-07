<template>
    <div class="container">
        <div class="row my-5">
            <div class="col-md-6 mx-auto">
                <ul class="list-group my-2" v-for="(errorArray, index) in store.getErrors" :key="index">
                    <li class="list-group-item bg-danger text-white mb-1" v-for="(error, index) in errorArray" :key="index">
                        {{ error }}
                    </li>
                </ul>
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="text-center">
                            Login
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <input type="text" v-model="data.user.email" placeholder="Email*" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" v-model="data.user.password" placeholder="Password*"
                                class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <button @click="userAuth" class="btn btn-primary btn-sm">
                                Login
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import Swal from 'sweetalert2';
import router from '@/router';
import { useAuthStore } from '@/stores/useAuthStore.js';

const data = reactive({
    user: {
        email: '',
        password: ''
    }
});

const errors = ref({});

const store = useAuthStore();

const userAuth = async () => {
    try {
        await axios.get("http://localhost:8000/sanctum/csrf-cookie");
        axios.post('/api/login', data.user)
            .then(response => {
                if (response.data.success) {
                    store.storeUser(response.data.user);
                    router.push('/');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.data.message,
                    });
                }
            })
            .catch(error => {
                if (error.response.status === 422) {
                    errors.value = error.response.data.errors
                }
            });

    } catch (error) {
        //
    }
}
</script>
