<script setup lang="ts">
import CardBox from '@/components/ui/box/CardBox.vue';
import Text from '@/components/ui/typography/Text.vue';
import Title from '@/components/ui/typography/Title.vue';
import { ListVideo } from 'lucide-vue-next';
import type { Project } from '../types/project';

defineProps<{
  data: Project
  active?: boolean
}>()


</script>
<template>
  <CardBox :active="active">
    <div class="flex flex-col">
      <Text class="text-xs">{{ data.created_at.toLocaleDateString() }}</Text>
      <Title class="text-xl">{{ data.title }}</Title>
    </div>

    <Text class="line-clamp-2">{{ data.description }}</Text>

    <div class="flex items-center gap-2">
      <ListVideo class="size-4 text-primary" />
      <Text class="text-sm">3 runners</Text>
    </div>
  </CardBox>
</template>
