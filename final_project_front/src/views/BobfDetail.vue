<template>
    <div class="container_fix">
        <div class="content">
            <div class="row">
                <div :model="getBobfDetail">
                   <div class="h1 mb-5"> {{this.bobfDetail.title}} </div>
                <div class="row">
                    <div class="col-sm-3 mb-2">{{this.bobfDetail.nick}}</div>
                    <div class="col-sm-6 mb-2">{{this.date}} {{this.time}}</div>
                    <div class="col-sm-3 mb-2">{{this.member}} ({{this.bobfDetail.cur_mem}}/{{this.bobfDetail.total_mem}})</div>
                </div>
                <section class="section-a">
                    <div class="container">
                        <div class="contents row">
                            <div class="col-sm-3">매장 이름 </div>
                            <div class="h5 col-sm-9">{{this.bobfDetail.restname}}</div>
                            <div class="col-sm-3">장&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</div>
                            <div class="Addr col-sm-9">
                                {{this.bobfDetail.sido}} / {{this.bobfDetail.gugun}}
                            </div>
                            <div class="col-sm-3">내&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;용</div>
                            <div class="h-75 col-sm-9">
                                {{this.bobfDetail.ctnt}}
                            </div>
                        </div>
                        <div>
                            <img style="" :src="`/static/img/bobf/${this.bobfDetail.img_path}`" onerror="this.src='https://images.unsplash.com/photo-1556761223-4c4282c73f77?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=765&q=80'" />
                        </div>
                    </div>
                </section> 
                </div>

                <div class="col-md-6">
                    <button class="btn" @click="updateBobfDetail" v-if="this.bobfDetail.iuser === user.iuser">수정</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-danger" @click="deleteBobfDetail" v-if="this.bobfDetail.iuser === user.iuser">삭제</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-danger" @click="goToChat(user.iuser)" v-if="this.bobfDetail.iuser !== user.iuser">채팅하기</button>
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
        },
        goToChat(iuser) {
            const res = this.bobfDetail.iuser
            console.log("res :", res)
            if(iuser !== undefined) {
                this.$router.push( {name: 'BobfChat', params: { iuser: res }} );
            } else {
                this.$swal.fire('🥕채팅 불가🥕', '로그인이 필요한 서비스입니다', 'warning')
                return false
            }
        }
    },
}
</script>

<style scoped>
img {
    width: 300px;
}
.container_fix{
    max-width: 1100px;
    margin: 1em auto;
    overflow: hidden;
}
.contents{
    height: 100%;
    border: 1rem;
}
.Addr {
    font-size: 12px;
}
.btn{
    border:2px solid #2B3F6B;
    border-radius:15px;
    color:#2B3F6B;
    padding: 6px 14px;
}
.btn-danger{
    color: white;
    background-color:#2B3F6B;
    border:1px solid #2B3F6B;
}
button:focus{
    outline:none;
    box-shadow:none;
}
:root {
  --primary-color: #333;
  --secondary-color: #444;
  --overlay-color: rgba(0, 0, 0, 0.7);
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Catamaran', sans-serif;
  line-height: 1.6;
  color: #333;
  font-size: 1.1rem;
}

h1,
h2,
h3,
h4 {
  line-height: 1.3;
}

a {
  color: #444;
  text-decoration: none;
}

ul {
  list-style: none;
}

img {
  width: 100%;
}

.section-a {
  margin: 2rem 0;
}

.section-a .container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 3rem;
  align-items: center;
  justify-content: center;
}

.section-a h1 {
  font-size: 4rem;
  color: var(--primary-color);
}

.section-a p {
  margin: 1rem 0;
}
</style>