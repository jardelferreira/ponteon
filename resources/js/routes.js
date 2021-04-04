
import Network from './components/NetworkComponent.vue'
import Affiliates from './components/AffiliateComponent.vue'

export const routes = [
    { 
        path:'/network/:network',
        name: 'network',
        component:Affiliates
    },
    { 
        path:'/',
        component:Network
    },
 
 
];