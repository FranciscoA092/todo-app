<script setup lang="ts">
import { Plus } from 'lucide-vue-next'

defineProps<{
  label: string
}>()
</script>
<template>
  <div
    class="w-full flex items-center justify-center p-6 rounded-lg bg-[linear-gradient(45deg,#1A1E27_25%,transparent_25%,transparent_50%,#1A1E27_50%,#1A1E27_75%,transparent_75%,transparent)] bg-[length:20px_20px] transition cursor-pointer group"
  >
    <div class="flex items-center gap-2">
      <Plus class="size-6 group-hover:text-primary" />
      <span class="font-semibold group-hover:text-primary">{{ label }}</span>
    </div>
  </div>
</template>
