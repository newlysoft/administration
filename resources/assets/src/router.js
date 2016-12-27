import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard'
import Debug from './components/pages/Debug'
import Layout from './components/layouts/Layout'
import Mail from './components/pages/Mail'
import Seo from './components/pages/Seo'
import Upload from './components/pages/Upload'
import Setting from './components/pages/Setting'

Vue.use(VueRouter)

export default new VueRouter({
  mode: 'hash',
  routes: [
    {
      path: '/',
      component: Layout,
      children: [
        {
          path: '/',
          component: Dashboard
        },
        {
          path: '/setting',
          component: Setting
        },
        {
          path: '/upload',
          component: Upload
        },
        {
          path: '/storage',
          component: Upload
        },
        {
          path: '/seo',
          component: Seo
        },
        {
          path: '/email',
          component: Mail
        },
        {
          path: '/debug',
          component: Debug
        }
      ]
    }
  ]
})
