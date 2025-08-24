<template>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Quantité</th>
                <th>Quantité_CL</th>
                <th>Usure</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.description || '-' }}</td>
                <td>{{ item.quantity ?? '-' }}</td>
                <td>{{ item.quantity_cl ?? '-' }}</td>
                <td>{{ item.wear ?? '-' }}</td>
                <td>
                <input
                    type="number"
                    v-model.number="amounts[item.id]"
                    min="1"
                />
                <button :disabled="loadingId === item.id" @click="$emit('use-item', item.id, amounts[item.id] || 1)">
                    {{ loadingId === item.id ? '...' : 'Utiliser' }}
                </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
    import { reactive } from "vue"

    const props = defineProps({
        items: Array,
        loadingId: [Number, null]
    })

    const amounts = reactive({})
</script>