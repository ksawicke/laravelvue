<template>
    <div class="countries">
        <div class="loading" v-if="loading">
            <div class="fa-2x">
                <i class="fas fa-spinner fa-spin"></i> Patience is a virtue...
            </div>
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <div class="row" v-show="showAddCountryForm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add a Country</strong>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <input type="hidden" class="form-control" placeholder="" v-model="country.id">

                                <label>Country</label>
                                <input type="text" class="form-control" placeholder="Country Name" v-model="country.name">
                                <!--span class="help-block">Please enter your email</span-->
                            </div>
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" placeholder="Abbreviation" v-model="country.abbreviation">
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                            <div class="form-group">
                                <label>Country Subdivision Type</label>
                                <select class="form-control" v-model="country.country_subdivision_types_id">
                                    <option value="">Please select one:</option>
                                    <option v-for="subdivisionType in subdivisionTypes" v-bind:value="subdivisionType.value">{{ subdivisionType.text }}</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" v-on:click="countryHandleOk"><i class="fa fa-dot-circle-o"></i> Submit</button>
                        <button type="reset" class="btn btn-sm btn-danger" v-on:click="addCountryHandle"><i class="fa fa-backward"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-show="showAddCountrySubdivisionItemForm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add a Country Item</strong>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <input type="hidden" class="form-control" placeholder="" v-model="country_subdivision_item.id">

                                <label>Country</label>
                                <input type="text" class="form-control" placeholder="Country Subdivision Item Name" v-model="country_subdivision_item.name">
                                <!--span class="help-block">Please enter your email</span-->
                            </div>
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" placeholder="Abbreviation" v-model="country_subdivision_item.abbreviation">
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" v-on:click="countrySubdivisionItemHandleOk"><i class="fa fa-dot-circle-o"></i> Submit</button>
                        <button type="reset" class="btn btn-sm btn-danger" v-on:click="addCountrySubdivisionItemHandle"><i class="fa fa-backward"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="countries" v-show="showCountriesTable">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> <strong>Countries</strong> <button class="badge badge-success" v-on:click="addCountryHandle">Add Country</button>
                        </div>
                        <div class="card-body">

                            <b-table responsive-sm
                                     :sort-by.sync="sortBy"
                                     :sort-desc.sync="sortDesc"
                                     :items="countries"
                                     :fields="fields">

                                <template slot="row-details" slot-scope="row">
                                    <b-card>

                                        <!-->

                                        <b-table responsive-sm striped
                                                 :sort-by.sync="sortBy"
                                                 :sort-desc.sync="sortDesc"
                                                 :items="row.item.country_subdivision_items"
                                                 :fields="fields">
                                            <template slot="name" slot-scope="data">
                                                {{ data.item.name }}
                                            </template>

                                            <template slot="abbreviation" slot-scope="data">
                                                {{ data.item.abbreviation }}
                                            </template>

                                            <template slot="actions" slot-scope="row">
                                                <b-button size="sm" v-on:click="editCountrySubdivisionItem(data.item.id)" class="badge badge-success">
                                                    Edit
                                                </b-button>
                                                <b-button size="sm" v-on:click="deleteCountrySubdivisionItem(data.item.id)" class="badge badge-danger">
                                                    Delete
                                                </b-button>
                                            </template>
                                        </b-table>

                                        <!-->

                                        <!--ul v-for="subitem in row.item.country_subdivision_items">
                                            <li>{{ subitem.name }} ({{ subitem.abbreviation }})
                                                <b-button size="sm" @click.stop="editCountrySubdivisionItem(subitem.id)" class="mr-1">
                                                    Edit
                                                </b-button>
                                                <b-button size="sm" @click.stop="deleteCountrySubdivisionItem(subitem.id)" class="mr-1">
                                                    Delete
                                                </b-button>
                                            </li>
                                        </ul-->
                                    </b-card>
                                </template>

                                <template slot="name" slot-scope="data">
                                    {{ data.item.name }}
                                </template>

                                <template slot="abbreviation" slot-scope="data">
                                    {{ data.item.abbreviation }}
                                </template>

                                <template slot="actions" slot-scope="row">
                                    <b-button size="sm" @click.stop="row.toggleDetails" class="badge badge-success">
                                        {{ row.detailsShowing ? '&nbsp;-&nbsp;' : '&nbsp;+&nbsp;'}}
                                    </b-button>
                                    <b-button size="sm" class="badge badge-success" v-on:click="addCountrySubdivisionItemHandle">Add {{ row.item.country_subdivision_types.name }}</b-button>
                                    <b-button size="sm" @click.stop="editCountry(row.item.id)" class="badge badge-success">
                                        Edit
                                    </b-button>
                                    <b-button size="sm" @click.stop="deleteCountry(row.item.id)" class="badge badge-danger">
                                        Delete
                                    </b-button>
                                </template>

                            </b-table>
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
                countries: null,
                country: {
                    name: '',
                    abbreviation: '',
                    country_subdivision_types_id: '',
                    mode: 'add'
                },
                country_subdivision_item: {
                    name: '',
                    abbreviation: '',
                    country_id: 0
                },
                subdivisionTypes: [],
                showAddCountryForm: false,
                showCountriesTable: true,
                showAddCountrySubdivisionItemForm: false,
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
                            { key: 'abbreviation', sortable: true },
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
            addCountryHandle() {
                this.showAddCountryForm = !this.showAddCountryForm;
                this.showCountriesTable = !this.showCountriesTable;
                this.country.id = 0;
            },
            addCountrySubdivisionItemHandle() {
                this.showAddCountrySubdivisionItemForm = !this.showAddCountrySubdivisionItemForm;
                this.showCountriesTable = !this.showCountriesTable;
                this.country_subdivision_item.country_id = 0;
            },
            editCountry(id) {
                this.showAddCountryForm = !this.showAddCountryForm;
                this.showCountriesTable = !this.showCountriesTable;

                axios
                    .get('/api/country/' + id, {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.country = response.data;
                    });
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
            countrySubdivisionItemHandleOk (evt) {
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
                var status = 0;
                switch(app.country.id) {
                    case 0:
                        axios.post('/api/country', newCountry)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addCountryHandle();
                                        break;

                                    default:
                                        alert('Unable to save country');
                                        break;
                                }
                            });
                        break;

                    default:
                        axios.patch('/api/country/' + newCountry.id, newCountry)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addCountryHandle();
                                        break;

                                    default:
                                        alert('Unable to save country');
                                        break;
                                }
                            });
                        break;
                }

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
