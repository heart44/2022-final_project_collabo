<template>
<main class="container mt-5">
  <div>
      <div class="">
        <h1 class="fl">밥 친구 구하기</h1>
        <div class="plus_btn" v-if="user.iuser !== undefined"><router-link to="/BobfWrite"><img src="../assets/plus.png"></router-link></div>
        <div class="row ">
          <!-- 지역 셀렉트1 -->
          <select class="form-select m-3 w-25" @change="changeAreaCate1" v-model="selectedAreaCate1">
            <option value="" >시/도 선택</option>
            <option :value="key" v-for="item, key in AreaCate1" :key="key">
              {{ key }}
            </option>
          </select>

          <!-- 지역 셀렉트2 -->
          <select class="form-select m-3 w-25" @change="changeAreaCate2" v-model="selectedAreaCate2" v-if="selectedAreaCate1 !== ''">
            <option value="">지역 선택</option>
            <option :value="item" v-for="item in AreaCate2List" :key="item">
              {{ item }}
            </option>
          </select>

          <!-- 지역 셀렉트3 -->
          <!-- <select class="form-select" @change="changeAreaCate3" v-model="selectedAreaCate3" v-if="selectedAreaCate2 !== '' && AreaCate3List.length !== 0 ">
            <option value="">지역 선택</option>
            <option :value="item" v-for="item in AreaCate3List" :key="item">
              {{ item }}
            </option>
          </select> -->

          <!-- 지역 셀렉트4 -->
          <!-- <select class="form-select" @change="getBobfList" v-model="selectedAreaCate4" v-if="selectedAreaCate3 !== ''  && AreaCate4List.length !== 0 ">
            <option value="">지역 선택</option>
            <option :value="item" v-for="item in AreaCate4List" :key="item">
              {{ item }}
            </option>
          </select> -->
          
          <!-- <form>
            <div>
              <label for="party">밥 먹을 날 선택하기</label>
              <input id="party" type="date" name="partydate" v-model="date"
                    min="2022-01-01" max="2022-12-31"
                    pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required>
            </div>
          </form> -->
        </div>
      </div>

      <div class="row">
        <div class="card-list col-xl-3" :key="ibobf" v-for="ibobf in paginatedData">
        <div class="card" style="width: 18rem; cursor:pointer;" @click="goToDetail(ibobf.ibobf)">
          <a class="card-image" target="_blank">
            <div>
              <img alt="이미지" class="card-img-top" :src="`/static/img/bobf/${ibobf.img_path}`" style="height: 300px; object-fit: cover" onerror="this.src='https://images.unsplash.com/photo-1556761223-4c4282c73f77?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=765&q=80'">
            </div>
          </a>
          <a class="card-description" target="_blank">
            <h3 class="card-title title">{{ ibobf.title }}</h3>
            <div class="d-flex justify-content-between align-ites-center">
                <small class="text-dark">{{ ibobf.sido }} / {{ ibobf.gugun}}</small>
                <small class="text-dark" v-if="ibobf.cur_mem === ibobf.total_mem ? this.member = '모집완료' : this.member = '모집중'">{{this.member}}</small>
            </div>
          </a>
        </div>
        </div>
      </div>

      <div class="m-5">
        <button class="btn" :disabled="pageNum === 0" @click="prevPage">이전</button>
        <span class="page-count mx-2">{{ pageNum + 1 }} / {{ pageCount }} 페이지</span>
        <button class="btn" :disabled="pageNum >= pageCount - 1" @click="nextPage">다음</button>
      </div>

  </div>
</main>
</template>

<script>

export default {
  components: {
  },
  data() {
    return {
      //지역
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
      AreaCate1List: [],
      AreaCate2List: [],
      AreaCate3List: [],
      // AreaCate4List: [],

      selectedAreaCate1: '',
      selectedAreaCate2: '',
      selectedAreaCate3: '',
      // selectedAreaCate4: '',

      BobfList: [],
      date:'',
      member: '',

    //페이징
      pageNum: 0,
      pageSize: 8
    };
  },
  props: {
  },
  computed: {
    user() {
        return this.$store.state.user;
    },
  //페이징
    pageCount() {
      let listLeng = this.BobfList.length,
          listSize = this.pageSize,
          page = Math.floor((listLeng - 1) / listSize) + 1;
      // if(listLeng % listSize > 0) page +=  1;

      return page;
    },
    paginatedData() {
      const start = this.pageNum * this.pageSize,
            end = start + this.pageSize;

      return this.BobfList.slice(start, end);
    }
  },
  created() {
    //지역
    this.getBobfList();
    
  },
  updated() {
    this.lazyload();
  },
  methods: {

  //카테고리
    changeAreaCate1() {
        this.selectedAreaCate2 = '';
        this.selectedAreaCate3 = '';
        // this.selectedAreaCate4 = '';

        this.Areacate2List = [];
        this.Areacate3List = [];

        this.getAreaCate2List(this.selectedAreaCate1);
        this.getBobfList();
    },

    changeAreaCate2() {
      this.selectedAreaCate3 = '';
      this.selectedAreaCate4 = '';
      this.AreaCate3List = [];
      this.getAreaCate3List(this.selectedAreaCate1, this.selectedAreaCate2);
      this.getBobfList();
    },
    // changeAreaCate3() {
    //   this.selectedAreaCate4 = '';
    //   this.AreaCate4List = [];
    //   this.getAreaCate4List(this.selectedAreaCate1, this.selectedAreaCate2, this.selectedAreaCate3);
    //   this.getBobfList();
    // },

    async getAreaCate2List(area1) {
      this.AreaCate2List = [];
      const area2 = await this.$get(`/api/AreaCate2List/${area1}`, {});

      area2.forEach(item => {
        if(item.area2 !== '' ) {
            this.AreaCate2List.push(item["area2"]);
        } else if(item.area2 === '' && item.area3 !== '' ){
          this.AreaCate2List.push(item["area3"]); //광역시를 위한 area3
        } else {
          this.AreaCate2List.push(item["area4"]); //세종시를 위한 area4
        }
      })
  
      this.AreaCate2List = new Set(this.AreaCate2List);

    },

    async getAreaCate3List(area1, area2_5) {
      const area3 = await this.$get(`api/AreaCate3List/${area1}/${area2_5}`, {});
      
      area3.forEach(item => {
        if(item.area3 !== '' && item.area3 !== area2_5) {
            this.AreaCate3List.push(item["area3"]);
        } else if(item.area3 !== '' && item.area3 === area2_5 || item.area3 === '' && item.area4 !== '' ){
          this.AreaCate3List.push(item["area4"]);
        }
      })

      if(this.AreaCate3List.length === 0) {
        this.AreaCate3List = []
      } else {
        this.AreaCate3List = new Set(this.AreaCate3List);
      }

    },

    /*
    async getAreaCate4List(area1, area2_5) {
      const area4 = await this.$get(`api/AreaCate3List/${area1}/${area2_5}`, {});
      
      area4.forEach(item => {
        if(item.area3 !== '' && item.area3 !== area2_5) {
            this.AreaCate4List.push(item['area4']);
        }
      })
    },
    */
    

  //밥친구 리스트
    async getBobfList() {
      // const select1 = this.AreaCate1[this.selectedAreaCate1];
      // const select3 = this.selectedAreaCate3;
      // const select4 = this.selectedAreaCate4;

      const select1 = this.selectedAreaCate1;
      const select2 = this.selectedAreaCate2;

      const param = {};
      if(select1 !== '') {
        param.area1 = select1;
      }
      if(select2 !== '') {
        param.area2 = select2;
      }

      //시/도 선택 -> 관련 시/도 내용만 뜸
      if(!select1) {
        this.BobfList = await this.$get('api/selBobfList', param);
      } else {
        const select1List = await this.$get('api/selBobfList', param);

        const sidoListCard = [];
          select1List.forEach(item => {
            if(item.sido === select1) {
              sidoListCard.push(item);
            }
          })
        this.BobfList = sidoListCard;
      }

      //구/군 선택 -> 관련 구/군 내용만 뜸
      if(select1 && select2) {
        const select1List = await this.$get('api/selBobfList', param);
        const gugunListCard = [];
        select1List.forEach(item => {
          if(item.gugun === select2) {
            gugunListCard.push(item);
          }
        })
        this.BobfList = gugunListCard;
      }

    },

  //글 상세페이지 이동
    goToDetail(ibobf) {
      const res = ibobf
      this.$router.push( {name: 'BobfDetail', params: { ibobf: res }} );
      // this.$router.push( {path: '/BobfDetail/ibobf'} );
    },

    
  //페이징
    nextPage() {
      this.pageNum += 1;
    },
    prevPage() {
      this.pageNum -= 1;      
    },

    lazyload() {
      const card_images = document.querySelectorAll('.card-image');

      card_images.forEach(function(card_image) {
        let content_image = card_image.querySelector('img');
        content_image.addEventListener('load', function() {
          card_image.className = card_image.className + ' is-loaded';
  		  });
  
	    });
	  }
  }

}
</script>

<style scoped>
main { overflow-x: hidden; }
.title {
  color: #2B3F6B
}
.btn{
    border:2px solid #2B3F6B;
    border-radius:15px;
    color:#2B3F6B;
    margin-left: 0.5rem;
}
.plus_btn img{
  float:right;
  margin-right:2%;
  margin-top: 1%;
}
.fl {
  text-align: left;
  padding-left: 13px;
  padding-bottom: 10px;
  color: #2B3F6B;
}
h1 {
  font-family: 'Cafe24Ssurround';
  font-weight: bold;
  font-size: 50px;
  letter-spacing: 1px;
}

/* Lazy Load Styles */
.card-image {
	display: block;
	min-height: 20rem; /* layout hack */
	background: #fff center center no-repeat;
	background-size: cover;
	filter: blur(3px); /* blur the lowres image */
}

.card-image > img {
	display: block;
	width: 100%;
	opacity: 0; /* visually hide the img element */
}

.card-image.is-loaded {
	filter: none; /* remove the blur on fullres image */
	transition: filter 1s;
}

/* Layout Styles */
html, body {
	width: 100%;
	height: 100%;
	margin: 0;
	font-size: 16px;
	font-family: sans-serif;
}

.card-list {
	display: block;
	margin: 1.5rem auto;
	padding: 0;
	font-size: 0;
	text-align: center;
	list-style: none;
}

.card {
	display: inline-block;
	width: 90%;
	max-width: 20rem;
	margin: 1rem;
	font-size: 1rem;
	text-decoration: none;
	overflow: hidden;
	box-shadow: 0 0 2rem -1rem rgba(0,0,0,0.5);
	transition: transform 0.1s ease-in-out, box-shadow 0.1s;
}

.card:hover {
	transform: translateY(-0.5rem) scale(1.0125);
	box-shadow: 0 0.5em 2rem -1rem rgba(0,0,0,0.5);
}

.card-description {
	display: block;
	padding: 1em 0.5em;
	color: #515151;
	text-decoration: none;
}

.card-description > h2 {
	margin: 0 0 0.5em;
}

.card-description > p {
	margin: 0;
}
</style>