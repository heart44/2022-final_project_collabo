<template>
<main>
  <div>
    <div>
      <div>
        <div>
          <div>
            <select class="form-select" @change="changeAreaCate1" v-model="selectedAreaCate1">
              <option value="" >시/도 선택</option>
              <option :value="key" v-for="item, key in AreaCate1" :key="key">
                {{ key }}
              </option>
            </select>
            
            <select class="form-select" @change="changeAreaCate2" v-model="selectedAreaCate2" v-if="selectedAreaCate1 !== ''">
              <option value="">구/군 선택</option>
              <option :value="item" v-for="item in AreaCate2List" :key="item">
                {{ item }}
              </option>
            </select>

            <select class="form-select" @change="getBobfList" v-model="getBobfList" v-if="selectedAreaCate2 !== ''">
              <option value="">제발.......그만해..이러다 다 죽어...</option>
              <option :value="item" v-for="item in Areacate3List" :key="item">
                {{ item }}
              </option>
            </select>
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
        <div class="col-xl-3 col-lg-4 col-md-6" :key="ibobf" v-for="ibobf in BobfList">
          <div class="card" style="width: 18rem;">
            <a style="cursor:pointer;">
                <img
                    alt="이미지" class="card-img-top">
            </a>
            <div class="card-body">
                <h5 class="card-title">{{ ibobf.title }}</h5>
                <p class="card-text">
                    <span class="badge bd-dark text-black me-1">{{ ibobf.nick }}</span>
                </p>
                <p class="card-text">
                    <span class="badge bd-dark text-black">
                      {{ ibobf.rest_address.split(' ')[0] }} {{ ibobf.rest_address.split(' ')[1] }}
                      </span>
                </p>
                    <span class="card-text badge bd-dark text-black">{{ ibobf.cur_mem }} / {{ ibobf.total_mem }}</span>
                <div class="d-flex justify-content-between align-ites-center">
                    <small class="text-dark">{{  }}</small>
                </div>
            </div>
          </div>
        </div>
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
      RestArea: [],
      SubArea: [],
      BobfList: [],
      date:'',
      aaa:'',
      AreaCate1List: [],
      AreaCate2List: [],
      AreaCate3List: [],
      selectedAreaCate1: '',
      selectedAreaCate2: '',
      selectedAreaCate3: 0,
    };
  },
  computed: {
    },
  created() {
    //지역
    this.getRestArea();
    this.selBobfList();
    this.getBobfList();
    // this.getAreaCate1List();
  },
  methods: {
    async selBobfList() {
      this.AreaCate1['value']
      this.BobfList = await this.$post('api/selBobfList', {});
    },

    //지역 카테고리
    async getRestArea() {
      const Addr = await this.$get('api/selArea', {});
        console.log(Addr);
        // const Addr = await this.$get('api/selArea', {})
        
        /*R
        for(let i=0; i<Addr.length; i++){
          let Addr1 = Addr[i].area1
            let Addr2 = Addr[i].area2
            let Addr3 = Addr[i].area3
            
            this.RestArea.push(Addr1);

            // if(Addr[i].area2 !== '' && Addr[i].area3 !== '') {
            //   this.SubArea.push(Addr2+'/'+Addr3);
            // } else {
            //   this.SubArea.push(Addr2,Addr3);
            // }
            this.SubArea.push(Addr2);
        }

      this.RestArea = Array.from(new Set(this.RestArea))
      this.SubArea = Array.from(new Set(this.SubArea))
      */
    },
    
    changeAreaCate1() {
        this.selectedAreaCate2 = '';
        this.selectedAreaCate3 = 0;
        this.Areacate2List = [];
        this.Areacate3List = [];

        this.getAreaCate2List(this.selectedAreaCate1);
        this.getBobfList();
    },
    changeAreaCate2() {
      this.selectedAreaCate3 = 0;
      this.AreaCate3List = [];
      this.getAreaCate3List(this.selectedAreaCate1, this.selectedAreaCate2);
      this.getBobfList();
    },

    async getAreaCate2List(area1) {
      this.AreaCate2List = [];
      const area2 = await this.$get(`/api/AreaCate2List/${area1}`, {});

      area2.forEach(item => {
        console.log(item["area4"]);
        if(item.area2 !== '' ) {
            this.AreaCate2List.push(item["area2"]);
        } else if(item.area2 === '' && item.area3 !== '' ){
          this.AreaCate2List.push(item["area3"]);
          console.log(this.AreaCate2List);
        } else {
          this.AreaCate2List.push(item["area4"]);
        }
        }
      )

      console.log(this.AreaCate2List);
      this.AreaCate2List = new Set(this.AreaCate2List);

    },
    async getAreaCate3List(area1, area2, area3) {
      this.AreaCate3List = await this.$get(`api/AreaCate3List/${area1}/${area2}/${area3}`, {});

    },
  

    async getBobfList() {
      
      const param = {};
      console.log(param)
      if(this.selectedAreaCate3 > 0) {
        param['area3'] = this.selectedAreaCate3;
      } else {
        if(this.selectedAreaCate1 !== '') {
          param['area1'] = this.selectedAreaCate1;
        }
        if(this.selectedAreaCate2 !== '') {
          param['area2'] = this.selectedAreaCate2;
        }
      }

      this.BobfList = await this.$get('api/selBobfList', param);
    },

  }
}
</script>