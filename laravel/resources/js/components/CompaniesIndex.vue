<template>
    <div class="companies">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <ul v-if="companies">
            <li v-for="{ name, website, phone,  social_linked_in, social_twitter, social_facebook, about } in companies">
                <strong>Name:</strong> {{ name }},
                <strong>Website:</strong> {{ website }},
                <strong>Phone:</strong> {{ phone }},
                <strong>Linked In:</strong> {{ social_linked_in }},
                <strong>Twitter:</strong> {{ social_twitter }},
                <strong>Facebook:</strong> {{ social_facebook }},
                <strong>About:</strong> {{ about }}
            </li>
        </ul>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                loading: false,
                companies: null,
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
                    .get('/api/companies', {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.companies = response.data;
                    });
            }
        }
    }
</script>
