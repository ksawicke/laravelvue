<template>

    <div class="subdivisionTypes">

        <div class="loading" v-if="loading">
            <div class="fa-2x">
                <i class="fas fa-spinner fa-spin"></i>&nbsp;&nbsp;Are the cookies done?
            </div>
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <b-modal id="confirmDeleteSubdivisionType"
                 ref="modal"
                 title="Delete Country Subvision Type?"
                 @ok="deleteSubdivisionType(subdivisionTypeMarkedForDeletion.id)">
            <form @submit.stop.prevent="handleSubmit">
                Are you sure you want to delete <strong>{{ subdivisionTypeMarkedForDeletion.name }}</strong>?
            </form>
        </b-modal>

        <div class="row" v-show="showAddSubdivisionTypeForm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add a Country Subdivision Type</strong>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <input type="hidden" class="form-control" placeholder="" v-model="subdivisionType.id">

                                <label>Subdivision Type</label>
                                <input type="text" class="form-control" placeholder="Subdivision Type"
                                       v-model="subdivisionType.name">
                                <!--span class="help-block">Please enter your email</span-->
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-success" v-on:click="subdivisionTypeHandleOk"><i
                            class="fa fa-check"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger" v-on:click="addSubdivisionTypeHandle"><i
                            class="fa fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="subdivisionTypes" v-show="showSubdivisionTypesTable">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> <strong>Subdivision Types</strong>
                            <button class="badge badge-success" v-on:click="addSubdivisionTypeHandle">Add Subdivision Type</button>
                        </div>

                        <div class="card-body">

                            <b-table responsive-sm
                                     :sort-by.sync="sortBy"
                                     :sort-desc.sync="sortDesc"
                                     :items="subdivisionTypes"
                                     :fields="fields">

                                <template slot="description" slot-scope="data">

                                    {{ data.item.name }}

                                </template>

                                <template slot="actions" slot-scope="row">

                                    <b-button size="sm" v-on:click="editSubdivisionType(row.item.id)"
                                              class="badge badge-success">
                                        Edit
                                    </b-button>

                                    <b-btn @click="subdivisionTypeMarkedForDeletion = row.item" v-b-modal.confirmDeleteSubdivisionType
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
                subdivisionTypes: null,
                subdivisionType: {
                    name: ''
                },
                showAddSubdivisionTypeForm: false,
                showSubdivisionTypesTable: true,
                subdivisionTypeMarkedForDeletion: {
                    id: 0,
                    name: ''
                },
                error: null
            }
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
                            {key: 'description', sortable: true},
                            {key: 'actions', sortable: false}
                        ];
                        this.sortBy = 'description';
                        this.sortDesc = false;
                    });
            },
            clearForm() {
                this.subdivisionType.description = '';
            },
            addSubdivisionTypeHandle() {
                this.showAddSubdivisionTypeForm = !this.showAddSubdivisionTypeForm;
                this.showSubdivisionTypesTable = !this.showSubdivisionTypesTable;
                this.subdivisionType.id = 0;
            },
            editSubdivisionType(id) {
                this.showAddSubdivisionTypeForm = !this.showAddSubdivisionTypeForm;
                this.showSubdivisionTypesTable = !this.showSubdivisionTypesTable;

                axios
                    .get('/api/subdivisiontype/' + id, {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.subdivisionType = response.data;
                    });
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

                this.$refs.modal.hide();
            },
            subdivisionTypeHandleOk(evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.subdivisionType.name) {
                    alert('Please enter subdivision type')
                } else {
                    this.saveSubdivisionTypeForm()
                }
            },
            saveSubdivisionTypeForm() {
                var app = this;
                var newSubdivisionType = app.subdivisionType;
                var waitStatus = 0;
                switch (app.subdivisionType.id) {
                    case 0:
                        axios.post('/api/subdivisiontype', newSubdivisionType)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addSubdivisionTypeHandle();
                                        break;

                                    default:
                                        alert('Unable to save subdivision type');
                                        break;
                                }
                            });
                        break;

                    default:
                        axios.patch('/api/subdivisiontype/' + newSubdivisionType.id, newSubdivisionType)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addSubdivisionTypeHandle();
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
