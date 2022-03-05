<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Form
                    <div class="text-center p-1">
                        <h6 v-if="error" class="text text-danger">{{error}}</h6>
                        <h6 v-if="success" class="text text-success">{{success}}</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form @submit.prevent="submitform()">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Form Name</label>
                                <input class="form-control" type="text" v-model="formName" required>
                            </div>
                            <div class="col-md-6 p-4">
                                <label>&nbsp;</label>
                                <button class="btn btn-success" @click.prevent="addMoreFields()">Add Fields</button>
                            </div>
                        </div>
                        <div>
                            <div v-for="(dynamic,index) in dynamicForm" :key="index" class="row form-group">
                                <div class="col-md-3">
                                    <label>Label Name</label>
                                    <input type="text" class="form-control" v-model="dynamic.label" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Field Type</label>
                                    <select class="form-control" v-model="dynamic.optionType" required>
                                        <option v-for="types in optionTypes" :key="types.id" :value="types.id">{{types.name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3" v-if="dynamic.optionType == 3 ">
                                    <label>Select Options<a class="text text-success pl-2" href="#" @click.prevent="addOptionValues(index)">Add</a></label>
                                    <!-- <input-tag v-model="dynamic.options"></input-tag> -->
                                    <span v-for="(options,ind) in dynamic.options" :key="ind">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control m-1" v-model="options.name" required>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn btn-sm btn-danger p-2" @click.prevent="deleteOptionValues(index,ind)">Delete</button>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <div class="col-md-2 p-4">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-danger" @click.prevent="deleteFields(index)">Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success float-right" value="Create Form">
                            <!-- <a class="btn btn-success float-right" href="#" >Create</a> -->
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import InputTag from 'vue-input-tag'
export default {
    components: {
        InputTag,
    },
    data() {
        return {
            optionTypes: [],
            dynamicForm: [],
            formName: null,
            error: null,
            success: null
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.getOptionTypes();
    },
    methods: {
        getOptionTypes() {
            axios.get(`/get-option-types`).then(response => {
                console.log(response.data.data);
                this.optionTypes = response.data.data;
            }).catch(err => {
                console.log(err)
            }).finally(() => {})
        },
        addMoreFields() {
            this.dynamicForm.push({
                label: null,
                optionType: null,
                options: []
            })
        },
        deleteFields(index) {
            this.dynamicForm.splice(index, 1)
        },
        submitform() {
            console.log(this.dynamicForm)
            axios.post(`/submit-form`, {
                formName: this.formName,
                dynamicForm: this.dynamicForm
            }).then(response => {
                console.log(response.data.data);
                this.success = "Your form created successfully"
                this.error = null
                this.dynamicForm = []
            }).catch(err => {
                this.error = err.response.data.message
            }).finally(() => {})
        },
        addOptionValues(index) {
            this.dynamicForm[index].options.push({
                name: null
            })
        },
        deleteOptionValues(index,ind){
           this.dynamicForm[index].options.splice(ind, 1)
        }
    }
}
</script>

<style scoped>
.p-4 {
    padding: 1.7rem !important;
}
</style>
