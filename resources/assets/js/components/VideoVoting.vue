<template>
    <div class="video__voting">

        <span v-if="!$root.user.authenticated" class="glyphicon glyphicon-thumbs-up"></span>
        <a href="#" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote == 'up'}" @click.prevent="vote('up')" v-else>
            <span class="glyphicon glyphicon-thumbs-up"></span>
        </a> {{ up }} &nbsp;

        <span v-if="!$root.user.authenticated" class="glyphicon glyphicon-thumbs-up"></span>
        <a href="#" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote == 'down'}" @click.prevent="vote('down')" v-else>
            <span class="glyphicon glyphicon-thumbs-down"></span>
        </a> {{ down }}
    </div>
</template>

<script>
    export default {
        data () {
            return {
                up: null,
                down: null,
                userVote: null,
                canVote: false
            }
        },
        methods: {
            getVotes () {
                this.$http.get('/videos/' + this.videoUid + '/votes').then((response) => {
                    this.up = response.json().data.up;
                    this.down = response.json().data.down;
                    this.userVote = response.json().data.user_vote;
                    this.canVote = response.json().data.can_vote;
                });
            },
            vote (type) {
                if (this.userVote == type) {
                    this[type]--;
                    this.userVote = null;
                    this.deleteVote(type);
                    return;
                }

                if (this.userVote) {
                    this[type == 'up' ? 'down' : 'up']--;
                }

                this[type]++;
                this.userVote = type;

                this.createVote(type);
            },
            deleteVote (type) {
                this.$http.delete('/videos/' + this.videoUid + '/votes');
            },
            createVote (type) {
                this.$http.post('/videos/' + this.videoUid + '/votes', {
                    type: type
                });
            }
        },
        props: {
            videoUid: null
        },
        mounted () {
            this.getVotes()
        }
    }
</script>
