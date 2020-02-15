
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="col-md-12 text-center">
                        <p v-if="errors.length">
                        <div class="alert alert-danger" role="alert" v-for="error in errors">
                        {{ error }}
                        </div>
                        </p>
                    </div>
                    <div class="col-md-12 text-center">
                        <p v-if="messages.length">
                        <div class="alert alert-success" role="alert" v-for="message in messages">
                            {{ message }}
                        </div>
                        </p>
                    </div>

                    <div class="card-body" v-if="!isLogin()">
                        <form @submit="checkForm" id="createAdministrator">
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input v-model="email" type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input v-model="password" type="password" class="form-control" id="password" placeholder="Password" name="password">
                            </div>
                            <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Login</button>
                        </form>
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
                errors: [],
                messages: [],
                email: '',
                password: '',
            }
        },
        mounted() {
            if(localStorage.getItem('message')){
                this.messages.push(localStorage.getItem('message'));
                localStorage.removeItem('message')
            }
        },
        methods:{
            isLogin(){
                return localStorage.isLogin === 'login';
            },
            checkForm: function (e) {
                console.log('this email' + this.email)
                const error = this;
                this.errors = [];
                if (!this.email) {
                    this.errors.push('Email required.');
                }
                if (!this.password) {
                    this.errors.push('Password required.');
                }
                if(this.errors.length < 1)
                {
                    const formContents = jQuery("#createAdministrator").serialize();
                    this.axios.post('/vueLogin', formContents).then(function(response, status, request) {
                        if(response.data.status === 'success'){
                            localStorage.user = response.data.data.user;
                            localStorage.isLogin = true;
                            location.reload();
                        }else{
                            error.errors.push('Email or Password Not match');
                        }
                    }, function() {
                        console.log('failed');
                    });
                }
                e.preventDefault();
            }
        }
    }
</script>
