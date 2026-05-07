<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(defineProps<{
  active?: boolean
}>(), {
  active: false
})

const style = computed(() => ({
  'border-primary': props.active,
  'border-transparent hover:border-white/10': !props.active
}))
</script>
<template>
  <div class="w-full p-6 flex flex-col gap-6 rounded-xl bg-[#1A1E27] border transition" :class="[style]">
    <slot />
  </div>
</template>
