import { createRouter, createWebHistory } from 'vue-router'
import LandingPage from '../components/LandingPage.vue'
import Appointment from '../components/Appointment.vue'
import ViewAppointment from '../components/viewAppointment.vue'

const routes = [
  { path: '/', name: 'Home', component: LandingPage },
  { path: '/appointment', name: 'Appointment', component: Appointment },
  { path: '/viewAppointment', name: 'ViewAppointment', component: ViewAppointment}
]

const router = createRouter({
  history: createWebHistory(),
  routes,

  // 👇 add scroll behavior
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      // back/forward button
      return savedPosition
    } else if (to.hash) {
      // scroll to anchors like #services
      return {
        el: to.hash,
        behavior: 'smooth'
      }
    } else {
      // default scroll to top
      return { top: 0 }
    }
  }
})

export default router
