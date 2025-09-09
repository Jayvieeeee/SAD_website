<script setup>
import { ref } from 'vue'
import api from '../axios.js'
import AppointmentSidebar from './appointmentSidebar.vue'
import DateTimeModal from './DateTimeModal.vue'
import { useValidation } from '../composables/useValidation.js'
import SuccessModal from './showSuccessModal.vue'
import dayjs from "dayjs";

const activeBtn = ref("schedule")
const setActive = (btn) => { activeBtn.value = btn }

const showDateTimeModal = ref(false)
const showSuccessModal = ref(false)
// date & time selection
const selectedDate = ref('')
const selectedTime = ref('')
const selectedTimeLabel = ref('')

// form data
const firstName = ref("")
const lastName = ref("")
const email = ref("")
const contactNo = ref("")
const selectedServices = ref([])


// validation rules
const { errors, validate } = useValidation({
  firstName: [(v) => !!v || "First name is required"],
  lastName: [(v) => !!v || "Last name is required"],
  email: [
    (v) => !!v || "Email is required",
    (v) => /\S+@\S+\.\S+/.test(v) || "Invalid email",
  ],
  contactNo: [(v) => !!v || "Contact number is required"],
  schedule: [(v) => !!v || "Please select a date and time"],
  selectedServices: [
    (v) => (Array.isArray(v) && v.length > 0) || "Please select at least one service",
  ],
})


const submit = async () => {
  const isValid = validate({
    firstName: firstName.value,
    lastName: lastName.value,
    email: email.value,
    contactNo: contactNo.value,
    schedule: selectedDate.value && selectedTime.value,
    selectedServices: selectedServices.value,
  });

  if (!isValid) return;

  try {
    await api.post('/appointments', {
      first_name: firstName.value,
      last_name: lastName.value,
      email: email.value,
      contact_no: contactNo.value,
      schedule_datetime: dayjs(`${selectedDate.value} ${selectedTime.value}`).format("YYYY-MM-DD HH:mm:ss"),
      services: selectedServices.value,
    });

    console.log("Booking success");
    showSuccessModal.value = true;
  } catch (err) {
    console.error("Error:", err.response?.data || err);
  }
};
</script>


<template>
 <div class="container mx-auto py-8">
        <!-- header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-dark flex justify-start">SCHEDULE APPOINTMENT</h1>
        </header>

            <!-- main -->
        <div class="flex flex-col lg:flex-row gap-8">
                    <!-- sidebar -->
                    <AppointmentSidebar 
                    :active-btn="activeBtn" 
                    @update:active-btn="setActive" 
                    />
            <main class="w-full lg:w-3/4 bg-white ml-20 p-6">
                <!-- personal Info Section -->
                <section class="mb-8">
                  <h2 class="text-xl font-bold text-teal-700 mb-4">Personal Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                    <input v-model="firstName" type="text" placeholder="Enter first name" name="firstName"
                        class="w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-neutral focus:border-neutral" />
                        <p v-if="errors.firstName" class="text-red-500 text-sm">{{ errors.firstName }}</p>
                    </div>
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                    <input v-model="email" type="email" placeholder="Enter email" name="email"
                        class="w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-neutral focus:border-neutral" />
                        <p class="text-xs text-gray-500 mt-1">Gmail only</p>
                        <p v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                    <input type="text" placeholder="Enter middle name" name="middleName"
                        class="w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-neutral focus:border-neutral" />
                        <p v-if="errors.middleName" class="text-red-500 text-sm">{{ errors.middleName }}</p>
                    </div>
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number *</label>
                    <input v-model="contactNo" type="tel" placeholder="Enter number" name="contactNo"
                        class="w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-neutral focus:border-neutral" />
                        <p class="text-xs text-gray-500 mt-1">09 (11 digits)</p>
                        <p v-if="errors.contactNo" class="text-red-500 text-sm">{{ errors.contactNo }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                    <input v-model="lastName" type="text" placeholder="Enter last name" name="lastName"
                        class="w-3/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-neutral focus:border-neutral" />
                         <p v-if="errors.lastName" class="text-red-500 text-sm">{{ errors.lastName }}</p>
                    </div>
                </div>
                </section>


                <!-- Dental Service Section -->
                <section>
                    <h2 class="text-lg font-semibold mb-4">Dental Service</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- General Dentistry -->
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">General Dentistry</h3>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input :value="1" v-model="selectedServices" type="checkbox" id="mouth-exam" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="mouth-exam" class="font-semibold ml-2 block text-sm">Mouth Examination</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="2" v-model="selectedServices" type="checkbox" id="cleaning" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="cleaning" class="font-semibold ml-2 block text-sm">Oral Prophylaxis (Cleaning)</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Restorative Care -->
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">Restorative Care</h3>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input :value="3" v-model="selectedServices" type="checkbox" id="tooth-restoration" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="tooth-restoration" class="font-semibold ml-2 block text-sm">Tooth Restoration (Pasta)</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="4" v-model="selectedServices" type="checkbox" id="tooth-extraction" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="tooth-extraction" class="font-semibold ml-2 block text-sm">Tooth Extraction</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cosmetic Dentistry -->
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">Cosmetic Dentistry</h3>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input :value="5" v-model="selectedServices" type="checkbox" id="veneers" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="veneers" class="font-semibold ml-2 block text-sm">Dental Veneers</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="6" v-model="selectedServices" type="checkbox" id="whitening" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="whitening" class="font-semibold ml-2 block text-sm">Teeth Whitening</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="7" v-model="selectedServices" type="checkbox" id="crowns" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="crowns" class="font-semibold ml-2 block text-sm">Crowns and Bridges</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Replacing and Repairing -->
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">Replacing and Repairing</h3>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input :value="8" v-model="selectedServices" type="checkbox" id="partial-denture" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="partial-denture" class="font-semibold ml-2 block text-sm">Partial Denture</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="9" v-model="selectedServices" type="checkbox" id="complete-denture" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="complete-denture" class="font-semibold ml-2 block text-sm">Complete Denture</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="10" v-model="selectedServices" type="checkbox" id="root-canal" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="root-canal" class="font-semibold ml-2 block text-sm">Root Canal Treatment</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="11" v-model="selectedServices" type="checkbox" id="wisdom-tooth" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="wisdom-tooth" class="font-semibold ml-2 block text-sm">Wisdom Tooth Removal</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dental X-Ray -->
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">Dental X-Ray</h3>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input :value="12" v-model="selectedServices" type="checkbox" id="panoramic" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="panoramic" class="font-semibold ml-2 block text-sm">Digital Panoramic x-ray</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="13" v-model="selectedServices" type="checkbox" id="cephalometric" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="cephalometric" class="font-semibold ml-2 block text-sm">Digital Cephalometric x-ray</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="14" v-model="selectedServices" type="checkbox" id="tmj" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="tmj" class="font-semibold ml-2 block text-sm">TMJ x-ray</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="15" v-model="selectedServices" type="checkbox" id="periapical" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="periapical" class="font-semibold ml-2 block text-sm">Periapical x-ray</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Orthodontics -->
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">Orthodontics</h3>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input :value="16" v-model="selectedServices" type="checkbox" id="metal-braces" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="metal-braces" class="font-semibold ml-2 block text-sm">Metal Braces</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="17" v-model="selectedServices" type="checkbox" id="ceramic-braces" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="ceramic-braces" class="font-semibold ml-2 block text-sm">Ceramic Braces</label>
                                </div>
                                <div class="flex items-center">
                                    <input :value="18" v-model="selectedServices" type="checkbox" id="swlf-braces" name="selectedServices" class="h-4 w-4 text-dark focus:ring-neutral border-gray-300 rounded">
                                    <label for="swlf-braces" class="font-semibold ml-2 block text-sm">SWLF Braces</label>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- error message -->
                    <p v-if="errors.selectedServices" class="text-red-500 text-sm mt-2">
                      {{ errors.selectedServices }}
                    </p>
                </section>

            </main>
        </div>  
         </div>

      <div class="p-8 mb-10">
      <h2 class="text-xl font-bold text-dark mb-6 mr-60 text-center">Date and Time</h2>

      <div class="flex justify-between items-center">
        <!-- Center button -->
        <div class="flex-1 flex justify-center">
          <button 
            @click="showDateTimeModal = true"
            class="bg-neutral px-6 py-2 rounded-full hover:bg-dark transition">
            Choose available slots
          </button>
        </div>

        <!-- Right button -->
        <button
          @click="submit"
          class="bg-dark text-white px-6 py-1 mr-20 rounded-full hover:bg-neutral transition">
          SUBMIT
        </button>
      </div>
    </div>

    <!--success modal-->
    <SuccessModal
      v-model="showSuccessModal"
      message="Appointment booked successfully!"
    />

<!-- Modal -->
     <DateTimeModal
      v-model="showDateTimeModal"
      v-model:selectedDate="selectedDate"
      v-model:selectedTime="selectedTime"
      v-model:selectedTimeLabel="selectedTimeLabel"
    />

</template>
