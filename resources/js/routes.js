import Accueil from './components/accueil.vue';
import ViewProducers from "./components/Producteurs/ViewProducers.vue"
import AddProducers from "./components/Producteurs/AddProducers.vue"
import ViewActeurs from "./components/Acteurs/ViewActeurs.vue"
import ViewFilms from "./components/Films/ViewFilms.vue"
import Panier from './components/Cart/Panier.vue';
import EventsHomeCart from './components/Cart/EventsHomeCart.vue';
export const routes = [
    {
    name: 'accueil',
    path: '/',
    component: Accueil
    },
    {
    name:"ViewProducers",
    path:"/ViewProducers",
    component: ViewProducers
    },
    {
    name: "AddProducers",
    path: "/AddProducers",
    component: AddProducers
    },
     {
        name: "ViewActeurs",
         path: "/ViewActeurs",
         component: ViewActeurs
    },
    {
        name: "ViewFilms",
        path: "/ViewFilms",
        component: ViewFilms
    },
    {
        path: '/Panier',
        name: 'Panier',
        component: Panier
    },
    {
        path: '/EventsHomeCart',
        name: 'EventsHomeCart',
        component: EventsHomeCart
    },
];
