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
                <template slot="row-details" slot-scope="row">
                    <b-card>
                        <ul v-for="subitem in row.item.country_subdivision_items">
                            <li>{{ subitem.name }} ({{ subitem.abbreviation }})
                                <b-button size="sm" @click.stop="editCountrySubdivisionItem(subitem.id)" class="mr-1">
                                    Edit
                                </b-button>
                                <b-button size="sm" @click.stop="deleteCountrySubdivisionItem(subitem.id)" class="mr-1">
                                    Delete
                                </b-button>
                            </li>
                        </ul>
                        <!--b-row class="mb-2">
                            <b-col sm="3" class="text-sm-right"><b>State:</b></b-col>
                            <b-col>????</b-col>
                        </b-row>
                        <b-row class="mb-2">
                            <b-col sm="3" class="text-sm-right"><b>Is Active:</b></b-col>
                            <b-col>88888</b-col>
                        </b-row-->
                        <!--ul v-if="data.item.country_subdivision_items" v-for="subitem in data.item.country_subdivision_items">
                        <li>{{ subitem.name }} ({{ subitem.abbreviation }})</li>
                    </ul-->
                        <b-button size="sm" @click="row.toggleDetails">Hide Details</b-button>
                    </b-card>
                </template>
                <template slot="name" slot-scope="data">
                    {{ data.item.name }} ({{ data.item.abbreviation }})<br />

                    <!--ul v-if="data.item.country_subdivision_items" v-for="subitem in data.item.country_subdivision_items">
                        <li>{{ subitem.name }} ({{ subitem.abbreviation }})</li>
                    </ul-->

                    <b-btn v-b-modal.modalAddNewCountrySubdivisionItem @click="setCountrySubdivisionItemCountryId(data.item.id)">Add {{ data.item.country_subdivision_types.name }}</b-btn>
                </template>
                <template slot="actions" slot-scope="row">
                    <b-button size="sm" @click.stop="row.toggleDetails" class="mr-2">
                        {{ row.detailsShowing ? 'Hide' : 'Show'}} Details
                    </b-button>
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

        <b-btn v-b-modal.modalAddNewCountry>Add Country</b-btn>

        <b-modal id="modalAddNewCountry"
                 ref="modal"
                 title="Add a new Country"
                 @ok="countryHandleOk"
                 @shown="clearForm">
            <form @submit.stop.prevent="saveCountryForm">
                <b-form-input type="text"
                              placeholder="Country"
                              v-model="country.name"></b-form-input>
                <b-form-input type="text"
                              placeholder="Abbreviation"
                              v-model="country.abbreviation"></b-form-input>
                <b-form-select v-model="country.country_subdivision_types_id"
                               placeholder="Country Subdivision Type"
                               :options="subdivisionTypes"
                               class="mb-3">
                    <template slot="first">
                        <!-- this slot appears above the options from 'options' prop -->
                        <option :value="null" disabled>-- Please select an option --</option>
                    </template></b-form-select>
            </form>
        </b-modal>

        <b-modal id="modalAddNewCountrySubdivisionItem"
                 ref="modal"
                 title="Add a new Country Sub Item"
                 @ok="countryItemHandleOk"
                 @shown="clearForm">
            <form @submit.stop.prevent="saveCountrySubdivisionItemForm">
                <!--b-form-input type="text"
                              v-model="country_subdivision_item.country_id"></b-form-input-->
                <b-form-input type="text"
                              placeholder="Name"
                              v-model="country_subdivision_item.name"></b-form-input>
                <b-form-input type="text"
                              placeholder="Abbreviation"
                              v-model="country_subdivision_item.abbreviation"></b-form-input>
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
                country_subdivision_item: {
                    name: '',
                    abbreviation: '',
                    country_id: 0
                },
                subdivisionTypes: [],
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

                axios
                    .get('/api/subdivisiontypes', {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        for(var id in response.data) {
                                this.subdivisionTypes.push( { text: response.data[id]["name"], value: response.data[id]["id"] });
                        }
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
            setCountrySubdivisionItemCountryId(id) {
                this.country_subdivision_item.country_id = id;
                console.log(this.country_subdivision_item)
            },
            deleteCountrySubdivisionItem(id) {
                axios.delete('/api/countrysubdivisionitem/' + id)
                    .then(function (resp) {
                        window.location.replace('/countries');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not delete country subdivision item");
                    });
            },

            /// Modal
            clearForm () {
                this.country.name = ''
            },
            countryHandleOk (evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.country.name) {
                    alert('Please enter country name')
                } else {
                    this.saveCountryForm()
                }
            },
            countryItemHandleOk (evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.country_subdivision_item.name &&
                    !this.country_subdivision_item.abbreviation) {
                    alert('Please fill in all fields')
                } else {
                    this.saveCountrySubdivisionItemForm()
                }
            },
            saveCountryForm() {
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
            },
            saveCountrySubdivisionItemForm() {
                var app = this;
                // app.country_subdivision_item.country_id = 1;
                var newCountrySubdivisionItem = app.country_subdivision_item;
                axios.post('/api/countrysubdivisionitem', newCountrySubdivisionItem)
                    .then(function (resp) {
                        app.clearForm()
                        app.$refs.modal.hide()
                        app.fetchData()
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create country subdivision item");
                    });
            }
        }
    }
</script>
