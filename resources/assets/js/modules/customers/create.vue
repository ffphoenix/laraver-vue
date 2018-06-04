<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Create Customer</strong>
                    </div>

                    <form v-on:submit.prevent="saveForm()">
                        <div class="card-body">
                            <preloader :isLodading="loading" />
                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="text-input">Name</label>
                                <div class="col-md-9">
                                    <input type="text" id="text-input" v-model="customer.name" class="form-control" v-bind:class="{ 'is-invalid': err && err.name }" placeholder="Enter Name">
                                    <div v-if="err && err.name" class="invalid-feedback">
                                        <div v-for="errorMsg, index in err.name">
                                            {{ errorMsg }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="email-input">CNP</label>
                                <div class="col-md-9">
                                    <input type="text" id="email-input" v-model="customer.cnp" v-bind:class="{ 'is-invalid': err && err.cnp }" class="form-control" placeholder="Enter CNP">
                                    <div v-if="err && err.cnp" class="invalid-feedback">
                                        <div v-for="errorMsg, index in err.cnp">
                                            {{ errorMsg }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                            <router-link :to="{name: 'CustomerIndex'}" class="btn btn-sm btn-secondary" exact><i class="fa fa-chevron-left"></i> Back</router-link>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import preloader from '../../components/preloader.vue';
    export default {
        mounted() {
            var app = this;
            app.loading = false;
        },
        data: function () {
            return {
                customer: {
                    name: '',
                    cnp: '',
                },
                err : [],
                loading : false
            }
        },
        methods: {
            saveForm() {
                var app = this;
                app.loading = true;
                var newCustomer = app.customer;
                axios.post('/bapi/customer', newCustomer)
                    .then(function (resp) {
                        app.loading = false;
                        app.$router.push({path: '/customer'});
                    })
                    .catch(function (error) {
                        app.loading = false;
                        app.err = error.response.data.error.details;
                    });
                return false;
            }
        },
        components : {
            preloader
        }
    }
</script>