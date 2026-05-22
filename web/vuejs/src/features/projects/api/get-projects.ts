import api from '@/services/api'
import type { GetProjectsResponse } from '../types/api-response'

export function getProjects(page: number = 1) {
  return api.get<GetProjectsResponse>('/projects?page=' + page)
}
