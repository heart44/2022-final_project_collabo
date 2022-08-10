<template>
    <main class="">
        <div class="container">
            <h2 class="text-center">~ 글 쓰기 ~</h2>

            <div class="">
                <label for="" class="form-label">제목</label>
                <div class="">
                    <input type="text" class="form-control" ref="title" v-model="composition.title">
                </div>
            </div>

            <div class="">
                <!-- <label for="" class="form-label"></label> -->
                <div class="">
                    <input type="hidden" class="form-control" ref="iuser" v-model="user.nick">
                </div>
            </div>
                
                
            <div class="">
                <label for="" class="form-label">매장 선택</label>
                <div>
                    <button @click="[showModal, showModalEvent()]" id="btnNewFeedModal" data-bs-toggle="modal" data-bs-target="#newFeedModal">모달 열기</button>
                        <div class="modal fade" id="newFeedModal" tabindex="-1" aria-labelledby="newFeedModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centerd modal-xl">
                                <div class="modal-content" id="newFeedModalContent">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="newFeedModalLabel">매장 찾기</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="id-modal-body">
                                        <slot name="body">
                                            <div class="input-group align-items-center">
                                                <div class="infiniteScroll">
                                                    <div>
                                                        <select class="form-select" @change="changeAreaCate1" v-model="selectedAreaCate1">
                                                            <option value="" >시/도 선택</option>
                                                            <option :value="key" v-for="item, key in AreaCate1" :key="key">
                                                                {{ key }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                        <div class="input-group align-items-center">
                                                            <input type="text" class="form-control radious" v-model="searchRest" @keyup.enter="searchArea()" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                                                            <a href="#" role="button" @click="searchArea()">
                                                                <span class="search_icon"><img src="../assets/search.png"></span>
                                                            </a>
                                                        </div>
                                                    <div>
                                                        <h4>{{ getSearchWord }}</h4>
                                                    </div>
                                                    <div  v-for="rest of searchList" :key="rest">
                                                        <div @click="getRestInfo(rest.name, rest.address)" style="cursor:pointer;"  data-bs-dismiss="modal">
                                                            <div style="width:100px;height:100px;"><img :src=rest.thumUrl style="width:100%;height:100%;"></div>
                                                            <div>
                                                                가게 이름 : <input type="hidden" id="name" v-model="rest.name" >{{ rest.name }}
                                                            </div>
                                                            <div>
                                                                가게 주소 : <input type="hidden" v-model="rest.address">{{rest.address}}
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </slot>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="" data-bs-dismiss="modal" aria-label="Close">닫기</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="" class="form-control" ref="address" :value="restInfo.name" v-if="getSearchWord !== ''" readonly/>
                        </div>
                </div>
            </div>

            <div class="">
                <label for="" class="form-label">날짜 시간</label>
                <div class="">
                    <input type="datetime-local" class="form-control" ref="partydt" v-model="this.partydate" >
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
                    <button type="button" class="btn" @click="goBack">취소</button>
                </div>
                <div class="">
                    <button type="button" class="btn" @click="insBobF">저장</button>
                </div>
            </div>

        </div>
    </main>
</template>

<script>

export default {
    computed: {
        user() {
            return this.$store.state.user;
        },
        getSearchWord() {
            return this.$store.getters.getSearchWord;
        },
        // restInfo() {
        //     return this.$store.state.restInfo;
        // }

    },
    props: {
        show: Boolean
    },
    data() {
        return {
            //insert 요소
            composition: {
                restname: '',
                iuser: '',
                title: null,
                partydt: '',
                total_mem: '',
                cur_mem: 1,
                img_path: '',
                ctnt: '',
                sido: '',
                gugun: '',
            },
            

            //가게 검색 모달
            showModal: false,
            searchRest: '',
            searchWord: '',
            searchList: {},
            
            //파티 날자 정하기
            partydate: '',


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
            selectAreaArray: [],

            //식당 정보
            restInfo: {},
            restName: '',
            sido: '',
            gugun: '',

        }
    },
    created() {
        this.selRestList()
        this.getNowDate()
        this.searchList = this.getSearchList
        this.searchWord = this.getSearchWord
    },
    methods: {
        //뒤로가기
        goBack(){
            this.$router.go(-1); [2]
        },

        //지역 카테고리
        changeAreaCate1() {
            this.selectedAreaCate2 = ''
            this.getSearchWord == ''
            this.RestList = [];
            this.selRestList();
        },
        
        /*
        async selRestList() {
            this.selectAreaArray = [];
            const selectArea = this.AreaCate1[this.selectedAreaCate1];

            const selectAreaArray2 = await this.$post('api/selRestList', {});
            selectAreaArray2.forEach( item => {
                if(item.rest_address.split(' ')[0] === selectArea)
                this.selectAreaArray.push(item)
            });
            
            this.RestList = new Set(this.selectAreaArray);

        },

        getRestArea() {
                const restAddr = this.restInfo.addr
            
            const sido = restAddr.split(' ')[0]
            const gugun = restAddr.split(' ')[1]
            this.sido = sido
            this.gugun = gugun
        },
        */
        


        //모달 검색
        async searchArea() {
            if(this.searchRest.trim() !== '') {

                // const param = { search_word: this.searchRest }
                // console.log(param)
                // this.searchList = await this.$post('search/menuCrawling', param);
                const result = await this.$get(`https://map.naver.com/v5/api/search?caller=pcweb&query=${this.searchRest}&type=all&searchCoord=128.591585;35.8666565&page=1&displayCount=20&isPlaceRecommendationReplace=true&lang=ko`);

                const res = result['result']['place']['list']

                const selectArea = this.selectedAreaCate1
                const ha = [];
                res.forEach(item => {
                    const searchSido = item.address.split(' ')[0]
                    if(selectArea !== '' && selectArea === searchSido) {
                        ha.push(item)
                    } 
                })

                this.searchList = ha;

                this.$store.commit('setSearchWord', this.searchRest);
                this.searchRest = ''
            }
        },

        getRestInfo(name, addr) {

            const param = { name : name, addr : addr}
            this.restInfo = param

            const sido = addr.split(' ')[0]
            const gugun = addr.split(' ')[1]
            
            this.sido = sido
            this.gugun = gugun
        
        },


        //오늘 날짜 가져오기
        getNowDate() {
            const date = new Date();

            let year = date.getFullYear()
            let month = ('0' + (date.getMonth() + 1)).slice(-2)
            let day = ('0' + date.getDate()).slice(-2)

            const dateString = year + '-' + month + '-' + day
            
            this.partydate = dateString + "T12:00"

        },

        showModalEvent() {
            this.searchRest = ''
            this.searchList = []
        },


        //글 쓰기
        async insBobF() {

            this.composition.iuser = this.user.iuser
            this.composition.partydt = this.partydate
            this.composition.sido = this.sido
            this.composition.gugun = this.gugun
            this.composition.restname = this.restInfo.name

            if(this.selectedAreaCate2 !== '') {
                this.composition.irest = this.selectedAreaCate2;
            }
            
            const res = await this.$post('api/insBobF', this.composition)

            if( res.result ) {
                this.$router.push( {path: '/BobfList'} );
            } else if ( this.composition.title === null || this.composition.title === '' ) {
                this.$refs.title.focus()
                this.$swal.fire('🥕글쓰기 실패🥕', '제목을 입력해 주세요', 'error')
            } else {
                this.$swal.fire('🥕글쓰기 실패🥕', '글쓰기에 실패했습니다!', 'error');
            }
            
        },
    }
}
</script>

<style>

</style>