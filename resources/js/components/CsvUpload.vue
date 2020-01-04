<template>
    <div>
        <div>
            <transition name="pop" appear>
                <div>
                    <h2>Upload .CSV file</h2>
                    <transition name="pop">
                        <div
                            v-if="notCSV"
                            class="alert alert-danger"
                            role="alert"
                        >
                            The input has to be a ".csv" file !
                        </div>
                    </transition>
                    <br /><br />
                    <!--            <input type="file"  id="file"   class="btn"  size="1000">-->
                    <label
                        v-if="!confirm"
                        for="file"
                        class="custom-file-upload sketchy"
                    >
                        <i class="fa fa-cloud-upload"></i> Click to Upload
                    </label>
                    <label v-else for="file" class="custom-file-upload sketchy">
                        <i class="fa fa-cloud-upload"></i> Change file
                    </label>

                    <input
                        id="file"
                        type="file"
                        @change="loadTextFromFile"
                        ref="file"
                    />
                    <br /><br />
                </div>
            </transition>
            <transition name="pop">
                <div v-if="confirm">
                    <h4 class="sketchy col">{{ file }}</h4>
                    <br />
                    <br />
                </div>
            </transition>
            <transition name="pop">
                <div v-if="confirm">
                    <h3 @click="navigate">Ready for the next step !</h3>
                </div>
            </transition>
            <br />
        </div>
    </div>
</template>
<style>
.pop-enter-active {
    animation: pop-in 0.5s ease-out forwards;
}
.pop-leave-active {
    animation: pop-out 1s ease-out forwards;
}
.pop-enter {
}
.pop-leave {
}
@keyframes pop-in {
    from {
        transform: scale(0);
    }
    to {
        transform: scale(1);
    }
}
@keyframes pop-out {
    to {
        transform: translateY(-120px);
    }
    from {
        transform: translateY(0);
    }
}

input[type="file"] {
    display: none;
}
.custom-file-upload {
    /*border: 1px solid #ff9003;*/
    color: #ff9003;
    text-align: center;
    /*border-radius: 5px;*/
    display: block;
    padding: 12px 12px;
    cursor: pointer;
    width: 70%;
    margin: 0 auto;
}
</style>
<script>
export default {
    props: ["selected", "isActive"],
    mounted() {
        console.log("UploadCsv Component mounted.");
    },
    data() {
        return {
            confirm: null,
            file: [],
            text: "",
            notCSV: false
        };
    },
    methods: {
        navigate() {
            this.$emit("navigate", "navigating");
        },

        // onFileChange(e) {
        //     var file = e.target.files || e.dataTransfer.files;
        //     if (!file.length)
        //         return;
        //     this.file = file;
        // },
        loadTextFromFile(ev) {
            // this.file = this.$refs.file.files[0];
            var fileName = ev.target.files[0].name;

            if (fileName.includes(".csv")) {
                this.notCSV = false;
                this.file = fileName;
            } else {
                this.notCSV = true;
                this.confirm = null;
                return;
            }

            const file = ev.target.files[0];
            const reader = new FileReader();
            reader.onload = e => this.$emit("load", e.target.result);
            reader.readAsText(file);
            this.confirm = true;
        },

        submitFile() {
            var formData = new FormData();
            formData.append("file", this.file);
            axios
                .post("/file", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(function() {})
                .catch(function() {});
        }
    }
};
</script>
