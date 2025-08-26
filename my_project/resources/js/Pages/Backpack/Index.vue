<template>
  <div>

    <BackpackTable
      :items="backpack.items"
      :loading-id="loadingId"
      @use-item="useItem"
      @delete-item="deleteItem"
    />
    <div class="text-center mt-8">
      <p>
        Poids du Sac : {{ backpack.weight }} kg,
        Poids Maximal : {{ backpack.max_weight }} kg,
        Volume du sac : {{ backpack.volume }} L,
        Volume Maximal : {{ backpack.max_volume }} L,
      </p>
    </div>

    <div v-if="apiResponse" class="flex justify-center mt-6 p-2 min-w-screen">
      <h1>Réponse de l'api : <strong>{{ apiResponse }}</strong></h1>
    </div>
    <div v-else class="flex justify-center mt-6">
      <p style="visibility:hidden">Pour garder l'espace</p>
    </div>

        <AddItemForm />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import BackpackTable from '@/Components/BackpackTable.vue'
import axios from 'axios'
import AddItemForm from '@/Components/AddItemForm.vue'

const props = defineProps({
  backpack: Object
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
</script>

