<script setup>
import { defineProps, defineEmits } from 'vue'
import Appointment from './Appointment.vue'
import viewAppointment from './viewAppointment.vue'

const props = defineProps({
  activeBtn: String
})

const emit = defineEmits(['update:active-btn'])

const setActive = (btn) => {
  emit('update:active-btn', btn)
}
</script>

<template>
           <!-- sidebar -->
            <aside class="w-full lg:w-1/4 bg-neutral shadow-lg rounded-r-3xl p-6 h-fit">
                <h2 class="text-lg font-bold text-white mb-6">Appointment</h2>
                <nav class="space-y-2">
                    <router-link to="appointment"
                         class="w-full text-left px-4 py-3 font-medium flex items-center appointment-btn transition text-gray-400 hover:text-white"
                         active-class="text-white">
                        <img :src="'/icons/calendar_clock.png'" alt="Calendar" class="h-5 w-5 mr-3">
                        Schedule Appointment
                    </router-link>

                     <div class="my-10 border-t-2 border-white w-full mx-auto"></div>

                    <router-link to="/viewAppointment"
                         class="w-full text-left px-4 py-3 font-medium flex items-center appointment-btn transition text-gray-400 hover:text-white"
                         active-class="text-white">
                        <img :src="'/icons/calendar.png'" alt="View" class="h-5 w-5 mr-3">
                        View Appointment
                    </router-link>
                </nav>
            </aside>
</template>