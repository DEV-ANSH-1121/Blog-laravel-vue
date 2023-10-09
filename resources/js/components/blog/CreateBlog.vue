<template>
    <div class="page-wrapper">
        <div class="container-fluid p-0">
            <!-- login page start-->
            <div class="row justify-content-center">
                <div class="col-md-12 mt-5">
                    <div class="card">
                        <div class="card-header row">
                            <h3>Create Blog</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <input type="text" v-model="data.createData.title" placeholder="Title*"
                                    class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <textarea v-model="data.createData.blog_body" placeholder="Blog Body*"
                                    class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <button @click="createBlog" class="btn btn-primary btn-sm">
                                    Create
                                </button>
                                &nbsp;
                                <router-link class="btn btn-sm btn-secondary" aria-current="page" to="/">
                                    Cancel
                                </router-link>
                            </div>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import Swal from 'sweetalert2';
import router from '@/router';
import { useAuthStore } from '@/stores/useAuthStore.js';


const store = useAuthStore();

const data = reactive({
    createData: {
        title: '',
        blog_body: ''
    }
});

const createBlog = async () => {
    try {
        const response = await axios.post('/api/blog/store', data.createData, {
            headers: store.getHeaderConfig.headers
        });
        if (response.data.success) {
            router.push('/');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: response.data.message,
            });
        }
    } catch (error) {
        console.log(error.response.data.errors.title);
    }
}
</script>
