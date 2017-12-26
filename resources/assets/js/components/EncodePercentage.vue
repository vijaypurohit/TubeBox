<template>
        <div class="progress" v-if="!processed">
            <div  :class=" 'progress-bar progress-bar-' + ( fileProgress < 50 ? 'danger' : 'success') + ' progress-bar-striped'" v-bind:style="{ width: fileProgress + '%' }" :aria-valuenow="{fileProgress}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    <!--<button class="glyphicon glyphicon-refresh" type="submit" @click.prevent="update">Refresh</button>-->
</template>

<script>
    export default {
        data () {
            return {
                uid: null,
                processed: null,
                video_id: null,
                canVote: false,
                fileProgress: 0,
                count:0,
            }
        },
        methods: {
            getEncode () {
                this.$http.get('/videos/' + this.videoUid + '/encode').then((response) => {
//                    console.log(response.json());
                    this.uid = response.json().data.uid;
                    this.video_id = response.json().data.video_id;
                    this.processed = response.json().data.processed;
                    this.processed_percentage = response.json().data.processed_percentage;
                    this.fileProgress = this.processed_percentage;
                    setTimeout(() => {
                        if(!this.processed){
                            this.update();
                        }
                    }, 6000);
                });
            },
            update() {
                console.log(this.count);
                console.log(this.oldValue);
                console.log(this.processed_percentage);
                console.log(this.processed_percentage != this.oldValue);
                this.count++;
                if(this.oldValue != this.processed_percentage)
                {
                    if(this.count < 5)
                    {
                        this.getEncode();
                    }
                }
            },
        },
        props: {
            videoUid: null,
            oldValue:null,
        },
        mounted () {
            this.getEncode()
        }
    }
</script>
