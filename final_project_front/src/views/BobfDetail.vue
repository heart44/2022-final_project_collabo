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
                        <div class="col-sm-3">{{this.member}} ({{this.bobfDetail.cur_mem}}/{{this.bobfDetail.total_mem}})</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <img :src="`/static/img/bobf/${this.bobfDetail.img_path}`" alt="image" onerror="this.src='https://images.unsplash.com/photo-1556761223-4c4282c73f77?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=765&q=80'">
                        </div>
                        <div class="col-md-6">
                            {{this.bobfDetail}}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <button @click="updateBobfDetail" v-if="this.bobfDetail.iuser === user.iuser">🤍🖤🤎💜💙💚💛🧡</button>
                </div>
                <div class="col-md-6">
                    <button @click="deleteBobfDetail" v-if="this.bobfDetail.iuser === user.iuser">🤍🖤🤎💜💙💚💛🧡</button>
                </div>
            </div>
        </div>
        <div>
            💛작고 소중한 테스트 공간입니다💛
            <div></div>
        </div>
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            bobfDetail: '',
            userInfo: '',
            img: '',
            
            date: '',
            time: '',
            member: '',
        }
    },
    created() {
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
        async getBobfDetail() {
            const param = { ibobf: this.$route.params.ibobf }
            this.bobfDetail = await this.$post('/api/selBobfDetail', param);
            this.userInfo = this.bobfDetail.iuser
            this.img = this.bobfDetail.img_path

            //시간 (오전 오후 나누기)
            const date = this.bobfDetail.partydt,
                  day =  date.slice(0,10),
                  hour = date.slice(11, 13),
                  min = date.slice(14, 16);

            this.date = day
            
                if(hour-12  < 10) {
                    this.time = "오전 " + hour + ":" + min
                } else {
                    this.time = "오후 " + hour + ":" + min
                }

            //멤버 모집
            const cur_mem = this.bobfDetail.cur_mem,
                  total_mem = this.bobfDetail.total_mem;
            
                if(cur_mem === total_mem) {
                    this.member = "모집 완료"
                } else if (cur_mem < total_mem) {
                    this.member = "모집 중"
                }
        },
        async deleteBobfDetail() {
            const param = { ibobf: this.$route.params.ibobf,
                            img_path: this.img }
            
            const res = await this.$post('/api/delBobfDetail', param);

            if(res.result) {
                // this.$router.push('BobfList');
                this.$swal.fire('🥕삭제 성공🥕', '글이 삭제되었습니다', 'success')
                this.$router.push({path: '/BobfList'});
            } else {
                this.$swal.fire('🥕삭제 실패🥕', '글이 삭제되지 않았습니다', 'error')
            }
        },
        updateBobfDetail() {
            const res = this.$route.params.ibobf
            console.log("res :", res)
            this.$router.push( {name: 'BobfWrite', params: { ibobf: res }} );
            // console.log(this.$route.params.ibobf);
            // this.$router.push( {path: '/BobfWrite', query: {ibobf: this.$route.params.ibobf}})
            // // const res = this.$post('/api/updateBobfDetail', param)
        }
    },
}
</script>

<style scoped>
img {
    width: 300px;
}
</style>