<template>
  <div>
    <Head>
      <title>Mon sac à dos</title>
    </Head>
    <BackpackTable
      :items="backpack.items"
      :loading-id="loadingId"
      @use-item="useItem"
      @delete-item="deleteItem"
    />

    <div class="flex justify-center mt-8 mb-8">
      <button @click="emptyBackpack(backpack.id)" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 disabled:opacity-50">Vider le sac</button>
    </div>
    <div class="text-center mt-8">
      <p>
        Poids du Sac : <strong>{{ backpack.weight }}</strong> kg,
        Poids Maximal : <strong>{{ backpack.max_weight }}</strong> kg,
        Volume du sac : <strong>{{ backpack.volume }}</strong> L,
        Volume Maximal : <strong>{{ backpack.max_volume }}</strong> L,
        <strong>{{ backpack.items.length }}</strong> objets dans le sac
      </p>
    
    </div>
    <div v-if="apiResponse" class="flex justify-center mt-6 p-2 min-w-screen">
      <h1>Réponse de l'api : <strong>{{ apiResponse }}</strong></h1>
    </div>
    <div v-else class="flex justify-center mt-6">
      <p style="visibility:hidden">Pour garder l'espace</p>
    </div>

        <AddItemForm @submitted="handleResponse"/>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import BackpackTable from '@/Components/BackpackTable.vue'
import axios from 'axios'
import AddItemForm from '@/Components/AddItemForm.vue'
import { Head } from '@inertiajs/vue3';
const props = defineProps({
  backpack: Object,
})


const apiResponse = ref(null)
const loadingId = ref(null)

function useItem(itemId, amount = 1) {
  loadingId.value = itemId
  axios.patch(`/api/item/use/${itemId}`, { amount })
    .then((response) => {
      console.log(response.data)
      apiResponse.value = response.data.result
      router.reload({ only: ['backpack'] })
    })
    .finally(() => {
      loadingId.value = null
    })
}

function deleteItem(itemId) {
  loadingId.value = itemId
  axios.delete(`/api/item/${itemId}`)
    .then((response) => {
      console.log(response.data)
      apiResponse.value = response.data.message
      router.reload({ only: ['backpack'] })
    })
    .finally(() => {
      loadingId.value = null
    })
}

function emptyBackpack(itemId) {
  loadingId.value = itemId
  axios.delete(`/api/backpack/empty/${itemId}`)
    .then((response) => {
      console.log(response.data)
      apiResponse.value = response.data.message
      router.reload({ only: ['backpack'] })
    })
    .finally(() => {
      loadingId.value = null
    })
}

function handleResponse(data) {
  console.log(data)
  apiResponse.value = data.message
  router.reload({ only: ['backpack'] })

}
</script>

