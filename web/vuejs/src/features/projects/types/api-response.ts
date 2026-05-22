import type { LaravelPagination } from '@/types/laravel'
import type { Project } from './project'

export type GetProjectsResponse = LaravelPagination<Project>
