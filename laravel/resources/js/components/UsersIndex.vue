<template>
    <div class="users">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <router-link :to="{ name: 'statuses.create' }">Add a status</router-link>

        <div class="container" v-if="users">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel panel-default">

                        <div class="panel-body table-responsive">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th width="150">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="{ id,  name, email } in users">
                                            <td>{{ name }}</td>
                                            <td>{{ email }}</td>
                                            <td>
                                                <router-link :to="{name: 'editCompany', params: {id: id}}" class="btn btn-xs btn-danger">
                                                    Edit
                                                </router-link>
                                                <a href="#"
                                                   class="btn btn-xs btn-danger"
                                                   v-on:click="deleteEntry(id, index)">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                loading: false,
                users: null,
                error: null,
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.users = null;
                this.loading = true;
                axios
                    .get('/api/users', {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.users = response.data;
                    });
            }
        }
    }
</script>
