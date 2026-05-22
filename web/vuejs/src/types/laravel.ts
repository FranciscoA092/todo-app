export type LaravelErrorResponse = {
  message: string
  errors?: Record<string, string[]>
}

export type LaravelPaginationMeta = {
  current_page: number
  from: number
  last_page: number
  per_page: number
  to: number
  total: number
}

export type LaravelPagination<T> = {
  data: T[]
  meta: LaravelPaginationMeta
}
