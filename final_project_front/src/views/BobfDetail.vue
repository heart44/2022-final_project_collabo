<template>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-6">
                    🧡💛💚💙💜🤎🖤🤍
                </div>
                <div class="col-md-6">
                    🤍🖤🤎💜💙💚💛🧡
                </div>
                <div :model="getBobfDetail">
                    <div class="h2">
                    {{this.bobfDetail.title}}
                    </div>
                    <div class="row">
                        <div class="col-sm-3">{{this.bobfDetail.nick}}</div>
                        <div class="col-sm-6">{{this.date}} {{this.time}}</div>
                        <div class="col-sm-3">{{this.bobfDetail.cur_mem}} / {{this.bobfDetail.total_mem}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <img :src="`/static/img/bobf/${this.bobfDetail.img_path}`" alt="image">
                        </div>
                        <div class="col-md-6">
                            {{this.bobfDetail}}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <button>🤍🖤🤎💜💙💚💛🧡</button>
                </div>
                <div class="col-md-6">
                    <button @click="deleteBobfDetail">🤍🖤🤎💜💙💚💛🧡</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            bobfDetail: '',
            date: '',
            time: '',
            img: '',

        }
    },
    created() {
        this.getIbobF()
        this.getBobfDetail()
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
    },
    component: {
    },
    methods: {
        getIbobF() {
            console.log(this.$route.params) 
        },
        async getBobfDetail() {
            const param = { ibobf: this.$route.params.ibobf }
            this.bobfDetail = await this.$post('/api/selBobfDetail', param);
            this.img = this.bobfDetail.img_path

            const date = this.bobfDetail.partydt
            const day =  date.slice(0,10)
            const hour = date.slice(11, 13)
            const min = date.slice(14, 16)

            this.date = day
            
            if(hour-12  < 10) {
                this.time = "오전 " + hour + ":" + min
            } else {
                this.time = "오후 " + hour + ":" + min
            }
        },
        async deleteBobfDetail() {
            const param = { ibobf: this.$route.params.ibobf,
                            img_path: this.img }
            console.log(param)
            this.bobfDetail = await this.$post('/api/delBobfDetail', param);
        },
    },
}
</script>

<style scoped>
img {
    width: 300px;
}
</style>