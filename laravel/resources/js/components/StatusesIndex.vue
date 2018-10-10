<template>

    <div class="statuses">

        <div class="loading" v-if="loading">
            <div class="fa-2x">
                <i class="fas fa-spinner fa-spin"></i>&nbsp;&nbsp;Just daydreaming...
            </div>
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <b-modal id="confirmDeleteStatus"
                 ref="modal"
                 title="Delete Status?"
                 @ok="deleteStatus(statusMarkedForDeletion.id)">
            <form @submit.stop.prevent="handleSubmit">
                Are you sure you want to delete <strong>{{ statusMarkedForDeletion.name }}</strong>?
            </form>
        </b-modal>

        <div class="row" v-show="showAddStatusForm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add a Status</strong>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <input type="hidden" class="form-control" placeholder="" v-model="status.id">

                                <label>Status</label>
                                <input type="text" class="form-control" placeholder="Status Name"
                                       v-model="status.name">
                                <!--span class="help-block">Please enter your email</span-->
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-success" v-on:click="statusHandleOk"><i
                            class="fa fa-check"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger" v-on:click="addStatusHandle"><i
                            class="fa fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="statuses" v-show="showStatusesTable">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> <strong>Statuses</strong>
                            <button class="badge badge-success" v-on:click="addStatusHandle">Add Status</button>
                        </div>

                        <div class="card-body">

                            <b-table responsive-sm
                                     :sort-by.sync="sortBy"
                                     :sort-desc.sync="sortDesc"
                                     :items="statuses"
                                     :fields="fields">

                                <template slot="name" slot-scope="data">

                                    {{ data.item.name }}

                                </template>

                                <template slot="actions" slot-scope="row">

                                    <b-button size="sm" v-on:click="editStatus(row.item.id)"
                                              class="badge badge-success">
                                        Edit
                                    </b-button>

                                    <b-btn @click="statusMarkedForDeletion = row.item" v-b-modal.confirmDeleteStatus
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
                statuses: null,
                status: {
                    name: ''
                },
                showAddStatusForm: false,
                showStatusesTable: true,
                statusMarkedForDeletion: {
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
                this.error = this.statuses = null;
                this.loading = true;
                axios
                    .get('/api/statuses', {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.statuses = response.data;
                        this.fields = [
                            {key: 'name', sortable: true},
                            {key: 'actions', sortable: false}
                        ];
                        this.sortBy = 'name';
                        this.sortDesc = false;
                    });
            },
            clearForm() {
                this.status.name = '';
            },
            addStatusHandle() {
                this.showAddStatusForm = !this.showAddStatusForm;
                this.showStatusesTable = !this.showStatusesTable;
                this.status.id = 0;
            },
            editStatus(id) {
                this.showAddStatusForm = !this.showAddStatusForm;
                this.showStatusesTable = !this.showStatusesTable;

                axios
                    .get('/api/status/' + id, {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        this.status = response.data;
                    });
            },
            deleteStatus(id) {
                axios.delete('/api/status/' + id)
                    .then(function (resp) {
                        window.location.replace('/statuses');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not delete status");
                    });

                this.$refs.modal.hide();
            },
            statusHandleOk(evt) {
                // Prevent modal from closing
                evt.preventDefault()
                if (!this.status.name) {
                    alert('Please enter status name')
                } else {
                    this.saveStatusForm()
                }
            },
            saveStatusForm() {
                var app = this;
                var newStatus = app.status;
                var waitStatus = 0;
                switch (app.status.id) {
                    case 0:
                        axios.post('/api/status', newStatus)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addStatusHandle();
                                        break;

                                    default:
                                        alert('Unable to save status');
                                        break;
                                }
                            });
                        break;

                    default:
                        axios.patch('/api/status/' + newStatus.id, newStatus)
                            .then(function (resp) {
                                switch (resp.status) {
                                    case 200:
                                        app.clearForm();
                                        app.fetchData();
                                        app.addStatusHandle();
                                        break;

                                    default:
                                        alert('Unable to save status');
                                        break;
                                }
                            });
                        break;
                }

            },
        }
    }
</script>
