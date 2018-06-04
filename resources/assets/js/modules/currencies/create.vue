<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Create Currency</strong>
                    </div>

                    <form v-on:submit.prevent="saveForm()">
                        <div class="card-body">
                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="text-input">Name</label>
                                <div class="col-md-9">
                                    <input type="text" id="text-input" v-model="currency.name" class="form-control" v-bind:class="{ 'is-invalid': err && err.name }" placeholder="Enter Name">
                                    <div v-if="err && err.name" class="invalid-feedback">
                                        <div v-for="errorMsg, index in err.name">
                                            {{ errorMsg }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="code-input">Code</label>
                                <div class="col-md-9">
                                    <input type="text" id="code-input" v-model="currency.code" v-bind:class="{ 'is-invalid': err && err.code }" class="form-control" placeholder="Enter code">
                                    <div v-if="err && err.code" class="invalid-feedback">
                                        <div v-for="errorMsg, index in err.code">
                                            {{ errorMsg }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="symbol-input">Symbol</label>
                                <div class="col-md-9">
                                    <input type="text" id="symbol-input" v-model="currency.symbol" v-bind:class="{ 'is-invalid': err && err.symbol }" class="form-control" placeholder="Enter Symbol">
                                    <div v-if="err && err.symbol" class="invalid-feedback">
                                        <div v-for="errorMsg, index in err.symbol">
                                            {{ errorMsg }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                            <router-link :to="{name: 'CurrencyIndex'}" class="btn btn-sm btn-secondary" exact><i class="fa fa-chevron-left"></i> Back</router-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                currency: {
                    name: '',
                    symbol: '',
                    code: '',
                },
                err : []
            }
        },
        methods: {
            saveForm() {
                var app = this;
                var newCurrency = app.currency;
                axios.post('/bapi/currency', newCurrency)
                    .then(function (resp) {
                        app.$router.push({path: '/currency'});
                    })
                    .catch(function (error) {
                        app.err = error.response.data.error.details;
                    });
                return false;
            }
        }
    }
</script>