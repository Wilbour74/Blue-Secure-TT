<template>
  <div>
    <h1>Mon sac à dos</h1>

    <BackpackTable
      :items="backpack.items"
      :loading-id="loadingId"
      @use-item="useItem"
    />

    <div v-if="apiResponse">
      <p>{{ apiResponse }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import BackpackTable from '@/Components/BackpackTable.vue'
import axios from 'axios'

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
</script>
