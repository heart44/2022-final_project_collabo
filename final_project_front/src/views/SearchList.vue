<template>
    <main>
        <div>
            <h3>{{ getSearchWord }}</h3>
            {{ getSearchList }}
            <div v-for="rest in getSearchList" :key="rest">
                <div>{{ rest.name }}</div>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "SearchList",
    data() {
        return {
            searchList: {},
            searchWord: ''
        }
    },
    created() {
        // this.searchList = this.getSearchList
        // this.searchWord = this.getSearchWord
    },
    computed: {
        getSearchList() {
            return this.$store.getters.getSearchList;
        },
        getSearchWord() {
            return this.$store.getters.getSearchWord;
        }
    },
    watch: {

    }
}
</script>

<style>

</style>