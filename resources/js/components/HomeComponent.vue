<template>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <h1 class="my-4">Latest Episodes</h1>

        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4" v-for="Episode in EpisodesAll">
                <div class="card h-100 video_play">
                    <router-link :to="{ name: 'episode', params: { id: Episode.title }}">
                        <img class="card-img-top" :alt="Episode.thumbnail" :src="'/image/'+Episode.thumbnail">
                        <a href="#" class="videoPlay"></a>

                    </router-link>
                    <div class="card-body">
                        <h4 class="card-title">
                            <p><small>{{Episode.series_tv.title}}</small></p>
                            <router-link :to="{ name: 'episode', params: { id: Episode.title }}">{{Episode.title}}</router-link>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                EpisodesAll: [
                ]
            }
        },
        created() {
            let uri = '/json/Episode/all';
            this.axios.get(uri).then(response => {
                this.EpisodesAll = response.data.data;
            });
        },

    }
</script>
