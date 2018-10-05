<template>
    <div class="statuses">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <ul v-if="statuses">
            <li v-for="{ name } in statuses">
                <strong>Name:</strong> {{ name }}
            </li>
        </ul>

        <b-btn v-b-modal.modalPrevent>Add Status</b-btn>

        <b-modal id="modalPrevent"
                 ref="modal"
                 title="Add a new Status"
                 @ok="handleOk"
                 @shown="clearName">
            <form @submit.stop.prevent="saveForm">
                <b-form-input type="text"
                              placeholder="Status"
                              v-model="status.name"></b-form-input>
            </form>
        </b-modal>

    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                loading: false,
                statuses: null,
                status: {
                    name: ''
                },
                error: null,
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.statuses = null;
                this.loading = true;
                axios
                    .get('/api/statuses', {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.statuses = response.data;
                    });
            },

            /// Modal
            clearName () {
                // this.name = ''
            },
            handleOk (evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.status.name) {
                    alert('Please enter your name')
                } else {
                    this.saveForm()
                }
            },
            saveForm() {
                var app = this;
                var newStatus = app.status;
                axios.post('/api/status', newStatus)
                    .then(function (resp) {
                        app.clearName()
                        app.$refs.modal.hide()
                        app.fetchData()
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your status");
                    });
            }
        }
    }
</script>
