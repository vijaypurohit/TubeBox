<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Upload</div>

                    <div class="panel-body">
                        <input type="file" name="video" id="video"  @change="fileInputChange" v-if="!uploading">

                        <div class="alert alert-danger" v-if="failed"> Something went wrong.
                            <a href="/upload">Please try again.</a>.
                        </div>
                        <div class="alert alert-danger" v-if="failed && error.video"> {{ error.video[0] }} </div>
                        <div class="alert alert-danger" v-if="failed && error.title"> {{ error.title[0] }} </div>
                        <div class="alert alert-danger" v-if="failed && error.description"> {{ error.description[0] }}</div>
                        <div class="alert alert-danger" v-if="failed && error.visibility"> {{ error.visibility[0] }}</div>

                        <div id="video-form" v-if="uploading && !failed">
                            <div class="alert alert-info" v-if="!uploadingComplete">
                                Your video will be available at <a :href="this.$root.url + '/videos/' + this.uid" target="_blank">{{ $root.url }}/videos/{{ uid }}</a>.
                            </div>
                            <div class="alert alert-success" v-if="uploadingComplete">
                                Upload complete. Video is now processing. <a href="/videos">Go to your videos</a>.
                            </div>

                            <div class="progress" v-if="!uploadingComplete">
                                <div  :class=" 'progress-bar progress-bar-' + ( fileProgress < 50 ? 'danger' : 'success') + ' progress-bar-striped'" v-bind:style="{ width: fileProgress + '%' }" :aria-valuenow="{fileProgress}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input v-validate="'required|max:191'" name="title" class="form-control" v-model="title">
                                <span v-show="errors.has('title')" class="help is-danger">{{ errors.first('title') }}</span>
                            </div>
                            <div class="help-block text-danger" v-if="error.title"> {{error.title[0]}} </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea v-validate="'required|max:2000'" name="description" class="form-control" v-model="description"></textarea>
                                <span v-show="errors.has('description')" class="help is-danger">{{ errors.first('description') }}</span>
                            </div>
                            <div class="help-block text-danger" v-if="error.description"> {{error.description[0] }}</div>

                            <div class="form-group">
                                <label for="visibility">Visibility</label>
                                <select v-validate="'required|in:private,unlisted,public'" class="form-control" name="visibility" v-model="visibility">
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="public">Public</option>
                                </select>
                                <span v-show="errors.has('visibility')" class="help is-danger">{{ errors.first('visibility') }}</span>
                            </div>
                            <div class="help-block text-danger" v-if="error.visibility"> {{error.visibility[0]}}</div>

                            <span class="help-block pull-right">{{ saveStatus }}</span>

                            <button class="btn btn-default" type="submit" @click.prevent="update">Save changes</button>

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
                uid: null,
                uploading: false,
                uploadingComplete: false,
                failed: false,
                title: 'Untitled',
                description: null,
                visibility: 'private',
                saveStatus: null,
                fileProgress: 0,
                error: '',
            }
        },
        methods: {
            fileInputChange() {

                this.uploading = true;
                this.failed = false;

                // original file data
                this.file = document.getElementById('video').files[0];
//                console.log(this.file);
                // calling store method

                this.store().then(() => {

                    var form = new FormData();
                    form.append('video', this.file);
                    form.append('uid', this.uid);

                    this.$http.post('/upload', form, {
                        progress: (e) => {
                            if (e.lengthComputable) {
//                                console.log(e.loaded + '  ' + e.total);
                                this.updateProgress(e)
                            }
                        }
                    }).then(() => {
                        this.uploadingComplete = true
                    }, () => {
                        this.failed = true
                    });
                }, (response) => {
                    this.failed = true;
                    this.error = response.json();
//                    setTimeout(() => {
//                        this.error = '';
//                        this.uploading = false;
//                        this.failed = false;
//                    }, 5000)
                })
            },
            store() {

                this.file = document.getElementById('video').files[0];

                var form = new FormData();
                form.append('video', this.file);
                form.append('title', this.title);
                form.append('description', this.description);
                form.append('visibility', this.visibility);
                form.append('extension', this.file.name.split('.').pop());

                return this.$http.post('/videos', form).then((response) => {
                    this.uid = response.json().data.uid;
                });
                //old one
//                return this.$http.post('/videos', {
//                    title: this.title,
//                    description: this.description,
//                    visibility: this.visibility,
//                    extension: this.file.name.split('.').pop()
//                }).then((response) => {
//                    this.uid = response.json().data.uid;
//                });
            },
            update() {

                this.$validator.validateAll().then(() => {

                    this.error = '';
                    this.saveStatus = 'Saving changes.';

                    return this.$http.put('/videos/' + this.uid, {
                        title: this.title,
                        description: this.description,
                        visibility: this.visibility
                    }).then((response) => {
                        this.saveStatus = 'Changes saved.';

                        setTimeout(() => {
                            this.saveStatus = null;
                        }, 3000)
                    }, (response) => {
//                    console.log(response.json());
                        this.error = response.json();
                        this.saveStatus = 'Failed to save changes.';
                        setTimeout(() => {
                            this.error = '';
                            this.saveStatus= null;
                        }, 6000)
                    });
                }).catch(() => {
                    this.saveStatus = 'Failed to save changes.';
//                    alert('Correct them errors!');
                });

            },
            updateProgress (e) {
                e.percent = (e.loaded / e.total) * 100;
                this.fileProgress = e.percent;
            },

        },
        mounted() {
            // in vue 2.0.1 there is no ready function use mounted instead...
            window.onbeforeunload = () => {
                if (this.uploading && !this.uploadingComplete && !this.failed) {
//                    console.log("I am inside onbeforeunload");
                    return 'Are you sure you want to navigate away?';
                }
            }
        }
    }
</script>
