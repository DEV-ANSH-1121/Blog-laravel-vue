<template>
    <div class="page-wrapper">
        <div class="container-fluid p-0">
            <!-- login page start-->
            <div class="row justify-content-center">
                <div class="col-md-12 mt-5">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col-8">
                                <h3>
                                    Blog List &nbsp;
                                    <router-link v-if="store.isLoggedIn" class="btn btn-sm btn-primary" aria-current="page"
                                        to="/create-blog">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Create
                                    </router-link>
                                </h3>

                            </div>
                            <div class="col-4">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Search blogs here"
                                        v-model="searchBlog" />
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                        @click="getBlogs()">Search</button>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" aria-describedby="Blog Table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Body</th>
                                            <th v-if="store.isLoggedIn">Status</th>
                                            <th v-if="store.isLoggedIn">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="blog in data" :key="blog.id">
                                            <td>{{ blog.title }}</td>
                                            <td>{{ blog.blog_body }}</td>
                                            <td v-if="store.isLoggedIn">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="flexSwitchCheckDefault" :checked="blog.status"
                                                        @change="setStatus(blog.uuid, blog.status)">
                                                </div>
                                            </td>
                                            <td v-if="store.isLoggedIn">
                                                <router-link class="btn btn-sm btn-primary" aria-current="page"
                                                    :to="{ name: 'updateBlog', params: { uuid: blog.uuid } }">Edit</router-link>
                                                &nbsp;
                                                <button class="btn btn-sm btn-danger"
                                                    @click="deleteBlog(blog.uuid)">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <Bootstrap5Pagination :data="paginatorData" @pagination-change-page="getBlogs" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Swal from 'sweetalert2';
import { useAuthStore } from '@/stores/useAuthStore.js';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const store = useAuthStore();

const data = ref([]);
const paginatorData = ref([]);

const searchBlog = ref('');

async function getBlogs(page = 1) {
    await axios
        .post('http://127.0.0.1:8000/api/blog', {
            "page": page,
            "search": searchBlog.value
        }).then((response) => {
            data.value = response.data.data.data;
            paginatorData.value = response.data.data;
        });

}

async function setStatus(blog, status) {
    await axios
        .post('http://127.0.0.1:8000/api/blog/update', {
            "uuid": blog,
            "status": !status
        }).then(() => getBlogs());
}

async function deleteBlog(blog) {
    Swal.fire({
        title: "Are you sure ?",
        text: "You will not be able to recover this blog !",
        type: "warning",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Delete',
        denyButtonText: `Don't Delete`,
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .post('http://127.0.0.1:8000/api/blog/delete', {
                    "uuid": blog,
                }).then(() => {
                    getBlogs();
                    Swal.fire('Deleted!', '', 'success');
                });
        }
    });
}

onMounted(() => {
    getBlogs();
})
</script>
