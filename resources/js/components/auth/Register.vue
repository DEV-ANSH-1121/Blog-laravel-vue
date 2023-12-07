<template>
    <div class="page-wrapper">
        <div class="container-fluid p-0">
            <!-- login page start-->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="auth-innerright">
                        <div class="authentication-box">
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h4>SIGNUP</h4>
                                    </div>
                                    <form class="theme-form">
                                        <div class="form-group mb-3">
                                            <input type="text" v-model="data.user.name" placeholder="Name*"
                                                class="form-control">
                                            <span class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" v-model="data.user.email" placeholder="Email*"
                                                class="form-control">
                                            <span class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="password" v-model="data.user.password" placeholder="Password*"
                                                class="form-control">
                                            <span class="text-danger" v-if="errors?.password">{{ errors.password[0]
                                            }}</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <button @click="userAuth" class="btn btn-primary btn-sm">
                                                Register
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- login page end-->
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
        name: '',
        email: '',
        password: ''
    }
});

const errors = ref({})

const store = useAuthStore();

const userAuth = async () => {
    try {
        await axios.get("http://localhost:8000/sanctum/csrf-cookie");
        axios.post('/api/register', data.user)
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
