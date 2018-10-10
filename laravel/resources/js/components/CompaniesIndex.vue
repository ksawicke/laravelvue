<template>
    <div class="companies">
        <div class="loading" v-if="loading">
            <div class="fa-2x">
                <i class="fas fa-spinner fa-spin"></i>&nbsp;&nbsp;Cookin' up somethin' good...
            </div>
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <b-modal id="confirmDeleteCompany"
                 ref="modal"
                 title="Delete Company?"
                 @ok="deleteCompany(companyMarkedForDeletion.id)">
            <form @submit.stop.prevent="handleSubmit">
                Are you sure you want to delete <strong>{{ companyMarkedForDeletion.name }}</strong>?
            </form>
        </b-modal>

        <div class="row" v-show="showAddCompanyForm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add a Company</strong>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <input type="hidden" class="form-control" placeholder="" v-model="company.id">

                                <label>Company</label>
                                <input type="text" class="form-control" placeholder="Company Name"
                                       v-model="company.name">
                                <!--span class="help-block">Please enter your email</span-->
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input type="text" class="form-control" placeholder="Website"
                                       v-model="company.website">
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" placeholder="Phone"
                                       v-model="company.phone">
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                            <div class="form-group">
                                <label>LinkedIn</label>
                                <input type="text" class="form-control" placeholder="LinkedIn"
                                       v-model="company.social_linked_in">
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                            <div class="form-group">
                                <label>Twitter</label>
                                <input type="text" class="form-control" placeholder="Twitter"
                                       v-model="company.social_twitter">
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" class="form-control" placeholder="Facebook"
                                       v-model="company.social_facebook">
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                            <div class="form-group">
                                <label>LinkedIn</label>
                                <textarea class="form-control" placeholder="About"
                                       v-model="company.about">
                                </textarea>
                                <!--span class="help-block">Please enter your password</span-->
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-success" v-on:click="companyHandleOk"><i
                            class="fa fa-check"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger" v-on:click="addCompanyHandle"><i
                            class="fa fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="companies" v-show="showCompaniesTable">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> <strong>Companies</strong>
                            <button class="badge badge-success" v-on:click="addCompanyHandle">Add Company</button>
                        </div>

                        <div class="card-body">

                            <b-table responsive-sm
                                     :sort-by.sync="sortBy"
                                     :sort-desc.sync="sortDesc"
                                     :items="companies"
                                     :fields="fields">

                                <template slot="name" slot-scope="data">

                                    {{ data.item.name }}

                                </template>

                                <template slot="website" slot-scope="data">

                                    {{ data.item.website }}

                                </template>

                                <template slot="phone" slot-scope="data">

                                    {{ data.item.phone }}

                                </template>

                                <template slot="actions" slot-scope="row">

                                    <b-button size="sm" v-on:click="editCompany(row.item.id)"
                                              class="badge badge-success">
                                        Edit
                                    </b-button>

                                    <b-btn @click="companyMarkedForDeletion = row.item" v-b-modal.confirmDeleteCompany
                                           size="sm" class="badge badge-danger">Delete
                                    </b-btn>

                                </template>

                            </b-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--
        <div v-if="companies">
            <b-table :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :items="companies"
                     :fields="fields">
                <template slot="actions" slot-scope="row">
                    <b-button size="sm" @click.stop="row.toggleDetails" class="mr-2">
                        {{ row.detailsShowing ? 'Hide' : 'Show'}} Details
                    </b-button>
                    <b-button size="sm" @click.stop="editCompany(row.item.id)" class="mr-1">
                        Edit
                    </b-button>
                    <b-button size="sm" @click.stop="deleteCompany(row.item.id)" class="mr-1">
                        Delete
                    </b-button>
                </template>
            </b-table>
            <p>
                Sorting By: <b>{{ sortBy }}</b>,
                Sort Direction: <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b>
            </p>
        </div>

        <b-btn v-b-modal.modalAddNewCompany>Add Company</b-btn>
        -->
        <!--b-modal id="modalAddNewCompany"
                 ref="modal"
                 title="Add a new Company"
                 @ok="companyHandleOk"
                 @shown="clearForm">
            <form @submit.stop.prevent="saveCompanyForm">
                <b-form-input type="text"
                              placeholder="Company"
                              v-model="company.name"></b-form-input>
                <b-form-input type="text"
                              placeholder="Website"
                              v-model="company.website"></b-form-input>
                <b-form-input type="text"
                              placeholder="Phone"
                              v-model="company.phone"></b-form-input>
                <b-form-input type="text"
                              placeholder="Linked In URL"
                              v-model="company.social_linked_in"></b-form-input>
                <b-form-input type="text"
                              placeholder="Twitter URL"
                              v-model="company.social_twitter"></b-form-input>
                <b-form-input type="text"
                              placeholder="Facebook URL"
                              v-model="company.social_facebook"></b-form-input>
                <b-form-textarea rows="3"
                              placeholder="About"
                              v-model="company.about"></b-form-textarea>
            </form>
        </b-modal-->
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                loading: false,
                companies: null,
                company: {
                    name: '',
                    website: '',
                    phone: '',
                    social_linked_in: '',
                    social_twitter: '',
                    social_facebook: '',
                    about: ''
                },
                showAddCompanyForm: false,
                showCompaniesTable: true,
                companyMarkedForDeletion: {
                    id: 0,
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
                this.error = this.companies = null;
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
                        this.fields = [
                            { key: 'name', sortable: true },
                            { key: 'actions', sortable: false }
                        ];
                        this.sortBy = 'name';
                        this.sortDesc = false;
                    });
            },
            addCompanyHandle() {
                this.showAddCompanyForm = !this.showAddCompanyForm;
                this.showCompaniesTable = !this.showCompaniesTable;
                this.company.id = 0;
            },
            editCompany(id) {
                this.showAddCompanyForm = !this.showAddCompanyForm;
                this.showCompaniesTable = !this.showCompaniesTable;

                axios
                    .get('/api/company/' + id, {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.company = response.data;
                    });
            },
            deleteCompany(id) {
                axios.delete('/api/company/' + id)
                    .then(function (resp) {
                        window.location.replace('/companies');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not delete company");
                    });

                this.$refs.modal.hide();
            },
            clearForm () {
                this.company.name = '';
                this.company.website = '';
                this.company.phone = '';
                this.company.social_linked_in = '';
                this.company.social_twitter = '';
                this.company.social_facebook = '';
                this.company.about = '';
            },
            companyHandleOk (evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.company.name) {
                    alert('Please fill in all fields')
                } else {
                    this.saveCompanyForm()
                }
            },
            saveCompanyForm() {
                var app = this;
                var newCompany = app.company;
                var status = 0;
                switch (app.company.id) {
                    case 0:
                        axios.post('/api/company', newCompany)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addCompanyHandle();
                                        break;

                                    default:
                                        alert('Unable to save company');
                                        break;
                                }
                            });
                        break;

                    default:
                        axios.patch('/api/company/' + newCompany.id, newCompany)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addCompanyHandle();
                                        break;

                                    default:
                                        alert('Unable to save company');
                                        break;
                                }
                            });
                        break;
                }
            },
        }
    }
</script>
