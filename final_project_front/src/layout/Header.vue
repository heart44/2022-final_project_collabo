<template>
    <nav class="navbar navbar-expand-lg navbar-dark main-bg shadows p-3 mb-5 bg-body rounded">
        <div class="container">
        <router-link to="/"><a class="logo" href="#"><img src="../assets/logo.svg" alt="logo"></a></router-link>
        <div class="row">
            <div class="col-auto">
                <select class="form-select" v-model="maincate" @change="changeCate1">
                    <option :key="name" v-for="(value, name) of categoryObj">{{ name }}</option>
                </select>
            </div>
            <div class="col-auto" v-if="maincate !== ''">
                <select class="form-select" v-model="midcate" @change="changeCate2">
                    <option :key="name" v-for="(value, name) of categoryObj[maincate]">{{ name }}</option>
                </select>                         <!-- of: 객체, in으로 해도 동작은 함-->
            </div>
            <!-- 
            <div class="col-auto" v-if="midcate !== ''">
                <select class="form-select" v-model="menu"> -->  <!-- in: 배열-->
                    <!-- <option :value="cate.id" :key="cate.id" v-for="cate in categoryObj[maincate][midcate]">{{ cate.value }}</option>
                </select>
            </div>  -->
        </div>
        <div class="input-group align-items-center">
            <input type="text" class="form-control radious" v-model="search" @keyup.enter="searchMenu()" placeholder="오늘은 @@이 많이 검색됐네요~" aria-label="Username" aria-describedby="basic-addon1">
            <a href="#" role="button" @click="searchMenu()"><span class="search_icon"><img src="../assets/search.png"></span></a>
        </div>
        
        <div class="d-flex">
            <div v-if="user.email === undefined">
                <router-link class="login_b" @click="Login" to="/LoginJoin"><button class="btn btn-danger" type="button">로그인</button></router-link>
            </div>
            <div v-else>
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">My Page</a>     
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><router-link class="" to="/MyPage"><a class="dropdown-item" href="#">마이페이지</a></router-link></li>
                            <li><a class="dropdown-item" href="#">다이어리</a></li>
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
            searchList: {}
        }
    },
    computed:{
        user() {
            return this.$store.state.user;
        },
        getSearchList() {
            return this.$store.state.searchList;
        }
    },
    created() {
        this.getCategoryList();
    },
    methods: {
        async signout() {
            this.$store.commit('user', {});
            await this.$post('user/signout');
        },
        async searchMenu() {
            if(this.search.trim() !== '') {
                const param = { search_word: this.search }
                console.log(param)
                // await this.$post('/search/searchLog', param);    //이거 검색기록임~ 나중에 주석 풀겨
                // const result = await this.$post('search/menuCrawling', param);
                const result = await this.$get(`https://map.naver.com/v5/api/search?caller=pcweb&query=${this.search}&type=all&searchCoord=128.591585;35.8666565&page=1&displayCount=20&isPlaceRecommendationReplace=true&lang=ko`);
                console.log(result['result']['place']['list']);

                // this.emitter.emit('searchlist', this.search)
                
                this.$store.commit('setSearchList', result['result']['place']['list']);
                this.$store.commit('setSearchWord', this.search);
                this.$router.push( {path: '/SearchList'} );
                this.search = ''
            }
        },
        async getCategoryList() {
            // console.log('ddd')
            const categoryList = await this.$get('/search/searchCategoryList');
            console.log(categoryList);
            let maincate = '';
            let midcate = '';      
            categoryList.forEach(item => {
            if(item.maincate !== maincate) {
                maincate = item.maincate;
                this.categoryObj[maincate] = {};
                midcate = '';          
            }
            if(item.midcate !== midcate) {
                midcate = item.midcate;
                this.categoryObj[maincate][midcate] = [];
            }   
            const obj = {
                id: item.imenu,
                value: item.menu
            };
            // console.log(obj)
            this.categoryObj[maincate][midcate].push(obj);
            // console.log(this.categoryObj)
            });      
        },
        changeCate1() {
            this.midcate = '';
            // this.product.category_id = '';
        },
        changeCate2() {
            // this.product.category_id = '';
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
</style>
