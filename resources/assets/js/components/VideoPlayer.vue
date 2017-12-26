<template>
    <video
        id="video"
        class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9"
        controls
        preload="auto"
        data-setup='{"fluid": true, "preload": "auto"}'
        v-bind:poster="thumbnailUrl">
        <source type="video/mp4" v-bind:src="videoUrl"></source>
    </video>
</template>

<script>
//    import videojs from "video.js";
        let videojs = require('video.js');
    export default {
        data () {
            return {
                player: null,
                duration: null
            }
        },
        props: {
            videoUid: null,
            videoUrl: null,
            thumbnailUrl: null
        },
        methods: {
            hasHitQuotaView () {
                if (!this.duration) {
                    return false;
                }

                return Math.round(this.player.currentTime()) === Math.round((10 * this.duration) / 100);
            },
            createView () {
                this.$http.post('/videos/' + this.videoUid + '/views');
            }
        },
        mounted () {
            // in vue 2.0.1 there is no ready function use mounted instead...
            //console.log('I am mounted') ;
           // console.log(videojs);
            this.player = videojs('video');

            this.player.on('loadedmetadata', () => {
                this.duration = Math.round(this.player.duration());
            });

            setInterval(() => {
                if (this.hasHitQuotaView()) {
//                    console.log('log a view');
                    this.createView();
                }
            }, 1000)
        }
    }
</script>
