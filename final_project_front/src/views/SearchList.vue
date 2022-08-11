<template>
    <main>
        <h3>{{ getSearchWord }}</h3>
        <h3></h3>
         
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
                            <div>전화번호 : {{ rest.tel }}</div>
                            <div>영업시간 : {{ rest.open_close }}</div>   
                            <button type="button" class="btn btn-danger" @click="calMenuList(rest.irest)" data-bs-toggle="popover" data-bs-placement="right" :data-bs-content="calMenuList(rest.irest)">메뉴</button>                         
                            <div v-if="user.email !== null"></div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div ref="mapDiv" class="col-8 aaa" style="width:50%;height:500px;"></div>
        </div>
            <div class="popover fade show bs-popover-end" role="tooltip" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(258px, 0px);" data-popper-placement="right">            
        </div>            
    </main>
</template>

<script>



export default {
    name: "SearchList",
    data() {
        return {
            restList: [],
            menuList: []
        }
    },
    
    created() {
        this.restList = this.getRestList
        // this.menuList = this.getMenuList
    },
    updated() {
        this.restList = this.getRestList
        // this.menuList = this.getMenuList
        this.mapContainer()
    },
    mounted() {
        this.mapContainer();

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
        // const popoverBody2 = document.querySelector('.popover-body');
        // popoverBody2.innerHTML = `<div>dddd</div>`;
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
        calMenuList(irest) {
            console.log(irest)
            const menu = []
            this.getMenuList.forEach(item => {
                if(item.irest === irest) {
                    const list = {
                        menu: item.menu
                    }
                    menu.push(list)
                }
            })
            console.log(menu)
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
main { overflow-x: hidden; }
.aaa { margin: 0 auto; }
.bbb { overflow: scroll; overflow-x: hidden; }
.bold { font-weight: bold; }
img { border-radius: 10px; border: 1px solid #eee; }
.btn-danger { background-color: #2B3F6B; border: 1px solid #2B3F6B; }
</style>