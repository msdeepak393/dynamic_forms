<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{formName}}
                    <div  v-if="dataStatus == null">Forms not found</div>
                </div>
                <div class="card-body">
                    <form v-if="dataStatus">
                        <div v-for="form in dynamicForm" :key="form.id">
                            <div class="form-group" v-if="form.option_type.name == 'Text' ">
                                <label>{{form.field_label}}</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group" v-if="form.option_type.name == 'Number' ">
                                <label>{{form.field_label}}</label>
                                <input type="number" class="form-control">
                            </div>
                            <div class="form-group" v-if="form.option_type.name == 'Select' ">
                                <label>{{form.field_label}}</label>
                                <select class="form-control">
                                    <option v-for="option in form.options" :key="option.id">{{option.options}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="float-right btn btn-sm btn-success" value="Submit" disabled>
                        </div>
                    </form>
                    <div v-else>
                        <p>please add form from admin area.</p>
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
            dataStatus: null,
            dynamicForm: [],
            formName: null,
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.getFormData();
    },
    methods: {
        getFormData() {
            axios.get(`/get-user-form`).then(response => {
                this.dataStatus = response.data.data;
                this.formName = response.data.data.name
                this.dynamicForm = response.data.data.fields
            }).catch(err => {
                console.log(err)
            }).finally(() => {})
        }
    }
}
</script>

<style scoped>
.p-4 {
    padding: 1.7rem !important;
}
</style>
