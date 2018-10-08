<template>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12 col-lg-12">

                    <p>
                        <router-link :to="{ name: 'home' }">Home</router-link> |
                        <router-link :to="{ name: 'hello' }">Hello World</router-link> |
                        <router-link :to="{ name: 'users.index' }">Users</router-link> |
                        <router-link :to="{ name: 'companies.index' }">Companies</router-link> |
                        <router-link :to="{ name: 'statuses.index' }">Statuses</router-link> |
                        <router-link :to="{ name: 'educationLevels.index' }">Education Levels</router-link> |
                        <router-link :to="{ name: 'countries.index' }">Countries</router-link> |
                        <router-link :to="{ name: 'subdivisionTypes.index' }">Country Subdivisions</router-link>
                    </p>

                    <router-view></router-view>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {}
</script>
