<template>
  <form @submit.prevent="submitForm" 
      class="w-1/2 mx-auto mt-10 space-y-3">

  <div>
    <label>Nom</label>
    <input 
      type="text" 
      v-model="form.name" 
      required 
      class="w-full border px-2 py-1"
    />
  </div>

  <div>
    <label>Type</label>
    <select v-model="form.type" required class="w-full border px-2 py-1">
      <option v-for="t in types" :key="t" :value="t">{{ t }}</option>
    </select>
  </div>

  <div class="flex gap-2">
    <div class="flex-1">
      <label>Poids (kg)</label>
      <input type="number" v-model.number="form.weight" min="0" step="0.01" required 
             class="w-full border px-2 py-1 text-center"/>
    </div>
    <div class="flex-1">
      <label>Volume (L)</label>
      <input type="number" v-model.number="form.volume" min="0" step="0.01" required 
             class="w-full border px-2 py-1 text-center"/>
    </div>
  </div>

  <div>
    <p class="text-xs text-center">Un seul champ à remplir (ou aucun)</p>
    <div class="flex gap-2 mt-2 justify-between">
      <input type="number" v-model.number="form.quantity" min="1" placeholder="Qté"
             class="w-1/3 border px-2 py-1 text-center"/>
      <input type="number" v-model.number="form.wear" min="0" placeholder="Usure"
             class="w-1/3 border px-2 py-1 text-center"/>
      <input type="number" v-model.number="form.quantity_cl" min="0" placeholder="CL"
             class="w-1/3 border px-2 py-1 text-center"/>
    </div>
  </div>

  <button type="submit" class="w-full border py-1">
    Ajouter
  </button>
</form>



  <div v-if="response">
    <p>{{ response }}</p>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

// Tableau des types disponibles
const types = ['Gourde', 'Couteau', 'Boussole', 'Trousse', 'Briquet', 'Carte', 'Rations', 'SacDeCouchage', 'Amadou', 'MateriauxTorche']

const form = reactive({
  type: types[0],
  name: '',
  weight: 0,
  volume: 0,
  quantity_cl: null,
  quantity: null,
  wear: null
})

const response = ref(null)

function submitForm() {
  axios.post('/api/item/add/1', form)
    .then(res => {
      response.value = res.data
      // Reset du formulaire si besoin
      form.name = ''
      form.type = types[0]
      form.description = ''
      form.quantity = 1
      form.wear = 0
      form.quantity_cl = null
      form.weight = 0
      form.volume = 0
      router.reload({ only: ['backpack'] })
    })
    .catch(err => {
      response.value = err.response?.data || err.message
    })
}
</script>
