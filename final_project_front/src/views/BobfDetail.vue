<template>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-6">
                    🧡💛💚💙💜🤎🖤🤍
                </div>
                <div class="col-md-6">
                    🤍🖤🤎💜💙💚💛🧡
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    created() {
        this.getIbobF()
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
        bobfDetailInfo() {
            return this.$store.state.bobfDetailInfo;
        }
    },
    component: {
    },
    methods: {
        getIbobF() {
            console.log(this.$route.params)
        }
        
    },
}
</script>

<style>
</style>