<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group mb-0">
            <div class="card p-4">
              <div class="card-body">
                <form v-on:submit.prevent="login()">
                  <h1>Login</h1>
                  <p class="text-muted">Sign In to your account</p>

                  <div class="input-group mb-3">
                    <span class="input-group-addon"><i class="icon-user"></i></span>
                    <input type="text" class="form-control" v-model="username" placeholder="Username">
                  </div>
                  <div class="input-group mb-4">
                    <span class="input-group-addon"><i class="icon-lock"></i></span>
                    <input type="password" class="form-control" v-model="password" placeholder="Password">
                  </div>
                  <b-alert v-if="error != false" show variant="danger">{{ error }}</b-alert>
                  <div class="row">

                    <div class="col-6">
                      <button type="submit" class="btn btn-primary px-4">Login</button>
                    </div>
                  </div>
                </form>
              </div>
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
                username: null,
                password: null,
                error: false
            }
        },
        methods: {
            login() {
                var app = this
                this.$auth.login({
                    data: {
                        username: app.username,
                        password: app.password
                    },
                    success: function () {},
                    error: function (error) {
                        console.log(error.response);
                        app.error = error.response.data.error.message;
                    },
                    rememberMe: true,
                    redirect: '/users',
                    fetchUser: true,
                });
            },
        }
    }
</script>
