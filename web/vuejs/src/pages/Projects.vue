<script setup lang="ts">
import AppLayout from '@/app/layouts/AppLayout.vue';
import ButtonAddData from '@/components/ui/button/ButtonAddData.vue';
import Text from '@/components/ui/typography/Text.vue';
import ProjectCard from '@/features/projects/components/ProjectCard.vue';

</script>
<template>
  <AppLayout title="Projetos">
    <template #header>
      <Text>3 projetos</Text>
    </template>

    <div class="flex flex-col gap-4">
      <ProjectCard :data="{
        id: 1,
        title: 'Apenas um teste de projeto',
        description: 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.',
        created_at: new Date()
      }" />

      <ButtonAddData label="Criar novo projeto" />

      <!-- <ProjectCard :active="true" /> -->
    </div>
  </AppLayout>
</template>
