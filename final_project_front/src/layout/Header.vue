<template>
    <nav class="navbar navbar-expand-lg navbar-dark main-bg shadows p-3 mb-5 bg-body rounded">
        <div class="container">
        <router-link to="/"><a class="logo" href="#"><img src="../assets/logo.svg" alt="logo"></a></router-link>
        <div class="input-group align-items-center">
            <input type="text" class="form-control radious" v-model="search" @keyup.enter="searchMenu()" placeholder="" aria-label="Username" aria-describedby="basic-addon1" ref="holder" >
            <a href="#" role="button" @click="searchMenu()"><span class="search_icon"><img src="../assets/search.png"></span></a>
        </div>
        
        <div class="d-flex">
            <button class="btn btn-secondary bobf"><router-link to="/BobfList" class="login_b"><img src="../assets/fork-set.svg">밥친구해용</router-link></button>
            <div v-if="user.email === undefined">
                <router-link class="login_b" @click="Login" to="/LoginJoin"><button class="btn btn-danger login_btn" type="button">로그인</button></router-link>
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
                
                const params = await this.naverSearch(this.search, this.getCurrentLoc.lon, this.getCurrentLoc.lat)
                await this.searchList(params)
                const restList = await this.getRestList(this.search, this.getCurrentLoc.lon, this.getCurrentLoc.lat)
                this.$store.commit('restList', restList)
                await this.getMenuList();

                this.$store.commit('setSearchWord', this.search);   //검색어 저장
                this.$router.push( {path: '/SearchList'} );
                this.search = ''

            }
        },
        async searchLog() {
            const log = await this.$get('/search/mostSearchLog')
            const holder = this.$refs.holder;
            if(log["rs"] != null) {
                holder.placeholder = `오늘은 ${log.rs}이(가) 많이 검색됐네요~` 
            } else {
                holder.placeholder = `메뉴를 입력해보세요!` 
            }
        },        
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
.bobf img{
    width:22px;
    margin-right: 5px;
    padding-bottom: 2px;
}
.login_btn{
    background-color:#F26C38;
    border:1px solid #F26C38;
}
</style>
