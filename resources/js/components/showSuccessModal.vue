<template>
  <div v-if="show" class="fixed inset-0 flex items-center justify-center z-50">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Modal -->
    <div class="relative bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center z-10">
      <!-- Check Icon -->
      <div class="flex justify-center mb-4">
        <img :src="'/icons/check.svg'" alt="Check Icon">
      </div>

      <!-- Title -->
      <h2 class="text-2xl font-bold text-green-600">SUCCESSFUL</h2>
      <p class="text-gray-700 mt-2">Appointment request sent</p>

      <!-- Message -->
      <p class="mt-4 text-gray-600">
        Thanks for scheduling with us! We’re looking forward to seeing you soon.
        <br />
        <span class="font-medium">Check your email for the appointment code</span>
      </p>

      <!-- Close Button -->
      <button
        @click="$emit('close')"
        class="mt-6 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700"
      >
        OK
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  show: Boolean
})
</script>
