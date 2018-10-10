<template>

    <div class="educationLevels">

        <div class="loading" v-if="loading">
            <div class="fa-2x">
                <i class="fas fa-spinner fa-spin"></i>&nbsp;&nbsp;Not goin' anywhere for awhile?
            </div>
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <b-modal id="confirmDeleteEducationLevel"
                 ref="modal"
                 title="Delete Education Level?"
                 @ok="deleteEducationLevel(educationLevelMarkedForDeletion.id)">
            <form @submit.stop.prevent="handleSubmit">
                Are you sure you want to delete <strong>{{ educationLevelMarkedForDeletion.description }}</strong>?
            </form>
        </b-modal>

        <div class="row" v-show="showAddEducationLevelForm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add a Education Level</strong>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <input type="hidden" class="form-control" placeholder="" v-model="educationLevel.id">

                                <label>Education Level</label>
                                <input type="text" class="form-control" placeholder="Education Level"
                                       v-model="educationLevel.description">
                                <!--span class="help-block">Please enter your email</span-->
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-success" v-on:click="educationLevelHandleOk"><i
                            class="fa fa-check"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger" v-on:click="addEducationLevelHandle"><i
                            class="fa fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="educationLevels" v-show="showEducationLevelsTable">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> <strong>Education Levels</strong>
                            <button class="badge badge-success" v-on:click="addEducationLevelHandle">Add Education Level</button>
                        </div>

                        <div class="card-body">

                            <b-table responsive-sm
                                     :sort-by.sync="sortBy"
                                     :sort-desc.sync="sortDesc"
                                     :items="educationLevels"
                                     :fields="fields">

                                <template slot="description" slot-scope="data">

                                    {{ data.item.description }}

                                </template>

                                <template slot="actions" slot-scope="row">

                                    <b-button size="sm" v-on:click="editEducationLevel(row.item.id)"
                                              class="badge badge-success">
                                        Edit
                                    </b-button>

                                    <b-btn @click="educationLevelMarkedForDeletion = row.item" v-b-modal.confirmDeleteEducationLevel
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
    export default {
        data() {
            return {
                loading: false,
                educationLevels: null,
                educationLevel: {
                    description: ''
                },
                showAddEducationLevelForm: false,
                showEducationLevelsTable: true,
                educationLevelMarkedForDeletion: {
                    id: 0,
                    description: ''
                },
                error: null
            }
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
                            {key: 'description', sortable: true},
                            {key: 'actions', sortable: false}
                        ];
                        this.sortBy = 'description';
                        this.sortDesc = false;
                    });
            },
            clearForm() {
                this.educationLevel.description = '';
            },
            addEducationLevelHandle() {
                this.showAddEducationLevelForm = !this.showAddEducationLevelForm;
                this.showEducationLevelsTable = !this.showEducationLevelsTable;
                this.educationLevel.id = 0;
            },
            editEducationLevel(id) {
                this.showAddEducationLevelForm = !this.showAddEducationLevelForm;
                this.showEducationLevelsTable = !this.showEducationLevelsTable;

                axios
                    .get('/api/educationlevel/' + id, {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.educationLevel = response.data;
                    });
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

                this.$refs.modal.hide();
            },
            educationLevelHandleOk(evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.educationLevel.description) {
                    alert('Please enter education level')
                } else {
                    this.saveEducationLevelForm()
                }
            },
            saveEducationLevelForm() {
                var app = this;
                var newEducationLevel = app.educationLevel;
                var waitStatus = 0;
                switch (app.educationLevel.id) {
                    case 0:
                        axios.post('/api/educationlevel', newEducationLevel)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addEducationLevelHandle();
                                        break;

                                    default:
                                        alert('Unable to save education level');
                                        break;
                                }
                            });
                        break;

                    default:
                        axios.patch('/api/educationlevel/' + newEducationLevel.id, newEducationLevel)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addEducationLevelHandle();
                                        break;

                                    default:
                                        alert('Unable to save education level');
                                        break;
                                }
                            });
                        break;
                }

            },
        }
    }
</script>
