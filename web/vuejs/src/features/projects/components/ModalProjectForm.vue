<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog'
import { Field, FieldLabel } from '@/components/ui/field'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'

const show = defineModel({ required: true, type: Boolean })
</script>
<template>
  <Dialog v-model:open="show">
    <DialogContent>
      <DialogHeader>
        <DialogTitle class="text-lg text-white">Cadastro de projeto</DialogTitle>
      </DialogHeader>

      <form class="space-y-2">
        <Field>
          <FieldLabel>Nome do projeto</FieldLabel>
          <Input placeholder="Digite o nome do projeto" />
        </Field>
        <Field>
          <FieldLabel>Descrição</FieldLabel>
          <Textarea placeholder="Digite a descrição do projeto" />
        </Field>
      </form>

      <DialogFooter>
        <Button variant="default" class="w-full">Salvar</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
