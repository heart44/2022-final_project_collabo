<template>
    <div>
        {{user}}
        {{bobfDetailInfo}}
        <div>
            ^^
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
        bobfDetailInfo() {
            return this.$store.state.bobfDetailInfo;
        }
    },
}
</script>

<style>
</style>