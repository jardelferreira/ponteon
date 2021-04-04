<template>
  <json-view :data="data" />
</template>
<script>
export default {
    data(){
        return {
            data:{}
        }
    },
    created(){

        this.data = (this.$route.params.data.data)
    },
    
}
</script>