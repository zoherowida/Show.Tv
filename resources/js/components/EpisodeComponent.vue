<template>
    <!-- Page Content -->
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-8">
                <h2 class="my-4">{{Episode.title}}  </h2>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <br/>

                <button type="button" v-on:click="Like()" :class="{'btn-outline-danger': caseUser == '1' }" class="btn btn-outline-primary" style="float: right">{{caseUser == 0 ?'Like' :'DisLike'}}({{countLike}})</button>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="height: fit-content;">
                <div class="embed-responsive embed-responsive-16by9" style="width: 100%; height: 80%;">
                    <iframe class="embed-responsive-item" :src="Episode.video" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4 class="my-4"> {{Episode.title}} </h4>
                <p><span>Duration : {{Episode.duration}} </span></p>
                <p></p>
                <p>{{Episode.description}}</p>
            </div>
        </div>

    </div>
    <!-- /.container -->
</template>

<script>
    export default {
        data() {
            return {
                Episode: {},
                countLike: 0,
                caseUser: 0,
            }
        },
        created() {
            const self = this;
            // Get Episode Video
            let uri = '/json/Episode';
            this.axios.post(uri,{id:this.$route.params.id}).then(response => {
                if(response.status === 200)
                {
                    this.Episode = response.data.data.episode;
                    this.countLike = response.data.data.count;
                    this.caseUser = response.data.data.caseUser;
                }
                else{
                    alert('error in fetch data');
                }
            }).catch(function (error) {
                self.$router.push('/');
            });
        },
        methods:{
            Like(){
                let uri = '/json/ChangeLike';
                this.axios.post(uri,{id: this.$route.params.id}).then(response => {
                    if(response.status === 200){
                        this.countLike = response.data.data.count;
                        this.caseUser = response.data.data.caseUser;
                    }
                }).catch(function (error) {
                    alert('Please Login for Like Episode');
                });
            }
        },

        mounted() {
            console.log('Episode mounted.')
        }
    }
</script>
