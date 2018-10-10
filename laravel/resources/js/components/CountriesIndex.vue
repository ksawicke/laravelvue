<template>
    <div class="countries">
        <div class="loading" v-if="loading">
            <div class="fa-2x">
                <i class="fas fa-spinner fa-spin"></i>&nbsp;&nbsp;Patience is a virtue...
            </div>
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <b-modal id="confirmDeleteCountry"
                 ref="modal"
                 title="Delete Country?"
                 @ok="deleteCountry(countryMarkedForDeletion.id)">
            <form @submit.stop.prevent="handleSubmit">
                Are you sure you want to delete <strong>{{ countryMarkedForDeletion.name }}</strong>?
            </form>
        </b-modal>

        <b-modal id="confirmDeleteCountrySubdivisionItem"
                 ref="modal"
                 title="Delete State/Providence?"
                 @ok="deleteCountrySubdivisionItem(countrySubdivisionItemMarkedForDeletion.id)">
            <form @submit.stop.prevent="handleSubmit">
                Are you sure you want to delete <strong>{{ countrySubdivisionItemMarkedForDeletion.name }}</strong>?
            </form>
        </b-modal>

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
                                <input type="text" class="form-control" placeholder="Country Name"
                                       v-model="country.name">
                                <!--span class="help-block">Please enter your email</span-->
                            </div>
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" placeholder="Abbreviation"
                                       v-model="country.abbreviation">
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                            <div class="form-group">
                                <label>Country Subdivision Type</label>
                                <select class="form-control" v-model="country.country_subdivision_types_id">
                                    <option value="">Please select one:</option>
                                    <option v-for="subdivisionType in subdivisionTypes"
                                            v-bind:value="subdivisionType.value">{{ subdivisionType.text }}
                                    </option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-success" v-on:click="countryHandleOk"><i
                            class="fa fa-check"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger" v-on:click="addCountryHandle"><i
                            class="fa fa-times"></i> Cancel
                        </button>
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
                                <input type="hidden" class="form-control" placeholder=""
                                       v-model="country_subdivision_item.id">

                                <input type="hidden" class="form-control" placeholder=""
                                       v-model="country_subdivision_item.country_id">

                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Country Subdivision Item Name"
                                       v-model="country_subdivision_item.name">
                                <!--span class="help-block">Please enter your email</span-->
                            </div>
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" placeholder="Abbreviation"
                                       v-model="country_subdivision_item.abbreviation">
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-success"
                                v-on:click="countrySubdivisionItemHandleOk"><i class="fa fa-check"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger" v-on:click="addCountrySubdivisionItemHandle">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="countries" v-show="showCountriesTable">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> <strong>Countries</strong>
                            <button class="badge badge-success" v-on:click="addCountryHandle">Add Country</button>
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
                                                <b-button size="sm" v-on:click="editCountrySubdivisionItem(row.item.id)"
                                                          class="badge badge-success">
                                                    Edit
                                                </b-button>
                                                <b-btn @click="countrySubdivisionItemMarkedForDeletion = row.item"
                                                       v-b-modal.confirmDeleteCountrySubdivisionItem size="sm"
                                                       class="badge badge-danger">Delete
                                                </b-btn>
                                            </template>
                                        </b-table>

                                    </b-card>

                                </template>

                                <template slot="name" slot-scope="data">

                                    <b-button size="sm" class="badge badge-default" @click.stop="data.toggleDetails">{{
                                        data.detailsShowing ? '-' : '+' }}
                                    </b-button>&nbsp;&nbsp;{{ data.item.name }}

                                </template>

                                <template slot="abbreviation" slot-scope="data">

                                    {{ data.item.abbreviation }}

                                </template>

                                <template slot="actions" slot-scope="row">

                                    <b-button size="sm" class="badge badge-success"
                                              v-on:click="addCountrySubdivisionItemHandle(row.item.id)">Add {{
                                        row.item.country_subdivision_types.name }}
                                    </b-button>
                                    <b-button size="sm" v-on:click="editCountry(row.item.id)"
                                              class="badge badge-success">
                                        Edit
                                    </b-button>

                                    <b-btn @click="countryMarkedForDeletion = row.item" v-b-modal.confirmDeleteCountry
                                           size="sm" class="badge badge-danger">Delete
                                    </b-btn>

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
                expandCountry: 0,
                countryMarkedForDeletion: {
                    id: 0,
                    name: ''
                },
                countrySubdivisionItemMarkedForDeletion: {
                    id: 0,
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
                            {key: 'name', sortable: true},
                            {key: 'abbreviation', sortable: true},
                            {key: 'actions', sortable: false}
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
                        for (var id in response.data) {
                            this.subdivisionTypes.push({
                                text: response.data[id]["name"],
                                value: response.data[id]["id"]
                            });
                        }
                    });
            },
            toggleCountry(id) {
                this.expandCountry = id;
            },
            addCountryHandle() {
                this.showAddCountryForm = !this.showAddCountryForm;
                this.showCountriesTable = !this.showCountriesTable;
                this.country.id = 0;
            },
            addCountrySubdivisionItemHandle(id) {
                this.showAddCountrySubdivisionItemForm = !this.showAddCountrySubdivisionItemForm;
                this.showCountriesTable = !this.showCountriesTable;
                this.country_subdivision_item.id = 0;
                this.country_subdivision_item.country_id = id;
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

                this.$refs.modal.hide();
            },
            setCountrySubdivisionItemCountryId(id) {
                this.country_subdivision_item.country_id = id;
                console.log(this.country_subdivision_item)
            },
            editCountrySubdivisionItem(id) {
                this.showAddCountrySubdivisionItemForm = !this.showAddCountrySubdivisionItemForm;
                this.showCountriesTable = !this.showCountriesTable;

                axios
                    .get('/api/countrysubdivisionitem/' + id, {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.country_subdivision_item = response.data;
                    });
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
            clearForm() {
                this.country.name = ''
            },
            clearCountrySubdivisionForm() {

            },
            countryHandleOk(evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.country.name) {
                    alert('Please enter country name')
                } else {
                    this.saveCountryForm()
                }
            },
            countrySubdivisionItemHandleOk(evt) {
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
                switch (app.country.id) {
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
                var newCountrySubdivisionItem = app.country_subdivision_item;
                var status = 0;
                // console.log(app.country_subdivision_item);
                // console.log("******");

                switch (app.country_subdivision_item.id) {
                    case 0:
                        axios.post('/api/countrysubdivisionitem', newCountrySubdivisionItem)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearCountrySubdivisionForm();
                                        app.fetchData();
                                        app.addCountrySubdivisionItemHandle();
                                        break;

                                    default:
                                        alert('Unable to save country subdivision item');
                                        break;
                                }
                            });
                        break;

                    default:
                        axios.patch('/api/countrysubdivisionitem/' + newCountrySubdivisionItem.id, newCountrySubdivisionItem)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearCountrySubdivisionForm();
                                        app.fetchData();
                                        app.addCountrySubdivisionItemHandle();
                                        break;

                                    default:
                                        alert('Unable to save country subdivision item');
                                        break;
                                }
                            });
                        break;
                }
            }
        }
    }
</script>
