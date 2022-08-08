<template>
    <main class="">
        <div class="container">
            <h2 class="text-center">~ 글 쓰기 ~</h2>

        <!-- 모달모달 -->
            <div class="modal-body">
                <slot name="body">
                <div class="input-group align-items-center">
                    <input type="text" class="form-control radious" v-model="searchRest" @keyup.enter="searchArea()" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                    <a href="#" role="button" @click="[showModal = true, searchArea()]">
                        <span class="search_icon"><img src="../assets/search.png"></span>
                    </a>
                    <Teleport to="body">
                        <modal :show="showModal" @close="showModal = false"></modal>                        
                    </Teleport>
                </div>
                </slot>
            </div>

            <div class="">
                <label for="" class="form-label">제목</label>
                <div class="">
                    <input type="text" class="form-control" ref="title" v-model="composition.title">
                </div>
            </div>

            <div class="">
                <label for="" class="form-label">작성자</label>
                <div class="">
                    <input type="text" class="form-control" ref="iuser" v-model="user.nick">
                </div>
            </div>
                
                
            <div class="">
                <label for="" class="form-label">매장 선택</label>
                <div>
                    <select class="form-select" @change="changeAreaCate1" v-model="selectedAreaCate1">
                        <option value="" >시/도 선택</option>
                        <option :value="key" v-for="item, key in AreaCate1" :key="key">
                            {{ key }}
                        </option>
                    </select>
                    <select class="form-select" @change="changeAreaCate2" v-model="selectedAreaCate2" v-if="selectedAreaCate1 !== ''">
                        <option value="" >매장 선택</option>
                        <option :value="item.irest" v-for="item in RestList" :key="item.irest">
                            {{item.rest_name}} 
                    <div class="">
                        <input type="text" class="form-control" ref="irest" v-model="composition.irest">
                    </div>
                        </option>
                    </select>
                </div>
            </div>

            <div class="">
                <label for="" class="form-label">날짜 시간</label>
                <div class="">
                    <input type="datetime-local" class="form-control" ref="partydt" v-model="this.testdate" >
                </div>
            </div>

            <div class="">
                <label for="" class="form-label">내용</label>
                <div class="">
                    <input type="text" class="form-control" ref="ctnt" v-model="composition.ctnt">
                </div>
            </div>

            <div class="">
                <label for="" class="form-label">총 인원 수</label>
                <div class="">
                    <input type="number" class="form-control" ref="total_mem" v-model="composition.total_mem">
                </div>
            </div>

            <div class="">
                <div class="">
                    <button type="button" class="btn" @click="HomeView">취소</button>
                </div>
                <div class="">
                    <button type="button" class="btn" @click="insBobF">저장</button>
                </div>
            </div>

            <div>
                테스트 공간 
                {{ restInfo }}
            </div>
        </div>
    </main>
</template>

<script>
import Modal from './Modal.vue'

export default {
    components: {
        Modal
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
        getSearchList() {
            return this.$store.state.getSearchList;
        },
        restInfo() {
            return this.$store.state.restInfo;
        }

    },
    data() {
        return {
            testName: '',
            //가게 검색 모달
            showModal: false,
            searchRest: '',
            searchWord: '',
            searchList: {},
            
            //insert 요소
            composition: {
                title: '',
                iuser: '',
                irest: '',
                partydt: '',
                ctnt: '',
                total_mem: '',
                cur_mem: 1,
                img_path: ''
                
            },
            
            testdate: '',

            //지역 검색 Object
            AreaCate1: {
                "서울특별시": "서울",
                "경기도": "경기",
                "인천광역시": "인천",
                "세종특별자치시": "세종",
                "강원도": "강원",
                "충청북도": "충북",
                "충청남도": "충남",
                "대전광역시": "대전",
                "경상북도": "경북",
                "경상남도": "경남",
                "대구광역시": "대구",
                "울산광역시": "울산",
                "부산광역시": "부산",
                "전라북도": "전북",
                "전라남도": "전남",
                "광주광역시": "광주",
                "제주특별자치도": "제주"
            },

            //지역에 따른 식당 리스트
            RestList: [],
            selectedAreaCate1: '',
            selectedAreaCate2: '',
            test: [],
        }
    },
    created() {
        this.selRestList(),
        this.searchWord = this.getSearchWord
        this.getNowDate()
    },
    methods: {
        changeAreaCate1() {
            this.selectedAreaCate2 = ''
            this.RestList = [];
            this.selRestList();
        },
        async selRestList() {
            this.test = [];
            const selectArea = this.AreaCate1[this.selectedAreaCate1];
            
            const test2 = await this.$post('api/selRestList', {});
            test2.forEach( item => {
                if(item.rest_address.split(' ')[0] === selectArea)
                this.test.push(item)
            });
            
            this.RestList = new Set(this.test);

        },


        insBobF() {
            const param = {};

            this.composition.iuser = this.user.iuser;
            this.composition.partydt = this.testdate

            if(this.selectedAreaCate2 !== '') {
                this.composition.irest = this.selectedAreaCate2;
                console.log(this.composition.irest)
            }
            
            const res = this.$post('api/insBobF', this.composition);

            console.log(this.composition)
            // console.log("res: " + res);
            // this.$router.push( {path: '/'} );
        },
        

        //모달 검색
        getSearchWord() {
          return this.$store.getters.getSearchWord;
        },
        async searchArea() {
            if(this.searchRest.trim() !== '') {

                const param = { search_word: this.searchRest }
                console.log(param)
                console.log(this.searchList);
                // this.searchList = await this.$post('search/menuCrawling', param);
                const result = await this.$get(`https://map.naver.com/v5/api/search?caller=pcweb&query=${this.searchRest}&type=all&searchCoord=128.591585;35.8666565&page=1&displayCount=20&isPlaceRecommendationReplace=true&lang=ko`);
                console.log(result['result']['place']['list']);

                
                this.$store.commit('setSearchList', result['result']['place']['list']);
                this.$store.commit('setSearchWord', this.searchRest);
                this.searchRest = ''
            }
        },


        //오늘 날짜 가져오기
        getNowDate() {
            const date = new Date();

            let year = date.getFullYear()
            let month = ('0' + (date.getMonth() + 1)).slice(-2)
            let day = ('0' + date.getDate()).slice(-2)

            const dateString = year + '-' + month + '-' + day
            
            this.testdate = dateString + "T12:00"

        }
    }
}
</script>

<style>

</style>