<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Edit User</strong>
                    </div>

                    <form v-on:submit.prevent="saveForm()">
                        <div class="card-body">

                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="text-input">Name</label>
                                <div class="col-md-9">
                                    <input type="text" id="text-input" v-model="user.name" class="form-control" v-bind:class="{ 'is-invalid': err && err.name }" placeholder="Enter Name">
                                    <div v-if="err && err.name" class="invalid-feedback">
                                        <div v-for="errorMsg, index in err.name">
                                            {{ errorMsg }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="email-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" id="email-input" v-model="user.email" v-bind:class="{ 'is-invalid': err && err.email }" class="form-control" placeholder="Enter Email">
                                    <div v-if="err && err.email" class="invalid-feedback">
                                        <div v-for="errorMsg, index in err.email">
                                            {{ errorMsg }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="password-input">Password</label>
                                <div class="col-md-9">
                                    <input type="password" id="password-input" v-model="user.password" v-bind:class="{ 'is-invalid': err && err.password }" class="form-control" placeholder="Password">
                                    <div v-if="err && err.password" class="invalid-feedback">
                                        <div v-for="errorMsg, index in err.password">
                                            {{ errorMsg }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="allow_api_login-input">Allow access to BOSS API</label>
                                <div class="col-md-9">
                                    <label class="switch switch-text switch-success">
                                        <input type="checkbox" class="switch-input" id="allow_api_login-input" v-model="user.allow_api_login">
                                        <span class="switch-label" data-on="On" data-off="Off"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                    <div v-if="err && err.password" class="invalid-feedback">
                                        <div v-for="errorMsg, index in err.allow_api_login">
                                            {{ errorMsg }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                            <router-link :to="{name: 'UsersIndex'}" class="btn btn-sm btn-secondary" exact><i class="fa fa-chevron-left"></i> Back</router-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.userId = id;
            axios.get('/bapi/user/' + id)
            .then(function (resp) {
                app.user = resp.data.data;
            })
            .catch(function () {
                alert("Could not load your user")
            });
        },
        data: function () {
            return {
                user: {
                    name: '',
                    email: '',
                    password: '',
                },
                err : []
            }
        },
        methods: {
            saveForm() {
                var app = this;
                var newUser = app.user;
                axios.patch('/bapi/user/' + app.userId, newUser)
                    .then(function (resp) {
                        app.$router.push({path: '/users'});
                    })
                    .catch(function (error) {

                        app.err = error.response.data.error.details;
                    });
            }
        }
    }
</script>