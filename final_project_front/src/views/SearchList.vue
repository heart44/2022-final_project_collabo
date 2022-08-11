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
                            <div v-if="user.email !== null"></div>
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
            menuList: []
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
        user() {
            return this.$store.state.user;
        },
    },
    methods: {
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
            const clusterer = new kakao.maps.MarkerClusterer({
                map: map, // 마커들을 클러스터로 관리하고 표시할 지도 객체 
                averageCenter: true, // 클러스터에 포함된 마커들의 평균 위치를 클러스터 마커 위치로 설정 
                minLevel: 5 // 클러스터 할 최소 지도 레벨 
            });
            clusterer.addMarkers(markers)
        },
        displayInfowindow(marker, title, item, map) {   //마커 위에 정보창 띄우기
            const infowindow = new kakao.maps.InfoWindow({
                content: `<div>${title}</div>`
            });
            
            // const content = `<div style="display:block;text-align:center;border-radius:80px;border:2px solid #2B3F6B;background:#fff;padding:10px 15px;">${title}</div>`;
            // const overlay = new kakao.maps.CustomOverlay({
            //     content: content,
            //     position: marker     
            // });
            
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
</style>