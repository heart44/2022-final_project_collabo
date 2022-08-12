<template>
<main class="container">
  <div>
    <div>
      <div>
        <div>
          <div>
            <!-- 지역 셀렉트1 -->
            <select class="form-select" @change="changeAreaCate1" v-model="selectedAreaCate1">
              <option value="" >시/도 선택</option>
              <option :value="key" v-for="item, key in AreaCate1" :key="key">
                {{ key }}
              </option>
            </select>

            <!-- 지역 셀렉트2 -->
            <select class="form-select" @change="changeAreaCate2" v-model="selectedAreaCate2" v-if="selectedAreaCate1 !== ''">
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
      </div>

      <div>
        <router-link to="/BobfWrite">글쓰기 테스트 화면</router-link>
      </div>

      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-6" :key="ibobf" v-for="ibobf in paginatedData">
          <div class="card h-100" style="width: 20rem;" @click="goDetail">
            <a @click="goToDetail(ibobf.ibobf)" style="cursor:pointer;">
              <div>
                  <img alt="이미지" class="card-img-top" :src="`/static/img/bobf/${ibobf.img_path}`" style="height: 250px; object-fit: cover" onerror="this.src='https://images.unsplash.com/photo-1556761223-4c4282c73f77?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=765&q=80'">
              </div>
              <div class="card-body">
                  <h5 class="card-title">{{ ibobf.title }}</h5>
                  <p class="card-text">
                      <span class="badge bd-dark text-black me-1">{{ ibobf.nick }}</span>
                  </p>
                  <div class="d-flex justify-content-between align-ites-center">
                      <small class="text-dark">{{ ibobf.sido }} / {{ ibobf.gugun}}</small>
                      <small class="text-dark" v-if="ibobf.cur_mem === ibobf.total_mem ? this.member = '모집완료' : this.member = '모집중'">{{this.member}}</small>
                  </div>
              </div>
            </a>
          </div>
        </div>
      </div>

      <div class="">
        <button class="" :disabled="pageNum === 0" @click="prevPage">이전</button>
        <span class="page-count">{{ pageNum + 1 }} / {{ pageCount }} 페이지</span>
        <button class="" :disabled="pageNum >= pageCount - 1" @click="nextPage">다음</button>
      </div>

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

  }

}
</script>

<style scoped>
main { overflow-x: hidden; }
</style>