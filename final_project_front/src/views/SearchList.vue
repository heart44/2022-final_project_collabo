<template>
    <main>
        <h3>{{ getSearchWord }}</h3>
        <h3></h3>
        <div class="row d-flex justify-content-center">
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
        <br>
        <div class="d-flex column pb-5">
            <div class="col-4 aaa bbb" style="width:40%;height:500px;">
                <div v-for="rest in restList" :key="rest" ref="aaa">
                    <div class="bold">{{ rest.rest_name }}</div>
                    <div class="ms-3 me-3 d-flex column justify-content-start align-items-center">
                        <div>
                            <div v-if="rest.img_path !== null">
                                <img :src=rest.img_path style="width:100px;height:100px;">
                            </div>
                            <div v-else>
                                <img src="https://cdn.pixabay.com/photo/2015/09/13/21/13/dishes-938747_960_720.jpg" style="width:100px;height:100px;">
                            </div>
                        </div>
                    
                        <div class="ms-4 d-flex flex-column align-items-start justify-content-start">
                            <div>주소 : {{ rest.rest_address }}</div>
                            <div>카테고리 : {{ rest.menu }}</div>
                            <div>전화번호 : {{ rest.tel }}</div>
                            <div>영업시간 : {{ rest.open_close }}</div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div ref="mapDiv" class="col-8 aaa" style="width:50%;height:500px;"></div>
        </div>
    </main>
</template>

<script>
export default {
    name: "SearchList",
    data() {
        return {
            restList: [],
            categoryObj: {},
            maincate: '',
            midcate: '',
            menu: '',
            // styleObj: {
            //     position: 'relative',
            //     bottom: '85px',
            //     borderRadius:'80px',
            //     border: '1px solid #ccc',
            //     borderBottom: '2px solid #ddd'
            // }
        }
    },
    created() {
        this.restList = this.getRestList
        this.getCategoryList();
    },
    updated() {
        this.restList = this.getRestList
        this.mapContainer()
    },
    mounted() {
        this.mapContainer()
    },
    computed: {
        getRestList() {
            return this.$store.getters.getRestList;
        },
        getSearchWord() {
            return this.$store.getters.getSearchWord;
        },
        getCurrentLoc() {
            return this.$store.getters.getCurrentLoc;
        },
    },
    methods: {
        calRestList() {
            const position = [];
            this.getRestList.forEach(item => {
                let param = {
                    title: item.rest_name,
                    latlng: new kakao.maps.LatLng(item.lat_y, item.lon_x),
                }
                position.push(param);
            })
            return position;
        },
        mapContainer() {
            const options = {
                center: new kakao.maps.LatLng(this.getCurrentLoc.lat, this.getCurrentLoc.lon),
                level: 5
            };

            const map = new kakao.maps.Map(this.$refs.mapDiv, options);
            // console.log(map)
            
            const position = this.calRestList();
            // console.log('dfjdjfkfj', position);
            
            // // 마커 이미지의 이미지 주소입니다
            const imageSrc = "https://www.svgrepo.com/show/130837/spoon.svg"; 
            // const imageSrc = "http://localhost/static/img/spoon-svgrepo-com.svg"; 
            
            // const iwRemoveable = true
            for(let i=0; i<position.length; i++) {
                // 마커 이미지의 이미지 크기 입니다
                const imageSize = new kakao.maps.Size(40, 50); 
                
                // 마커 이미지를 생성합니다    
                const markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, {offset: new kakao.maps.Point(27, 69)}); 
                
                // 마커를 생성합니다
                const marker = new kakao.maps.Marker({
                    // map: map, // 마커를 표시할 지도
                    position: position[i].latlng, // 마커를 표시할 위치
                    // title : position[i].title, // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
                    image : markerImage // 마커 이미지 
                });
                marker.setMap(map);

                const content = `<div style="z-index:3;position:relative;bottom:75px;">` +
                                    `<div style="display:block;text-align:center;border-radius:80px;border:2px solid #2B3F6B;background:#fff;padding:10px 15px;font-size:14px;font-weight:bold;">${position[i].title}</div>`+
                                `</div>`;
                const customOverlay = new kakao.maps.CustomOverlay({
                    map: map, // 인포윈도우가 표시될 지도
                    position : position[i].latlng, 
                    content : content,
                    // removable : iwRemoveable
                    // yAnchor: 1 
                });
                
                // infowindow.setMap(map, marker);
                // customOverlay.setMap(map, marker)
                // console.log(customOverlay)
            }
            const aaa = this.$refs.aaa
            console.log(aaa)
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
    },
}
    

</script>

<style scoped>
main { overflow-x: hidden; }
.aaa { margin: 0 auto; }
.bbb { overflow: scroll; overflow-x: hidden; }
.bold { font-weight: bold; }
img { border-radius: 10px; border: 1px solid #eee; }
/* .customoverlay {position:relative;bottom:85px;border-radius:80px;border: 1px solid #ccc;border-bottom:2px solid #ddd;} */
.customoverlay:nth-of-type(n) {border:0; box-shadow:0px 1px 2px #888;}
.customoverlay .title {display:block;text-align:center;background:#fff;padding:10px 15px;font-size:14px;font-weight:bold;}
.customoverlay::after {content:'';position:absolute;margin-left:-12px;left:50%;bottom:-12px;width:22px;height:12px;background:url('https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/vertex_white.png')}
</style>