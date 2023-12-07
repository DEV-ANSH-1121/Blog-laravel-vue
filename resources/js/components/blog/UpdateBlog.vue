<template>
    <div class="page-wrapper">
        <div class="container-fluid p-0">
            <!-- login page start-->
            <div class="row justify-content-center">
                <div class="col-md-12 mt-5">
                    <div class="card">
                        <div class="card-header row">
                            <h3>Update Blog</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <input type="text" v-model="data.updateData.title" placeholder="Title*"
                                    class="form-control">
                                <span class="text-danger" v-if="errors?.title">{{ errors.title[0] }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <textarea v-model="data.updateData.blog_body" placeholder="Blog Body*"
                                    class="form-control"></textarea>
                                <span class="text-danger" v-if="errors?.blog_body">{{ errors.blog_body[0] }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <button @click="updateBlog" class="btn btn-primary btn-sm">
                                    Update
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
import { onMounted, reactive, ref } from "vue";
import Swal from 'sweetalert2';
import router from '@/router';
import { useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/useAuthStore.js';

const store = useAuthStore();

const route = useRoute()

const data = reactive({
    updateData: {
        uuid: '',
        title: '',
        blog_body: ''
    }
});

const errors = ref({});


async function getBlog() {
    await axios
        .get('http://127.0.0.1:8000/api/blog?uuid=' + route.params.uuid)
        .then((response) => {
            data.updateData.uuid = response.data.data.uuid,
                data.updateData.title = response.data.data.title,
                data.updateData.blog_body = response.data.data.blog_body
        });
}

const updateBlog = async () => {
    try {
        axios.post('/api/blog/update', data.updateData, {
            headers: store.getHeaderConfig.headers
        }).then(response => {
            if (response.data.success) {
                router.push('/');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.data.message,
                });
            }
        }).catch(error => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
            }
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
    }
}

onMounted(() => {
    getBlog();
})
</script>
