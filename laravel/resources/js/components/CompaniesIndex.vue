<template>
    <div class="companies">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

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

        <b-modal id="modalAddNewCompany"
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
        </b-modal>
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
            editCompany(id) {
                console.log("EDIT ID " + id);
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
            },
            clearForm () {
                this.company.name = ''
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
                axios.post('/api/company', newCompany)
                    .then(function (resp) {
                        app.clearForm()
                        app.$refs.modal.hide()
                        app.fetchData()
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create company");
                    });
            },
        }
    }
</script>
