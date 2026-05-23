<script setup lang="ts">
import AppLayout from '@/app/layouts/AppLayout.vue'
import ButtonAddData from '@/components/ui/button/ButtonAddData.vue'
import Text from '@/components/ui/typography/Text.vue'
import { getProjects } from '@/features/projects/api/get-projects'
import ModalProjectForm from '@/features/projects/components/ModalProjectForm.vue'
import ProjectCard from '@/features/projects/components/ProjectCard/Index.vue'
import ProjectCardSkeleton from '@/features/projects/components/ProjectCard/Skeleton.vue'
import type { Project } from '@/features/projects/types/project'
import { onMounted, reactive } from 'vue'

const state = reactive({
  loading: true,
  openedModal: false,
  projects: [] as Project[],
})

onMounted(async () => await requestProjects())

async function requestProjects(page: number = 1) {
  state.loading = true
  try {
    const { data } = await getProjects(page)
    state.projects.push(
      ...data.data.map((i) => {
        return {
          ...i,
          created_at: new Date(i.created_at),
        }
      }),
    )
  } catch (error) {
    console.error('Error fetching projects:', error)
  } finally {
    state.loading = false
  }
}
</script>
<template>
  <AppLayout title="Projetos">
    <template #header>
      <Text>3 projetos</Text>
    </template>

    <div class="flex flex-col gap-4">
      <ButtonAddData label="Criar novo projeto" @click="state.openedModal = true" />
      <ProjectCardSkeleton v-if="state.loading" v-for="i in 3" :key="`skeleton-${i}`" />
      <ProjectCard v-else v-for="project in state.projects" :key="project.id" :data="project" />
      <ModalProjectForm v-model="state.openedModal" />
    </div>
  </AppLayout>
</template>
