<template>
    <main class="">
         <div class="container mt-5">
            <h1 class="fl">글 등록</h1>
            <input type="hidden" v-model="composition.ibobf">
            <input type="hidden" class="form-control" ref="iuser" v-model="user.nick">


            <div class="mt-3 mb-4 row">
                <label for="" class="col-md-3 col-form-label">제목</label>
                <span class="col-md-6 input input--minoru">
					<input type="text" class="form-control input__field input__field--minoru rounded-pill" id="Minoru" ref="title" v-model="composition.title">
					<label class="input__label input__label--minoru" for="Minoru"></label>
				</span>
                <!-- <div class="col-md-6">
                    <input type="text" class="form-control input__field input__field--minoru" ref="title" v-model="composition.title">
                </div> -->
            </div>
                
        <!-- 모달 -->
            <div class="mb-4 row">
                <label for="" class="col-md-3 col-form-label">매장 선택</label>
                <div class="d-flex column col-md-6 ms-2">
                    <button class="v btn" @click="[showModal, showModalEvent()]" id="btnNewFeedModal" data-bs-toggle="modal" data-bs-target="#newFeedModal">
                        검색
                    </button>
                        <div class="modal fade" id="newFeedModal" tabindex="-1" aria-labelledby="newFeedModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centerd modal-lg modal-dialog-scrollable">
                                <div class="modal-content" id="newFeedModalContent">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="newFeedModalLabel">매장 찾기</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="id-modal-body">
                                        <slot name="body">
                                            <div class="input-group align-items-center">
                                                    <div class="input-group align-items-center mb-3">
                                                        <div>
                                                            <select class="form-select md-5" @change="changeAreaCate1" v-model="selectedAreaCate1">
                                                                <option value="" >시/도 선택</option>
                                                                <option :value="key" v-for="item, key in AreaCate1" :key="key">
                                                                    {{ key }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control radious ms-3 me-2" v-model="searchRest" @keyup.enter="searchArea()" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                                                        <a href="#" role="button" @click="searchArea()">
                                                            <span class="search_icon ms-2"><img src="../assets/search.png"></span>
                                                        </a>
                                                    </div>
                                                <!-- 모달 검색 결과 뜨는 부분 -->
                                                <div class="row">
                                                    <div  v-for="rest of searchList" :key="rest">
                                                        <div class="" @click="getRestInfo(rest.name, rest.address)" style="cursor:pointer;"  data-bs-dismiss="modal">
                                                            <div class="d-flex column pb-3">
                                                                <div class="col-4" style="width:100px;height:100px;"><img :src=rest.thumUrl style="width:100%;height:100%;" class="col-4"></div>
                                                                <div class="ps-4 d-flex flex-column align-items-start justify-content-center">
                                                                    <h5 class="mb-1 restName">
                                                                        <input type="hidden" id="name" v-model="rest.name" >{{ rest.name }}
                                                                    </h5>
                                                                    <div class="">
                                                                        <input type="hidden" v-model="rest.address">{{rest.address}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </slot>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-bs-dismiss="modal" aria-label="Close">닫기</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div clas="" style="width: 270px;">
                        <input type="" class="form-control ms-3" ref="address" :value="restInfo.name" v-if="getSearchWord !== ''" readonly/>
                    </div>
                </div>
            </div>

            <div class="mb-4 row">
                <label for="" class="col-md-3 col-form-label">일시 / 인원</label>
                <span class="d-flex column col-md-6 input input--minoru">
                    <input type="datetime-local" class="form-control input__field input__field--minoru" id="Minoru" ref="partydt" v-model="this.partydate" >
                    <input type="number" class="form-control ms-5 input__field input__field--minoru" id="Minoru" ref="total_mem" v-model="composition.total_mem">
                </span>
            </div>

            <!-- <div class="mb-4 row">
                <label for="" class="col-md-4 col-form-label">모집 인원</label>
                <span class="col-md-6 input input--minoru">
                    <input type="number" class="form-control input__field input__field--minoru" id="Minoru" ref="total_mem" v-model="composition.total_mem">
                    <label class="input__label input__label--minoru" for="Minoru"></label>
                </span>
            </div> -->

            <div class="mb-4 row">
                <label for="" class="col-md-3 col-form-label">내용</label>
                <span class="col-md-6 input input--minoru">
                    <textarea class="form-control input__field input__field--minoru" rows="10" id="Minoru" ref="ctnt" v-model="composition.ctnt"></textarea>
                    <label class="input__label input__label--minoru" for="Minoru"></label>
                </span>
            </div>

            <div class="mb-4 row">
                <label for="" class="col-md-3 col-form-label">이미지</label>
                <div class="col-md-4">
                    <input type="file" ref="bobfImg" id="img" class="form-control" accept="image/*" >
                </div>
            </div>

            <div class="mt-5 row">
                <div class="mb-3">
                    <button type="button" class="btn btn-danger" @click="insBobF">저장</button>
                    <button type="button" class="btn" @click="goBack">취소</button>
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
                ibobf: 0,
                restname: '',
                iuser: '',
                title: null,
                partydt: '',
                total_mem: '',
                cur_mem: 1,
                img: '',
                ctnt: '',
                sido: '',
                gugun: '',
            },
            //수정

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

            //이미지

        }
    },
    created() {
        this.getNowDate()
        this.searchList = this.getSearchList
        this.searchWord = this.getSearchWord
        this.updateBobf()
    },
    updated() {

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
            // this.selRestList();
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
                    } else if(selectArea === '') {
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
        showModalEvent() {
            this.searchRest = ''
            this.searchList = []
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


        //글 쓰기 & 수정
        async insBobF() {
            let image = '';
            if(this.$refs.bobfImg.files.length !== 0) {
                image = await this.$base64(this.$refs.bobfImg.files[0]);
            }

            this.composition.iuser = this.user.iuser
            this.composition.partydt = this.partydate
            this.composition.sido = this.sido
            this.composition.gugun = this.gugun
            this.composition.restname = this.restInfo.name
            this.composition.img = image
            this.composition.ibobf =this.$route.params.ibobf


            if(this.selectedAreaCate2 !== '') {
                this.composition.irest = this.selectedAreaCate2;
            }
        
            let res;
            console.log("ibobf:" , this.$route.params.ibobf)
            if(this.$route.params.ibobf) {
                res = await this.$post('api/updateBobfDetail', this.composition)
                if(res.result) {
                    this.$router.push( {path: '/BobfList'} );
                    this.$swal.fire('🥕글수정 성공🥕', '글이 수정되었습니다', 'success')
                }
            } else {        
                res = await this.$post('api/insBobF', this.composition)
                if(res.result) {
                    this.$router.push( {path: '/BobfList'} );
                    this.$swal.fire('🥕글등록 성공🥕', '글이 등록되었습니다', 'success')
                } else if ( this.composition.title === null || this.composition.title === '' ) {
                    this.$refs.title.focus()
                    this.$swal.fire('🥕글쓰기 실패🥕', '제목을 입력해 주세요', 'error')
                } else {
                    this.$swal.fire('🥕글쓰기 실패🥕', '글쓰기에 실패했습니다!', 'error');
                }
            }
            console.log(res)

            // if( res.result ) {
            //     // this.$swal.fire('🥕글등록 성공🥕', '글이 등록되었습니다', 'success')
            //     this.$router.push( {path: '/BobfList'} );
            // } else if ( this.composition.title === null || this.composition.title === '' ) {
            //     this.$refs.title.focus()
            //     this.$swal.fire('🥕글쓰기 실패🥕', '제목을 입력해 주세요', 'error')
            // } else {
            //     this.$swal.fire('🥕글쓰기 실패🥕', '글쓰기에 실패했습니다!', 'error');
            // }
            
        },
        //수정시 내용 가져오기
        async updateBobf() {

            if(this.$route.params.ibobf) {
                const ibobf = this.$route.params.ibobf;
                const detail = await this.$post(`api/selBobfDetail/`, { ibobf })
                if(detail) {
                    this.composition.ibobf      = ibobf;
                    this.restInfo.name          = detail.restname;
                    this.sido                   = detail.sido;
                    this.gugun                  = detail.gugun;
                    this.user.iuser             = detail.iuser;
                    this.composition.title      = detail.title;
                    this.composition.ctnt       = detail.ctnt;
                    this.composition.partydt    = detail.partydt;
                    this.composition.img        = detail.img_path;
                    this.composition.total_mem  = detail.total_mem;
                }
            }
        },

    
    }
}
</script>

<style scoped>
::-webkit-scrollbar {
    display: none;
}
.btn{
    border:2px solid #2B3F6B;
    border-radius:15px;
    color:#2B3F6B;
    margin-right:10px;
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
.restName {
    color: #2B3F6B
}


.input {
	position: relative;
	z-index: 1;
	display: inline-block;
	/* margin: 1em; */
	max-width: 700px;
	width: calc(100% - 2em);
	vertical-align: top;
}

.input__field {
	position: relative;
	display: block;
	float: right;
	/* padding: 0.8em; */
    padding-right: calc(var(--bs-gutter-x) * .5);
    padding-left: calc(var(--bs-gutter-x) * .5);
    margin-top: var(--bs-gutter-y);
	width: 60%;
	/* border: none; */
	border-color:#eca29b;
	/* border-radius: 15px; */
	background: #f0f0f0;
	color: #aaa;
	/* font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; */
	-webkit-appearance: none; /* for box shadows to show on iOS */
}

.input__field:focus {
	outline: none;
}

.input__label {
	display: inline-block;
	float: right;
	padding: 0 1em;
	width: 40%;
	color: #6a7989;
	font-weight: bold;
	font-size: 70.25%;
	-webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.input__label-content {
	position: relative;
	display: block;
	padding: 1.6em 0;
	width: 100%;
}

.graphic {
	position: absolute;
	top: 0;
	left: 0;
	fill: none;
}

.icon {
	color: #ddd;
	font-size: 150%;
}
.input__field--minoru {
	width: 100%;
	background: #fff;
	box-shadow: 0px 0px 0px 2px transparent;
	color: #eca29b;
	-webkit-transition: box-shadow 0.3s;
	transition: box-shadow 0.3s;
}

.input__label--minoru {
	padding: 0;
	width: 100%;
	text-align: left;
}

.input__label--minoru::after {
	content: '';
  	position: absolute;
  	top: 0;
  	z-index: -1;
  	width: 94%;
  	height: 3em;
	box-shadow: 0px 0px 0px 0px;
    border-radius: 15px;
	color: rgba(199,152,157, 0.6);
}

.input__field--minoru:focus {
	box-shadow: 0px 0px 0px 2px #eca29b;
}

.input__field--minoru:focus + .input__label--minoru {
	pointer-events: none;
}

/* .input__field--minoru:focus + .input__label--minoru::after {
	-webkit-animation: anim-shadow 0.3s forwards;
	animation: anim-shadow 0.3s forwards;
} */

@-webkit-keyframes anim-shadow {
	to {
		box-shadow: 0px 0px 100px 50px;
    	opacity: 0;
	}
}

@keyframes anim-shadow {
	to {
		box-shadow: 0px 0px 100px 50px;
    	opacity: 0;
	}
}

.input__label-content--minoru {
	padding: 0.75em 0.15em;
}
.fl {
  text-align: left;
  padding-left: 8%;
  padding-bottom: 15px;
  color: #2B3F6B;
}
h1 {
  font-family: 'Cafe24Ssurround';
  font-weight: bold;
  font-size: 50px;
  letter-spacing: 1px;
}
</style>