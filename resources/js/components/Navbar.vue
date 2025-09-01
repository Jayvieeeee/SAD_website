<template>
  <header class="bg-white shadow-sm">
    <div class="container mx-auto flex justify-between items-center py-2 px-4">
      
      <div class="flex items-center space-x-2">
       <img :src="'/images/logo.svg'" alt="logo" class="h-[80px]">
      </div>

      <nav class="hidden md:flex space-x-10 font-semibold text-black">
        <router-link to="/" class="hover:text-dark">HOME</router-link>
        <router-link to="/#services" class="hover:text-dark">OUR SERVICES</router-link>
        <router-link to="/#faqs" class="hover:text-dark">FAQs</router-link>
        <router-link to="/#testimonials" class="hover:text-dark">TESTIMONIALS</router-link>
        <router-link to="/#contact" class="hover:text-dark">CONTACT US</router-link>
      </nav>


      <router-link 
      to="/appointment" 
      class="hidden md:block bg-dark text-white px-6 py-3 rounded-full font-semibold hover:bg-gray-800 transition">
      BOOK AN<br> APPOINTMENT
      </router-link>
    </div>
  </header>
</template>

