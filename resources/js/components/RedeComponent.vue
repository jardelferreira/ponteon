<template>
<ul>
    <li v-for="filiate in filiates" :key="filiate.id" v-bind:value="filiate.id">
        {{filiate}}
       
    </li>
</ul>
</template>
<script>
export default {
    name: 'rede-component',
    data(){
        return {
            filiates:{}
        }
    },
    created(){

        this.filiates = (this.$route.params.data.data)
    },
    methods:{
        hasFiliate(data){
            debugger
            return data.isArray();
        }

    }
    
}
</script>