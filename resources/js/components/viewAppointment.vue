<script setup>
import AppointmentSidebar from './appointmentSidebar.vue'
</script>

<template>
  <div class="container mx-auto py-12">

    <header class="mb-8">
      <h1 class="text-3xl font-bold text-dark">VIEW APPOINTMENT</h1>
    </header>
            <p class="text-center font-medium mb-10 ml-12 indent-[135px]">
                To view, cancel, or reschedule your appointment, please enter your appointment<br>
                code and email address. Then, click the "View details" button.
            </p>
    <div class="flex flex-col lg:flex-row gap-8 mb-12">

      <AppointmentSidebar />

      <main class="w-full lg:w-3/4 font-medium bg-white pl-[100px]">


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 mt-8">
          <div>
            <label class="block text-base font-semibold mb-3">Appointment Code</label>
            <input type="text" placeholder="Enter Code"
                   class="w-3/4 px-4 py-3 border border-black rounded-lg focus:ring-teal-500 focus:border-teal-500"/>
          </div>
        </div>

        <!-- Button -->
        <div class="flex justify-start pt-[80px]">
          <button
            class="bg-dark text-white px-6 py-1 rounded-full hover:bg-neutral transition">
            VIEW DETAILS
          </button>
        </div>
      </main>
    </div>
  </div>
</template>
