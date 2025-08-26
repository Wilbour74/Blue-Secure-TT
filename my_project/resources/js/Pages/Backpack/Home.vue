<template>
  <div class="flex flex-col items-center justify-center min-h-screen text-center">
    <h1 class="text-3xl font-bold mb-6">Bienvenue sur mon application</h1>
    <p class="mb-4">Clique ci-dessous pour accéder à ton inventaire</p>
    
   <div>
      <button 
        @click="goToInventory" 
        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition"
      >
        Voir mon inventaire
      </button>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'


const goToInventory = () => {
  router.visit('/backpack/1')
}
</script>
