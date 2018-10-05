<template>
    <div class="subdivisionTypes">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <div v-if="subdivisionTypes">
            <b-table :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :items="subdivisionTypes"
                     :fields="fields">
                <template slot="actions" slot-scope="row">
                    <b-button size="sm" @click.stop="editSubdivisionType(row.item.id)" class="mr-1">
                        Edit
                    </b-button>
                    <b-button size="sm" @click.stop="deleteSubdivisionType(row.item.id)" class="mr-1">
                        Delete
                    </b-button>
                </template>
            </b-table>
            <p>
                Sorting By: <b>{{ sortBy }}</b>,
                Sort Direction: <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b>
            </p>
        </div>

        <b-btn v-b-modal.modalPrevent>Add Subdivision Type</b-btn>

        <b-modal id="modalPrevent"
                 ref="modal"
                 title="Add a new Subdivision Type"
                 @ok="handleOk"
                 @shown="clearForm">
            <form @submit.stop.prevent="saveForm">
                <b-form-input type="text"
                              placeholder="Subdivsion Type"
                              v-model="subdivisionType.name"></b-form-input>
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
                subdivisionTypes: null,
                subdivisionType: {
                    name: ''
                },
                error: null
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.subdivisionTypes = null;
                this.loading = true;
                axios
                    .get('/api/subdivisiontypes', {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.subdivisionTypes = response.data;
                        this.fields = [
                            { key: 'name', sortable: true },
                            { key: 'actions', sortable: false }
                        ];
                        this.sortBy = 'name';
                        this.sortDesc = false;
                    });
            },
            editSubdivisionType(id) {
                console.log("EDIT ID " + id);
            },
            deleteSubdivisionType(id) {
                axios.delete('/api/subdivisiontype/' + id)
                    .then(function (resp) {
                        window.location.replace('/subdivisiontypes');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not delete subdivision type");
                    });
            },

            /// Modal
            clearForm () {
                this.name = ''
            },
            handleOk (evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.subdivisionType.name) {
                    alert('Please enter subdivison type')
                } else {
                    this.saveForm()
                }
            },
            saveForm() {
                var app = this;
                var newSubdivisionType = app.subdivisionType;
                axios.post('/api/subdivisiontype', newSubdivisionType)
                    .then(function (resp) {
                        app.clearForm()
                        app.$refs.modal.hide()
                        app.fetchData()
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create subdivison type");
                    });
            }
        }
    }
</script>
