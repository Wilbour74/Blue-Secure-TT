<template>
  <form @submit.prevent="submitForm" 
      class="w-1/2 mx-auto mt-10 space-y-3 rounded-lg border-2 border-dashed border-indigo-200 p-6 mb-6"
      >
  <div class="text-center">
    <h2 class="text-lg font-bold ">Ajouter un objet au Sac à Dos</h2>
  </div>
  <div>
    <label class="">Nom</label>
    <input 
      type="text" 
      v-model="form.name" 
      required 
      class="w-full border px-2 py-1"
    />
  </div>

  <div>
    <label class="">Type</label>
    <select v-model="form.type" required class="w-full border px-2 py-1">
      <option v-for="t in types" :key="t" :value="t">{{ t }}</option>
    </select>
  </div>

  <div class="flex gap-2">
    <div class="flex-1">
      <label class="">Poids (kg)</label>
      <input type="number" v-model.number="form.weight" min="0" step="0.01" required 
             class="w-full border px-2 py-1 text-center"/>
    </div>
    <div class="flex-1">
      <label class="">Volume (L)</label>
      <input type="number" v-model.number="form.volume" min="0" step="0.01" required 
             class="w-full border px-2 py-1 text-center"/>
    </div>
  </div>

  <div>
    <p class="text-xs text-center ">Un seul champ à remplir (ou aucun)</p>
    <p class="text-xs text-center">(Gourde = CL) , (Couteau, Briquet = Usure) , (Sac de couchage, Carte, Boussole = Rien), (Reste = Quantité)</p>
    <div class="flex gap-2 mt-2 justify-between">

      <input type="number" v-model.number="form.quantity" min="1" placeholder="Qté"
             :disabled="form.wear !== null || form.quantity_cl !== null"
             class="w-1/3 border px-2 py-1 text-center"/>

      <input type="number" v-model.number="form.wear" min="0" placeholder="Usure"
             :disabled="form.quantity !== null || form.quantity_cl !== null"
             class="w-1/3 border px-2 py-1 text-center"/>

      <input type="number" v-model.number="form.quantity_cl" min="0" placeholder="CL"
             :disabled="form.quantity !== null || form.wear !== null"
             class="w-1/3 border px-2 py-1 text-center"/>
    </div>
    <div class="text-xs text-center mt-1">
      <button type="button" @click="resetForm" class="underline ">Réinitialiser les champs</button>
    </div>
  </div>

    <div class="flex justify-center">
        <button type="submit" class="border py-1 px-4 rounded bg-indigo-600  hover:bg-indigo-700">
            Ajouter
        </button>
    </div>
</form>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'
import { defineEmits } from 'vue'

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

// Logique pour que si un champ est rempli, les autres se désactivent
function resetForm() {
  form.quantity = null;
  form.wear = null;
  form.quantity_cl = null;
}

const emit = defineEmits(['add'])

const response = ref(null)

function submitForm() {
  axios.post('/api/item/add/1', form)
    .then(response => {
      emit('add', response.data)
      response.value = response.data
      // Reset du formulaire si besoin
      form.name = ''
      form.type = types[0]
      form.description = ''
      form.quantity = 1
      form.wear = 0
      form.quantity_cl = null
      form.weight = null
      form.volume = null
      router.reload({ only: ['backpack'] })
    })
    .catch(
     response.value = "Erreur"
    )
}
</script>
