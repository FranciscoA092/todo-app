<script setup lang="ts">
import CardBox from '@/components/ui/box/CardBox.vue'
import Skeleton from '@/components/ui/skeleton/Skeleton.vue'
</script>
<template>
  <CardBox>
    <div class="w-full flex items-center gap-4">
      <div class="flex-1 flex flex-col">
        <Skeleton class="w-40 h-2" />
        <Skeleton class="w-3/4 h-6 mt-2" />
      </div>
    </div>
    <div class="w-full space-y-2">
      <Skeleton class="w-full h-3" />
      <Skeleton class="w-full h-3" />
      <Skeleton class="w-3/4 h-3" />
    </div>
    <div class="flex items-center gap-2">
      <Skeleton class="size-4" />
      <Skeleton class="w-16 h-3" />
    </div>
  </CardBox>
</template>
