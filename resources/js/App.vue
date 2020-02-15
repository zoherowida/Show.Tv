// App.vue

<template>
    <div class="Home">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
            <router-link to="/" class="navbar-brand">SHOW.TV</router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link">Home</router-link>
                    </li>
                    <li class="nav-item" v-for="Series in SeriesTvs">
                        <router-link  :key="Series.id" :to="{ name: 'Series', params: { id: Series.title }}" class="nav-link">{{Series.title}} </router-link>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    </form>

                    <router-link to="/login" class="btn btn-outline-success my-2 my-sm-0"  v-show="!isLogin()">Login</router-link>
                    <router-link to="/register" class="btn btn-outline-success my-2 my-sm-0"  v-show="!isLogin()" style="margin: 2px;">Register</router-link>
                    <div class="btn-group dropleft" v-show="isLogin()">
                        <button class="btn btn-outline-success my-2 my-sm-0 dropdown-toggle NameUser" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" @click.prevent="logout">LogOut</a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
        <br />
        <transition name="fade">
            <router-view></router-view>
        </transition>
    </div>

</template>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>
<script>
    export default{
        data() {
            return {
                SeriesTvs: [
                ],
                name:''
            }
        },
        mounted() {
            let uri = '/json/UserAuth';
            this.axios.post(uri,{}).then(response => {
                if(response.status === 200){
                    if(response.data.data.user == null){
                        localStorage.isLogin = false;
                    }else{
                        localStorage.user = response.data.data.user;
                        localStorage.isLogin = true;
                        $('.NameUser').html(response.data.data.user.name);
                    }
                }else{
                    localStorage.user = null;
                    localStorage.isLogin = false;
                }
            });
        },
        created() {
            let uri = '/json/SeriesTv';
            this.axios.post(uri,{}).then(response => {
                this.SeriesTvs = response.data.data;
            });
        },
        methods:{
            isLogin(){
                return localStorage.getItem('isLogin') == 'true' ? true : false;
            },
            logout(){
                axios.post('/logout').then(response => {

                    if (response.status === 302 || 401) {
                        localStorage.isLogin = false;
                        localStorage.removeItem('user');
                        location.reload();

                    }
                    else {
                        // throw error and go to catch block
                    }
                }).catch(error => {
                });
            },
        },

    }
</script>
