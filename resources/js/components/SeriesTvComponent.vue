<template>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-8">
                <h1 class="my-4">{{ $route.params.id }} </h1>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <br/>
                <button type="button"  v-on:click="Follow()" :class="{'btn-outline-danger': countFollow == '1' }" class="btn btn-outline-primary" style="float: right">{{countFollow == 0 ?'Follow' :'UnFollow'}}({{countFollow}})</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4" v-for="Episode in Episodes" :key="Episode.id">
                <div class="card h-100 video_play">
                    <router-link :to="{ name: 'episode', params: { id: Episode.title }}">
                        <img class="card-img-top" :alt="Episode.thumbnail" :src="'/image/'+Episode.thumbnail">
                        <a href="#" class="videoPlay"></a>
                    </router-link>
                    <div class="card-body">
                        <h4 class="card-title">
                            <router-link :to="{ name: 'episode', params: { id: Episode.title }}">{{Episode.title}}</router-link>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container --></template>

<script>
    export default {
        props: [
            'id'
        ],
        data() {
            return {
                Episodes: [
                ],
                countFollow: 0,
                caseUser: 0
            }
        },
        watch: {
            '$route.params.id': function (id) {
                this.fetch();
            }
        },
        methods:{
            fetch(){
                const self = this;
                let uri = '/json/Episodes';
                this.axios.post(uri,{id :this.$route.params.id}).then(response => {
                    if(response.data.result === 1){
                        this.Episodes = response.data.data.episodes;
                        this.countFollow = response.data.data.count;
                        this.caseUser = response.data.data.caseUser;
                    }else{
                        self.$router.push('/');
                    }
                }).catch(function (error) {
                    self.$router.push('/');
                });
            },

            Follow(){
                let uri = '/json/ChangeFollow';
                this.axios.post(uri,{id: this.$route.params.id}).then(response => {
                    if(response.status === 200){
                        this.countFollow = response.data.data.count;
                        this.caseUser = response.data.data.caseUser;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
        created() {
            this.fetch();
        },
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>
