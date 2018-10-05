<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">

                <h1>Vue Router Demo App</h1>

                <p>
                    <router-link :to="{ name: 'home' }">Home</router-link> |
                    <router-link :to="{ name: 'hello' }">Hello World</router-link> |
                    <router-link :to="{ name: 'users.index' }">Users</router-link> |
                    <router-link :to="{ name: 'companies.index' }">Companies</router-link> |
                    <router-link :to="{ name: 'statuses.index' }">Statuses</router-link>
                </p>

                <router-view></router-view>

            </div>
        </div>
    </div>
</template>
<script>
    export default {}
</script>
