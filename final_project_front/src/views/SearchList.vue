<template>
    <main>
        <h3>{{ getSearchWord }}</h3>
        <br>
        <div class="d-flex column">
            <div  class="col-4">
                <div v-for="rest in getSearchList" :key="rest">
                    <div>가게이름 : {{ rest.name }}</div>
                    <div>가게주소 : {{ rest.address }}</div>
                    <div>카테고리 : {{ rest.category[0] }}</div>
                    <div>영업시간 : {{ rest.bizhourInfo }}</div>
                    <div>메뉴 : {{ rest.menuInfo }}</div>
                    <div>x : {{ rest.x }}</div>
                    <div>y : {{ rest.y }}</div>
                    <hr>
                </div>
            </div>
            <div ref="mapDiv" class="col-8" style="width:400px;height:400px;">{{ mapContainer }}</div>
        </div>
    </main>
</template>

<script>
export default {
    name: "SearchList",
    data() {
        return {
            // searchList: [],
            // searchWord: '',
            map: {}
        }
    },
    created() {
        // this.searchList = this.getSearchList
        // this.searchWord = this.getSearchWord
    },
    mounted() {
        this.mapContainer()
        console.log(this.$refs.mapDiv)
    },
    computed: {
        getSearchList() {
            return this.$store.getters.getSearchList;
        },
        getSearchWord() {
            return this.$store.getters.getSearchWord;
        },
        getCurrentLoc() {
            return this.$store.getters.getCurrentLoc;
        }
    },
    methods: {
        mapContainer() {
            const options = {
                center: new kakao.maps.LatLng(this.getCurrentLoc.lat, this.getCurrentLoc.lon),
                level: 5
            };

            const map = new kakao.maps.Map(this.$refs.mapDiv, options);
            console.log(map)
        },
    },
    
}
</script>

<style>

</style>