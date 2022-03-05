<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Forms
                    <div class="text-center p-1">
                        <h6 v-if="error" class="text text-danger">{{error}}</h6>
                        <h6 v-if="success" class="text text-success">{{success}}</h6>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" v-if="!editFormStatus" >
                        <thead>
                            <tr>
                                <th scope="col">Form Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="forms.length">
                                <tr v-for="form in forms" :key="form.id">
                                    <td>{{form.name}}</td>
                                    <td>
                                        <button class="btn btn-success" @click.prevent="editForm(form.id)">Edit</button>
                                        <button class="btn btn-danger" @click.prevent="deleteForms(form.id)">Delete</button>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        No any forms found
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <edit-form v-if="editFormStatus" :id="editId"></edit-form>
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
            forms: [],
            error: null,
            success: null,
            editId: null,
            editFormStatus: false
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.getForms();
    },
    methods: {
        getForms() {
            axios.get(`/get-forms`).then(response => {
                console.log(response.data.data);
                this.forms = response.data.data
            }).catch(err => {
                console.log(err)
            }).finally(() => {})
        },
        deleteForms(id) {
            axios.get(`/delete-forms/${id}`).then(response => {
                this.success = response.data.message
                this.getForms();
            }).catch(err => {
                console.log(err)
            }).finally(() => {})
        },
        editForm(id) {
            this.editId = id;
            this.editFormStatus = true
        }
    }
}
</script>

<style scoped>
.p-4 {
    padding: 1.7rem !important;
}
</style>
