
import Network from './components/NetworkComponent.vue'
import Affiliates from './components/AffiliateComponent.vue'
import Rede from './components/RedeComponent.vue'

export const routes = [
    { 
        path:'/network/:network',
        name: 'network',
        component:Rede
    },
    { 
        path:'/',
        component:Network
    },
 
 
];