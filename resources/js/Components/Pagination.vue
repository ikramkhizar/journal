<script setup>
defineProps({
  links: Array
})
</script>

<template>
  <div>
    <Component
      :is="link.url ? 'Link' : 'span'"
      v-for="link in links"
      :href="link.url"
      v-html="link.label"
      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
      :class="{ 'bg-gray-200': link.active }"
    />
  </div>
</template>
