<template>
    <div class="flex flex-col items-center mt-6 w-full px-2">
        <h2 class="text-2xl font-bold mb-4 text-center">Mon sac à dos</h2>

            <div class="overflow-x-auto w-full">
                <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                    <th class="px-3 py-2 text-center border-b border-gray-300">Type</th>
                    <th class="px-3 py-2 text-center border-b border-gray-300">Nom</th>
                    <th class="px-3 py-2 text-center border-b border-gray-300">Description</th>
                    <th class="px-3 py-2 text-center border-b border-gray-300">Quantité</th>
                    <th class="px-3 py-2 text-center border-b border-gray-300 hidden sm:table-cell">Quantité_CL</th>
                    <th class="px-3 py-2 text-center border-b border-gray-300 hidden sm:table-cell">Usure</th>
                    <th class="px-3 py-2 text-center border-b border-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item.id" class="hover:bg-gray-50">
                    <td class="px-3 py-2 text-center border-b border-gray-200">{{ item.type }}</td>
                    <td class="px-3 py-2 text-center border-b border-gray-200">{{ item.name }}</td>
                    <td class="px-3 py-2 text-center border-b border-gray-200">{{ item.description || '-' }}</td>
                    <td class="px-3 py-2 text-center border-b border-gray-200">{{ item.quantity ?? '-' }}</td>
                    <td class="px-3 py-2 text-center border-b border-gray-200 hidden sm:table-cell">{{ item.quantity_cl ?? '-' }}</td>
                    <td class="px-3 py-2 text-center border-b border-gray-200 hidden sm:table-cell">{{ item.wear ?? '-' }}</td>
                    <td class="px-3 py-2 text-center border-b border-gray-200 flex items-center justify-center gap-2">
                        <input
                        type="number"
                        v-model.number="amounts[item.id]"
                        min="1"
                        class="w-16 px-2 py-1 border rounded text-center focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        />
                        <button
                        :disabled="loadingId === item.id"
                        @click="$emit('use-item', item.id, amounts[item.id] || 1)"
                        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50"
                        >
                        {{ loadingId === item.id ? '...' : 'Utiliser' }}
                        </button>
                        <button
                        :disabled="loadingId === item.id"
                        @click="$emit('delete-item', item.id)"
                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 disabled:opacity-50"
                        >
                        {{ loadingId === item.id ? '...' : 'Supprimer' }}
                        </button>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
    </div>



</template>

<script setup>
    import { reactive } from "vue"

    const props = defineProps({
        items: Array,
        loadingId: [Number, null]
    })

    const amounts = reactive({})
</script>