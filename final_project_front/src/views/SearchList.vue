<template>
    <main class="mt-5">
        <div class="container">
            <h3>{{ getSearchWord }}</h3>
            <h3></h3>
            <br>
            <div class="d-flex column pb-5">
                <div class="col-4 rlist scroll" style="width:40%;height:500px;">
                    <div v-for="rest in restList" :key="rest" ref="aaa">
                        <h5 class="bold">{{ rest.rest_name }}</h5>
                        <span v-if="rest.rating !== null"><router-link to="/Diary" class="link"> 나의 별점 {{ myRating(rest.rating) }}</router-link></span>
                        <div class="ms-3 me-3 d-flex column justify-content-start">
                            <div class="mt-3">
                                <div v-if="(rest.img_path === null) || (rest.img_path !== null && rest.img_path.indexOf('http://blogfiles.naver.net') !== -1)">
                                    <img class="basic" src="https://cdn.pixabay.com/photo/2015/09/13/21/13/dishes-938747_960_720.jpg">
                                </div>
                                <div v-else>
                                    <img class="basic" :src=rest.img_path>
                                </div>
                            </div>
    
                            <div class="ms-4 d-flex flex-column justify-content-center align-items-start">
                                <div class="d-flex justify-content-start align-items-start mt-3 mb-3"><img src="../assets/location.png" alt="주소"> <span class="ms-3 text-start">{{ rest.rest_address }}</span></div>
                                <div class="d-flex justify-content-start align-items-start "><img src="../assets/phone-call.png" alt="전화번호"> <span class="ms-3 text-start">{{ rest.tel }}</span></div>
                                <div class="d-flex justify-content-start align-items-start mt-3 mb-3"><img src="../assets/clock.png" alt="영업시간"> <span class="ms-3 text-start">{{ rest.open_close }}</span></div>   
                                <div class="btn-group">
                                    <button v-if="calMenuList(rest.irest)[0] != null" type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        메뉴
                                    </button>
                                    <ul class="dropdown-menu scrollable-menu scroll">
                                        <li class="menulist dropdown-item disabled" v-for="menu in calMenuList(rest.irest)" :key="menu">{{ menu }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div ref="mapDiv" class="col-8 aaa" style="width:50%;height:500px;"></div>
            </div>
                <div class="popover fade show bs-popover-end" role="tooltip" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(258px, 0px);" data-popper-placement="right">            
            </div>            
        </div>           
    </main>
</template>

<script>

export default {
    name: "SearchList",
    data() {
        return {
            restList: [],
            menuList: [],
            irest: 0
        }
    },
    
    created() {
        this.restList = this.getRestList
    },
    updated() {
        this.restList = this.getRestList
        this.mapContainer()
    },
    mounted() {
        this.mapContainer();
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
        user() {
            return this.$store.state.user;
        },
        getMenuList() {
            return this.$store.getters.getMenuList;
        }
    },
    methods: {
        myRating(rating) {
            switch(rating) {
                case 1: return rating = "⭐"
                case 2: return rating = "⭐⭐"
                case 3: return rating = "⭐⭐⭐"
                case 4: return rating = "⭐⭐⭐⭐"
                case 5: return rating = "⭐⭐⭐⭐⭐"
                default: return rating = ""
            }
        },
        calMenuList(irest) {
            // console.log(irest)
            const menu = []
            this.getMenuList.forEach(item => {
                if(item.irest === irest) {
                    menu.push(item.menu)
                }
            })
            // console.log(menu)
            
            return menu
        },
        calRestList() { //map에 쓸 position 가공
            const position = [];
            this.restList.forEach(item => {
                let param = {
                    title: item.rest_name,
                    latlng: new kakao.maps.LatLng(item.lat_y, item.lon_x),
                }
                position.push(param);
            })
            return position;
        },
        mapContainer() {    //지도 띄우는 곳
            const options = {
                center: new kakao.maps.LatLng(this.getCurrentLoc.lat, this.getCurrentLoc.lon),
                level: 5
            };
            const map = new kakao.maps.Map(this.$refs.mapDiv, options);            
            const position = this.calRestList();
            this.displayMarker(position, map);
        },
        displayMarker(position, map) {  //마커 띄우기
            const bounds = new kakao.maps.LatLngBounds();
            const markers = [];

            for(let i=0; i<position.length; i++) {
                const placePosition = position[i].latlng
                const marker = this.addMarker(placePosition)
                const item = this.getListItem(i)

                bounds.extend(placePosition);

                this.displayInfowindow(marker, position[i].title, item, map);
                markers.push(marker);
            }
            this.displayClusterer(map, markers);
        },
        displayClusterer(map, markers) {    //클러스터 띄우기
            const clusterer = new kakao.maps.MarkerClusterer({
                map: map, 
                averageCenter: true, 
                minLevel: 5,
                calculator: [10, 30, 50],
                styles: [
                    { // calculator 각 사이 값 마다 적용될 스타일을 지정한다
                            width : '30px', height : '30px',
                            textAlign:'center',
                            borderRadius: '50%',
                            border: '2px solid #2B3F6B',
                            background: 'rgba(255, 255, 255, 0.795)',
                            lineHeight: '31px'
                    },
                    {
                        width : '40px', height : '40px',
                        background: '#f7cab1dc',
                        textAlign: 'center',
                        fontWeight: 'bold',
                        lineHeight: '41px'
                    },
                    {
                        width : '50px', height : '50px',
                        background: 'rgba(255, 51, 204, .8)',
                        textAlign: 'center',
                        fontWeight: 'bold',
                        lineHeight: '51px'
                    },
                    {
                        width : '60px', height : '60px',
                        background: 'rgba(255, 80, 80, .8)',
                        textAlign: 'center',
                        fontWeight: 'bold',
                        lineHeight: '61px'
                    }
                ]
            });
            clusterer.addMarkers(markers)
        },
        displayInfowindow(marker, title, item, map) {   //마커 위에 정보창 띄우기
            const infowindow = new kakao.maps.InfoWindow({
                content: `<div>${title}</div>`
            });
            
            kakao.maps.event.addListener(marker, 'mouseover', function() {
                infowindow.open(map, marker)
            })
            kakao.maps.event.addListener(marker, 'mouseout', function() {
                infowindow.close()
            })

            item.onmouseover =  function() {
                infowindow.open(map, marker)
            };
            item.onmouseout =  function() {
                infowindow.close()
            };

        },
        getListItem(idx) {  //리스트 가져오기
            const list = this.$refs.aaa;
            const item = list[idx];

            return item
        },
        addMarker(latlng) {    //지도에 마커 등록
            const imageSrc = "https://www.svgrepo.com/show/130837/spoon.svg"; 
            const imageSize = new kakao.maps.Size(30, 50); 
            const markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize); 

            const marker = new kakao.maps.Marker({
                position: latlng, // 마커를 표시할 위치
                image : markerImage // 마커 이미지 
            });
            // marker.setMap(map);

            return marker;
        },
    },
}

</script>



<style scoped>
main { overflow: auto; overflow-x: hidden; }
.rlist { margin: 0 auto; }
.scroll { overflow: auto; overflow-x: hidden; }
.scroll::-webkit-scrollbar { width: 10px;  /* 스크롤바의 너비 */ }
.scroll::-webkit-scrollbar-thumb { background: #f26d38; /* 스크롤바의 색상 */ border-radius: 100px; }
.scroll::-webkit-scrollbar-track { background: #2b3f6b4a;  /*스크롤바 뒷 배경 색상*/ border-radius: 100px; }
.scrollable-menu {
    height: auto;
    max-height: 200px;
}
.bold { font-weight: bold; }
.basic { width:100px; height:100px; border-radius: 10px; object-fit: cover; }
.btn-danger { background-color: #2B3F6B; border: 1px solid #2B3F6B; }
.btn-danger:focus{ box-shadow: none; }
.menulist { border-bottom: 1px solid #eee; }
.menulist:last-child { border: none; padding-top: 5px; }
.link { text-decoration: none; color: #000; }
.link:hover { color: #000; }
.dropdown-item { z-index: 5; }
</style>