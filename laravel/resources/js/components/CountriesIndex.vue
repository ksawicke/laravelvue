<template>
    <div class="countries">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <div v-if="countries">
            <b-table :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :items="countries"
                     :fields="fields">
                <template slot="actions" slot-scope="row">
                    <b-button size="sm" @click.stop="editCountry(row.item.id)" class="mr-1">
                        Edit
                    </b-button>
                    <b-button size="sm" @click.stop="deleteCountry(row.item.id)" class="mr-1">
                        Delete
                    </b-button>
                </template>
            </b-table>
            <p>
                Sorting By: <b>{{ sortBy }}</b>,
                Sort Direction: <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b>
            </p>
        </div>

        <b-btn v-b-modal.modalPrevent>Add Country</b-btn>

        <b-modal id="modalPrevent"
                 ref="modal"
                 title="Add a new Country"
                 @ok="handleOk"
                 @shown="clearForm">
            <form @submit.stop.prevent="saveForm">
                <b-form-input type="text"
                              placeholder="Country"
                              v-model="country.name"></b-form-input>
                <b-form-select v-model="subdivisiontype"
                               :options="options"
                               class="mb-3"></b-form-select>
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
                countries: null,
                country: {
                    name: ''
                },
                subdivisionTypes: null,
                error: null
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.countries = null;
                this.loading = true;
                axios
                    .get('/api/countries', {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.countries = response.data;
                        this.fields = [
                            { key: 'name', sortable: true },
                            { key: 'actions', sortable: false }
                        ];
                        this.sortBy = 'name';
                        this.sortDesc = false;
                    });
            },
            editCountry(id) {
                console.log("EDIT ID " + id);
            },
            deleteCountry(id) {
                axios.delete('/api/country/' + id)
                    .then(function (resp) {
                        window.location.replace('/countries');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not delete country");
                    });
            },

            /// Modal
            clearForm () {
                this.country.name = ''
            },
            handleOk (evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.country.name) {
                    alert('Please enter country name')
                } else {
                    this.saveForm()
                }
            },
            saveForm() {
                var app = this;
                var newCountry = app.country;
                axios.post('/api/country', newCountry)
                    .then(function (resp) {
                        app.clearForm()
                        app.$refs.modal.hide()
                        app.fetchData()
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create country");
                    });
            }
        }
    }
</script>
