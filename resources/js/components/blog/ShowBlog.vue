<template>
    <div class="page-wrapper">
        <div class="container-fluid p-0">
            <!-- login page start-->
            <div class="row justify-content-center">
                <div class="col-md-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <strong>{{ blog.title }}</strong>
                            <small> ~By {{ blog.user.name }}</small>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <h4>{{ blog.title }}</h4>
                            </div>
                            <div class="form-group mb-3">
                                <p>{{ blog.blog_body }}</p>
                            </div>
                            <div class="form-group mb-3">
                                <router-link class="btn btn-sm btn-primary" aria-current="page"
                                    :to="{ name: 'updateBlog', params: { uuid: route.params.uuid } }">Edit</router-link>
                                &nbsp;
                                <router-link class="btn btn-sm btn-primary" aria-current="page" to="/">
                                    List
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
import { onMounted, ref } from "vue";
import { useRoute } from 'vue-router'

const route = useRoute()

const blog = ref({
    title: '',
    blog_body: '',
    user: ''
});

async function getBlog() {
    await axios
        .get('http://127.0.0.1:8000/api/blog?uuid=' + route.params.uuid)
        .then((response) => {
            blog.value.title = response.data.data.title
            blog.value.blog_body = response.data.data.blog_body
            blog.value.user = response.data.data.author
        });
}

onMounted(() => {
    getBlog();
})
</script>
