<template>
    <nav class="navbar navbar-expand-lg navbar-dark main-bg shadows p-3 mb-5 bg-body rounded">
        <div class="container">
            <a class="logo" href="#"><router-link to="/"><img src="../assets/logo.svg" alt="logo"></router-link></a>
            <!-- <button class="navbar-toggler" type="button" 
            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" aria-expanded="false">
                <span class="navbar-toggler-icon">
                </span>
            </button> -->
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
                <div class="col-auto" v-if="midcate !== ''">
                    <select class="form-select" v-model="product.category_id">   <!-- in: 배열-->
                        <option :value="cate.id" :key="cate.id" v-for="cate in categoryObj[maincate][midcate]">{{ cate.value }}</option>
                    </select>
                </div>
            </div>
            <div class="input-group align-items-center">
                <input type="text" class="form-control radious" placeholder="오늘은 @@이 많이 검색됐네요~" aria-label="Username" aria-describedby="basic-addon1">
                <a href="#"><span class="search_icon"><img src="../assets/search.png"></span></a>
            </div>
            <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">My Page</a>     
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">마이페이지</a></li>
                        <li><a class="dropdown-item" href="#">다이어리</a></li>
                    </ul>
            </div>
            <div class="d-flex">
                <div >
                    <button class="btn btn-danger" type="button"><router-link class="login_b" to="/LoginJoin">로그인</router-link></button>
                </div>
                <div>
                    <button class="btn btn-danger" type="button" @click="kakaoLogout">로그아웃</button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name:'header',
    computed:{
    },
    data() {
        return {
            categoryObj: {},
            maincate: '',
            midcate: '',
        }
    },
    created() {
        this.getCategoryList();
    },
    methods: {
        async getCategoryList() {
            console.log('ddd')
            const categoryList = await this.$get('/api/categoryList');
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
                this.categoryObj[maincate][midcate].push(obj);
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

