<template>
    <div class="educationLevels">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <div v-if="educationLevels">
            <b-table :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :items="educationLevels"
                     :fields="fields">
                <template slot="actions" slot-scope="row">
                    <b-button size="sm" @click.stop="editEducationLevels(row.item.id)" class="mr-1">
                        Edit
                    </b-button>
                    <b-button size="sm" @click.stop="deleteEducationLevels(row.item.id)" class="mr-1">
                        Delete
                    </b-button>
                </template>
            </b-table>
            <p>
                Sorting By: <b>{{ sortBy }}</b>,
                Sort Direction: <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b>
            </p>
        </div>

        <b-btn v-b-modal.modalPrevent>Add Education Level</b-btn>

        <b-modal id="modalPrevent"
                 ref="modal"
                 title="Add a new Education Level"
                 @ok="handleOk"
                 @shown="clearForm">
            <form @submit.stop.prevent="saveForm">
                <b-form-input type="text"
                              placeholder="Education Level"
                              v-model="educationLevel.description"></b-form-input>
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
                educationLevels: null,
                educationLevel: {
                    description: ''
                },
                error: null
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.educationLevels = null;
                this.loading = true;
                axios
                    .get('/api/educationlevels', {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.educationLevels = response.data;
                        this.fields = [
                            { key: 'description', sortable: true },
                            { key: 'actions', sortable: false }
                        ];
                        this.sortBy = 'description';
                        this.sortDesc = false;
                    });
            },
            editEducationLevel(id) {
                console.log("EDIT ID " + id);
            },
            deleteEducationLevel(id) {
                axios.delete('/api/educationlevel/' + id)
                    .then(function (resp) {
                        window.location.replace('/educationlevels');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not delete education level");
                    });
            },

            /// Modal
            clearForm () {
                this.description = ''
            },
            handleOk (evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.educationLevel.description) {
                    alert('Please enter description')
                } else {
                    this.saveForm()
                }
            },
            saveForm() {
                var app = this;
                var newEducationLevel = app.educationLevel;
                axios.post('/api/educationlevel', newEducationLevel)
                    .then(function (resp) {
                        app.clearForm()
                        app.$refs.modal.hide()
                        app.fetchData()
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create education level");
                    });
            }
        }
    }
</script>
