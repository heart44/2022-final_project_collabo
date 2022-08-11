<template>
    <nav class="navbar navbar-expand-lg navbar-dark main-bg shadows p-3 mb-5 bg-body rounded">
        <div class="container">
        <router-link to="/"><a class="logo" href="#"><img src="../assets/logo.svg" alt="logo"></a></router-link>
        <div class="input-group align-items-center">
            <input type="text" class="form-control radious" v-model="search" @keyup.enter="searchMenu()" placeholder="" aria-label="Username" aria-describedby="basic-addon1" ref="holder" >
            <a href="#" role="button" @click="searchMenu()"><span class="search_icon"><img src="../assets/search.png"></span></a>
        </div>
        
        <div class="d-flex">
            <button class="btn btn-secondary"><router-link to="/BobfList" class="login_b">밥친구해용</router-link></button>
            <div v-if="user.email === undefined">
                <router-link class="login_b" @click="Login" to="/LoginJoin"><button class="btn btn-danger" type="button">로그인</button></router-link>
            </div>
            <div v-else class="d-flex">
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">My Page</a>    
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><router-link class="" to="/Profile"><a class="dropdown-item" href="#">프로필수정</a></router-link></li>
                            <li><router-link class="" to="/Diary"><a class="dropdown-item" href="#">다이어리</a></router-link></li>
                        </ul>
                </div>
                <button class="btn btn-danger" type="button" @click="signout">로그아웃</button>
            </div>
        </div>
        </div>
    </nav>
</template>

<script>
export default {
    name:'header',
    data() {
        return {
            categoryObj: {},
            maincate: '',
            midcate: '',
            menu: '',
            search: '',
            searchList: {},
            log: ''
        }
    },
    computed:{
        user() {
            return this.$store.state.user;
        },
        getSearchList() {
            return this.$store.state.getSearchList;
        },
        getCurrentLoc() {
            return this.$store.getters.getCurrentLoc;
        }
    },
    created() {

    },
    updated() {
        this.searchLog()
    },
    mounted() {
        this.searchLog()
    },
    methods: {
        async signout() {
            this.$store.commit('user', {});
            await this.$post('user/signout');
        },
        async searchMenu() {    //통신부분 개망....완전 일 많이 하는 중,,,근데 나누기.....힘들어요,,,,,,
            if(this.search.trim() !== '') {
                const param = { 
                    search_word: this.search,
                    iuser: this.user.iuser
                }
                console.log(param)
                const log = await this.$post('/search/searchLog', param);    //이거 검색기록임~ 나중에 주석 풀겨
                console.log(log)
                // const result = await this.$post('search/menuCrawling', param);
                //이거는 네이버에서 메뉴 가져오는 거 통신
                const result = await this.$get(`https://map.naver.com/v5/api/search?caller=pcweb&query=${this.search}&type=all&searchCoord=${this.getCurrentLoc.lon};${this.getCurrentLoc.lat}&page=1&displayCount=20&isPlaceRecommendationReplace=true&lang=ko`);
                const searchList = result['result']['place']['list']
                let params = []
                searchList.forEach(item => {    //for문 돌려서 데이터 가공쓰
                    params.push({
                        name: item.name,
                        addr: item.address,
                        tel: item.tel,
                        menu: item.menuInfo,
                        open_close: item.bizhourInfo,
                        lon_x: item.x,
                        lat_y: item.y,
                        img_path: item.thumUrl
                    })
                });
                params.push(this.search);
                console.log(params)
                //여기는 db에 검색해서 나온 내용 저장쓰
                const rs = await this.$post('/search/searchList', params);
                console.log(rs)

                //여기는 그 뭐냐,,,검색하면 디비에 저장된 내용 가져와서 searchList.vue에 뿌려줄라고
                const rs2 = await this.$get(`/search/restList/${this.search}/${this.getCurrentLoc.lon}/${this.getCurrentLoc.lat}`);
                console.log(rs2["rs"]);
                this.$store.commit('restList', rs2["rs"]);  //select 해온 결과 값 store에 저장
                
                this.$store.commit('setSearchList', params);    //네이버 결과 값 저장
                this.$store.commit('setSearchWord', this.search);   //검색어 저장
                this.$router.push( {path: '/SearchList'} );
                this.search = ''

                this.getMenuList();
            }
        },
        async searchLog() {
            const log = await this.$get('/search/mostSearchLog')
            const holder = this.$refs.holder;
            if(log) {
                holder.placeholder = `오늘은 ${log.rs}이(가) 많이 검색됐네요~` 
            } 
        },
        async getMenuList() {
            const rs = await this.$get('/search/menuList')
            console.log(rs)
        }
        
    }
}
</script>

<style scoped>
.main-bg{
    border-bottom: 1px solid #F26C38; 
}
.logo img{
    width: 200px;
}
.logo img{
    width:230px;
}
.input-group{
    width:400px; 
}
.btn{
    margin-left:10px;
}
.search_icon{
    margin-left:10px;
}
input[type="text"]{
    border: 2px solid #F26C38;
}
input::placeholder{
    color: #333333;
}
input:focus {
    outline:none;
    box-shadow:none;
}
.radious{
    border-radius: 30px !important;
}
.shadows{
    box-shadow: 5px 1px 5px #F26C38;
}
.btn-secondary{
    background-color:#F26C38;
    border: 1px solid #F26C38;
}
.btn-secondary:focus{
    box-shadow: none;
}
.dropdown-menu{
    border:1px solid #F26C38;
}
.dropdown-item{
    color: #333333;
}
.dropdown-item:hover{
    background-color:#F26C38;
    color: white;
}
.btn-danger{
    background-color:#2B3F6B;
    border:1px solid #2B3F6B;
}
.btn-danger:focus{
    box-shadow:none;
}
.login_b:hover{
    color: white !important;
}
</style>
