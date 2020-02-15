
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="col-md-12 text-center">
                        <p v-if="errors.length">
                            <b>Please correct the following error(s):</b>
                        <div class="alert alert-danger" role="alert" v-for="error in errors">
                            {{ error }}
                        </div>
                        </p>
                    </div>
                    <div class="card-body" >
                        <form @submit="checkForm" id="register">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input v-model="name" type="text" class="form-control" id="name" placeholder="Enter your Name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input v-model="email" type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input v-model="password" type="password" class="form-control" id="password" placeholder="Password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password:</label>
                                <input v-model="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" name="password_confirmation">
                            </div>
                            <div class="form-group">
                                <label for="image">Image:</label>
                                <input type="file" class="form-control" id="image" name="image" v-on:change="onImageChange"
                                       accept="image/jpeg, image/png, image/jpeg, image/git">
                            </div>
                            <button type="submit" id="submitForm" class="btn btn-outline-success my-2 my-sm-0">SignUp</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.');

        },
        data() {
            return {
                errors: [],
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                image: ''
            }
        },
        methods:{
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
                console.log(this.image);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            checkForm: function (e) {
                const error = this;
                this.errors = [];
                if (!this.name) {
                    this.errors.push('Name required.');
                }
                if (!this.email) {
                    this.errors.push('Email required.');
                }
                if (!this.password) {
                    this.errors.push('Password required.');
                }
                if (!this.password_confirmation) {
                    this.errors.push('Confirm Password required.');
                }
                if (this.password_confirmation !== this.password) {
                    this.errors.push('Password Not Match.');
                }
                if (!this.image) {
                    this.errors.push('image required.');
                }

                let self = this;
                if(this.errors.length < 1)
                {
                    var formContents = jQuery("#register").serialize();
                    formContents +='&image='+this.image;

                    axios.post('/registerUser', formContents).then(function(response, status, request) {
                        if(response.status === 200){
                            if(response.data.result === 0){
                                error.errors.push(response.message);
                            }else{
                                localStorage.message = response.data.message;
                                self.$router.push('/login');
                            }
                        }else{
                            // if error request
                        }
                    }, function() {
                        console.log('failed');
                    });
                }
                e.preventDefault();
            },


        }
    }
</script>
