<script setup lang="ts">
import Title from '@/components/ui/typography/Title.vue'
import { useColorMode } from '@vueuse/core'

defineProps<{
  title: string
}>()

const mode = useColorMode()

mode.value = 'dark'
</script>
<template>
  <div class="w-[600px] mx-auto flex flex-col">
    <header class="w-full flex flex-col py-4">
      <Title>{{ title }}</Title>
      <slot name="header" />
    </header>
    <main>
      <slot />
    </main>
  </div>
</template>
