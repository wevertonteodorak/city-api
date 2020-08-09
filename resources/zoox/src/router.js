import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'Home',
      //component: Dashboard
      component: () => import('./components/Home.vue')
    },
    {
        path: '/cidade',
        name: 'Cidades',
        //component: Dashboard
        component: () => import('./components/Cidade/CidadeList.vue')
    },
    {
      path: '/estado',
      name: 'Estados',
      //component: Dashboard
      component: () => import('./components/Estado/EstadoList.vue')
    },
  ]
})
